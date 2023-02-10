## Kurulum ve Entegrasyon rehberi

### Minimum Gereksinimler

- WHMCS 7.8 veya üstü
- PHP7.4 veya daha üstü (Önerilen 8.1) 
- PHP SOAPClient eklentisi aktif olmalıdır.

## Kullanım

```php
    
require_once __DIR__.'/src/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');


```

Domain listesi için
```php
$list = $dna->GetList();
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
$childns = $dna->AddChildNameServer('domainadi.com','ns1','1.2.3.4');
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

Bakiye sorgulamak için
```php
$balance = $dna->GetCurrentBalance();
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
        'TRABISCITIYID'        => '41'
    ]);
```




