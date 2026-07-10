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

## 📦 Download — always use Releases!

⬇️ **Get the latest tested version here: https://github.com/domainreseller/php-dna/releases/latest**

> ⚠️ Do **not** use the green **Code → Download ZIP** button — that downloads the raw development branch. Release packages are versioned, tested and production-ready.

## Installation and Integration Guide

### Minimum Requirements

- PHP7.4 or higher (Recommended 8.1)
- PHP SOAPClient extension must be active (for SOAP mode).
- PHP cURL extension must be active (for REST mode).

## 🔑 API Credentials — Username/Password or Reseller ID/API Key?

Both are supported — enter them into the same two constructor parameters; the library detects which API to use automatically:

| You have | First parameter | Second parameter | API used |
|---|---|---|---|
| **New panel credentials** (recommended) | Reseller ID — UUID like `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx` | API Key | REST |
| **Legacy credentials** | API username | API password | SOAP |

> 💡 Find your **Reseller ID** and **API Key** in your DomainNameAPI panel under **API Settings**.
> ⚠️ These are **API credentials** — your panel login e-mail and password will **not** work here.

No extra configuration is needed: if the first parameter is in UUID format the library talks to the modern REST API, otherwise it falls back to classic SOAP. Both modes return identical response structures, so your integration code never changes.

```php
// New panel credentials (REST)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'your-api-key');

// Legacy credentials (SOAP)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('your-api-username', 'your-api-password');
```

### A) Manual Usage

Download the files and examine the examples in the [examples](examples) folder.

```php
require_once __DIR__.'/DomainNameApi/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```


### B) Composer Integration

```bash
composer require domainreseller/php-dna
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```


### Usage



#### Domain Registration

Note: Additional parameters are required for .tr domains. The Additional parameter is used for domain names that require extra information like .tr.

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
    // Additional attributes are only required for .tr domains
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'         => '17'
    ]);
```

<details>
<summary>Sample Output for Domain Registration</summary>

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
            [Start] => 2024-03-15T10:00:00
            [Expiration] => 2025-03-15T10:00:00
            [RemainingDays] => 365
        )
        [NameServers] => Array
        (
            [0] => ns1.example.com
            [1] => ns2.example.com
        )
        [Additional] => Array
        (
        )
        [ChildNameServers] => Array
        (
        )
    )
)
```

</details>


<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain Renewal

```php
$dna->Renew('example.com', 1);
```
<details>
<summary>Sample Output for Domain Renewal</summary>

