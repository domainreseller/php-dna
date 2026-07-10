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

## 📦 Downloaden — gebruik altijd de Releases!

⬇️ **Download hier de nieuwste geteste versie: https://github.com/domainreseller/php-dna/releases/latest**

> ⚠️ Gebruik **niet** de groene knop **Code → Download ZIP** — daarmee downloadt u de ruwe ontwikkelbranch. Release-pakketten zijn geversioneerd, getest en klaar voor productie.

## Installatie en Integratie Gids

### Minimale Vereisten

- PHP7.4 of hoger (Aanbevolen 8.1)
- PHP SOAPClient extensie moet actief zijn (voor SOAP-modus).
- PHP cURL extensie moet actief zijn (voor REST-modus).

## 🔑 API-inloggegevens — Gebruikersnaam/Wachtwoord of Reseller ID/API Key?

Beide worden ondersteund — vul ze in dezelfde twee constructor-parameters in; de bibliotheek detecteert automatisch welke API moet worden gebruikt:

| U heeft | Eerste parameter | Tweede parameter | Gebruikte API |
|---|---|---|---|
| **Nieuwe panel-gegevens** (aanbevolen) | Reseller ID — UUID zoals `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx` | API Key | REST |
| **Legacy-gegevens** | API-gebruikersnaam | API-wachtwoord | SOAP |

> 💡 U vindt uw **Reseller ID** en **API Key** in uw DomainNameAPI-panel onder **API-instellingen**.
> ⚠️ Dit zijn **API-inloggegevens** — het e-mailadres en wachtwoord waarmee u op het panel inlogt, werken hier **niet**.

Er is geen extra configuratie nodig: heeft de eerste parameter een UUID-formaat, dan communiceert de bibliotheek met de moderne REST API, anders valt ze terug op klassiek SOAP. Beide modi geven identieke responsstructuren terug, dus uw integratiecode verandert nooit.

```php
// Nieuwe panel-gegevens (REST)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'your-api-key');

// Legacy-gegevens (SOAP)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('your-api-username', 'your-api-password');
```

### A) Handmatig Gebruik

Download de bestanden en bekijk de voorbeelden in de [examples](examples) map.

```php
require_once __DIR__.'/DomainNameApi/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### B) Voor integratie met Composer

```bash
composer require domainreseller/php-dna 
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### Gebruik

#### Domein Registratie Bewerkingen

Opmerking: Extra parameters zijn vereist voor .tr domeinen. De Additional parameter wordt gebruikt voor domeinnamen die extra informatie vereisen zoals .tr.

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

$dna->RegisterWithContactInfo(
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
    // Additional attributes zijn alleen vereist voor .tr domeinen.
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'         => '17'
    ]);
```

<details>
<summary>Voorbeelduitvoer voor Domeinregistratie</summary>

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

#### Domein Verlenging

```php
$dna->Renew('example.com', 1);
```
<details>
<summary>Voorbeelduitvoer voor Domeinverlenging</summary>

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

#### Domein Transfer

```php
$dna->Transfer('example.com', 'Xy9#mK2$', 3);
```

<details>
<summary>Voorbeelduitvoer voor Domeintransfer</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domein Verwijderen

```php
$dna->DeleteDomain('example.com');
```

<details>
<summary>Voorbeelduitvoer voor Domein Verwijderen</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domein Informatie

```php
$dna->GetDetails('example.com');
```

<details>
<summary>Voorbeelduitvoer voor Domein Informatie</summary>

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

#### Nameserver Informatie

```php
$dna->GetNameServer('example.com');
```

<details>
<summary>Voorbeelduitvoer voor Nameserver Informatie</summary>

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

#### Nameserver Wijzigen

```php
$dna->ModifyNameServer('example.com', ["ns1.example.com", "ns2.example.com"]);
```

<details>
<summary>Voorbeelduitvoer voor Nameserver Wijzigen</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domein Vergrendeling

```php
$lock = $dna->EnableTheftProtectionLock('example.com');
```

<details>
<summary>Voorbeelduitvoer voor Domein Vergrendeling</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domein Ontgrendelen

```php
$unlock = $dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>Voorbeelduitvoer voor Domein Ontgrendelen</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Child NameServer Toevoegen

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Voorbeelduitvoer voor Child NameServer Toevoegen</summary>

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

#### Child NameServer Verwijderen

```php
$dna->DeleteChildNameServer('example.com', 'ns1.example.com');
```

<details>
<summary>Voorbeelduitvoer voor Child NameServer Verwijderen</summary>

```php
Array
(
    [data] => Array
        (
            [NameServer] => ns1.example.com
        )
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Child NameServer Wijzigen

```php
$dna->ModifyChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Voorbeelduitvoer voor Child NameServer Wijzigen</summary>

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

#### Domein Privacy Wijzigen

```php
$lock = $dna->ModifyPrivacyProtectionStatus('example.com', true, 'eigenaar optionele opmerking');
```

