<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:13
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: use your Reseller ID (UUID) + API Key from Panel → API Settings (REST),
// or your legacy API username + password (SOAP). Panel login e-mail/password will NOT work.
$username = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID) or legacy API username
$password = 'your-api-key';                          // API Key or legacy API password

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);


$contact = array(
    "FirstName"       => 'John',
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
 * Save Contacts for domain, Contacts segments will be saved as Administrative, Billing, Technical, Registrant.
 * @param string $DomainName
 * @param array $Contacts
 * @return array
 */
$ns_add=$dna->saveContacts('example.com',['Administrative'=>$contact, 'Billing'=>$contact, 'Technical'=>$contact, 'Registrant'=>$contact,]);
print_r($ns_add);


/**
 * Array
(
    [result] => OK
)
 */
