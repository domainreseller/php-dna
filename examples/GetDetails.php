<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 14:17
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */



require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: use your Reseller ID (UUID) + API Key from Panel → API Settings (REST),
// or your legacy API username + password (SOAP). Panel login e-mail/password will NOT work.
$username = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID) or legacy API username
$password = 'your-api-key';                          // API Key or legacy API password

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Get Domain details
 * @param string $DomainName
 * @return array
 */
$result = $dna->getDetails('example.com');
print_r($result);

/**
 * Array
(
    [data] => Array
        (
            [ID] => 123456
            [Status] => Active
            [DomainName] => example.com
            [AuthCode] => ABC123XYZ456DEF789GHI012JKL345MNO
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
