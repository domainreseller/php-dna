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
    "FirstName"        => 'Ahmet',
    "LastName"         => 'Yilmaz',
    "Company"          => '',
    "EMail"            => 'ahmet.yilmaz@example.com',
    "AddressLine1"     => 'Ornek Sokak No: 123',
    "AddressLine2"     => 'Daire 4',
    "AddressLine3"     => '',
    "City"             => 'Istanbul',
    "Country"          => 'TR',
    "Fax"              => '2121234567',
    "FaxCountryCode"   => '90',
    "Phone"            => '5551234567',
    "PhoneCountryCode" => 90,
    "Type"             => 'Contact',
    "ZipCode"          => '34000',
    "State"            => 'Istanbul'
);

$invidual = [
    'TRABISDOMAINCATEGORY' => 1,
    'TRABISCITIZIENID'     => '11111111111',
    'TRABISNAMESURNAME'    => 'Ahmet Yilmaz',
    'TRABISCOUNTRYID'      => '215',
    'TRABISCITYID'         => '34',
    'TRABISCOUNTRYNAME'    => 'Türkiye',
    'TRABISCITYNAME'       => 'Istanbul',
];

$commercial = [
    'TRABISDOMAINCATEGORY' => 0,
    'TRABISORGANIZATION'   => 'Example Ltd. Sti.',
    'TRABISTAXOFFICE'      => 'Istanbul VD',
    'TRABISTAXNUMBER'      => '1234567890',
    'TRABISCOUNTRYID'      => '215',
    'TRABISCITYID'         => '34',
    'TRABISCOUNTRYNAME'    => 'Türkiye',
    'TRABISCITYNAME'       => 'Istanbul',
];


/**
 * Register domain with contact information,
 * For Individual owner set 7th parameter as $invidual
 * For Company owner set 7th parameter as $commercial
 * Country And City IDs (TRABISCOUNTRYID , TRABISCITYID) can be found from  https://trabis.domainnameapi.com/#countryList
 * if there is no country or city id, you can use country and city name (TRABISCOUNTRYNAME , TRABISCITYNAME)
 * country id , city id  parameters are optional for country name , city name parameters
 * @param string $DomainName
 * @param int $Period
 * @param array $Contacts
 * @param array $NameServers
 * @param bool $TheftProtectionLock
 * @param bool $PrivacyProtection
 * @param array $addionalAttributes
 * @return array
 */
$info = $dna->registerWithContactInfo('example.com.tr', 1, [
        'Administrative' => $contact,
        'Billing'        => $contact,
        'Technical'      => $contact,
        'Registrant'     => $contact
    ], [
        "ns1.example.com",
        "ns2.example.com"
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