<details>
<summary>Voorbeelduitvoer voor Domein Privacy Wijzigen</summary>

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

#### Domein Contact Opslaan

```php
$contact = [
    "FirstName"        => 'John',
    "LastName"         => 'Doe',
    "Company"          => 'Example Corp',
    "EMail"            => 'john@example.com',
    "AddressLine1"     => '123 Main Street',
    "AddressLine2"     => '',
    "AddressLine3"     => '',
    "City"             => 'Springfield',
    "Country"          => 'US',
    "Fax"              => '5559876543',
    "FaxCountryCode"   => '1',
    "Phone"            => '5551234567',
    "PhoneCountryCode" => 1,
    "Type"             => 'Contact',
    "ZipCode"          => '62701',
    "State"            => 'IL'
];

$dna->SaveContacts('example.com', [
    'Administrative' => $contact,
    'Billing'        => $contact,
    'Technical'      => $contact,
    'Registrant'     => $contact
]);
```

<details>
<summary>Voorbeelduitvoer voor Domein Contact Opslaan</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Reseller Details Ophalen

```php
$dna->GetResellerDetails();
```

<details>
<summary>Voorbeelduitvoer voor Reseller Details Ophalen</summary>

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

### Tests

De bibliotheek bevat PHPUnit-tests die verifiëren dat de SOAP- en REST API-responsstructuren overeenkomen.

#### Setup

1. Create a `.env.test` file in the project root:

```env
SOAP_USER=your-soap-username
SOAP_PASS=your-soap-password
REST_USER=your-uuid-rest-username
REST_PASS=your-rest-api-token
SOAP_DOMAIN=yourdomain.com
REST_DOMAIN=yourdomain.com
SOAP_DOMAIN_CONTACTS=yourdomain-with-contacts.com
REST_DOMAIN_CONTACTS=yourdomain-with-contacts.com
```

2. Run all tests:

```bash
env $(cat .env.test | xargs) vendor/bin/phpunit --testdox
```

3. Run specific test suites:

```bash
# SOAP read operations only
env $(cat .env.test | xargs) vendor/bin/phpunit --testdox --filter SoapRead

# REST write operations only
env $(cat .env.test | xargs) vendor/bin/phpunit --testdox --filter RestWrite
```

#### Test Structure

| Test File | Description |
|-----------|-------------|
| `tests/SoapReadTest.php` | SOAP API read operations (GetDetails, GetList, CheckAvailability, etc.) |
| `tests/SoapWriteTest.php` | SOAP API write operations (ModifyNameServer, Lock, ChildNS, etc.) |
| `tests/RestReadTest.php` | REST API read operations |
| `tests/RestWriteTest.php` | REST API write operations |

<hr style="border: 4px solid #000; border-style: dashed;">

## Return en Foutcodes met Beschrijvingen

| Code | Beschrijving | Detail |
|------|-------------|--------|
| 1000 | Commando succesvol voltooid | Operatie succesvol. |
| 1001 | Commando succesvol voltooid; actie in behandeling | Operatie succesvol. De operatie is echter momenteel in de wachtrij geplaatst voor voltooiing. |
| 2003 | Vereiste parameter ontbreekt | Parameter ontbreekt error. Bijvoorbeeld: geen telefoon invoer in contactinformatie. |
| 2105 | Object komt niet in aanmerking voor verlenging | Domeinstatus is niet geschikt voor verlenging, vergrendeld voor update operaties. Status mag niet "clientupdateprohibited" zijn. Kan te wijten zijn aan andere statusvoorwaarden. |
| 2200 | Authenticatiefout | Autorisatiefout, beveiligingscode is onjuist of domein is geregistreerd bij een andere registrar. |
| 2302 | Object bestaat | Domeinnaam of nameserver informatie bestaat al in database. Kan niet geregistreerd worden. |
| 2303 | Object bestaat niet | Domeinnaam of nameserver informatie bestaat niet in database. Nieuwe registratie vereist. |
| 2304 | Objectstatus verbiedt operatie | Domeinstatus is niet geschikt voor updates, vergrendeld voor update operaties. Status mag niet "clientupdateprohibited" zijn. Kan te wijten zijn aan andere statusvoorwaarden. |

