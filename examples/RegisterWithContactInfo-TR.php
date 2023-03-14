<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:39
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../src/dna.php';

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

$invidual = [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '11111111111111',
        'TRABISNAMESURNAME'    => 'Bünyamin Mutlu',
        'TRABISCOUNTRYID'      => '215',
        'TRABISCITYID'        => '41'
    ];

$commercial = [
    'TRABISDOMAINCATEGORY' => 0,
    'TRABISORGANIZATION'   => 'Bunyamin LTD. STI.',
    'TRABISTAXOFFICE'      => 'GEBZE VD',
    'TRABISTAXNUMBER'      => '10223334445'
];

// For Individual owner set 7th parameter as $invidual
// For Company owner set 7th parameter as $commercial

/**
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
$info = $dna->RegisterWithContactInfo('bunyamin083.com.tr', 1, [
        'Administrative' => $contact,
        'Billing'        => $contact,
        'Technical'      => $contact,
        'Registrant'     => $contact
    ], [
        "tr.atakdomain.com",
        "eu.atakdomain.com"
    ], true, false,
    $invidual
);

print_r($info);


/**
 * Array
(
    [result] => OK
    [data] => Array
        (
            [ID] => 0
            [Status] => active
            [DomainName] => bunyamin083.com.tr
            [AuthCode] =>
            [LockStatus] => true
            [PrivacyProtectionStatus] => false
            [IsChildNameServer] => false
            [Contacts] => Array
                (
                    [Billing] => Array
                        (
                            [ID] => 11965589
                        )

                    [Technical] => Array
                        (
                            [ID] => 11965589
                        )

                    [Administrative] => Array
                        (
                            [ID] => 11965589
                        )

                    [Registrant] => Array
                        (
                            [ID] => 11965589
                        )

                )

            [Dates] => Array
                (
                    [Start] => 2023-03-04T00:00:00
                    [Expiration] => 2024-03-03T00:00:00
                    [RemainingDays] => 0
                )

            [NameServers] => Array
                (
                    [0] => tr.atakdomain.com
                    [1] => eu.atakdomain.com
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
