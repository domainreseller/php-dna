<?php

require_once __DIR__ . '/BaseComparisonTestCase.php';

class RestWriteTest extends BaseComparisonTestCase
{
    public function testEnableTheftProtectionLock(): void
    {
        $result = self::$rest->EnableTheftProtectionLock(self::$restDomain);
        $this->assertEquals('OK', $result['result']);
        $this->assertArrayHasKey('LockStatus', $result['data']);
    }

    public function testDisableTheftProtectionLock(): void
    {
        $result = self::$rest->DisableTheftProtectionLock(self::$restDomain);
        $this->assertEquals('OK', $result['result']);
        $this->assertArrayHasKey('LockStatus', $result['data']);
    }

    public function testModifyNameServer(): void
    {
        $result = self::$rest->ModifyNameServer(self::$restDomainContacts, ['eu.apiname.com', 'tr.apiname.com']);
        $this->assertEquals('OK', $result['result']);
        $this->assertArrayHasKey('NameServers', $result['data']);
        $this->assertIsArray($result['data']['NameServers']);
    }

    public function testAddModifyDeleteChildNameServer(): void
    {
        $ns = 'phpunit.' . self::$restDomain;

        $add = self::$rest->AddChildNameServer(self::$restDomain, $ns, '7.7.7.7');
        $this->assertEquals('OK', $add['result']);
        $this->assertEquals(['NameServer', 'IPAdresses'], array_keys($add['data']));

        $mod = self::$rest->ModifyChildNameServer(self::$restDomain, $ns, '8.8.8.8');
        $this->assertEquals('OK', $mod['result']);

        $del = self::$rest->DeleteChildNameServer(self::$restDomain, $ns);
        $this->assertEquals('OK', $del['result']);
        $this->assertEquals(['NameServer'], array_keys($del['data']));
    }

    public function testModifyPrivacyProtection(): void
    {
        $enable = self::$rest->ModifyPrivacyProtectionStatus(self::$restDomain, true);
        if ($enable['result'] === 'OK') {
            $this->assertArrayHasKey('PrivacyProtectionStatus', $enable['data']);
            $this->assertArrayNotHasKey('DomainName', $enable['data']);
        }
        self::$rest->ModifyPrivacyProtectionStatus(self::$restDomain, false);
    }

    public function testSyncFromRegistry(): void
    {
        $result = self::$rest->SyncFromRegistry(self::$restDomainContacts);
        $this->assertEquals(['data', 'result'], array_keys($result));
        $this->assertEquals('OK', $result['result']);
    }

    public function testModifyNameServerError(): void
    {
        $result = self::$rest->ModifyNameServer('nonexistent-xyz.com', ['ns1.test.com', 'ns2.test.com']);
        $this->assertEquals('ERROR', $result['result']);
        $this->assertEquals(['Code', 'Message', 'Details'], array_keys($result['error']));
    }

    public function testLockError(): void
    {
        $result = self::$rest->EnableTheftProtectionLock('nonexistent-xyz.com');
        $this->assertEquals('ERROR', $result['result']);
    }

    public function testSaveContacts(): void
    {
        // Gateway returns an empty body on success per Swagger; verify the save
        // actually persisted by reading the contacts back via GetContacts.
        $contacts = self::sampleContacts();
        $save = self::$rest->SaveContacts(self::$restDomainContacts, $contacts);

        $this->assertEquals('OK', $save['result']);
        $this->assertArrayHasKey('data', $save);
        $this->assertArrayHasKey('contacts', $save['data']);
        $this->assertIsArray($save['data']['contacts']);

        $get = self::$rest->GetContacts(self::$restDomainContacts);
        $this->assertEquals('OK', $get['result']);
        foreach (['Administrative', 'Billing', 'Technical', 'Registrant'] as $type) {
            $persisted = $get['data']['contacts'][$type];
            $this->assertEquals($contacts[$type]['FirstName'], $persisted['FirstName'], "$type FirstName roundtrip");
            $this->assertEquals($contacts[$type]['LastName'],  $persisted['LastName'],  "$type LastName roundtrip");
            $this->assertEquals($contacts[$type]['EMail'],     $persisted['EMail'],     "$type EMail roundtrip");
            $this->assertEquals($contacts[$type]['Country'],   $persisted['Address']['Country'], "$type Country roundtrip");
        }
    }

    public function testSaveContactsError(): void
    {
        $result = self::$rest->SaveContacts('nonexistent-' . bin2hex(random_bytes(4)) . '.com', self::sampleContacts());

        $this->assertEquals('ERROR', $result['result']);
        $this->assertEquals(['Code', 'Message', 'Details'], array_keys($result['error']));
    }
}
