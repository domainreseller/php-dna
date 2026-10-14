<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:41
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: your Reseller ID (UUID) + API Key from Panel → API Settings.
// Panel login credentials will NOT work.
$resellerId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID)
$apiKey     = 'your-api-key';                          // API Key

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($resellerId, $apiKey);

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
