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

## 📦 İndirme — her zaman Releases kullanın!

⬇️ **En güncel test edilmiş sürümü buradan indirin: https://github.com/domainreseller/php-dna/releases/latest**

> ⚠️ Yeşil **Code → Download ZIP** butonunu **kullanmayın** — bu buton ham geliştirme dalını (development branch) indirir. Release paketleri sürümlenmiş, test edilmiş ve canlı kullanıma hazırdır.

## Kurulum ve Entegrasyon rehberi

### Minimum Gereksinimler

- PHP7.4 veya daha üstü (Önerilen 8.1)
- PHP SOAPClient eklentisi aktif olmalıdır (SOAP modu için).
- PHP cURL eklentisi aktif olmalıdır (REST modu için).

## 🔑 API Bilgileri — Kullanıcı Adı/Şifre mi, Reseller ID/API Key mi?

Her ikisi de desteklenir — bilgilerinizi aynı iki constructor parametresine girmeniz yeterli; kütüphane hangi API'nin kullanılacağını otomatik olarak algılar:

| Elinizdeki bilgi | Birinci parametre | İkinci parametre | Kullanılan API |
|---|---|---|---|
| **Yeni panel bilgileri** (önerilen) | Reseller ID — `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx` biçiminde UUID | API Key | REST |
| **Eski (legacy) bilgiler** | API kullanıcı adı | API şifresi | SOAP |

> 💡 **Reseller ID** ve **API Key** bilgilerinizi DomainNameAPI panelinizdeki **API Ayarları** bölümünde bulabilirsiniz.
> ⚠️ Bunlar **API bilgileridir** — panel giriş e-postanız ve şifreniz burada **ÇALIŞMAZ**.

Ekstra hiçbir yapılandırma gerekmez: birinci parametre UUID biçimindeyse kütüphane modern REST API ile konuşur, aksi halde klasik SOAP'a döner. Her iki mod da birebir aynı response yapısını döndürür, entegrasyon kodunuz asla değişmez.

```php
// Yeni panel bilgileri (REST)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'your-api-key');

// Eski (legacy) bilgiler (SOAP)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('your-api-username', 'your-api-password');
```

### A) Manuel Kullanım

Dosyaları indirin [examples](examples) klasörünün içindeki örnekleri inceleyin.

```php
require_once __DIR__.'/DomainNameApi/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```


### B) Composer ile entegrasyon için

```bash
composer require domainreseller/php-dna
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```


### Kullanım



#### Domain Kayıt işlemleri için

Not: .tr domainler için ekstra parametreler gereklidir. .tr gibi ek bilgi gereken alan adlarında Additional parametresi kullanılır.

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
    //Additional attributes sadece .tr domainler için gereklidir.
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'         => '17'
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



#### Alan adları listesi 

