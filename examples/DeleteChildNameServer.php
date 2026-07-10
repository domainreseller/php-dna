<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:41
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: use your Reseller ID (UUID) + API Key from Panel → API Settings (REST),
// or your legacy API username + password (SOAP). Panel login e-mail/password will NOT work.
$username = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID) or legacy API username
$password = 'your-api-key';                          // API Key or legacy API password

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Delete Child Name Server for domain
 * @param string $DomainName
 * @param string $NameServer
 * @return array
 */
$ns_del = $dna->deleteChildNameServer('example.com', 'ns1.example.com');
print_r($ns_del);


/**
 * Array
(
    [result] => OK
)
 */
