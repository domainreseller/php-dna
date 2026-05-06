<?php

require_once __DIR__ . '/BaseComparisonTestCase.php';

class SoapReadTest extends BaseComparisonTestCase
{
    public function testGetResellerDetails(): void
    {
        $result = self::$soap->GetResellerDetails();

        $this->assertEquals('OK', $result['result']);
        $expectedKeys = ['result', 'id', 'active', 'name', 'balance', 'currency', 'symbol', 'balances'];
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $result);
        }
        $this->assertCount(2, $result['balances']);
        foreach (['balance', 'currency', 'symbol'] as $k) {
            $this->assertArrayHasKey($k, $result['balances'][0]);
        }
    }

    public function testGetCurrentBalanceUSD(): void
    {
        $result = self::$soap->GetCurrentBalance('USD');

        $expectedKeys = ['ErrorCode', 'OperationMessage', 'OperationResult', 'Balance', 'CurrencyId', 'CurrencyInfo', 'CurrencyName', 'CurrencySymbol'];
        $this->assertEquals($expectedKeys, array_keys($result));
        $this->assertEquals(2, $result['CurrencyId']);
        $this->assertEquals('USD', $result['CurrencyName']);
    }

    public function testGetCurrentBalanceTRY(): void
    {
        $result = self::$soap->GetCurrentBalance('TRY');

        $this->assertEquals(1, $result['CurrencyId']);
        $this->assertEquals('TL', $result['CurrencyName']);
        $this->assertEquals('TL', $result['CurrencySymbol']);
    }

    public function testCheckAvailabilityNotAvailable(): void
    {
        $result = self::$soap->CheckAvailability(['google'], ['com'], 1, 'create');

        $this->assertArrayHasKey(0, $result);
        $this->assertArrayNotHasKey('result', $result);
        $expectedKeys = ['TLD', 'DomainName', 'Status', 'Command', 'Period', 'IsFee', 'Price', 'Currency', 'Reason'];
        $this->assertEquals($expectedKeys, array_keys($result[0]));
        $this->assertEquals('notavailable', $result[0]['Status']);
    }

    public function testCheckAvailabilityAvailable(): void
    {
        $result = self::$soap->CheckAvailability(['xyznotexist999'], ['com'], 1, 'create');
        $this->assertEquals('available', $result[0]['Status']);
    }

    public function testCheckAvailabilityEmptyReturnsError(): void
    {
        $result = self::$soap->CheckAvailability([], ['com'], 1, 'create');
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }

    public function testGetList(): void
    {
        $result = self::$soap->GetList();

        $this->assertEquals(['data', 'result', 'TotalCount'], array_keys($result));
        $this->assertArrayHasKey('Domains', $result['data']);

        $domainKeys = ['ID', 'Status', 'DomainName', 'AuthCode', 'LockStatus', 'PrivacyProtectionStatus',
            'IsChildNameServer', 'Contacts', 'Dates', 'NameServers', 'Additional', 'ChildNameServers'];
        if (!empty($result['data']['Domains'])) {
            $this->assertEquals($domainKeys, array_keys($result['data']['Domains'][0]));
        }
    }

    public function testGetDetails(): void
    {
        $result = self::$soap->GetDetails(self::$soapDomain);

        $this->assertEquals(['data', 'result'], array_keys($result));
        $this->assertEquals('OK', $result['result']);

        $dataKeys = ['ID', 'Status', 'DomainName', 'AuthCode', 'LockStatus', 'PrivacyProtectionStatus',
            'IsChildNameServer', 'Contacts', 'Dates', 'NameServers', 'Additional', 'ChildNameServers'];
        $this->assertEquals($dataKeys, array_keys($result['data']));
        $this->assertIsString($result['data']['LockStatus']);

        foreach (['Billing', 'Technical', 'Administrative', 'Registrant'] as $type) {
            $this->assertArrayHasKey($type, $result['data']['Contacts']);
            $this->assertArrayHasKey('ID', $result['data']['Contacts'][$type]);
        }
    }

    public function testGetDetailsError(): void
    {
        $result = self::$soap->GetDetails('nonexistent-domain-xyz.com');

        $this->assertEquals('ERROR', $result['result']);
        $this->assertEquals(['Code', 'Message', 'Details'], array_keys($result['error']));
    }

    public function testGetContacts(): void
    {
        $result = self::$soap->GetContacts(self::$soapDomainContacts);

        $this->assertEquals('OK', $result['result']);
        $this->assertArrayHasKey('contacts', $result['data']);

        foreach (['Administrative', 'Billing', 'Technical', 'Registrant'] as $type) {
            $this->assertArrayHasKey($type, $result['data']['contacts']);
            $contactKeys = ['ID', 'Status', 'AuthCode', 'FirstName', 'LastName', 'Company',
                'EMail', 'Type', 'Address', 'Phone', 'Additional'];
            $this->assertEquals($contactKeys, array_keys($result['data']['contacts'][$type]));
            $this->assertEquals(['Line1', 'Line2', 'Line3', 'State', 'City', 'Country', 'ZipCode'],
                array_keys($result['data']['contacts'][$type]['Address']));
        }
    }

    public function testGetTldList(): void
    {
        $result = self::$soap->GetTldList(5);

        $this->assertEquals('OK', $result['result']);
        $this->assertIsArray($result['data']);
        $this->assertNotEmpty($result['data']);

        // SOAP shape: no gracePeriod / redemptionPeriod
        $expectedKeys = ['id', 'status', 'maxchar', 'maxperiod', 'minchar', 'minperiod',
            'tld', 'pricing', 'currencies'];
        $this->assertEquals($expectedKeys, array_keys($result['data'][0]));

        $first = $result['data'][0];
        $this->assertIsString($first['tld']);
        $this->assertIsArray($first['pricing']);
        $this->assertIsArray($first['currencies']);
    }

    public function testCheckTransferNonExistent(): void
    {
        $result = self::$soap->CheckTransfer('nonexistent-' . bin2hex(random_bytes(4)) . '.com', 'fakeAuthCode');

        // SOAP shape: only `result` on either OK or ERROR
        $this->assertArrayHasKey('result', $result);
        $this->assertContains($result['result'], ['OK', 'ERROR']);
    }

    public function testCheckTransferInvalidAuthCode(): void
    {
        $result = self::$soap->CheckTransfer('google.com', 'fakeAuthCode');

        $this->assertArrayHasKey('result', $result);
        $this->assertContains($result['result'], ['OK', 'ERROR']);
    }

    public function testWrongCredentials(): void
    {
        $bad = new \DomainNameApi\DomainNameAPI_PHPLibrary('wronguser', 'wrongpass');
        $result = $bad->GetResellerDetails();
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }
}
