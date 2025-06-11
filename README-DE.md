<div align="center">  
  <a href="README-TR.md"   >   TR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/TR.png" alt="TR" height="20" /></a>  
  <a href="README.md"> | EN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/US.png" alt="EN" height="20" /></a>  
   <a href="README-DE.md"> | DE <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/DE.png" alt="DE" height="20" /></a>  
  <a href="README-SA.md"> | SA <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/SA.png" alt="AR" height="20" /></a>  
  <a href="README-NL.md"> | NL <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/NL.png" alt="NL" height="20" /></a>  
  <a href="README-AZ.md"> | AZ <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/AZ.png" alt="AZ" height="20" /></a>  
  <a href="README-CN.md"> | CN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/CN.png" alt="CN" height="20" /></a>  
  <a href="README-FR.md"> | FR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/FR.png" alt="FR" height="20" /></a>  
  <a href="README-IT.md"> | IT <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/IT.png" alt="IT" height="20" /></a>  
</div>

## Installations- und Integrationsanleitung

### Mindestanforderungen

- PHP7.4 oder höher (Empfohlen 8.1)
- PHP SOAPClient-Erweiterung muss aktiviert sein.

### A) Manuelle Verwendung

Laden Sie die Dateien herunter und prüfen Sie die Beispiele im [examples](examples) Ordner.

```php
require_once __DIR__.'/src/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### B) Integration mit Composer

```bash
composer require domainreseller/php-dna
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### Verwendung

#### Für Domain-Registrierungen

Hinweis: Für .tr Domains werden zusätzliche Parameter benötigt. Bei Domains wie .tr, die zusätzliche Informationen benötigen, wird der Additional-Parameter verwendet.

```php
$contact = [
    "FirstName"        => 'John',
    "LastName"         => 'Doe',
    "Company"          => 'Example Corp',
    "EMail"            => 'john.doe@example.com',
    "AddressLine1"     => '123 Lorem Street',
    "AddressLine2"     => 'Suite 456',
    "AddressLine3"     => '',
    "City"             => 'Springfield',
    "Country"          => 'US',
    "Fax"              => '1234567890',
    "FaxCountryCode"   => '1',
    "Phone"            => '9876543210',
    "PhoneCountryCode" => 1,
    "Type"             => 'Contact',
    "ZipCode"          => '12345',
    "State"            => 'IL'
];

$a->RegisterWithContactInfo(
    'example.com',
    1,
    [
        'Administrative' => $contact,
        'Billing'        => $contact,
        'Technical'      => $contact,
        'Registrant'     => $contact
    ],
    ["ns1.example.com", "ns2.example.com"],
    true,
    false,
    //Addional attributes sadece .tr domainler için gereklidir.
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'        => '17'
    ]);
```

<details>
<summary>Domain Kayıt işlemleri için Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
    [data] => Array
    (
        [ID] => 123456
        [Status] => clientTransferProhibited
        [DomainName] => example.com
        [AuthCode] => Xy9#mK2$pL5@vN8
        [LockStatus] => true
        [PrivacyProtectionStatus] => false
        [IsChildNameServer] => false
        [Contacts] => Array
        (
            [Billing] => Array
            (
                [ID] => 987654
            )
            [Technical] => Array
            (
                [ID] => 987654
            )
            [Administrative] => Array
            (
                [ID] => 987654
            )
            [Registrant] => Array
            (
                [ID] => 987654
            )
        )
        [Dates] => Array
        (
            [Start] => 2024-03-15T10:00:00+03:00
            [Expiration] => 2025-03-15T10:00:00+03:00
            [RemainingDays] => 365
        )
        [NameServers] => Array
        (
            [0] => ns1.example.com
            [1] => ns2.example.com
        )
        [Additional] => Array
        (
            [TRABISDOMAINCATEGORY] => 1
            [TRABISCITIZIENID] => 98765432109
            [TRABISNAMESURNAME] => Jane Smith
            [TRABISCOUNTRYID] => 840
            [TRABISCITYID] => 34
        )
        [ChildNameServers] => Array
        (
                )
          
        )
    )
)


