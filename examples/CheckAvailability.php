<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:07
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: your Reseller ID (UUID) + API Key from Panel → API Settings.
// Panel login credentials will NOT work.
$resellerId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID)
$apiKey     = 'your-api-key';                          // API Key

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($resellerId, $apiKey);


/**
 * Check Availability , SLD and TLD must be in array
 * @param array $Domains
 * @param array $TLDs
 * @param int $Period
 * @param string $Command
 * @return array
 */
$result = $dna->checkAvailability(['example','testdomain'],['com','net'],1,'create');
print_r($result);


/**
 *Array
(
    [0] => Array
        (
            [TLD] => com
            [DomainName] => example
            [Status] => notavailable
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 9.9900
            [Currency] => USD
            [Reason] => Domain exists
        )

    [1] => Array
        (
            [TLD] => net
            [DomainName] => testdomain
            [Status] => available
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 12.9900
            [Currency] => USD
            [Reason] =>
        )

    [2] => Array
        (
            [TLD] => net
            [DomainName] => example
            [Status] => notavailable
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 12.9900
            [Currency] => USD
            [Reason] => Domain exists
        )

    [3] => Array
        (
            [TLD] => com
            [DomainName] => testdomain
            [Status] => available
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 9.9900
            [Currency] => USD
            [Reason] =>
        )

)
 */
