<div align="center">  
  <a href="README-TR.md"   >   TR <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/TR.png" alt="TR" height="20" /></a>  
  <a href="README.md"> | EN <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/US.png" alt="EN" height="20" /></a>  
   <a href="README-DE.md"> | DE <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/DE.png" alt="DE" height="20" /></a>  
  <a href="README-SA.md"> | SA <img style="padding-top: 8px" src="https://raw.githubusercontent.com/yammadev/flag-icons/master/png/SA.png" alt="AR" height="20" /></a>  
</div>

## دليل التثبيت والتكامل

### الحد الأدنى من المتطلبات

- PHP7.4 أو أعلى (يوصى بـ 8.1)
- يجب تفعيل إضافة PHP SOAPClient

### أ) الاستخدام اليدوي

قم بتنزيل الملفات وراجع الأمثلة في مجلد [examples](examples).

```php
require_once __DIR__.'/src/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```


### ب) للتكامل باستخدام Composer

```bash
composer require atakdomain/domainnameapi-php
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```


### الاستخدام



#### لعمليات تسجيل النطاق

ملاحظة: تتطلب نطاقات .tr معلمات إضافية. يتم استخدام معلمة Additional للنطاقات التي تتطلب معلومات إضافية مثل .tr.

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
<summary>مثال على مخرجات عمليات تسجيل النطاق</summary>

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

#### تجديد النطاق

```php
$dna->Renew('example.com', 1);
```
<details>
<summary>مثال على مخرجات تجديد النطاق</summary>

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

#### نقل النطاق

```php
$dna->Transfer('example.com', 'Xy9#mK2$', 3);
```

<details>
<summary>مثال على مخرجات نقل النطاق</summary>

```php
Array
(
    [result] => OK
)


```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">



#### قائمة النطاقات

```php
$dna->GetList(['OrderColumn'=>'Id', 'OrderDirection'=>'ASC', 'PageNumber'=>0,'PageSize'=>1000]);
```
<details>
<summary>مثال على مخرجات قائمة النطاقات</summary>

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

#### قائمة امتدادات النطاقات

```php
$dna->GetTldList(100);
```
<details>

<summary>مثال على مخرجات قائمة امتدادات النطاقات</summary>

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


#### التحقق من توفر النطاق

```php
$dna->CheckAvailability('example.com',1,'create');
```

<details>
<summary>مثال على مخرجات التحقق من توفر النطاق</summary>

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

#### تفاصيل النطاق

```php
$dna->GetDetails('example.com');
```

<details>
<summary>مثال على مخرجات تفاصيل النطاق</summary>

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

#### تعديل خوادم الأسماء

```php
$dna->ModifyNameServer('example.com', [
    'ns1'=>'ns1.example.com',
    'ns2'=>'ns2.example.com'
]);
```

<details>
<summary>مثال على مخرجات تعديل خوادم الأسماء</summary>

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


#### تفعيل قفل النطاق

```php
    
$lock = $dna->EnableTheftProtectionLock('example.com');
``` 

<details>
<summary>مثال على مخرجات تفعيل قفل النطاق</summary>

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



#### إلغاء قفل النطاق

```php
$lock = $dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>مثال على مخرجات إلغاء قفل النطاق</summary>

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


#### إضافة خادم أسماء فرعي للنطاق

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');

```

<details>
<summary>مثال على مخرجات إضافة خادم أسماء فرعي</summary>

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


#### حذف خادم أسماء فرعي من النطاق

```php
$dna->DeleteChildNameServer('example.com', 'test5.example.com');

```

<details>
<summary>مثال على مخرجات حذف خادم أسماء فرعي</summary>

```php
Array
(
    [result] => OK
)
```

</details>


<hr style="border: 4px solid #000; border-style: dashed;">

#### تحديث خادم الأسماء الفرعي

```php
 $dna->ModifyChildNameServer('example.com', 'test5.example.com', '1.2.3.4');
```

<details>
<summary>مثال على مخرجات تحديث خادم الأسماء الفرعي</summary>

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

#### تعديل حالة حماية الخصوصية

```php
$lock = $dna->ModifyPrivacyProtectionStatus('example.com', true, 'owners optional comment');
```

<details>

<summary>مثال على مخرجات تعديل حالة حماية الخصوصية</summary>

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

#### حفظ معلومات الاتصال للنطاق

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
<summary>مثال على مخرجات حفظ معلومات الاتصال</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">



#### للحصول على معلومات الوكيل

```php
$dna->GetResellerDetails();
```

<details>
<summary>مثال على مخرجات معلومات الوكيل</summary>

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



## رموز العودة والأخطاء مع تفسيراتها

| الرمز | الوصف | التفاصيل |
|-------|--------|-----------|
| 1000 | تم تنفيذ الأمر بنجاح | العملية ناجحة |
| 1001 | تم تنفيذ الأمر بنجاح؛ الإجراء معلق | العملية ناجحة ولكنها في قائمة الانتظار للإكمال |
| 2003 | معلمة مطلوبة مفقودة | خطأ في المعلمات، مثل عدم إدخال رقم الهاتف في معلومات الاتصال |
| 2105 | الكائن غير مؤهل للتجديد | حالة النطاق غير مناسبة للتجديد، مقفلة للتحديثات |
| 2200 | خطأ في المصادقة | خطأ في التفويض، رمز الأمان خاطئ أو النطاق مسجل لدى شركة تسجيل أخرى |
| 2302 | الكائن موجود | اسم النطاق أو معلومات خادم الأسماء موجودة في قاعدة البيانات، لا يمكن التسجيل |
| 2303 | الكائن غير موجود | اسم النطاق أو معلومات خادم الأسماء غير موجودة في قاعدة البيانات، يجب إنشاء تسجيل جديد |
| 2304 | حالة الكائن تمنع العملية | حالة النطاق غير مناسبة للتحديث، مقفلة للتحديثات |





