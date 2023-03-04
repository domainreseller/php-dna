<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:13
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../src/DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);


$contact = array(
    "FirstName"       => 'Bunyamin',
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
 * Save Contacts for domain, Contacts segments will be saved as Administrative, Billing, Technical, Registrant.
 * @param string $DomainName
 * @param array $Contacts
 * @return array
 */
$ns_add=$dna->SaveContacts('domainhakkinda.com',['Administrative'=>$contact, 'Billing'=>$contact, 'Technical'=>$contact, 'Registrant'=>$contact,]);
print_r($ns_add);


/**
 * Array
(
    [result] => OK
)
 */
