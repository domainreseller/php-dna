<?php
/**
 * Created by PhpStorm.
 * User: bunyaminakcay
 * Project name php-dna
 * 4.03.2023 15:16
 * Bünyamin AKÇAY <bunyamin@bunyam.in>
 */

require_once __DIR__.'/../DomainNameApi/DomainNameAPI_PHPLibrary.php';

$username = 'test1.dna@apiname.com';
$password = 'FsUvpJMzQ69scpqE';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary($username,$password);

/**
 * Get Contacts for domain, Administrative, Billing, Technical, Registrant segments will be returned
 * @param string $DomainName
 * @return array
 */
$contacts=$dna->GetContacts('domainhakkinda.com');
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
                            [ID] => 11965538
                            [Status] =>
                            [Additional] => Array
                                (
                                )

                            [Address] => Array
                                (
                                    [Line1] => adres 1 adres 1 adres 1
                                    [Line2] => test test
                                    [Line3] =>
                                    [State] => GEBZE
                                    [City] => Kocaeli
                                    [Country] => TR
                                    [ZipCode] => 41829
                                )

                            [Phone] => Array
                                (
                                    [Phone] => Array
                                        (
                                            [Number] => 5350000002
                                            [CountryCode] => 90
                                        )

                                    [Fax] => Array
                                        (
                                            [Number] => 2626060026
                                            [CountryCode] => 90
                                        )

                                )

                            [AuthCode] =>
                            [FirstName] => Bunyamin
                            [LastName] => AKCAY
                            [Company] => n/a
                            [EMail] => bakcay@live.com
                            [Type] => Contact
                        )

                    [Billing] => Array
                        (
                            [ID] => 11965538
                            [Status] =>
                            [Additional] => Array
                                (
                                )

                            [Address] => Array
                                (
                                    [Line1] => adres 1 adres 1 adres 1
                                    [Line2] => test test
                                    [Line3] =>
                                    [State] => GEBZE
                                    [City] => Kocaeli
                                    [Country] => TR
                                    [ZipCode] => 41829
                                )

                            [Phone] => Array
                                (
                                    [Phone] => Array
                                        (
                                            [Number] => 5350000002
                                            [CountryCode] => 90
                                        )

                                    [Fax] => Array
                                        (
                                            [Number] => 2626060026
                                            [CountryCode] => 90
                                        )

                                )

                            [AuthCode] =>
                            [FirstName] => Bunyamin
                            [LastName] => AKCAY
                            [Company] => n/a
                            [EMail] => bakcay@live.com
                            [Type] => UkContact
                        )

                    [Registrant] => Array
                        (
                            [ID] => 11965538
                            [Status] =>
                            [Additional] => Array
                                (
                                )

                            [Address] => Array
                                (
                                    [Line1] => adres 1 adres 1 adres 1
                                    [Line2] => test test
                                    [Line3] =>
                                    [State] => GEBZE
                                    [City] => Kocaeli
                                    [Country] => TR
                                    [ZipCode] => 41829
                                )

                            [Phone] => Array
                                (
                                    [Phone] => Array
                                        (
                                            [Number] => 5350000002
                                            [CountryCode] => 90
                                        )

                                    [Fax] => Array
                                        (
                                            [Number] => 2626060026
                                            [CountryCode] => 90
                                        )

                                )

                            [AuthCode] =>
                            [FirstName] => Bunyamin
                            [LastName] => AKCAY
                            [Company] => n/a
                            [EMail] => bakcay@live.com
                            [Type] => EuContact
                        )

                    [Technical] => Array
                        (
                            [ID] => 11965538
                            [Status] =>
                            [Additional] => Array
                                (
                                )

                            [Address] => Array
                                (
                                    [Line1] => adres 1 adres 1 adres 1
                                    [Line2] => test test
                                    [Line3] =>
                                    [State] => GEBZE
                                    [City] => Kocaeli
                                    [Country] => TR
                                    [ZipCode] => 41829
                                )

                            [Phone] => Array
                                (
                                    [Phone] => Array
                                        (
                                            [Number] => 5350000002
                                            [CountryCode] => 90
                                        )

                                    [Fax] => Array
                                        (
                                            [Number] => 2626060026
                                            [CountryCode] => 90
                                        )

                                )

                            [AuthCode] =>
                            [FirstName] => Bunyamin
                            [LastName] => AKCAY
                            [Company] => n/a
                            [EMail] => bakcay@live.com
                            [Type] => CoopContact
                        )

                )

        )

    [result] => OK
)
*/
