<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:17
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */



require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Get Domain details
 * @param string $DomainName
 * @return array
 */
$result = $dna->GetDetails('cnic-test769.bbs.tr');
print_r($result);

/**
 * Array
(
    [data] => Array
        (
            [ID] => 637611
            [Status] => Active
            [DomainName] => cnic-test769.bbs.tr
            [AuthCode] => JS9D89C4GBTBC68XKZ28S3ZGL00SMWAC
            [LockStatus] => true
            [PrivacyProtectionStatus] => false
            [IsChildNameServer] => false
            [Contacts] => Array
                (
                    [Billing] => Array
                        (
                            [ID] => 0
                        )

                    [Technical] => Array
                        (
                            [ID] => 0
                        )

                    [Administrative] => Array
                        (
                            [ID] => 0
                        )

                    [Registrant] => Array
                        (
                            [ID] => 0
                        )

                )

            [Dates] => Array
                (
                    [Start] => 2022-09-09T00:00:00
                    [Expiration] => 2026-09-08T00:00:00
                    [RemainingDays] => 1284
                )

            [NameServers] => Array
                (
                )

            [Additional] => Array
                (
                )

            [ChildNameServers] => Array
                (
                )

        )

    [result] => OK
)
 */
