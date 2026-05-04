<?php

require_once __DIR__ . '/../DomainNameApi/DNARest.php';

use DomainNameApi\DNARest;
use PHPUnit\Framework\TestCase;

class RestRequestShapeTest extends TestCase
{
    private DNARest $rest;

    protected function setUp(): void
    {
        $this->rest = new DNARest('00000000-0000-0000-0000-000000000000', 'token');
        $this->rest->setServiceUrl('http://127.0.0.1:1');
    }

    public function testEnableTheftProtectionLockSendsLockStatusTrue(): void
    {
        $this->rest->enableTheftProtectionLock('example.com');

        $req = $this->rest->getRequestData();
        $this->assertSame('POST', $req['method']);
        $this->assertStringEndsWith('/domains/lock', $req['url']);
        $this->assertSame('example.com', $req['payload']['domainName']);
        $this->assertArrayHasKey('lockStatus', $req['payload']);
        $this->assertTrue($req['payload']['lockStatus']);
    }

    public function testDisableTheftProtectionLockSendsLockStatusFalseToLockEndpoint(): void
    {
        $this->rest->disableTheftProtectionLock('example.com');

        $req = $this->rest->getRequestData();
        $this->assertSame('POST', $req['method']);
        $this->assertStringEndsWith('/domains/lock', $req['url']);
        $this->assertStringNotContainsString('/domains/unlock', $req['url']);
        $this->assertSame('example.com', $req['payload']['domainName']);
        $this->assertArrayHasKey('lockStatus', $req['payload']);
        $this->assertFalse($req['payload']['lockStatus']);
    }

    public function testRegisterWithContactInfoUsesRegisterWithContactsEndpoint(): void
    {
        $contacts = [
            'Registrant'     => $this->sampleContact(),
            'Administrative' => $this->sampleContact(),
            'Technical'      => $this->sampleContact(),
            'Billing'        => $this->sampleContact(),
        ];

        $this->rest->registerWithContactInfo(
            'example.com',
            1,
            $contacts,
            ['ns1.example.com', 'ns2.example.com'],
            true,
            false,
            []
        );

        $req = $this->rest->getRequestData();
        $this->assertSame('POST', $req['method']);
        $this->assertStringEndsWith('/domains/register-with-contacts', $req['url']);
        $this->assertSame('example.com', $req['payload']['domainName']);
        $this->assertSame(1, $req['payload']['period']);
        $this->assertCount(4, $req['payload']['contacts']);
        $this->assertArrayHasKey('isLocked', $req['payload']);
        $this->assertArrayHasKey('privacyEnabled', $req['payload']);
    }

    public function testDefaultServiceUrlPointsToProductionGateway(): void
    {
        $rest = new DNARest('00000000-0000-0000-0000-000000000000', 'token');
        $this->assertSame('https://api.domainresellerapi.com/api/v1', $rest->getServiceUrl());
        $this->assertSame('https://api.domainresellerapi.com/api/v1', DNARest::URL_PROD);
        $this->assertSame('https://ote.domainresellerapi.com/api/v1', DNARest::URL_OTE);
    }

    private function sampleContact(): array
    {
        return [
            'FirstName'        => 'Ada',
            'LastName'         => 'Lovelace',
            'Company'          => 'Analytical Engines',
            'EMail'            => 'ada@example.com',
            'AddressLine1'     => '1 Babbage Way',
            'City'             => 'London',
            'State'            => 'LDN',
            'Country'          => 'GB',
            'ZipCode'          => 'EC1A',
            'PhoneCountryCode' => '44',
            'Phone'            => '2071234567',
        ];
    }
}
