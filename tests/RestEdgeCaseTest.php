<?php

require_once __DIR__ . '/BaseComparisonTestCase.php';

/**
 * Edge cases for DNARest: weird input, empty payloads, missing fields,
 * boundary values. None of these should throw — every public method must
 * return a structured envelope.
 */
class RestEdgeCaseTest extends BaseComparisonTestCase
{
    // -----------------------------------------------------------------------
    // Empty / missing payloads
    // -----------------------------------------------------------------------

    public function testCheckAvailabilityEmptyExtensions(): void
    {
        $result = self::$rest->CheckAvailability(['hello'], [], 1, 'create');
        $this->assertIsArray($result);
        // Either returns empty rows or an error envelope — never throw.
        $this->assertTrue(
            is_int(array_key_first($result)) || ($result['result'] ?? null) === 'ERROR',
            'Expected list or error envelope; got: ' . json_encode($result)
        );
    }

    public function testSaveContactsEmptyArray(): void
    {
        $result = self::$rest->SaveContacts(self::$restDomainContacts, []);
        $this->assertIsArray($result);
        $this->assertContains($result['result'] ?? null, ['OK', 'ERROR']);
    }

    public function testSaveContactsMissingType(): void
    {
        // Only Administrative provided; gateway should reject with 4xx.
        $partial = ['Administrative' => self::sampleContacts()['Administrative']];
        $result  = self::$rest->SaveContacts(self::$restDomainContacts, $partial);
        $this->assertIsArray($result);
        $this->assertContains($result['result'] ?? null, ['OK', 'ERROR']);
    }

    public function testRegisterWithEmptyContacts(): void
    {
        $result = self::$rest->RegisterWithContactInfo('edge-' . bin2hex(random_bytes(3)) . '.xyz', 1, [], [], true, false);
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }

    public function testModifyNameServerEmptyList(): void
    {
        $result = self::$rest->ModifyNameServer(self::$restDomain, []);
        $this->assertIsArray($result);
        $this->assertContains($result['result'] ?? null, ['OK', 'ERROR']);
    }

    // -----------------------------------------------------------------------
    // Whitespace / empty-string domain names
    // -----------------------------------------------------------------------

    public function testGetDetailsWhitespaceDomain(): void
    {
        $result = self::$rest->GetDetails('   ');
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }

    public function testGetDetailsWithLeadingTrailingSpaces(): void
    {
        // Library should not trim; gateway should reject (or look up exact).
        $result = self::$rest->GetDetails('  google.com  ');
        $this->assertIsArray($result);
        $this->assertContains($result['result'] ?? null, ['OK', 'ERROR']);
    }

    // -----------------------------------------------------------------------
    // Special characters / injection-style strings
    // -----------------------------------------------------------------------

    public function testGetDetailsSqlInjectionString(): void
    {
        $result = self::$rest->GetDetails("'; DROP TABLE domains;--");
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }

    public function testGetDetailsScriptTag(): void
    {
        $result = self::$rest->GetDetails('<script>alert(1)</script>.com');
        $this->assertEquals('ERROR', $result['result']);
    }

    public function testCheckAvailabilityEmojiLabel(): void
    {
        // Finding: gateway responds with empty [] for emoji labels — neither
        // populated rows nor an error envelope. Library does not crash.
        $result = self::$rest->CheckAvailability(['🚀rocket'], ['com'], 1, 'create');
        $this->assertIsArray($result);
    }

    public function testCheckAvailabilityUnicodeLabel(): void
    {
        // IDN label (German umlaut) — not punycoded by the library.
        $result = self::$rest->CheckAvailability(['münchen'], ['de'], 1, 'create');
        $this->assertIsArray($result);
    }

    // -----------------------------------------------------------------------
    // Length boundaries
    // -----------------------------------------------------------------------

    public function testGetDetailsExtremelyLongDomain(): void
    {
        $longLabel = str_repeat('a', 250);
        $result    = self::$rest->GetDetails($longLabel . '.com');
        $this->assertEquals('ERROR', $result['result']);
    }

