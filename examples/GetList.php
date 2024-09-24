<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 13:57
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */
require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);


/**
 * Get Domain List 0f your account
 * @return array
 */
$domainlist = $dna->GetList();
print_r($domainlist);



//
/*
Array
(
    [data] => Array
        (
            [Domains] => Array
                (
                    [0] => Array
                        (
                            [ID] => 564346
                            [Status] => Active
                            [DomainName] => domainhakkinda.com
                            [AuthCode] => Qg7=b3}TS?e42xN&
                            [LockStatus] => false
                            [PrivacyProtectionStatus] => false
                            [IsChildNameServer] => false
                            [Contacts] => Array
                                (
                                    [Billing] => Array
                                        (
                                            [ID] => 11854114
                                        )

                                    [Technical] => Array
                                        (
                                            [ID] => 11854114
                                        )

                                    [Administrative] => Array
                                        (
                                            [ID] => 11854114
                                        )

                                    [Registrant] => Array
                                        (
                                            [ID] => 11854114
                                        )

                                )

                            [Dates] => Array
                                (
                                    [Start] => 2022-05-26T16:08:37
                                    [Expiration] => 2024-05-26T16:08:37
                                    [RemainingDays] => 449
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

                    [1] => Array
                        (
                            [ID] => 632424
                            [Status] => Active
                            [DomainName] => necati10916.com.tr
                            [AuthCode] => 1UXVRL03XUCPMRMPYYN7EF6TBV72WXVJ
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
                                    [Start] => 2022-08-28T00:00:00
                                    [Expiration] => 2024-08-27T00:00:00
                                    [RemainingDays] => 542
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

                    [2] => Array
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


                )

        )

    [result] => OK
)
*/

