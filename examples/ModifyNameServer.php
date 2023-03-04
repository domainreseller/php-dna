<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:22
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */



require_once __DIR__.'/../src/DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Modify Name Server, Nameservers must be valid array
 * @param string $DomainName
 * @param array $NameServers
 * @return array
 */
$ns_change=$dna->ModifyNameServer('domainhakkinda.com',['ns1'=>'ns1.bunyam.in','ns2'=>'ns2.bunyam.in']);
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