```php
Array
(
    [result] => OK
    [data] => Array
    (
        [ExpirationDate] => 2025-03-15T10:00:00
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
<summary>Sample Output for Domain Transfer</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain List

```php
$dna->GetList(['OrderColumn'=>'Id', 'OrderDirection'=>'ASC', 'PageNumber'=>0,'PageSize'=>1000]);
```
<details>
<summary>Sample Output for Domain List</summary>

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
                    [Start] => 2024-03-15T10:00:00
                    [Expiration] => 2025-03-15T10:00:00
                    [RemainingDays] => 365
                )
                [NameServers] => Array
                (
                    [0] => ns1.example.com
                    [1] => ns2.example.com
                )
                [Additional] => Array
                (
                )
                [ChildNameServers] => Array
                (
                    [0] => Array
                    (
                        [ns] => ns1.example.com
                        [ip] => 1.2.3.4
                    )
                )
            )
        )
    )
    [result] => OK
    [TotalCount] => 1
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### TLD List

```php
$dna->GetTldList(100);
```
<details>

<summary>Sample Output for TLD List</summary>

```php
Array
(
    [data] => Array
        (
            [0] => Array
                (
                    [id] => 1
                    [status] => Active
                    [maxchar] => 63
                    [maxperiod] => 10
                    [minchar] => 1
                    [minperiod] => 1
                    [tld] => com
                    [pricing] => Array
                        (
                            [registration] => Array
                                (
                                    [1] => 10.8100
                                )
                            [renew] => Array
                                (
                                    [1] => 11.0100
                                )
                            [transfer] => Array
                                (
                                    [1] => 10.6100
                                )
                            [restore] => Array
                                (
                                    [1] => 99.9000
                                )
                        )
                    [currencies] => Array
                        (
                            [registration] => USD
                            [renew] => USD
                            [transfer] => USD
                            [restore] => USD
                        )
                )
        )
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain Availability Check

```php
$dna->CheckAvailability(['hello','world123x0'], ['com','net'], 1, 'create');
```

<details>
<summary>Sample Output for Domain Availability Check</summary>

```php
Array
(
    [0] => Array
        (
            [TLD] => com
            [DomainName] => hello
            [Status] => notavailable
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 10.8100
            [Currency] => USD
            [Reason] => Domain exists
        )

    [1] => Array
        (
            [TLD] => com
            [DomainName] => world123x0
            [Status] => available
            [Command] => create
            [Period] => 1
            [IsFee] =>
            [Price] => 10.8100
            [Currency] => USD
            [Reason] =>
        )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain Details

```php
$dna->GetDetails('example.com');
```

<details>
<summary>Sample Output for Domain Details</summary>

```php
Array
(
    [data] => Array
        (
            [ID] => 564346
            [Status] => Active
            [DomainName] => example.com
            [AuthCode] => DHQ!K52
            [LockStatus] => true
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
                    [0] => ns1.example.com
                    [1] => ns2.example.com
                )
            [Additional] => Array
                (
                )
            [ChildNameServers] => Array
                (
                    [0] => Array
                        (
                            [ns] => ns1.example.com
                            [ip] => 1.2.3.4
                        )
                )
        )
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Nameserver Modification

```php
$dna->ModifyNameServer('example.com', ['ns1.example.com', 'ns2.example.com']);
```

<details>
<summary>Sample Output for Nameserver Modification</summary>

```php
Array
(
    [data] => Array
        (
            [NameServers] => Array
                (
                    [0] => ns1.example.com
                    [1] => ns2.example.com
                )
        )
    [result] => OK
)
```


</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Enable Domain Lock

```php
$dna->EnableTheftProtectionLock('example.com');
```

<details>
<summary>Sample Output for Enable Domain Lock</summary>

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

#### Disable Domain Lock

```php
$dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>Sample Output for Disable Domain Lock</summary>

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

#### Add Child Nameserver

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Sample Output for Add Child Nameserver</summary>

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

#### Delete Child Nameserver

```php
$dna->DeleteChildNameServer('example.com', 'ns1.example.com');
```

<details>
<summary>Sample Output for Delete Child Nameserver</summary>

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

#### Update Child Nameserver

```php
$dna->ModifyChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Sample Output for Update Child Nameserver</summary>

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

#### Modify Domain Privacy

```php
$dna->ModifyPrivacyProtectionStatus('example.com', true, 'Owner request');
```

<details>

<summary>Sample Output for Modify Domain Privacy</summary>

```php
Array
(
    [data] => Array
        (
            [PrivacyProtectionStatus] => true
        )
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Save Domain Contacts

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
<summary>Sample Output for Save Domain Contacts</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Get Reseller Details

```php
$dna->GetResellerDetails();
```

<details>
<summary>Sample Output for Get Reseller Details</summary>

```php
Array
(
    [result] => OK
    [id] => 12345
    [active] => 1
    [name] => Example Reseller
    [balance] => 500.0000
    [currency] => USD
    [symbol] => $
    [balances] => Array
        (
            [0] => Array
                (
                    [balance] => 500.0000
                    [currency] => USD
                    [symbol] => $
                )
            [1] => Array
                (
                    [balance] => 1500.0000
                    [currency] => TL
                    [symbol] => TL
                )
        )
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

### Testing

The library includes PHPUnit tests that verify both SOAP and REST API response structures match.

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

## Return and Error Codes with Descriptions

| Code | Description                                    | Detail                                                                                                                                                         |
|------|------------------------------------------------|----------------------------------------------------------------------------------------------------------------------------------------------------------------|
| 1000 | Command completed successfully                 | Operation successful.                                                                                                                                          |
| 1001 | Command completed successfully; action pending | Operation successful. However, the operation is currently queued for completion.                                                                               |
| 2003 | Required parameter missing                     | Parameter missing error. For example, no phone entry in contact information.                                                                                   |
| 2105 | Object is not eligible for renewal             | Domain status is not suitable for renewal, locked for update operations. Status should not be "clientupdateprohibited". May be due to other status conditions. |
| 2200 | Authentication error                           | Authorization error, security code is incorrect or domain is registered with another registrar.                                                                |
| 2302 | Object exists                                  | Domain name or nameserver information already exists in database. Cannot be registered.                                                                        |
| 2303 | Object does not exist                          | Domain name or nameserver information does not exist in database. New registration required.                                                                   |
| 2304 | Object status prohibits operation              | Domain status is not suitable for updates, locked for update operations. Status should not be "clientupdateprohibited". May be due to other status conditions. |

| CODE | DETAIL                                                                                                                               |
|------|--------------------------------------------------------------------------------------------------------------------------------------|
| 101  | System Error Detailed For ({0})!                                                                                                     |
| 102  | Multiple Errors Detailed For ({0})!                                                                                                  |
| 103  | Unknown Errors Detailed For ({0})!                                                                                                   |
| 200  | API command not found ({0})!                                                                                                         |
| 210  | API service not found ({0})!                                                                                                         |
| 211  | API service provider not set!                                                                                                        |
| 300  | Reseller not found!                                                                                                                  |
| 301  | Your current IP address is not authorized to access. Please make sure you are connecting from an authorized IP address and try again |
| 310  | TLD is not supported!                                                                                                                |
| 320  | API not found!                                                                                                                       |
| 321  | Currency is not supported!                                                                                                           |
| 330  | Required parameter(s) not set ({0}).                                                                                                 |
| –    | Make sure you send all contact objects full                                                                                          |
| 340  | Price definition not found ({0}[{1}]-{2}{3}).                                                                                        |
| 350  | Insufficient reseller balance. (Reseller Id : {0} - Current Balance : {1} {2}).                                                      |
| 350  | Accounting currency does not match or the balance is not sufficient.                                                                 |
| 360  | Invalid API request for field ({0}).                                                                                                 |
| 360  | API quota exceeded!                                                                                                                  |
| 361  | Throttled error!                                                                                                                     |
| 362  | Premium domain is not available to register right now.                                                                               |
| 363  | Operation cancelled because domain in auto-renewal period                                                                            |
| 364  | This domain is currently unavailable for transaction due to a problem with the registry                                              |

| CODE | DETAIL                                                                                      |
|------|---------------------------------------------------------------------------------------------|
| 400  | Invalid contact ({0}).                                                                      |
| 401  | Contact info can not sync.                                                                  |
| 402  | No access to contact information from registry.                                             |
| 403  | THE SYSTEM HAS MISSING INFORMATION. ENTER YOUR DEFAULT INFORMATION OR CONTACT SUPPORT TEAM. |
| 404  | DOMAIN CONTACT CANNOT UPDATE. PERMISSION FROM THE REGISTRY.                                 |
| 410  | Contact not found.                                                                          |
| 410  | Contact not found ({0}).                                                                    |
| 420  | Invalid Api command for contact {0}.                                                        |
| 430  | Contact api not found.                                                                      |
| 440  | Contact is not synced.                                                                      |
| 450  | Too many domain contacts!                                                                   |
| 451  | Failed to proceed with contact update.                                                      |

| CODE | DETAIL                                                                                                                               |
|------|--------------------------------------------------------------------------------------------------------------------------------------|
| 500  | Invalid domain id.                                                                                                                   |
| 500  | Invalid domain id ({0}).                                                                                                             |
| 501  | Domain could not synchronized({0})                                                                                                   |
| 502  | Internal transfer failed                                                                                                             |
| 503  | Domain registration is not available.                                                                                                |
| 504  | Domain information does not match. Before :{0}                                                                                       |
| 505  | Enter the Ip Address.                                                                                                                |
| 506  | Domain Transfer Has Been Started But Contact Info Not Read.                                                                          |
| 507  | Authorization error.                                                                                                                 |
| 510  | Domain not found.                                                                                                                    |
| 511  | Expired domains cannot be found.                                                                                                     |
| 512  | Domain is not renewable.                                                                                                             |
| 513  | Domain is not in updateable status. It must be active for to be updated                                                              |
| 514  | Redemption Period Expected.                                                                                                          |
| 520  | Invalid Api command for domain "{0}".                                                                                                |
| 530  | Invalid domain period. Period must be {0} to {1} years. Requested period is {2} years.                                               |
| 540  | Domain cannot be extended beyond {0} years from current date.                                                                        |
| 550  | Invalid domain name. Domain must be {0} to {1} characters length. Requested domain name is {2} characters.                           |
| 560  | Invalid name server count. Domain must have {0} to {1} name servers. Requested name server count is {2}.                             |
| 561  | No name server information found in the incoming request                                                                             |
| 570  | Idn not supported for tld "{0}".                                                                                                     |
| 571  | Period invalid.                                                                                                                      |
| 572  | Command invalid.                                                                                                                     |
| 573  | Domain names not found.                                                                                                              |
| 574  | TLD names not found.                                                                                                                 |
| 575  | Domain is not in updateable status. It must be active for name servers to be updated                                                 |
| 576  | Domain can be renewed in the last 1 month before the expire date                                                                     |
| 580  | Transfer not supported for tld "{0}".                                                                                                |
| 581  | Child name server not found                                                                                                          |
| 582  | Transfer started by other reseller.                                                                                                  |
| 583  | Transfer not initialized. Please contact the support team.                                                                           |
| 584  | Object status prohibits operation                                                                                                    |
| 590  | Auth code is required for this transfer.                                                                                             |
| 591  | Auth code is not valid.                                                                                                              |
| 592  | Transfer lock exists on domain.                                                                                                      |
| 593  | Domain cannot be transferred, Status Information and Transfer Lock must comply with the required criteria. (Status Information: #ok) |
| 594  | Domain name server address could not resolved ({0})                                                                                  |
| 595  | Contact information can not be read (whois.registrar.tld) Please make sure that privacy protection status open                       |
| 596  | Contact information could not verified                                                                                               |
| 597  | Tld Not Found                                                                                                                        |
| 598  | Unknown error occurred                                                                                                               |
| 599  | Domain Forward Not Found                                                                                                             |
