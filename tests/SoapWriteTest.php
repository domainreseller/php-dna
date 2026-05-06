<?php

require_once __DIR__ . '/BaseComparisonTestCase.php';

class SoapWriteTest extends BaseComparisonTestCase
{
    public function testEnableTheftProtectionLock(): void
    {
        $result = self::$soap->EnableTheftProtectionLock(self::$soapDomain);
        $this->assertEquals('OK', $result['result']);
        $this->assertArrayHasKey('LockStatus', $result['data']);
    }

    public function testDisableTheftProtectionLock(): void
    {
        $result = self::$soap->DisableTheftProtectionLock(self::$soapDomain);
        $this->assertEquals('OK', $result['result']);
        $this->assertArrayHasKey('LockStatus', $result['data']);
    }

    public function testModifyNameServer(): void
    {
        $result = self::$soap->ModifyNameServer(self::$soapDomainContacts, ['ns1.bunyam.in', 'ns2.bunyam.in']);
        $this->assertEquals('OK', $result['result']);
        $this->assertArrayHasKey('NameServers', $result['data']);
        $this->assertIsArray($result['data']['NameServers']);
    }

    public function testAddModifyDeleteChildNameServer(): void
    {
        $ns = 'phpunit.' . self::$soapDomain;

        $add = self::$soap->AddChildNameServer(self::$soapDomain, $ns, '7.7.7.7');
        $this->assertEquals('OK', $add['result']);
        $this->assertEquals(['NameServer', 'IPAdresses'], array_keys($add['data']));

        $mod = self::$soap->ModifyChildNameServer(self::$soapDomain, $ns, '8.8.8.8');
        $this->assertEquals('OK', $mod['result']);

        $del = self::$soap->DeleteChildNameServer(self::$soapDomain, $ns);
        $this->assertEquals('OK', $del['result']);
        $this->assertEquals(['NameServer'], array_keys($del['data']));
    }

    public function testModifyPrivacyProtection(): void
    {
        $enable = self::$soap->ModifyPrivacyProtectionStatus(self::$soapDomain, true);
        if ($enable['result'] === 'OK') {
            $this->assertArrayHasKey('PrivacyProtectionStatus', $enable['data']);
        }
        self::$soap->ModifyPrivacyProtectionStatus(self::$soapDomain, false);
    }

    public function testSyncFromRegistry(): void
    {
        $result = self::$soap->SyncFromRegistry(self::$soapDomainContacts);
        $this->assertEquals(['data', 'result'], array_keys($result));
        $this->assertEquals('OK', $result['result']);
    }

    public function testModifyNameServerError(): void
    {
        $result = self::$soap->ModifyNameServer('nonexistent-xyz.com', ['ns1.test.com', 'ns2.test.com']);
        $this->assertEquals('ERROR', $result['result']);
        $this->assertEquals(['Code', 'Message', 'Details'], array_keys($result['error']));
    }

    public function testLockError(): void
    {
        $result = self::$soap->EnableTheftProtectionLock('nonexistent-xyz.com');
        $this->assertEquals('ERROR', $result['result']);
    }

    public function testSaveContacts(): void
    {
        $contacts = self::sampleContacts();
        $save = self::$soap->SaveContacts(self::$soapDomainContacts, $contacts);

        // SOAP shape: only `result` on success (no data envelope).
        $this->assertEquals('OK', $save['result']);

        // Verify persistence via GetContacts roundtrip.
        $get = self::$soap->GetContacts(self::$soapDomainContacts);
        $this->assertEquals('OK', $get['result']);
        foreach (['Administrative', 'Billing', 'Technical', 'Registrant'] as $type) {
            $persisted = $get['data']['contacts'][$type];
            $this->assertEquals($contacts[$type]['FirstName'], $persisted['FirstName'], "$type FirstName roundtrip");
            $this->assertEquals($contacts[$type]['LastName'],  $persisted['LastName'],  "$type LastName roundtrip");
            $this->assertEquals($contacts[$type]['EMail'],     $persisted['EMail'],     "$type EMail roundtrip");
        }
    }

    public function testSaveContactsError(): void
    {
        $result = self::$soap->SaveContacts('nonexistent-' . bin2hex(random_bytes(4)) . '.com', self::sampleContacts());

        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }
}
