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

## Guida all'Installazione e Integrazione

### Requisiti Minimi

- PHP7.4 o superiore (Raccomandato 8.1)
- L'estensione PHP SOAPClient deve essere attiva.

### A) Utilizzo Manuale

Scarica i file ed esamina gli esempi nella cartella [examples](examples).

```php
require_once __DIR__.'/src/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### B) Per l'integrazione con Composer

```bash
composer require domainreseller/php-dna 
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### Utilizzo

#### Operazioni di Registrazione Domini

Nota: Parametri aggiuntivi sono richiesti per i domini .tr. Il parametro Additional viene utilizzato per nomi di dominio che richiedono informazioni extra come .tr.

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
    //Gli attributi Additional sono richiesti solo per i domini .tr.
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'        => '17'
    ]);
```

<details>
<summary>Output di Esempio per la Registrazione del Dominio</summary>

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

#### Rinnovo Dominio

```php
$dna->Renew('example.com', 1);
```
<details>
<summary>Output di Esempio per il Rinnovo del Dominio</summary>

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

#### Trasferimento Dominio

```php
$dna->Transfer('example.com', 'Xy9#mK2$', 3);
```

<details>
<summary>Output di Esempio per il Trasferimento del Dominio</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Eliminazione Dominio

```php
$dna->DeleteDomain('example.com');
```

<details>
<summary>Output di Esempio per l'Eliminazione del Dominio</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Informazioni Dominio

```php
$dna->GetDetails('example.com');
```

<details>
<summary>Output di Esempio per le Informazioni del Dominio</summary>

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

#### Informazioni Name Server

```php
$dna->GetNameServer('example.com');
```

<details>
<summary>Output di Esempio per le Informazioni Name Server</summary>

```php
Array
(
    [result] => OK
    [data] => Array
    (
        [0] => ns1.example.com
        [1] => ns2.example.com
    )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Modifica Name Server

```php
$dna->ModifyNameServer('example.com', ["ns1.example.com", "ns2.example.com"]);
```

<details>
<summary>Output di Esempio per la Modifica Name Server</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Blocco Dominio

```php
$lock = $dna->EnableTheftProtectionLock('example.com');
```

<details>
<summary>Output di Esempio per il Blocco del Dominio</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Sblocco Dominio

```php
$unlock = $dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>Output di Esempio per lo Sblocco del Dominio</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Aggiungere Child Name Server

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Output di Esempio per Aggiungere Child Name Server</summary>

```php
Array
(
    [data] => Array
        (
            [NameServer] => ns1.example.com
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

#### Eliminare Child Name Server

```php
$dna->DeleteChildNameServer('example.com', 'ns1.example.com');
```

<details>
<summary>Output di Esempio per Eliminare Child Name Server</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Modificare Child Name Server

```php
$dna->ModifyChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Output di Esempio per Modificare Child Name Server</summary>

```php
Array
(
    [data] => Array
        (
            [NameServer] => ns1.example.com
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

#### Modificare Protezione Privacy

```php
$lock = $dna->ModifyPrivacyProtectionStatus('example.com', true, 'commento opzionale del proprietario');
```

<details>
<summary>Output di Esempio per Modificare Protezione Privacy</summary>

```php
Array
(
    [result] => OK
    [data] => Array
        (
            [PrivacyProtectionStatus] => true
        )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Salvare Contatto Dominio

```php
$contact = [
    "FirstName"        => 'Bunyamin',
    "LastName"         => 'Mutlu',
    "Company"          => '',
    "EMail"            => 'bun.mutlu@gmail.com',
    "AddressLine1"     => 'indirizzo 1 indirizzo 1 indirizzo 1 ',
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
<summary>Output di Esempio per Salvare Contatto Dominio</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Ottenere Dettagli Rivenditore

```php
$dna->GetResellerDetails();
```

<details>
<summary>Output di Esempio per Ottenere Dettagli Rivenditore</summary>

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

## Codici di Ritorno ed Errore con Descrizioni

| Codice | Descrizione | Dettaglio |
|--------|-------------|-----------|
| 1000 | Comando completato con successo | Operazione riuscita. |
| 1001 | Comando completato con successo; azione in sospeso | Operazione riuscita. Tuttavia, l'operazione è attualmente in coda per il completamento. |
| 2003 | Parametro richiesto mancante | Errore parametro mancante. Ad esempio: nessuna voce telefonica nelle informazioni di contatto. |
| 2105 | L'oggetto non è idoneo per il rinnovo | Lo stato del dominio non è adatto per il rinnovo, bloccato per operazioni di aggiornamento. Lo stato non dovrebbe essere "clientupdateprohibited". Potrebbe essere dovuto ad altre condizioni di stato. |
| 2200 | Errore di autenticazione | Errore di autorizzazione, codice di sicurezza errato o dominio registrato con un altro registrar. |
| 2302 | L'oggetto esiste | Il nome di dominio o le informazioni del name server esistono già nel database. Non può essere registrato. |
| 2303 | L'oggetto non esiste | Il nome di dominio o le informazioni del name server non esistono nel database. È richiesta una nuova registrazione. |
| 2304 | Lo stato dell'oggetto vieta l'operazione | Lo stato del dominio non è adatto per gli aggiornamenti, bloccato per operazioni di aggiornamento. Lo stato non dovrebbe essere "clientupdateprohibited". Potrebbe essere dovuto ad altre condizioni di stato. |

| CODICE | DETTAGLIO |
|--------|-----------|
| 101 | Errore di sistema dettagliato per ({0})! |
| 102 | Errori multipli dettagliati per ({0})! |
| 103 | Errori sconosciuti dettagliati per ({0})! |
| 200 | Comando API non trovato ({0})! |
| 210 | Servizio API non trovato ({0})! |
| 211 | Provider di servizio API non impostato! |
| 300 | Rivenditore non trovato! |
| 301 | Il tuo indirizzo IP attuale non è autorizzato ad accedere. Assicurati di connetterti da un indirizzo IP autorizzato e riprova |
| 310 | TLD non supportato! |
| 320 | API non trovata! |
| 321 | Valuta non supportata! |
| 330 | Parametro/i richiesto/i non impostato/i ({0}). |
| – | Assicurati di inviare tutti gli oggetti di contatto completi |
| 340 | Definizione prezzo non trovata ({0}[{1}]-{2}{3}). |
| 350 | Saldo rivenditore insufficiente. (Id Rivenditore : {0} - Saldo Attuale : {1} {2}). |
| 350 | La valuta contabile non corrisponde o il saldo non è sufficiente. |
| 360 | Richiesta API non valida per il campo ({0}). |
| 360 | Quota API superata! |
| 361 | Errore di throttling! |
| 362 | Il dominio premium non è disponibile per la registrazione al momento. |
| 363 | Operazione annullata perché il dominio è nel periodo di rinnovo automatico |
| 364 | Questo dominio è attualmente non disponibile per la transazione a causa di un problema con il registro |

| CODICE | DETTAGLIO |
|--------|-----------|
| 400 | Contatto non valido ({0}). |
| 401 | Le informazioni di contatto non possono essere sincronizzate. |
| 402 | Nessun accesso alle informazioni di contatto dal registro. |
| 403 | IL SISTEMA HA INFORMAZIONI MANCANTI. INSERISCI LE TUE INFORMAZIONI PREDEFINITE O CONTATTA IL TEAM DI SUPPORTO. |
| 404 | IL CONTATTO DEL DOMINIO NON PUÒ ESSERE AGGIORNATO. PERMESSO DAL REGISTRO. |
| 410 | Contatto non trovato. |
| 410 | Contatto non trovato ({0}). |
| 420 | Comando Api non valido per il contatto {0}. |
| 430 | API contatto non trovata. |
| 440 | Il contatto non è sincronizzato. |
| 450 | Troppi contatti di dominio.. ! |
| 451 | Impossibile procedere con l'aggiornamento del contatto. |

| CODICE | DETTAGLIO |
|--------|-----------|
| 500 | ID dominio non valido. |
| 500 | ID dominio non valido ({0}). |
| 501 | Il dominio non può essere sincronizzato({0}) |
| 502 | Trasferimento interno fallito |
| 503 | La registrazione del dominio non è disponibile. |
| 504 | Le informazioni del dominio non corrispondono .. Prima :{0} |
| 505 | Inserisci l'indirizzo IP. |
| 506 | Il trasferimento del dominio è stato avviato ma le informazioni di contatto non possono essere lette .. |
| 507 | Errore di autorizzazione. |
| 510 | Dominio non trovato. |
| 511 | I domini scaduti non possono essere trovati. |
| 512 | Il dominio non è rinnovabile. |
| 513 | Il dominio non è in stato aggiornabile. Deve essere attivo per essere aggiornato |
| 514 | Periodo di redenzione previsto. |
| 520 | Comando Api non valido per il dominio "{0}". |
| 530 | Periodo di dominio non valido. Il periodo deve essere da {0} a {1} anni. Il periodo richiesto è {2} anni. |
| 540 | Il dominio non può essere esteso oltre {0} anni dalla data attuale. |
| 550 | Nome di dominio non valido. Il dominio deve essere lungo da {0} a {1} caratteri. Il nome di dominio richiesto è di {2} caratteri. |
| 560 | Numero di name server non valido. Il dominio deve avere da {0} a {1} name server. Il numero di name server richiesto è {2}. |
| 561 | Nessuna informazione name server trovata nella richiesta in arrivo |
| 570 | Idn non supportato per tld "{0}". |
| 571 | Periodo non valido. |
| 572 | Comando non valido. |
| 573 | Nomi di dominio non trovati. |
| 574 | Nomi TLD non trovati. |
| 575 | Il dominio non è in stato aggiornabile. Deve essere attivo per aggiornare i name server |
| 576 | Il dominio può essere rinnovato nell'ultimo mese prima della data di scadenza |
| 580 | Trasferimento non supportato per tld "{0}". |
| 581 | Child name server non trovato |
| 582 | Trasferimento avviato da altro rivenditore. |
| 583 | Trasferimento non inizializzato. Contatta il team di supporto. |
| 584 | Lo stato dell'oggetto vieta l'operazione |
| 590 | Il codice di autorizzazione è richiesto per questo trasferimento. |
| 591 | Il codice di autorizzazione non è valido. |
| 592 | Esiste un blocco di trasferimento sul dominio. |
| 593 | Il dominio non può essere trasferito, le informazioni di stato e il blocco di trasferimento devono rispettare i criteri richiesti. (Informazioni di stato: #ok) |
| 594 | L'indirizzo del name server di dominio non può essere risolto ({0}) |
| 595 | Le informazioni di contatto non possono essere lette (whois.registrar.tld) Assicurati che lo stato di protezione della privacy sia aperto |
| 596 | Le informazioni di contatto non possono essere verificate |
| 597 | Tld non trovato |
| 598 | Si è verificato un errore sconosciuto |
| 599 | Inoltro di dominio non trovato |
</rewritten_file> 