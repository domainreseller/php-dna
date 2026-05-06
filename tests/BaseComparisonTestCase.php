<?php

use DomainNameApi\DomainNameAPI_PHPLibrary;
use PHPUnit\Framework\TestCase;

/**
 * Base class for REST vs SOAP comparison tests.
 *
 * Required ENV vars:
 *   SOAP_USER, SOAP_PASS, REST_USER, REST_PASS
 *   SOAP_DOMAIN, REST_DOMAIN
 *   SOAP_DOMAIN_CONTACTS, REST_DOMAIN_CONTACTS
 *
 * Run: env $(cat .env.test | xargs) vendor/bin/phpunit --testdox
 */
abstract class BaseComparisonTestCase extends TestCase
{
    protected static DomainNameAPI_PHPLibrary $soap;
    protected static DomainNameAPI_PHPLibrary $rest;
    protected static string $soapDomain;
    protected static string $restDomain;
    protected static string $soapDomainContacts;
    protected static string $restDomainContacts;

    public static function setUpBeforeClass(): void
    {
        $required = ['SOAP_USER', 'SOAP_PASS', 'REST_USER', 'REST_PASS',
            'SOAP_DOMAIN', 'REST_DOMAIN', 'SOAP_DOMAIN_CONTACTS', 'REST_DOMAIN_CONTACTS'];

        foreach ($required as $key) {
            if (empty(getenv($key))) {
                self::markTestSkipped("Missing env var: {$key}");
            }
        }

        self::$soap = new DomainNameAPI_PHPLibrary(getenv('SOAP_USER'), getenv('SOAP_PASS'));
        self::$rest = new DomainNameAPI_PHPLibrary(getenv('REST_USER'), getenv('REST_PASS'));
        self::$soapDomain         = getenv('SOAP_DOMAIN');
        self::$restDomain         = getenv('REST_DOMAIN');
        self::$soapDomainContacts = getenv('SOAP_DOMAIN_CONTACTS');
        self::$restDomainContacts = getenv('REST_DOMAIN_CONTACTS');
    }

    protected static function sampleContacts(): array
    {
        $contact = [
            'FirstName'        => 'Bunyamin',
            'LastName'         => 'Akcay',
            'Company'          => 'Atak Domain',
            'EMail'            => 'test@bunyam.in',
            'AddressLine1'     => 'Yenisehir Mah. Arda Sk. No:36',
            'City'             => 'Kocaeli',
            'Country'          => 'TR',
            'Phone'            => '5354792542',
            'PhoneCountryCode' => '90',
            'Fax'              => '5354792542',
            'FaxCountryCode'   => '90',
            'ZipCode'          => '41000',
            'State'            => 'Izmit',
        ];
        return [
            'Administrative' => $contact,
            'Billing'        => $contact,
            'Technical'      => $contact,
            'Registrant'     => $contact,
        ];
    }
}