```

</details>


<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain Yenileme

```php
$dna->Renew('example.com', 1);
```
<details>
<summary>Domain Yenileme Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
    [data] => Array
    (
        [ExpirationDate] => 2025-03-15T10:00:00+03:00
    )
)


```

</details>


<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain Transfer

```php
$dna->Transfer('example.com', 'Xy9#mK2$', 3);
```

<details>
<summary>Domain Transfer Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
)


```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">



#### Domain-Namen-Liste

```php
$dna->GetList(['OrderColumn'=>'Id', 'OrderDirection'=>'ASC', 'PageNumber'=>0,'PageSize'=>1000]);
```
<details>
<summary>Domain-Namen-Liste Örnek Çıktı</summary>

```php
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
                [DomainName] => example.com
                [AuthCode] => DHQ!K52
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
                    [Start] => 2024-03-15T10:00:00+03:00
                    [Expiration] => 2025-03-15T10:00:00+03:00
                    [RemainingDays] => 365
                )
                [NameServers] => Array
                (
                    [0] => ns1.example.com
                    [1] => ns2.example.com
                )
                [Additional] => Array
                (
                    [TRABISDOMAINCATEGORY] => 1
                    [TRABISCITIZIENID] => 98765432109
                    [TRABISNAMESURNAME] => Jane Smith
                    [TRABISCOUNTRYID] => 215
                    [TRABISCITYID] => 34
                )
                [ChildNameServers] => Array
                (
                    [0] => Array
                    (
                        [Name] => ns1.example.com
                        [IP] => 1.2.3.4
                    )
                    [1] => Array
                    (
                        [Name] => ns2.example.com
                        [IP] => 2.3.4.5
                    )
                )
            )
        )
    )
    [result] => OK
)


```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### TLD-Liste

```php
$dna->GetTldList(100);
```
<details>

<summary>TLD-Liste Örnek Çıktı</summary>

```php

Array
(
    [data] => Array
        (
            [0] => Array
                (
                    [id] => 1971
                    [status] => Active
                    [maxchar] => 63
                    [maxperiod] => 10
                    [minchar] => 3
                    [minperiod] => 1
                    [tld] =>  cc.bh
                    [pricing] => Array
                        (
                            [backorder] => Array
                                (
                                    [1] => 149.9900
                                )

                            [refund] => Array
                                (
                                    [1] => 149.9900
                                )

                            [restore] => Array
                                (
                                    [1] => 85.0000
                                )

                            [transfer] => Array
                                (
                                    [1] => 149.9900
                                )

                            [renew] => Array
                                (
                                    [1] => 149.9900
                                )

                            [registration] => Array
                                (
                                    [1] => 149.9900
                                )

                        )

                    [currencies] => Array
                        (
                            [backorder] => USD
                            [refund] => USD
                            [restore] => USD
                            [transfer] => USD
                            [renew] => USD
                            [registration] => USD
                        )

                )

            [1] => Array
                (
                    [id] => 1956
                    [status] => Active
                    [maxchar] => 63
                    [maxperiod] => 10
                    [minchar] => 3
                    [minperiod] => 1
                    [tld] => aaa.pro
                    [pricing] => Array
                        (
                            [backorder] => Array
                                (
                                    [1] => 156.2500
                                )

                            [refund] => Array
                                (
                                    [1] => 156.2500
                                )

                            [restore] => Array
                                (
                                    [1] => 80.0000
                                )

                            [transfer] => Array
                                (
                                    [1] => 156.2500
                                )

                            [renew] => Array
                                (
                                    [1] => 156.2500
                                )

                            [registration] => Array
                                (
                                    [1] => 156.2500
                                )

                        )

                    [currencies] => Array
                        (
                            [backorder] => USD
                            [refund] => USD
                            [restore] => USD
                            [transfer] => USD
                            [renew] => USD
                            [registration] => USD
                        )

                )

        )

    [result] => OK
)


