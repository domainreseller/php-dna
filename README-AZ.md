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

## 📦 Yükləmə — həmişə Releases istifadə edin!

⬇️ **Ən son test edilmiş versiyanı buradan əldə edin: https://github.com/domainreseller/php-dna/releases/latest**

> ⚠️ Yaşıl **Code → Download ZIP** düyməsindən **istifadə etməyin** — bu, xam inkişaf branch-ını yükləyir. Release paketləri versiyalanmış, test edilmiş və istehsalata hazırdır.

## Quraşdırma və İnteqrasiya Təlimatı

### Minimum Tələblər

- PHP7.4 və ya daha yuxarı (Təklif olunan 8.1)
- PHP SOAPClient əlavəsi aktiv olmalıdır (SOAP rejimi üçün).
- PHP cURL əlavəsi aktiv olmalıdır (REST rejimi üçün).

## 🔑 API Məlumatları — İstifadəçi adı/Şifrə, yoxsa Reseller ID/API Key?

Hər ikisi dəstəklənir — məlumatları eyni iki constructor parametrinə daxil edin; kitabxana hansı API-nin istifadə olunacağını avtomatik müəyyən edir:

| Sizdə olan | Birinci parametr | İkinci parametr | İstifadə olunan API |
|---|---|---|---|
| **Yeni panel məlumatları** (tövsiyə olunur) | Reseller ID — `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx` kimi UUID | API Key | REST |
| **Köhnə (legacy) məlumatlar** | API istifadəçi adı | API şifrəsi | SOAP |

> 💡 **Reseller ID** və **API Key** məlumatlarınızı DomainNameAPI panelinizdə **API Parametrləri** bölməsində tapa bilərsiniz.
> ⚠️ Bunlar **API məlumatlarıdır** — panelə giriş e-poçtunuz və şifrəniz burada **işləməyəcək**.

Heç bir əlavə konfiqurasiya lazım deyil: birinci parametr UUID formatındadırsa, kitabxana müasir REST API ilə əlaqə qurur, əks halda klassik SOAP-a keçir. Hər iki rejim eyni cavab strukturunu qaytarır, ona görə də inteqrasiya kodunuz heç vaxt dəyişmir.

```php
// Yeni panel məlumatları (REST)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'your-api-key');

// Köhnə (legacy) məlumatlar (SOAP)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('your-api-username', 'your-api-password');
```

### A) Manual İstifadə

Faylları endirin və [examples](examples) qovluğundakı nümunələrə baxın.

```php
require_once __DIR__.'/DomainNameApi/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### B) Composer ilə inteqrasiya üçün

```bash
composer require domainreseller/php-dna 
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### İstifadə

#### Domen Qeydiyyat Əməliyyatları

Qeyd: .tr domenləri üçün əlavə parametrlər tələb olunur. Additional parametri .tr kimi əlavə məlumat tələb edən domen adları üçün istifadə olunur.

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
    // Additional atributları yalnız .tr domenləri üçün tələb olunur.
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'         => '17'
    ]);
```

<details>
<summary>Domen Qeydiyyatı üçün Nümunə Çıxış</summary>

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

#### Domen Yenilənməsi

```php
$dna->Renew('example.com', 1);
```
<details>
<summary>Domen Yenilənməsi üçün Nümunə Çıxış</summary>

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

#### Domen Transferi

```php
$dna->Transfer('example.com', 'Xy9#mK2$', 3);
```

<details>
<summary>Domen Transferi üçün Nümunə Çıxış</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domen Silmə

```php
$dna->DeleteDomain('example.com');
```

<details>
<summary>Domen Silmə üçün Nümunə Çıxış</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domen Məlumatları

```php
$dna->GetDetails('example.com');
```

<details>
<summary>Domen Məlumatları üçün Nümunə Çıxış</summary>

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

#### Nameserver Məlumatları

```php
$dna->GetNameServer('example.com');
```

<details>
<summary>Nameserver Məlumatları üçün Nümunə Çıxış</summary>

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

#### Nameserver Dəyişdirmə

```php
$dna->ModifyNameServer('example.com', ["ns1.example.com", "ns2.example.com"]);
```

<details>
<summary>Nameserver Dəyişdirmə üçün Nümunə Çıxış</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domen Kilidi

```php
$lock = $dna->EnableTheftProtectionLock('example.com');
```

<details>
<summary>Domen Kilidi üçün Nümunə Çıxış</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Domen Kilidini Açmaq

```php
$unlock = $dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>Domen Kilidini Açmaq üçün Nümunə Çıxış</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Child NameServer Əlavə Etmək

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Child NameServer Əlavə Etmək üçün Nümunə Çıxış</summary>

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

#### Child NameServer Silmə

```php
$dna->DeleteChildNameServer('example.com', 'ns1.example.com');
```

