<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:36
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Disable Theft Protection Lock for domain
 * @param string $DomainName
 * @return array
 */
$lock=$dna->DisableTheftProtectionLock('domainhakkinda.com');
print_r($lock);
