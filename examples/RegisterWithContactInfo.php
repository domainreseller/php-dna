<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:39
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: use your Reseller ID (UUID) + API Key from Panel → API Settings (REST),
// or your legacy API username + password (SOAP). Panel login e-mail/password will NOT work.
$username = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID) or legacy API username
$password = 'your-api-key';                          // API Key or legacy API password

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);



$contact = array(
    "FirstName"        => 'John',
    "LastName"         => 'Doe',
    "Company"          => 'Example Corp',
    "EMail"            => 'john.doe@example.com',
    "AddressLine1"     => '123 Main Street',
    "AddressLine2"     => 'Suite 100',
    "AddressLine3"     => '',
    "City"             => 'Los Angeles',
    "Country"          => 'US',
    "Fax"              => '5559876543',
    "FaxCountryCode"   => '1',
    "Phone"            => '5551234567',
    "PhoneCountryCode" => 1,
    "Type"             => 'Contact',
    "ZipCode"          => '90001',
    "State"            => 'California'
);

/**
 * !!!! THIS EXAMPLE IS NOT WORKING WITH .TR DOMAIN REGISTRATION, CHECK RegisterWithContactInfo-TR.php FILE
 * Register domain with contact information
 * @param string $DomainName
 * @param int $Period
 * @param array $Contacts
 * @param array $NameServers
 * @param bool $TheftProtectionLock
 * @param bool $PrivacyProtection
 * @param array $addionalAttributes
 * @return array
 */
$info = $dna->registerWithContactInfo('example.com', 1, [
        'Administrative' => $contact,
        'Billing'        => $contact,
        'Technical'      => $contact,
        'Registrant'     => $contact
    ], [
        "ns1.example.com",
        "ns2.example.com"
    ], true, false);

print_r($info);


/**
 * Array
(
    [result] => OK
    [data] => Array
        (
            [ID] => 0
            [Status] => clientTransferProhibited
            [DomainName] => testdomain859.com
            [AuthCode] => E!m5b3}R6Qq=Wc/9
            [LockStatus] => true
            [PrivacyProtectionStatus] => false
            [IsChildNameServer] => false
            [Contacts] => Array
                (
                    [Billing] => Array
                        (
                            [ID] => 0
                        )

                    [Technical] => Array
                        (
                            [ID] => 0
                        )

                    [Administrative] => Array
                        (
                            [ID] => 0
                        )

                    [Registrant] => Array
                        (
                            [ID] => 0
                        )

                )

            [Dates] => Array
                (
                    [Start] => 2023-03-04T15:45:33+03:00
                    [Expiration] => 2024-03-04T15:45:33+03:00
                    [RemainingDays] => 0
                )

            [NameServers] => Array
                (
                    [0] => tr.atakdomain.info
                    [1] => eu.atakdomain.info
                )

            [Additional] => Array
                (
                )

            [ChildNameServers] => Array
                (
                )

        )

)

 */
