<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:19
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */


require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: your Reseller ID (UUID) + API Key from Panel → API Settings.
// Panel login credentials will NOT work.
$resellerId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID)
$apiKey     = 'your-api-key';                          // API Key

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($resellerId, $apiKey);

/**
 * Renew domain
 * @param string $DomainName
 * @param int $Period
 * @return array
 */
$renew=$dna->renew('example.com',2);
print_r($renew);

/**
 * Array
(
    [result] => OK
    [data] => => Array
        (
            [ExpirationDate] =>2025-03-04 00:00:00
   )

)
 */
