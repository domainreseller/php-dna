<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:31
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

require_once __DIR__.'/../src/DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);


/**
 * Get Current primary Balance for your account
 */
$balance = $dna->GetCurrentBalance();
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