| CODE | DETAIL |
|------|--------|
| 101 | Systeemfout gedetailleerd voor ({0})! |
| 102 | Meerdere fouten gedetailleerd voor ({0})! |
| 103 | Onbekende fouten gedetailleerd voor ({0})! |
| 200 | API commando niet gevonden ({0})! |
| 210 | API service niet gevonden ({0})! |
| 211 | API service provider niet ingesteld! |
| 300 | Reseller niet gevonden! |
| 301 | Uw huidige IP-adres is niet geautoriseerd voor toegang. Zorg ervoor dat u verbinding maakt vanaf een geautoriseerd IP-adres en probeer opnieuw |
| 310 | TLD wordt niet ondersteund! |
| 320 | API niet gevonden! |
| 321 | Valuta wordt niet ondersteund! |
| 330 | Vereiste parameter(s) niet ingesteld ({0}). |
| – | Zorg ervoor dat u alle contactobjecten volledig verzendt |
| 340 | Prijsdefinitie niet gevonden ({0}[{1}]-{2}{3}). |
| 350 | Onvoldoende reseller saldo. (Reseller Id : {0} - Huidig Saldo : {1} {2}). |
| 350 | Boekhoudvaluta komt niet overeen of het saldo is niet voldoende. |
| 360 | Ongeldige API aanvraag voor veld ({0}). |
| 360 | API quota overschreden! |
| 361 | Throttled error! |
| 362 | Premium domein is momenteel niet beschikbaar voor registratie. |
| 363 | Operatie geannuleerd omdat domein in auto-vernieuwingsperiode is |
| 364 | Dit domein is momenteel niet beschikbaar voor transactie vanwege een probleem met het register |

| CODE | DETAIL |
|------|--------|
| 400 | Ongeldig contact ({0}). |
| 401 | Contactinfo kan niet synchroniseren. |
| 402 | Geen toegang to contactinformatie van register. |
| 403 | HET SYSTEEM HEEFT ONTBREKENDE INFORMATIE. VOER UW STANDAARDINFORMATIE IN OF NEEM CONTACT OP MET HET ONDERSTEUNINGSTEAM. |
| 404 | DOMEINCONTACT KAN NIET WORDEN BIJGEWERKT. TOESTEMMING VAN HET REGISTER. |
| 410 | Contact niet gevonden. |
| 410 | Contact niet gevonden ({0}). |
| 420 | Ongeldig Api commando voor contact {0}. |
| 430 | Contact api niet gevonden. |
| 440 | Contact is niet gesynchroniseerd. |
| 450 | Te veel domeincontacten.. ! |
| 451 | Kon niet doorgaan met contact update. |

| CODE | DETAIL |
|------|--------|
| 500 | Ongeldig domein id. |
| 500 | Ongeldig domein id ({0}). |
| 501 | Domein kon niet worden gesynchroniseerd({0}) |
| 502 | Interne transfer mislukt |
| 503 | Domeinregistratie is niet beschikbaar. |
| 504 | Domeininformatie komt niet overeen .. Voor :{0} |
| 505 | Voer het IP-adres in. |
| 506 | Domeintransfer is gestart maar contactinfo kon niet worden gelezen .. |
| 507 | Autorisatiefout. |
| 510 | Domein niet gevonden. |
| 511 | Verlopen domeinen kunnen niet worden gevonden. |
| 512 | Domein is niet verlengbaar. |
| 513 | Domein is niet in updatebare status. Het moet actief zijn om te worden bijgewerkt |
| 514 | Redemption Period verwacht. |
| 520 | Ongeldig Api commando voor domein "{0}". |
| 530 | Ongeldige domeinperiode. Periode moet {0} tot {1} jaar zijn. Gevraagde periode is {2} jaar. |
| 540 | Domein kan niet worden verlengd tot meer dan {0} jaar vanaf huidige datum. |
| 550 | Ongeldige domeinnaam. Domein moet {0} tot {1} karakters lang zijn. Gevraagde domeinnaam is {2} karakters. |
| 560 | Ongeldig nameserver aantal. Domein moet {0} tot {1} nameservers hebben. Gevraagd nameserver aantal is {2}. |
| 561 | Geen nameserver informatie gevonden in de binnenkomende aanvraag |
| 570 | Idn niet ondersteund voor tld "{0}". |
| 571 | Periode ongeldig. |
| 572 | Commando ongeldig. |
| 573 | Domeinnamen niet gevonden. |
| 574 | TLD namen niet gevonden. |
| 575 | Domein is niet in updatebare status. Het moet actief zijn voor nameservers om te worden bijgewerkt |
| 576 | Domein kan worden vernieuwd in de laatste 1 maand voor de vervaldatum |
| 580 | Transfer niet ondersteund voor tld "{0}". |
| 581 | Child nameserver niet gevonden |
| 582 | Transfer gestart door andere reseller. |
| 583 | Transfer niet geïnitialiseerd. Neem contact op met het ondersteuningsteam. |
| 584 | Objectstatus verbiedt operatie |
| 590 | Auth code is vereist voor deze transfer. |
| 591 | Auth code is niet geldig. |
| 592 | Transfer lock bestaat op domein. |
| 593 | Domein kan niet worden getransfereerd, Statusinformatie en Transfer Lock moeten voldoen aan de vereiste criteria. (Statusinformatie: #ok) |
| 594 | Domein nameserver adres kon niet worden opgelost ({0}) |
| 595 | Contactinformatie kan niet worden gelezen (whois.registrar.tld) Zorg ervoor dat privacy bescherming status open is |
| 596 | Contactinformatie kon niet worden geverifieerd |
| 597 | Tld niet gevonden |
| 598 | Onbekende fout opgetreden |
| 599 | Domein Forward niet gevonden |
</rewritten_file> 