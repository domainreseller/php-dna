<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:22
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */



require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: your Reseller ID (UUID) + API Key from Panel → API Settings.
// Panel login credentials will NOT work.
$resellerId = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID)
$apiKey     = 'your-api-key';                          // API Key

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($resellerId, $apiKey);

/**
 * Modify Name Server, Nameservers must be valid array
 * @param string $DomainName
 * @param array $NameServers
 * @return array
 */
$ns_change=$dna->modifyNameServer('example.com',['ns1'=>'ns1.example.com','ns2'=>'ns2.example.com']);
print_r($ns_change);


/**
 * Array
(
    [data] => Array
        (
            [NameServers] => Array
                (
                    [ns1] => ns1.bunyam.in
                    [ns2] => ns2.bunyam.in
                )

        )

    [result] => OK
)
 */
