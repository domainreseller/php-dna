<?php

require_once __DIR__ . '/BaseComparisonTestCase.php';

class RestReadTest extends BaseComparisonTestCase
{
    public function testGetResellerDetails(): void
    {
        $result = self::$rest->GetResellerDetails();

        $this->assertEquals('OK', $result['result']);
        $expectedKeys = ['result', 'id', 'active', 'name', 'balance', 'currency', 'symbol', 'balances'];
        foreach ($expectedKeys as $key) {
            $this->assertArrayHasKey($key, $result);
        }
        $this->assertArrayNotHasKey('data', $result, 'No extra data key');
        $this->assertCount(2, $result['balances']);
        $this->assertEquals('TL', $result['balances'][1]['currency']);
    }

    public function testGetCurrentBalanceUSD(): void
    {
        $result = self::$rest->GetCurrentBalance('USD');

        $expectedKeys = ['ErrorCode', 'OperationMessage', 'OperationResult', 'Balance', 'CurrencyId', 'CurrencyInfo', 'CurrencyName', 'CurrencySymbol'];
        $this->assertEquals($expectedKeys, array_keys($result));
        $this->assertEquals(2, $result['CurrencyId']);
        $this->assertEquals('USD', $result['CurrencyName']);
    }

    public function testGetCurrentBalanceTRY(): void
    {
        $result = self::$rest->GetCurrentBalance('TRY');

        $this->assertEquals(1, $result['CurrencyId']);
        $this->assertEquals('TL', $result['CurrencyName']);
        $this->assertEquals('TL', $result['CurrencySymbol']);
    }

    public function testCheckAvailabilityNotAvailable(): void
    {
        $result = self::$rest->CheckAvailability(['google'], ['com'], 1, 'create');

        $msg = 'Unexpected response: ' . json_encode($result);
        $this->assertArrayHasKey(0, $result, $msg);
        $this->assertArrayNotHasKey('result', $result, $msg);
        $expectedKeys = ['TLD', 'DomainName', 'Status', 'Command', 'Period', 'IsFee', 'Price', 'Currency', 'Reason'];
        $this->assertEquals($expectedKeys, array_keys($result[0]), $msg);
        $this->assertEquals('notavailable', $result[0]['Status'], $msg);
    }

    public function testCheckAvailabilityAvailable(): void
    {
        $result = self::$rest->CheckAvailability(['xyznotexist999'], ['com'], 1, 'create');
        $this->assertEquals('available', $result[0]['Status'] ?? null,
            'Unexpected response: ' . json_encode($result));
    }

    public function testCheckAvailabilityEmptyReturnsError(): void
    {
        $result = self::$rest->CheckAvailability([], ['com'], 1, 'create');
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }

    public function testGetList(): void
    {
        $result = self::$rest->GetList();

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
        $result = self::$rest->GetDetails(self::$restDomain);

        $this->assertEquals(['data', 'result'], array_keys($result));
        $this->assertEquals('OK', $result['result']);

        $dataKeys = ['ID', 'Status', 'DomainName', 'AuthCode', 'LockStatus', 'PrivacyProtectionStatus',
            'IsChildNameServer', 'Contacts', 'Dates', 'NameServers', 'Additional', 'ChildNameServers'];
        $this->assertEquals($dataKeys, array_keys($result['data']));
        $this->assertIsString($result['data']['LockStatus']);
        $this->assertContains($result['data']['LockStatus'], ['true', 'false']);
        $this->assertStringNotContainsString('.', $result['data']['Dates']['Start'], 'No milliseconds');

        if (!empty($result['data']['ChildNameServers'])) {
            $this->assertIsString($result['data']['ChildNameServers'][0]['ip']);
        }

        foreach (['Billing', 'Technical', 'Administrative', 'Registrant'] as $type) {
            $this->assertArrayHasKey($type, $result['data']['Contacts']);
            $this->assertArrayHasKey('ID', $result['data']['Contacts'][$type]);
        }
    }

    public function testGetDetailsError(): void
    {
        $result = self::$rest->GetDetails('nonexistent-domain-xyz.com');

        $this->assertEquals('ERROR', $result['result']);
        $this->assertEquals(['Code', 'Message', 'Details'], array_keys($result['error']));
    }

    public function testGetContacts(): void
    {
        $result = self::$rest->GetContacts(self::$restDomainContacts);

        $this->assertEquals('OK', $result['result']);
        $this->assertArrayHasKey('contacts', $result['data']);

        foreach (['Administrative', 'Billing', 'Technical', 'Registrant'] as $type) {
            $this->assertArrayHasKey($type, $result['data']['contacts']);
            $contactKeys = ['ID', 'Status', 'AuthCode', 'FirstName', 'LastName', 'Company',
                'EMail', 'Type', 'Address', 'Phone', 'Additional'];
            $this->assertEquals($contactKeys, array_keys($result['data']['contacts'][$type]));
            $this->assertEquals(['Line1', 'Line2', 'Line3', 'State', 'City', 'Country', 'ZipCode'],
                array_keys($result['data']['contacts'][$type]['Address']));
            $this->assertArrayHasKey('Phone', $result['data']['contacts'][$type]['Phone']);
            $this->assertArrayHasKey('Fax', $result['data']['contacts'][$type]['Phone']);
        }
    }

    public function testGetTldList(): void
    {
        $result = self::$rest->GetTldList(5);

        $this->assertEquals('OK', $result['result']);
        $this->assertIsArray($result['data']);
        $this->assertNotEmpty($result['data']);

        // Shape must match SOAP exactly so the facade is transport-transparent.
        $expectedKeys = ['id', 'status', 'maxchar', 'maxperiod', 'minchar', 'minperiod',
            'tld', 'pricing', 'currencies'];
        $this->assertEquals($expectedKeys, array_keys($result['data'][0]));

        $first = $result['data'][0];
        $this->assertIsString($first['tld']);
        $this->assertIsArray($first['pricing']);
        $this->assertIsArray($first['currencies']);
        $this->assertArrayHasKey('registration', $first['pricing']);
    }

    public function testCheckTransferNonExistent(): void
    {
        $result = self::$rest->CheckTransfer('nonexistent-' . bin2hex(random_bytes(4)) . '.com', 'fakeAuthCode');

        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
        $this->assertEquals(['Code', 'Message', 'Details'], array_keys($result['error']));
    }

    public function testCheckTransferInvalidAuthCode(): void
    {
        // Registered domain not on this account + bogus auth code → gateway returns
        // HTTP 4xx, library converts to error envelope (no data branch).
        $result = self::$rest->CheckTransfer('google.com', 'fakeAuthCode');

        $this->assertEquals('ERROR', $result['result']);
        $this->assertEquals(['Code', 'Message', 'Details'], array_keys($result['error']));
    }

    public function testWrongCredentials(): void
    {
        $bad = new \DomainNameApi\DomainNameAPI_PHPLibrary('fd2bea54-0000-0000-0000-000000000000', 'wrongtoken');
        $result = $bad->GetResellerDetails();
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }
}
