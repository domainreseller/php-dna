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
}