    public function testCheckAvailabilitySingleCharLabel(): void
    {
        $result = self::$rest->CheckAvailability(['a'], ['com'], 1, 'create');
        $this->assertIsArray($result);
    }

    // -----------------------------------------------------------------------
    // Period boundary values
    // -----------------------------------------------------------------------

    public function testCheckAvailabilityZeroPeriod(): void
    {
        $result = self::$rest->CheckAvailability(['hello'], ['com'], 0, 'create');
        $this->assertIsArray($result);
    }

    public function testCheckAvailabilityNegativePeriod(): void
    {
        $result = self::$rest->CheckAvailability(['hello'], ['com'], -1, 'create');
        $this->assertIsArray($result);
    }

    public function testCheckAvailabilityHugePeriod(): void
    {
        $result = self::$rest->CheckAvailability(['hello'], ['com'], 999, 'create');
        $this->assertIsArray($result);
    }

    public function testRenewZeroPeriod(): void
    {
        $result = self::$rest->Renew(self::$restDomain, 0);
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }

    public function testRenewNegativePeriod(): void
    {
        $result = self::$rest->Renew(self::$restDomain, -3);
        $this->assertEquals('ERROR', $result['result']);
        $this->assertArrayHasKey('error', $result);
    }

    // -----------------------------------------------------------------------
    // Unknown command / TLD
    // -----------------------------------------------------------------------

    public function testCheckAvailabilityUnknownCommand(): void
    {
        $result = self::$rest->CheckAvailability(['hello'], ['com'], 1, 'banana');
        $this->assertIsArray($result);
    }

    public function testCheckAvailabilityUnknownTld(): void
    {
        $result = self::$rest->CheckAvailability(['hello'], ['notarealtldever'], 1, 'create');
        $this->assertIsArray($result);
    }

    // -----------------------------------------------------------------------
    // Child nameserver edge cases
    // -----------------------------------------------------------------------

    public function testAddChildNameServerInvalidIp(): void
    {
        $result = self::$rest->AddChildNameServer(self::$restDomain, 'edge.' . self::$restDomain, 'not-an-ip');
        $this->assertIsArray($result);
        $req = self::$rest->getRequestData();
        // Library treats invalid IP as v6 path (filter_var returns false).
        $this->assertEquals('v6', $req['payload']['ipAddresses'][0]['ipVersion'] ?? null);
    }

    public function testAddChildNameServerEmptyIp(): void
    {
        $result = self::$rest->AddChildNameServer(self::$restDomain, 'edge.' . self::$restDomain, '');
        $this->assertIsArray($result);
        $this->assertContains($result['result'] ?? null, ['OK', 'ERROR']);
    }

    // -----------------------------------------------------------------------
    // Envelope safety: every public method must return an array (no throws)
    // even when fed pathological inputs.
    // -----------------------------------------------------------------------

    public function testNoMethodEverThrows(): void
    {
        $bad = '   <<>>!!@#  ';
        $methods = [
            fn() => self::$rest->GetDetails($bad),
            fn() => self::$rest->GetContacts($bad),
            fn() => self::$rest->SyncFromRegistry($bad),
            fn() => self::$rest->Renew($bad, 1),
            fn() => self::$rest->Transfer($bad, 'epp', 1),
            fn() => self::$rest->CancelTransfer($bad),
            fn() => self::$rest->ApproveTransfer($bad),
            fn() => self::$rest->RejectTransfer($bad),
            fn() => self::$rest->EnableTheftProtectionLock($bad),
            fn() => self::$rest->DisableTheftProtectionLock($bad),
            fn() => self::$rest->ModifyPrivacyProtectionStatus($bad, true),
            fn() => self::$rest->ModifyNameServer($bad, ['ns1.test.com']),
            fn() => self::$rest->CheckTransfer($bad, 'epp'),
        ];

        foreach ($methods as $i => $fn) {
            $result = $fn();
            $this->assertIsArray($result, "Method index $i did not return an array");
            $this->assertArrayHasKey('result', $result, "Method index $i missing result key");
        }
    }
}
