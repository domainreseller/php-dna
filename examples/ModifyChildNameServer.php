<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:41
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Modify IP of Child Name Server for domain
 * @param string $DomainName
 * @param string $NameServer
 * @param string $IPAdresses
 * @return array
 */
$ns_mod = $dna->ModifyChildNameServer('domainhakkinda.com', 'test5.domainhakkinda.com', '1.2.3.4');
print_r($ns_mod);


/**
 * Array
(
    [data] => Array
        (
            [NameServer] => test5.domainhakkinda.com
            [IPAdresses] => Array
                (
                    [0] => 1.2.3.4
                )

        )

    [result] => OK
)
 */