```php
$dna->GetList(['OrderColumn'=>'Id', 'OrderDirection'=>'ASC', 'PageNumber'=>0,'PageSize'=>1000]);
```
<details>
<summary>Alan adları listesi Örnek Çıktı</summary>

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
                        [ns] => ns1.example.com
                        [ip] => 1.2.3.4
                    )
                    [1] => Array
                    (
                        [ns] => ns2.example.com
                        [ip] => 2.3.4.5
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

#### TLD Listesi

```php
$dna->GetTldList(100);
```
<details>

<summary>TLD Listesi Örnek Çıktı</summary>

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


#### Alan adı uygunluğu kontrolü

```php
$dna->CheckAvailability(['hello','world123x0'], ['com','net'], 1, 'create');
```

<details>
<summary>Alan adı uygunluğu kontrolü Örnek Çıktı</summary>

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

#### Alan adı detayları

```php
$dna->GetDetails('example.com');
```

<details>
<summary>Alan adı detayları Örnek Çıktı</summary>

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

#### Nameserver Düzenlemesi

```php
$dna->ModifyNameServer('example.com', ['ns1.example.com', 'ns2.example.com']);
```

<details>
<summary>Nameserver Düzenlemesi Örnek Çıktı</summary>

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


#### Domain Kilidi aktifleştirme

```php
    
$lock = $dna->EnableTheftProtectionLock('example.com');
``` 

<details>
<summary>Domain Kilidi aktifleştirme Örnek Çıktı</summary>

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



#### Domain Kilidi kaldırma

```php
$lock = $dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>Domain Kilidi kaldırma Örnek Çıktı</summary>

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


#### Domaine ChildNS ekleme

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');

```

<details>
<summary>Domaine ChildNS ekleme Örnek Çıktı</summary>

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


#### Domaine ChildNS silme

```php
$dna->DeleteChildNameServer('example.com', 'test5.example.com');

```

<details>
<summary>Domaine ChildNS silme Örnek Çıktı</summary>

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

#### Child NS Güncelleme

```php
 $dna->ModifyChildNameServer('example.com', 'test5.example.com', '1.2.3.4');
```

<details>
<summary>Child NS Güncelleme Örnek Çıktı</summary>

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

#### Domain gizliliği değiştirme

```php
$lock = $dna->ModifyPrivacyProtectionStatus('example.com', true, 'owners optional comment');
```

<details>

<summary>Domain gizliliği değiştirme Örnek Çıktı</summary>

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

#### Domain contact kaydetme

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
<summary>Domain contact kaydetme Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">



#### Reseller bilgilerini almak için

```php
$dna->GetResellerDetails();
```

<details>
<summary>Reseller bilgilerini almak için Örnek Çıktı</summary>

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



### Testler

Kütüphane, hem SOAP hem REST API yanıt yapılarının eşleştiğini doğrulayan PHPUnit testleri içerir.

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

## Dönüş ve Hata Kodları ile Açıklamaları

| Kod   | Açıklama                                               | Detay                                                             |
|-------|--------------------------------------------------------|-------------------------------------------------------------------|
| 1000  | Command completed successfully                       | İşlem başarılı.                                                  |
| 1001  | Command completed successfully; action pending.     | İşlem başarılı. Fakat işlem şu an tamamlanmak için kuyruğa alındı. |
| 2003  | Required parameter missing                          | Parametre eksik hatası. Örneğin; Kontak bilgisinde telefon girişi yapılmaması. |
| 2105  | Object is not eligible for renewal                  | Domain durumu yenilemeye müsait değil, güncelleme işlemlerine kilitlenmiştir. Durum durumu "clientupdateprohibited" olmamalı. Diğer durum durumlarından kaynaklanabilir. |
| 2200  | Authentication error                               | Yetki hatası, güvenlik kodu hatalı veya domain başka bir kayıt firmasında bulunuyor. |
| 2302  | Object exists                                      | Domain adı veya name server bilgisi veritabanında mevcut. Kayıt edilemez. |
| 2303  | Object does not exist                              | Domain adı veya name server bilgisi veritabanında mevcut değil. Yeni kayıt oluşturulmalı. |
| 2304  | Object status prohibits operation                  | Domain durumu güncellemeye müsait değildir, güncelleme işlemlerine kilitlenmiştir. Durum durumu "clientupdateprohibited" olmamalı. Diğer durum durumlarından kaynaklanabilir. |

| KOD | DETAY                                                                                                                               |
|-----|-------------------------------------------------------------------------------------------------------------------------------------|
| 101 | Sistem Hatası Detayları ({0}) İçin!                                                                                                |
| 102 | Çoklu Hatalar Detayları ({0}) İçin!                                                                                                |
| 103 | Bilinmeyen Hatalar Detayları ({0}) İçin!                                                                                           |
| 200 | API komutu bulunamadı ({0})!                                                                                                       |
| 210 | API servisi bulunamadı ({0})!                                                                                                      |
| 211 | API servis sağlayıcısı ayarlanmamış!                                                                                               |
| 300 | Bayi bulunamadı!                                                                                                                   |
| 301 | Mevcut IP adresiniz erişim için yetkilendirilmemiş. Yetkili IP adresinden bağlandığınızdan emin olun ve tekrar deneyin            |
| 310 | TLD desteklenmiyor!                                                                                                                |
| 320 | API bulunamadı!                                                                                                                    |
| 321 | Para birimi desteklenmiyor!                                                                                                        |
| 330 | Gerekli parametre(ler) ayarlanmadı ({0}).                                                                                          |
| –   | Tüm iletişim nesnelerini tam olarak gönderdiğinizden emin olun                                                                     |
| 340 | Fiyat tanımı bulunamadı ({0}[{1}]-{2}{3}).                                                                                         |
| 350 | Yetersiz bayi bakiyesi. (Bayi Id : {0} - Mevcut Bakiye : {1} {2}).                                                                 |
| 350 | Muhasebe para birimi eşleşmiyor veya bakiye yetersiz.                                                                              |
| 360 | Alan ({0}) için geçersiz API isteği.                                                                                               |
| 360 | API kotası aşıldı!                                                                                                                 |
| 361 | Azaltma hatası!                                                                                                                    |
| 362 | Premium domain şu anda kayıt için kullanılamıyor.                                                                                  |
| 363 | Domain otomatik yenileme döneminde olduğu için işlem iptal edildi                                                                  |
| 364 | Bu domain şu anda kayıt defteri ile ilgili bir sorun nedeniyle işlem için kullanılamıyor                                          |

| KOD | DETAY                                                                                       |
|-----|---------------------------------------------------------------------------------------------|
| 400 | Geçersiz iletişim ({0}).                                                                   |
| 401 | İletişim bilgisi senkronize edilemiyor.                                                    |
| 402 | Kayıt defterinden iletişim bilgilerine erişim yok.                                         |
| 403 | SİSTEMDE EKSİK BİLGİ VAR. VARSAYILAN BİLGİLERİNİZİ GİRİN VEYA DESTEK EKIBI İLE İLETİŞİME GEÇİN. |
| 404 | DOMAIN İLETİŞİMİ GÜNCELLENEMİYOR. KAYIT DEFTERİNDEN İZİN.                                  |
| 410 | İletişim bulunamadı.                                                                       |
| 410 | İletişim bulunamadı ({0}).                                                                 |
| 420 | İletişim {0} için geçersiz Api komutu.                                                     |
| 430 | İletişim api'si bulunamadı.                                                                |
| 440 | İletişim senkronize edilmemiş.                                                             |
| 450 | Çok fazla domain iletişimi.. !                                                             |
| 451 | İletişim güncellemesi ile ilerlenemedi.                                                    |

| KOD | DETAY                                                                                                                               |
|-----|-------------------------------------------------------------------------------------------------------------------------------------|
| 500 | Geçersiz domain id.                                                                                                                 |
| 500 | Geçersiz domain id ({0}).                                                                                                           |
| 501 | Domain senkronize edilemedi({0})                                                                                                   |
| 502 | İç transfer başarısız                                                                                                              |
| 503 | Domain kaydı kullanılamıyor.                                                                                                       |
| 504 | Domain bilgisi eşleşmiyor .. Önce :{0}                                                                                             |
| 505 | IP Adresini girin.                                                                                                                 |
| 506 | Domain Transferi Başlatıldı Ancak İletişim Bilgisi Okunamadı ..                                                                    |
| 507 | Yetkilendirme hatası.                                                                                                              |
| 510 | Domain bulunamadı.                                                                                                                 |
| 511 | Süresi dolmuş domainler bulunamıyor.                                                                                               |
| 512 | Domain yenilenemez.                                                                                                                |
| 513 | Domain güncellenebilir durumda değil. Güncellenebilmesi için aktif olmalı                                                          |
| 514 | Geri Alım Süresi Bekleniyor.                                                                                                       |
| 520 | Domain "{0}" için geçersiz Api komutu.                                                                                             |
| 530 | Geçersiz domain süresi. Süre {0} ile {1} yıl arasında olmalı. İstenen süre {2} yıl.                                               |
| 540 | Domain mevcut tarihten itibaren {0} yılın ötesine uzatılamaz.                                                                      |
| 550 | Geçersiz domain adı. Domain {0} ile {1} karakter uzunluğunda olmalı. İstenen domain adı {2} karakter.                             |
| 560 | Geçersiz name server sayısı. Domain {0} ile {1} name server'a sahip olmalı. İstenen name server sayısı {2}.                       |
| 561 | Gelen istekte name server bilgisi bulunamadı                                                                                       |
| 570 | Idn tld "{0}" için desteklenmiyor.                                                                                                 |
| 571 | Süre geçersiz.                                                                                                                     |
| 572 | Komut geçersiz.                                                                                                                    |
| 573 | Domain adları bulunamadı.                                                                                                          |
| 574 | TLD adları bulunamadı.                                                                                                             |
| 575 | Domain güncellenebilir durumda değil. Name server'ların güncellenmesi için aktif olmalı                                            |
| 576 | Domain son kullanma tarihinden önceki son 1 ay içinde yenilenebilir                                                                |
| 580 | Transfer tld "{0}" için desteklenmiyor.                                                                                            |
| 581 | Alt name server bulunamadı                                                                                                         |
| 582 | Transfer başka bayi tarafından başlatıldı.                                                                                         |
| 583 | Transfer başlatılmadı. Lütfen destek ekibi ile iletişime geçin.                                                                    |
| 584 | Nesne durumu işlemi yasaklıyor                                                                                                     |
| 590 | Bu transfer için auth kodu gerekli.                                                                                                |
| 591 | Auth kodu geçerli değil.                                                                                                           |
| 592 | Domain üzerinde transfer kilidi mevcut.                                                                                            |
| 593 | Domain transfer edilemiyor, Durum Bilgisi ve Transfer Kilidi gerekli kriterlere uymalı. (Durum Bilgisi: #ok)                      |
| 594 | Domain name server adresi çözümlenemedi ({0})                                                                                      |
| 595 | İletişim bilgisi okunamıyor (whois.registrar.tld) Gizlilik koruma durumunun açık olduğundan emin olun                             |
| 596 | İletişim bilgisi doğrulanamadı                                                                                                     |
| 597 | Tld Bulunamadı                                                                                                                     |
| 598 | Bilinmeyen hata oluştu                                                                                                             |
| 599 | Domain Yönlendirmesi Bulunamadı                                                                                                    |