```  

</details>

<hr style="border: 4px solid #000; border-style: dashed;">


#### Domain-Name-Verfügbarkeit-Kontrol

```php
$dna->CheckAvailability('example.com',1,'create');
```

<details>
<summary>Domain-Name-Verfügbarkeit-Kontrol Örnek Çıktı</summary>

```php
 *Array
(
    [0] => Array
        (
            [TLD] => com
            [DomainName] => hello
            [Status] => notavailable
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 9.9900
            [Currency] => USD
            [Reason] => Domain exists
        )

    [1] => Array
        (
            [TLD] => net
            [DomainName] => world123x0
            [Status] => available
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 12.9900
            [Currency] => USD
            [Reason] =>
        )
    [2] => Array
        (
            [TLD] => net
            [DomainName] => hello
            [Status] => notavailable
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 12.9900
            [Currency] => USD
            [Reason] => Domain exists
        )

    [3] => Array
        (
            [TLD] => com
            [DomainName] => world123x0
            [Status] => available
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 9.9900
            [Currency] => USD
            [Reason] =>
        )

)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain-Details

```php
$dna->GetDetails('example.com');
```

<details>
<summary>Domain-Details Örnek Çıktı</summary>

```php

Array
(
    [data] => Array
        (
            [ID] => 564346
            [Status] => Active
            [DomainName] => example.com
            [AuthCode] => DHQ!K52
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
                    [Start] => 2025-05-26T16:08:37
                    [Expiration] => 2027-05-26T16:08:37
                    [RemainingDays] => 449
                )

            [NameServers] => Array
                (
                    "ns1.example.com",
                    "ns2.example.com"
                )

            [Additional] => Array
                (
                    [TRABISDOMAINCATEGORY] => 1
                    [TRABISCITIZIENID] => 1112221111111
                    [TRABISNAMESURNAME] => "Bunyamin Mutlu"
                    [TRABISCOUNTRYID] => 215
                    [TRABISCITYID] => 41
                )

            [ChildNameServers] => Array
                (
                    Array
                        (
                            [Name] => 'ns1.example.com'
                            [IP] =>'1.2.3.4'
                            )
                    Array
                        (
                            [Name] => 'ns2.example.com'
                            [IP] =>'2.3.4.5'
                        )
                )
            
        )

    [result] => OK
)

```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Nameserver-Änderung

```php
$dna->ModifyNameServer('example.com', [
    'ns1'=>'ns1.example.com',
    'ns2'=>'ns2.example.com'
]);
```

<details>
<summary>Nameserver-Änderung Örnek Çıktı</summary>

```php

Array
(
    [data] => Array
        (
            [NameServers] => Array
                (
                    [ns1] => ns1.example.com
                    [ns2] => ns2.example.com
                )

        )

    [result] => OK
)

```


</details>

<hr style="border: 4px solid #000; border-style: dashed;">


#### Domain-Sperrung-Aktivierung

```php
    
$lock = $dna->EnableTheftProtectionLock('example.com');
``` 

<details>
<summary>Domain-Sperrung-Aktivierung Örnek Çıktı</summary>

```php

Array
(
    [data] => Array
        (
            [LockStatus] => true
        )

    [result] => OK
)

```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">



#### Domain-Sperrung-Löschen

```php
$lock = $dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>Domain-Sperrung-Löschen Örnek Çıktı</summary>

```php

Array
(
    [data] => Array
        (
            [LockStatus] => false
        )

    [result] => OK
)

``` 

</details>

<hr style="border: 4px solid #000; border-style: dashed;">


#### Domaine ChildNS hinzufügen

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');

```

<details>
<summary>Domaine ChildNS hinzufügen Örnek Çıktı</summary>

