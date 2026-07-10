<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:36
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: use your Reseller ID (UUID) + API Key from Panel → API Settings (REST),
// or your legacy API username + password (SOAP). Panel login e-mail/password will NOT work.
$username = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID) or legacy API username
$password = 'your-api-key';                          // API Key or legacy API password

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Disable Theft Protection Lock for domain
 * @param string $DomainName
 * @return array
 */
$lock=$dna->disableTheftProtectionLock('example.com');
print_r($lock);