<details>
<summary>Child NameServer Silmə üçün Nümunə Çıxış</summary>

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

#### Child NameServer Dəyişdirmə

```php
$dna->ModifyChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>Child NameServer Dəyişdirmə üçün Nümunə Çıxış</summary>

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

#### Domen Məxfiliyi Dəyişdirmə

```php
$lock = $dna->ModifyPrivacyProtectionStatus('example.com', true, 'sahibin istəyə bağlı şərhi');
```

<details>
<summary>Domen Məxfiliyi Dəyişdirmə üçün Nümunə Çıxış</summary>

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

#### Domen Əlaqə Saxlamaq

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
<summary>Domen Əlaqə Saxlamaq üçün Nümunə Çıxış</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### Satıcı Təfərrüatlarını Əldə Etmək

```php
$dna->GetResellerDetails();
```

<details>
<summary>Satıcı Təfərrüatlarını Əldə Etmək üçün Nümunə Çıxış</summary>

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

### Testlər

Kitabxana, həm SOAP həm REST API cavab strukturlarının uyğunluğunu yoxlayan PHPUnit testləri ehtiva edir.

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

## Geri Dönüş və Xəta Kodları ilə Açıqlamaları

| Kod | Açıqlama | Təfərrüat |
|-----|----------|-----------|
| 1000 | Əmr uğurla tamamlandı | Əməliyyat uğurlu. |
| 1001 | Əmr uğurla tamamlandı; hərəkət gözləmədə | Əməliyyat uğurlu. Bununla belə, əməliyyat hazırda tamamlanması üçün növbəyə alınıb. |
| 2003 | Tələb olunan parametr çatışmır | Parametr çatışmır xətası. Məsələn: əlaqə məlumatlarında telefon girişi yox. |
| 2105 | Obyekt yenilənmə üçün uyğun deyil | Domen statusu yenilənmə üçün uyğun deyil, yeniləmə əməliyyatları üçün kilidlənib. Status "clientupdateprohibited" olmamalıdır. Digər status şərtlərindən qaynaqlanana bilər. |
| 2200 | Kimlik doğrulama xətası | İcazə xətası, təhlükəsizlik kodu səhvdir və ya domen başqa qeydiyyat şirkətində mövcuddur. |
| 2302 | Obyekt mövcuddur | Domen adı və ya nameserver məlumatları verilənlər bazasında mövcuddur. Qeydiyyat edilə bilməz. |
| 2303 | Obyekt mövcud deyil | Domen adı və ya nameserver məlumatları verilənlər bazasında mövcud deyil. Yeni qeydiyyat tələb olunur. |
| 2304 | Obyekt statusu əməliyyatı qadağan edir | Domen statusu yeniləmələr üçün uyğun deyil, yeniləmə əməliyyatları üçün kilidlənib. Status "clientupdateprohibited" olmamalıdır. Digər status şərtlərindən qaynaqlanana bilər. |

| KOD | TƏFƏRRÜAT |
|-----|-----------|
| 101 | Sistem Xətası Təfərrüatlı ({0}) Üçün! |
| 102 | Çoxlu Xətalar Təfərrüatlı ({0}) Üçün! |
| 103 | Naməlum Xətalar Təfərrüatlı ({0}) Üçün! |
| 200 | API əmri tapılmadı ({0})! |
| 210 | API xidməti tapılmadı ({0})! |
| 211 | API xidmət provayderi təyin edilməyib! |
| 300 | Satıcı tapılmadı! |
| 301 | Hazırkı IP ünvanınız girişə icazəli deyil. İcazəli IP ünvanından qoşulduğunuzdan əmin olun və yenidən cəhd edin |
| 310 | TLD dəstəklənmir! |
| 320 | API tapılmadı! |
| 321 | Valyuta dəstəklənmir! |
| 330 | Tələb olunan parametr(lər) təyin edilməyib ({0}). |
| – | Bütün əlaqə obyektlərini tam göndərdiyinizə əmin olun |
| 340 | Qiymət tərifə tapılmadı ({0}[{1}]-{2}{3}). |
| 350 | Kifayət qədər satıcı balansı yoxdur. (Satıcı Id : {0} - Hazırkı Balans : {1} {2}). |
| 350 | Mühasibat valyutası uyğunlaşmır və ya balans kifayət deyil. |
| 360 | Sahə ({0}) üçün etibarsız API sorğusu. |
| 360 | API kvotası aşılıb! |
| 361 | Throttled xətası! |
| 362 | Premium domen hazırda qeydiyyat üçün əlçatan deyil. |
| 363 | Domen avtomatik yenilənmə dövründə olduğu üçün əməliyyat ləğv edildi |
| 364 | Bu domen hazırda qeydiyyat ilə bağlı problem səbəbindən əməliyyat üçün əlçatan deyil |

| KOD | TƏFƏRRÜAT |
|-----|-----------|
| 400 | Etibarsız əlaqə ({0}). |
| 401 | Əlaqə məlumatı sinxronlaşdırıla bilmir. |
| 402 | Qeydiyyat dəftərindən əlaqə məlumatlarına giriş yoxdur. |
| 403 | SİSTEMDƏ ÇATIŞMAYAN MƏLUMAT VAR. STANDART MƏLUMATLARINIZI DAXİL EDİN VƏ YA DƏSTƏK KOMANDASI İLƏ ƏLAQƏ SAXLAYIN. |
| 404 | DOMEN ƏLAQƏSI YENİLƏNƏ BİLMİR. QEYDİYYAT DƏFTƏRİNDƏN İCAZƏ. |
| 410 | Əlaqə tapılmadı. |
| 410 | Əlaqə tapılmadı ({0}). |
| 420 | Əlaqə {0} üçün etibarsız Api əmri. |
| 430 | Əlaqə api-si tapılmadı. |
| 440 | Əlaqə sinxronlaşdırılmayıb. |
| 450 | Çox çoxlu domen əlaqələri.. ! |
| 451 | Əlaqə yeniləməsi ilə davam edilə bilmədi. |

| KOD | TƏFƏRRÜAT |
|-----|-----------|
| 500 | Etibarsız domen id. |
| 500 | Etibarsız domen id ({0}). |
| 501 | Domen sinxronlaşdırıla bilmədi({0}) |
| 502 | Daxili transfer uğursuz oldu |
| 503 | Domen qeydiyyatı əlçatan deyil. |
| 504 | Domen məlumatları uyğunlaşmır .. Əvvəl :{0} |
| 505 | IP Ünvanını daxil edin. |
| 506 | Domen Transferi Başladıldı Lakin Əlaqə Məlumatı Oxuna Bilmədi .. |
| 507 | İcazə xətası. |
| 510 | Domen tapılmadı. |
| 511 | Vaxtı keçmiş domenlər tapıla bilmir. |
| 512 | Domen yenilənə bilmir. |
| 513 | Domen yenilənə bilən statusda deyil. Yenilənə bilməsi üçün aktiv olmalıdır |
| 514 | Bərpa Dövrü Gözlənilir. |
| 520 | Domen "{0}" üçün etibarsız Api əmri. |
| 530 | Etibarsız domen müddəti. Müddət {0} ilə {1} il arasında olmalıdır. Tələb olunan müddət {2} ildir. |
| 540 | Domen hazırkı tarixdən {0} ildən artıq uzadıla bilməz. |
| 550 | Etibarsız domen adı. Domen {0} ilə {1} simvol uzunluğunda olmalıdır. Tələb olunan domen adı {2} simvoldur. |
| 560 | Etibarsız nameserver sayı. Domen {0} ilə {1} nameserverə sahib olmalıdır. Tələb olunan nameserver sayı {2}. |
| 561 | Daxil olan sorğuda nameserver məlumatı tapılmadı |
| 570 | Idn tld "{0}" üçün dəstəklənmir. |
| 571 | Müddət etibarsızdır. |
| 572 | Əmr etibarsızdır. |
| 573 | Domen adları tapılmadı. |
| 574 | TLD adları tapılmadı. |
| 575 | Domen yenilənə bilən statusda deyil. Nameserverlər yenilənə bilməsi üçün aktiv olmalıdır |
| 576 | Domen son istifadə tarixindən əvvəlki son 1 ay ərzində yenilənə bilər |
| 580 | Transfer tld "{0}" üçün dəstəklənmir. |
| 581 | Uşaq nameserveri tapılmadı |
| 582 | Transfer başqa satıcı tərəfindən başladıldı. |
| 583 | Transfer başladılmadı. Dəstək komandası ilə əlaqə saxlayın. |
| 584 | Obyekt statusu əməliyyatı qadağan edir |
| 590 | Bu transfer üçün auth kodu tələb olunur. |
| 591 | Auth kodu etibarsızdır. |
| 592 | Domen üzərində transfer kilidi mövcuddur. |
| 593 | Domen transfer edilə bilməz, Status Məlumatı və Transfer Kilidi tələb olunan kriterlərə uyğun gəlməlidir. (Status Məlumatı: #ok) |
| 594 | Domen nameserver ünvanı həll edilə bilmədi ({0}) |
| 595 | Əlaqə məlumatı oxuna bilmir (whois.registrar.tld) Məxfilik qoruma statusunun açıq olduğundan əmin olun |
| 596 | Əlaqə məlumatı təsdiqlənə bilmədi |
| 597 | Tld Tapılmadı |
| 598 | Naməlum xəta baş verdi |
| 599 | Domen Yönləndirməsi Tapılmadı |
</rewritten_file> 