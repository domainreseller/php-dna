## Kurulum ve Entegrasyon rehberi

### Minimum Gereksinimler

- PHP7.4 veya daha üstü (Önerilen 8.1) 
- PHP SOAPClient eklentisi aktif olmalıdır.

## Kullanım

Dosyaları indirin [examples](examples) klasörünün içindeki örnekleri inceleyin.

```php
require_once __DIR__.'/src/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```



Domain listesi için
```php
$list = $dna->GetList(['OrderColumn'=>'Id', 'OrderDirection'=>'ASC', 'PageNumber'=>0,'PageSize'=>1000]);
```

TLD Listesini almak için
```php
$list = $dna->GetTldList(100);
```

Domain uygunluğu kontrolü için
```php
$check = $dna->CheckAvailability('domainadi.com',1,'create');
```

Domain detayları için
```php
$detail = $dna->GetDetails('domainadi.com');
```

Nameserver Düzenlemesi için
```php
$ns = $dna->SetNameservers(ModifyNameServer('domain.com',['ns1'=>'ns1.domain.com','ns2'=>'ns2.domain.com']);
```

Domain Kilidi aktifleştirme için
```php
$lock = $dna->EnableTheftProtectionLock('domainadi.com');

```

Domain Kilidi kaldırma için
```php
$lock = $dna->DisableTheftProtectionLock('domainadi.com');
```

Domaine ChildNS ekleme için
```php
$childns = $dna->AddChildNameServer('domainadi.com','ns1.domainadi.com','1.2.3.4');
```

Domaine aitContact kaydetmek için
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

$childns = $dna->SaveContacts('domainadi.com','ns1','1.2.3.4');

```

Domain Contactlarını almak için
```php
$contact = $dna->GetContacts('domainadi.com');
```

Domain Yenilemek için
```php
$lock=$dna->Renew('domainadi.com',1);
```

Registry üzerinden sync yapmak için
```php
$lock=$dna->SyncFromRegistry('domainadi.com');
```

Bakiye sorgulamak için (Parametreler içinde 1=TL, 2=USD yazabilir yada direkt USD TRY TL ibaresi kullanabilirsiniz)
```php
$balance_usd = $dna->GetCurrentBalance(); //Varsayılan USD
$balance_usd = $dna->GetCurrentBalance('USD');
$balance_try = $dna->GetCurrentBalance('TRY');
$balance_usd = $dna->GetCurrentBalance(1); // 1=TRY/TL
$balance_try = $dna->GetCurrentBalance(2); // 2=USD
```

Reseller bilgilerini almak için
```php  
$reseller = $dna->GetResellerDetails();

```

Domain Kayıt işlemleri için
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

$info = $a->RegisterWithContactInfo(
    'domainadi.com.tr',
    1,
    [
        'Administrative' => $contact,
        'Billing'        => $contact,
        'Technical'      => $contact,
        'Registrant'     => $contact
    ],
    ["tr.atakdomain.com", "eu.atakdomain.com"],true,false,
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '1112221111111',
        'TRABISNAMESURNAME'    => 'Bunyamin Mutlu',
        'TRABISCOUNTRYID'      => '215',
        'TRABISCITYID'        => '41'
    ]);
```


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




