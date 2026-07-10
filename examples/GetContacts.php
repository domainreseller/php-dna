<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:16
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

// Credentials: use your Reseller ID (UUID) + API Key from Panel → API Settings (REST),
// or your legacy API username + password (SOAP). Panel login e-mail/password will NOT work.
$username = 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx'; // Reseller ID (UUID) or legacy API username
$password = 'your-api-key';                          // API Key or legacy API password

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Get Contacts for domain, Administrative, Billing, Technical, Registrant segments will be returned
 * @param string $DomainName
 * @return array
 */
$contacts=$dna->getContacts('example.com');
print_r($contacts);


/**
Array
(
    [data] => Array
        (
            [contacts] => Array
                (
                    [Administrative] => Array
                        (
                            [ID] => 123456
                            [Status] =>
                            [Additional] => Array
                                (
                                )

                            [Address] => Array
                                (
                                    [Line1] => 123 Main Street
                                    [Line2] => Suite 100
                                    [Line3] =>
                                    [State] => California
                                    [City] => Los Angeles
                                    [Country] => US
                                    [ZipCode] => 90001
                                )

                            [Phone] => Array
                                (
                                    [Phone] => Array
                                        (
                                            [Number] => 5551234567
                                            [CountryCode] => 1
                                        )

                                    [Fax] => Array
                                        (
                                            [Number] => 5559876543
                                            [CountryCode] => 1
                                        )

                                )

                            [AuthCode] =>
                            [FirstName] => John
                            [LastName] => Doe
                            [Company] => Example Corp
                            [EMail] => john.doe@example.com
                            [Type] => Contact
                        )

                    [Billing] => Array
                        (
                            [ID] => 123456
                            [Status] =>
                            [Additional] => Array
                                (
                                )

                            [Address] => Array
                                (
                                    [Line1] => 123 Main Street
                                    [Line2] => Suite 100
                                    [Line3] =>
                                    [State] => California
                                    [City] => Los Angeles
                                    [Country] => US
                                    [ZipCode] => 90001
                                )

                            [Phone] => Array
                                (
                                    [Phone] => Array
                                        (
                                            [Number] => 5551234567
                                            [CountryCode] => 1
                                        )

                                    [Fax] => Array
                                        (
                                            [Number] => 5559876543
                                            [CountryCode] => 1
                                        )

                                )

                            [AuthCode] =>
                            [FirstName] => John
                            [LastName] => Doe
                            [Company] => Example Corp
                            [EMail] => john.doe@example.com
                            [Type] => UkContact
                        )

                    [Registrant] => Array
                        (
                            [ID] => 123456
                            [Status] =>
                            [Additional] => Array
                                (
                                )

                            [Address] => Array
                                (
                                    [Line1] => 123 Main Street
                                    [Line2] => Suite 100
                                    [Line3] =>
                                    [State] => California
                                    [City] => Los Angeles
                                    [Country] => US
                                    [ZipCode] => 90001
                                )

                            [Phone] => Array
                                (
                                    [Phone] => Array
                                        (
                                            [Number] => 5551234567
                                            [CountryCode] => 1
                                        )

                                    [Fax] => Array
                                        (
                                            [Number] => 5559876543
                                            [CountryCode] => 1
                                        )

                                )

                            [AuthCode] =>
                            [FirstName] => John
                            [LastName] => Doe
                            [Company] => Example Corp
                            [EMail] => john.doe@example.com
                            [Type] => EuContact
                        )

                    [Technical] => Array
                        (
                            [ID] => 123456
                            [Status] =>
                            [Additional] => Array
                                (
                                )

                            [Address] => Array
                                (
                                    [Line1] => 123 Main Street
                                    [Line2] => Suite 100
                                    [Line3] =>
                                    [State] => California
                                    [City] => Los Angeles
                                    [Country] => US
                                    [ZipCode] => 90001
                                )

                            [Phone] => Array
                                (
                                    [Phone] => Array
                                        (
                                            [Number] => 5551234567
                                            [CountryCode] => 1
                                        )

                                    [Fax] => Array
                                        (
                                            [Number] => 5559876543
                                            [CountryCode] => 1
                                        )

                                )

                            [AuthCode] =>
                            [FirstName] => John
                            [LastName] => Doe
                            [Company] => Example Corp
                            [EMail] => john.doe@example.com
                            [Type] => CoopContact
                        )

                )

        )

    [result] => OK
)
*/
