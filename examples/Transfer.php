<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:39
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: your Reseller ID (UUID) + API Key from Panel → API Settings.
// Panel login credentials will NOT work.
$resellerId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID)
$apiKey     = 'your-api-key';                          // API Key

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($resellerId, $apiKey);


/**
 * Transfer Domain
 * @param string $DomainName
 * @param string $AuthCode
 * @param int $Period
 * @return array
 */
$result = $dna->transfer('example.com', 'ABC123XYZ456',1);
print_r($result);

/**
 * Array
(
    [result] => OK
)
 */
