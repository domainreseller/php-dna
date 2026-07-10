<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:56
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: use your Reseller ID (UUID) + API Key from Panel → API Settings (REST),
// or your legacy API username + password (SOAP). Panel login e-mail/password will NOT work.
$username = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID) or legacy API username
$password = 'your-api-key';                          // API Key or legacy API password

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Modify privacy protection status of domain
 * @param string $DomainName
 * @param bool $Status
 * @param string $Reason
 * @return array
 */
$privacy = $dna->modifyPrivacyProtectionStatus('example.com', true/**or false*/, 'Owner request');
print_r($privacy);

/**
 * Array
(
    [result] => OK
    [data] => => Array
        (
            [PrivacyProtectionStatus] =>trıe
   )
)
 */


