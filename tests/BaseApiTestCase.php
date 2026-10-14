<?php

use DomainNameApi\DomainNameAPI_PHPLibrary;
use PHPUnit\Framework\TestCase;

/**
 * Base class for live REST API tests.
 *
 * Required ENV vars:
 *   DNA_RESELLER_ID, DNA_API_KEY, DNA_DOMAIN, DNA_DOMAIN_CONTACTS
 *
 * Run: env $(cat .env.test | xargs) vendor/bin/phpunit --testdox
 */
abstract class BaseApiTestCase extends TestCase
{
    protected static DomainNameAPI_PHPLibrary $rest;
    protected static string $restDomain;
    protected static string $restDomainContacts;

    public static function setUpBeforeClass(): void
    {
        $required = ['DNA_RESELLER_ID', 'DNA_API_KEY', 'DNA_DOMAIN', 'DNA_DOMAIN_CONTACTS'];

        foreach ($required as $key) {
            if (empty(getenv($key))) {
                self::markTestSkipped("Missing env var: {$key}");
            }
        }

        self::$rest = new DomainNameAPI_PHPLibrary(getenv('DNA_RESELLER_ID'), getenv('DNA_API_KEY'));

        // Tests deliberately probe the library with pathological inputs
        // (testNoMethodEverThrows, edge cases). Letting those errors stream
        // into the shared production Sentry project would pollute real
        // signal with synthetic test noise.
        self::$rest->setErrorReportingEnabled(false);

        self::$restDomain         = getenv('DNA_DOMAIN');
        self::$restDomainContacts = getenv('DNA_DOMAIN_CONTACTS');
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
