<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:39
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);



$contact = array(
    "FirstName"        => 'Bunyamin',
    "LastName"         => 'Mutlu',
    "Company"          => '',
    "EMail"            => 'bun.mutlu@gmail.com',
    "AddressLine1"     => 'adres 1 adres 1 adres 1 ',
    "AddressLine2"     => 'test test',
    "AddressLine3"     => '',
    "City"             => 'Kocaeli',
    "Country"          => 'TR',
    "Fax"              => '2626060026',
    "FaxCountryCode"   => '90',
    "Phone"            => '5555555555',
    "PhoneCountryCode" => 90,
    "Type"             => 'Contact',
    "ZipCode"          => '41829',
    "State"            => 'GEBZE'
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
$info = $dna->RegisterWithContactInfo('testdomain859.com', 1, [
        'Administrative' => $contact,
        'Billing'        => $contact,
        'Technical'      => $contact,
        'Registrant'     => $contact
    ], [
        "tr.atakdomain.info",
        "eu.atakdomain.info"
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
