## Kurulum ve Entegrasyon rehberi

### Minimum Gereksinimler

- PHP7.4 veya daha üstü (Önerilen 8.1) 
- PHP SOAPClient eklentisi aktif olmalıdır.

### A) Manuel Kullanım

Dosyaları indirin [examples](examples) klasörünün içindeki örnekleri inceleyin.

```php
require_once __DIR__.'/src/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```


### B) Composer ile entegrasyon için

```bash
composer require atakdomain/domainnameapi-php
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```


### Kullanım



#### Domain Kayıt işlemleri için

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

$a->RegisterWithContactInfo(
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

<details>
<summary>Domain Kayıt işlemleri için Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
    [data] => Array
        (
            [ID] => 0
            [Status] => clientTransferProhibited
            [DomainName] => testdomain859.com
            [AuthCode] => E!m5b3}R6Qq=Wc/9
            [LockStatus] => true
            [PrivacyProtectionStatus] => false
            [IsChildNameServer] => false
            [Contacts] => Array
                (
                    [Billing] => Array
                        (
                            [ID] => 0
                        )

                    [Technical] => Array
                        (
                            [ID] => 0
                        )

                    [Administrative] => Array
                        (
                            [ID] => 0
                        )

                    [Registrant] => Array
                        (
                            [ID] => 0
                        )

                )

            [Dates] => Array
                (
                    [Start] => 2023-03-04T15:45:33+03:00
                    [Expiration] => 2024-03-04T15:45:33+03:00
                    [RemainingDays] => 0
                )

            [NameServers] => Array
                (
                    [0] => tr.atakdomain.info
                    [1] => eu.atakdomain.info
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

#### Domain Yenileme

```php
$dna->Renew('domainadi.com',1);
```
<details>
<summary>Domain Yenileme Örnek Çıktı</summary>

```php
 Array
(
    [result] => OK
    [data] => => Array
        (
            [ExpirationDate] =>2025-03-04 00:00:00
   )

)
```

</details>


<hr style="border: 4px solid #000; border-style: dashed;">

#### Domain Transfer

```php
$dna->Transfer('testdomain859.com', '5b3}R6Qq',3);
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
                            [DomainName] => domain001.com
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
                                    "ns1.google.com",
                                    "ns2.google.com"
                                    
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
                                            [Name] => 'ns1.domainadi.com'
                                            [IP] =>'8.8.8.8'
                                         )
                                    Array
                                        (
                                            [Name] => 'ns2.domainadi.com'
                                            [IP] =>'8.8.5.5'
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
$dna->CheckAvailability('domainadi.com',1,'create');
```

<details>
<summary>Alan adı uygunluğu kontrolü Örnek Çıktı</summary>

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

#### Alan adı detayları

```php
$dna->GetDetails('domainadi.com');
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
            [DomainName] => domainadi.com
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
                    "ns1.google.com",
                    "ns2.google.com"
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
                            [Name] => 'ns1.domainadi.com'
                            [IP] =>'1.2.3.4'
                            )
                    Array
                        (
                            [Name] => 'ns2.domainadi.com'
                            [IP] =>'2.3.4.5'
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
$dna->ModifyNameServer('domainhakkinda.com',['ns1'=>'ns1.domain.com','ns2'=>'ns2.domain.com']);
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
                    [ns1] => ns1.domain.com
                    [ns2] => ns2.domain.com
                )

        )

    [result] => OK
)

```


</details>

<hr style="border: 4px solid #000; border-style: dashed;">


#### Domain Kilidi aktifleştirme

```php
    
$lock = $dna->EnableTheftProtectionLock('domainhakkinda.com');
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
$lock = $dna->DisableTheftProtectionLock('domainadi.com');
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
$dna->AddChildNameServer('domainhakkinda.com','test5.domainhakkinda.com','1.2.3.4');

```

<details>
<summary>Domaine ChildNS ekleme Örnek Çıktı</summary>

```php


Array
(
    [data] => Array
        (
            [NameServer] => test5.domainhakkinda.com
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
$dna->DeleteChildNameServer('domainhakkinda.com', 'test5.domainhakkinda.com');

```

<details>
<summary>Domaine ChildNS silme Örnek Çıktı</summary>

```php
Array
(
    [result] => OK
)
```

</details>


<hr style="border: 4px solid #000; border-style: dashed;">

#### Child NS Güncelleme

```php
 $dna->ModifyChildNameServer('domainhakkinda.com', 'test5.domainhakkinda.com', '1.2.3.4');
```

<details>
<summary>Child NS Güncelleme Örnek Çıktı</summary>

```php
Array
(
    [data] => Array
        (
            [NameServer] => test5.domainhakkinda.com
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
$lock = $dna->ModifyPrivacyProtectionStatus('domainhakkinda.com', true, 'owners optional comment');
```

<details>

<summary>Domain gizliliği değiştirme Örnek Çıktı</summary>

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

#### Domain contact kaydetme

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

$dna->SaveContacts('domainadi.com','ns1','1.2.3.4');

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




