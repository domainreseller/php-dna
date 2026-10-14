<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:31
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: your Reseller ID (UUID) + API Key from Panel → API Settings.
// Panel login credentials will NOT work.
$resellerId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID)
$apiKey     = 'your-api-key';                          // API Key

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($resellerId, $apiKey);


/**
 * Get Current primary Balance for your account
 */
$balance = $dna->getCurrentBalance();
print_r($balance);


/**
 * Array
(
    [ErrorCode] => 0
    [OperationMessage] => Command completed succesfully.
    [OperationResult] => SUCCESS
    [Balance] => 0.00
    [CurrencyId] => 2
    [CurrencyInfo] =>
    [CurrencyName] => USD
    [CurrencySymbol] => $
)
 */