```php


Array
(
    [data] => Array
        (
            [NameServer] => test5.example.com
            [IPAdresses] => Array
                (
                    [0] => 1.2.3.4
                )

        )

    [result] => OK
)
    
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">


#### Domaine ChildNS löschen

```php
$dna->DeleteChildNameServer('example.com', 'test5.example.com');

```

<details>
<summary>Domaine ChildNS löschen Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
)
```

</details>


<hr style="border: 4px solid #000; border-style: dashed;">

#### Child NS-Aktualisierung

```php
 $dna->ModifyChildNameServer('example.com', 'test5.example.com', '1.2.3.4');
```

<details>
<summary>Child NS-Aktualisierung Örnek Çıktı</summary>

```php
Array
(
    [data] => Array
        (
            [NameServer] => test5.example.com
            [IPAdresses] => Array
                (
                    [0] => 1.2.3.4
                )

        )

    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain-Privatsphäre-Änderung

```php
$lock = $dna->ModifyPrivacyProtectionStatus('example.com', true, 'owners optional comment');
```

<details>

<summary>Domain-Privatsphäre-Änderung Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
    [data] => => Array
        (
            [PrivacyProtectionStatus] =>trıe
   )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain-Kontakt-Speichern

```php

$contact = [
    "FirstName"        => 'Bunyamin',
    "LastName"         => 'Mutlu',
    "Company"          => '',
    "EMail"            => 'bun.mutlu@gmail.com',
    "AddressLine1"     => 'adres 1 adres 1 adres 1 ',
    "AddressLine2"     => 'test test',
    "AddressLine3"     => '',
    "City"             => 'Kocaeli',
    "Country"          => 'TR',
    "Fax"              => '2626060026',
    "FaxCountryCode"   => '90',
    "Phone"            => '5555555555',
    "PhoneCountryCode" => 90,
    "Type"             => 'Contact',
    "ZipCode"          => '41829',
    "State"            => 'GEBZE'
];

$dna->SaveContacts('example.com','ns1','1.2.3.4');

