<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:35
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

require_once __DIR__.'/../src/DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);


/**
 * Stops Incoming Transfer
 * @param string $DomainName
 */
$cancel = $dna->CancelTransfer('incomingdomain.com');
print_r($cancel);


/**
 * Array
(
    [result] => OK
    [data] => Array
        (
            [DomainName] => incomingdomain.com
        )

)
 */