```

<details>
<summary>Domain-Kontakt-Speichern Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">



#### Reseller-Details abrufen

```php
$dna->GetResellerDetails();
```

<details>
<summary>Reseller-Details abrufen Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
    [id] => 12345
    [active] => 1
    [name] => TEST ACCOUNT 1
    [balance] => 0.0000
    [currency] => USD
    [symbol] => $
    [balances] => Array
        (
            [0] => Array
                (
                    [balance] => 0.0000
                    [currency] => USD
                    [symbol] => $
                )

            [1] => Array
                (
                    [balance] => 0.0000
                    [currency] => TL
                    [symbol] => TL
                )

        )

)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">



## Rückgabe- und Fehlercodes mit Erklärungen

| Code  | Beschreibung                                          | Details                                                           |
|-------|------------------------------------------------------|-------------------------------------------------------------------|
| 1000  | Befehl erfolgreich abgeschlossen                     | Operation erfolgreich.                                             |
| 1001  | Befehl erfolgreich abgeschlossen; Aktion ausstehend  | Operation erfolgreich. Der Vorgang wurde jedoch in die Warteschlange eingereiht. |
| 2003  | Erforderlicher Parameter fehlt                        | Parameterfehler. Zum Beispiel: Keine Telefonnummer in Kontaktinformationen angegeben. |
| 2105  | Objekt ist nicht für Verlängerung geeignet           | Domain-Status erlaubt keine Verlängerung, ist für Updates gesperrt. Status darf nicht "clientupdateprohibited" sein. Kann auch an anderen Statusbedingungen liegen. |
| 2200  | Authentifizierungsfehler                             | Berechtigungsfehler, Sicherheitscode falsch oder Domain bei anderem Registrar. |
| 2302  | Objekt existiert bereits                             | Domain-Name oder Nameserver-Information existiert bereits in der Datenbank. Kann nicht registriert werden. |
| 2303  | Objekt existiert nicht                               | Domain-Name oder Nameserver-Information existiert nicht in der Datenbank. Muss neu erstellt werden. |
| 2304  | Objektstatus verhindert Operation                    | Domain-Status erlaubt keine Aktualisierung, ist für Updates gesperrt. Status darf nicht "clientupdateprohibited" sein. Kann auch an anderen Statusbedingungen liegen. |

| CODE | DETAIL                                                                                                                               |
|------|--------------------------------------------------------------------------------------------------------------------------------------|
| 101  | Systemfehler detailliert für ({0})!                                                                                                  |
| 102  | Mehrere Fehler detailliert für ({0})!                                                                                                |
| 103  | Unbekannte Fehler detailliert für ({0})!                                                                                             |
| 200  | API-Befehl nicht gefunden ({0})!                                                                                                     |
| 210  | API-Service nicht gefunden ({0})!                                                                                                    |
| 211  | API-Service-Provider nicht gesetzt!                                                                                                  |
| 300  | Reseller nicht gefunden!                                                                                                             |
| 301  | Ihre aktuelle IP-Adresse ist nicht für den Zugriff autorisiert. Stellen Sie sicher, dass Sie sich von einer autorisierten IP-Adresse verbinden und versuchen Sie es erneut |
| 310  | TLD wird nicht unterstützt!                                                                                                          |
| 320  | API nicht gefunden!                                                                                                                  |
| 321  | Währung wird nicht unterstützt!                                                                                                      |
| 330  | Erforderliche Parameter nicht gesetzt ({0}).                                                                                         |
| –    | Stellen Sie sicher, dass Sie alle Kontaktobjekte vollständig senden                                                                  |
| 340  | Preisdefinition nicht gefunden ({0}[{1}]-{2}{3}).                                                                                    |
| 350  | Unzureichendes Reseller-Guthaben. (Reseller Id : {0} - Aktuelles Guthaben : {1} {2}).                                                |
| 350  | Buchhaltungswährung stimmt nicht überein oder das Guthaben ist nicht ausreichend.                                                    |
| 360  | Ungültige API-Anfrage für Feld ({0}).                                                                                                |
| 360  | API-Quota überschritten!                                                                                                             |
| 361  | Drosselungsfehler!                                                                                                                   |
| 362  | Premium-Domain ist derzeit nicht für die Registrierung verfügbar.                                                                    |
| 363  | Operation abgebrochen, da sich die Domain in der automatischen Verlängerungsperiode befindet                                        |
| 364  | Diese Domain ist derzeit aufgrund eines Problems mit der Registry nicht für Transaktionen verfügbar                                  |

| CODE | DETAIL                                                                                      |
|------|---------------------------------------------------------------------------------------------|
| 400  | Ungültiger Kontakt ({0}).                                                                   |
| 401  | Kontaktinfo kann nicht synchronisiert werden.                                               |
| 402  | Kein Zugriff auf Kontaktinformationen von der Registry.                                     |
| 403  | DAS SYSTEM HAT FEHLENDE INFORMATIONEN. GEBEN SIE IHRE STANDARDINFORMATIONEN EIN ODER KONTAKTIEREN SIE DAS SUPPORT-TEAM. |
| 404  | DOMAIN-KONTAKT KANN NICHT AKTUALISIERT WERDEN. BERECHTIGUNG VON DER REGISTRY.               |
| 410  | Kontakt nicht gefunden.                                                                     |
| 410  | Kontakt nicht gefunden ({0}).                                                               |
| 420  | Ungültiger Api-Befehl für Kontakt {0}.                                                      |
| 430  | Kontakt-API nicht gefunden.                                                                 |
| 440  | Kontakt ist nicht synchronisiert.                                                           |
| 450  | Zu viele Domain-Kontakte.. !                                                                |
| 451  | Kontaktaktualisierung konnte nicht fortgesetzt werden.                                      |

| CODE | DETAIL                                                                                                                               |
|------|--------------------------------------------------------------------------------------------------------------------------------------|
| 500  | Ungültige Domain-ID.                                                                                                                 |
| 500  | Ungültige Domain-ID ({0}).                                                                                                           |
| 501  | Domain konnte nicht synchronisiert werden({0})                                                                                       |
| 502  | Interner Transfer fehlgeschlagen                                                                                                     |
| 503  | Domain-Registrierung ist nicht verfügbar.                                                                                            |
| 504  | Domain-Informationen stimmen nicht überein .. Vorher :{0}                                                                            |
| 505  | Geben Sie die IP-Adresse ein.                                                                                                        |
| 506  | Domain-Transfer wurde gestartet, aber Kontaktinfo konnte nicht gelesen werden ..                                                     |
| 507  | Autorisierungsfehler.                                                                                                                |
| 510  | Domain nicht gefunden.                                                                                                               |
| 511  | Abgelaufene Domains können nicht gefunden werden.                                                                                    |
| 512  | Domain ist nicht verlängerbar.                                                                                                       |
| 513  | Domain ist nicht in aktualisierbarem Status. Sie muss aktiv sein, um aktualisiert zu werden                                         |
| 514  | Rücknahmeperiode erwartet.                                                                                                           |
| 520  | Ungültiger Api-Befehl für Domain "{0}".                                                                                              |
| 530  | Ungültige Domain-Periode. Periode muss {0} bis {1} Jahre betragen. Angeforderte Periode ist {2} Jahre.                              |
| 540  | Domain kann nicht über {0} Jahre vom aktuellen Datum hinaus verlängert werden.                                                       |
| 550  | Ungültiger Domain-Name. Domain muss {0} bis {1} Zeichen lang sein. Angeforderter Domain-Name ist {2} Zeichen.                       |
| 560  | Ungültige Nameserver-Anzahl. Domain muss {0} bis {1} Nameserver haben. Angeforderte Nameserver-Anzahl ist {2}.                      |
| 561  | Keine Nameserver-Informationen in der eingehenden Anfrage gefunden                                                                   |
| 570  | Idn nicht unterstützt für TLD "{0}".                                                                                                 |
| 571  | Periode ungültig.                                                                                                                    |
| 572  | Befehl ungültig.                                                                                                                     |
| 573  | Domain-Namen nicht gefunden.                                                                                                         |
| 574  | TLD-Namen nicht gefunden.                                                                                                            |
| 575  | Domain ist nicht in aktualisierbarem Status. Sie muss aktiv sein, damit Nameserver aktualisiert werden können                       |
| 576  | Domain kann in dem letzten Monat vor dem Ablaufdatum verlängert werden                                                               |
| 580  | Transfer nicht unterstützt für TLD "{0}".                                                                                            |
| 581  | Child-Nameserver nicht gefunden                                                                                                      |
| 582  | Transfer von anderem Reseller gestartet.                                                                                             |
| 583  | Transfer nicht initialisiert. Bitte kontaktieren Sie das Support-Team.                                                              |
| 584  | Objektstatus verbietet Operation                                                                                                     |
| 590  | Auth-Code ist für diesen Transfer erforderlich.                                                                                      |
| 591  | Auth-Code ist nicht gültig.                                                                                                          |
| 592  | Transfer-Sperre existiert auf Domain.                                                                                                |
| 593  | Domain kann nicht transferiert werden, Statusinformationen und Transfer-Sperre müssen die erforderlichen Kriterien erfüllen. (Statusinformationen: #ok) |
| 594  | Domain-Nameserver-Adresse konnte nicht aufgelöst werden ({0})                                                                        |
| 595  | Kontaktinformationen können nicht gelesen werden (whois.registrar.tld) Stellen Sie sicher, dass der Datenschutzstatus offen ist     |
| 596  | Kontaktinformationen konnten nicht verifiziert werden                                                                                |
| 597  | TLD nicht gefunden                                                                                                                   |
| 598  | Unbekannter Fehler aufgetreten                                                                                                       |
| 599  | Domain-Weiterleitung nicht gefunden                                                                                                  |





