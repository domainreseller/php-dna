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
composer require domainreseller/php-dna
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

| الرمز | التفاصيل                                                                                                                               |
|------|---------------------------------------------------------------------------------------------------------------------------------------|
| 101  | خطأ النظام مفصل لـ ({0})!                                                                                                              |
| 102  | أخطاء متعددة مفصلة لـ ({0})!                                                                                                           |
| 103  | أخطاء غير معروفة مفصلة لـ ({0})!                                                                                                        |
| 200  | أمر API غير موجود ({0})!                                                                                                              |
| 210  | خدمة API غير موجودة ({0})!                                                                                                            |
| 211  | مزود خدمة API غير مُعيَّن!                                                                                                             |
| 300  | الموزع غير موجود!                                                                                                                     |
| 301  | عنوان IP الحالي الخاص بك غير مخول للوصول. تأكد من أنك تتصل من عنوان IP مخول وحاول مرة أخرى                                              |
| 310  | TLD غير مدعوم!                                                                                                                        |
| 320  | API غير موجود!                                                                                                                        |
| 321  | العملة غير مدعومة!                                                                                                                    |
| 330  | المعاملات المطلوبة غير مُعيَّنة ({0}).                                                                                                  |
| –    | تأكد من إرسال جميع كائنات الاتصال بالكامل                                                                                                |
| 340  | تعريف السعر غير موجود ({0}[{1}]-{2}{3}).                                                                                              |
| 350  | رصيد الموزع غير كافٍ. (معرف الموزع : {0} - الرصيد الحالي : {1} {2}).                                                                   |
| 350  | عملة المحاسبة غير متطابقة أو الرصيد غير كافٍ.                                                                                          |
| 360  | طلب API غير صالح للحقل ({0}).                                                                                                          |
| 360  | تم تجاوز حصة API!                                                                                                                     |
| 361  | خطأ في التحكم في المعدل!                                                                                                               |
| 362  | النطاق المميز غير متاح للتسجيل الآن.                                                                                                    |
| 363  | تم إلغاء العملية لأن النطاق في فترة التجديد الآلي                                                                                       |
| 364  | هذا النطاق غير متاح حاليًا للمعاملة بسبب مشكلة في السجل                                                                               |

| الرمز | التفاصيل                                                                                       |
|------|----------------------------------------------------------------------------------------------|
| 400  | اتصال غير صالح ({0}).                                                                          |
| 401  | لا يمكن مزامنة معلومات الاتصال.                                                                |
| 402  | لا يوجد وصول لمعلومات الاتصال من السجل.                                                        |
| 403  | النظام يحتوي على معلومات مفقودة. أدخل معلوماتك الافتراضية أو اتصل بفريق الدعم.                     |
| 404  | لا يمكن تحديث اتصال النطاق. إذن من السجل.                                                       |
| 410  | الاتصال غير موجود.                                                                            |
| 410  | الاتصال غير موجود ({0}).                                                                       |
| 420  | أمر Api غير صالح للاتصال {0}.                                                                 |
| 430  | API الاتصال غير موجود.                                                                        |
| 440  | الاتصال غير متزامن.                                                                           |
| 450  | اتصالات النطاق كثيرة جداً.. !                                                                  |
| 451  | فشل في المتابعة مع تحديث الاتصال.                                                              |

| الرمز | التفاصيل                                                                                                                               |
|------|---------------------------------------------------------------------------------------------------------------------------------------|
| 500  | معرف النطاق غير صالح.                                                                                                                 |
| 500  | معرف النطاق غير صالح ({0}).                                                                                                           |
| 501  | لا يمكن مزامنة النطاق ({0})                                                                                                          |
| 502  | فشل النقل الداخلي                                                                                                                    |
| 503  | تسجيل النطاق غير متاح.                                                                                                               |
| 504  | معلومات النطاق غير متطابقة .. قبل :{0}                                                                                               |
| 505  | أدخل عنوان IP.                                                                                                                       |
| 506  | تم بدء نقل النطاق لكن لا يمكن قراءة معلومات الاتصال ..                                                                              |
| 507  | خطأ في التفويض.                                                                                                                      |
| 510  | النطاق غير موجود.                                                                                                                    |
| 511  | لا يمكن العثور على النطاقات المنتهية الصلاحية.                                                                                        |
| 512  | النطاق غير قابل للتجديد.                                                                                                             |
| 513  | النطاق ليس في حالة قابلة للتحديث. يجب أن يكون نشطاً ليتم تحديثه                                                                      |
| 514  | فترة الاسترداد متوقعة.                                                                                                               |
| 520  | أمر Api غير صالح للنطاق "{0}".                                                                                                       |
| 530  | فترة النطاق غير صالحة. يجب أن تكون الفترة من {0} إلى {1} سنة. الفترة المطلوبة هي {2} سنة.                                         |
| 540  | لا يمكن تمديد النطاق إلى ما بعد {0} سنة من التاريخ الحالي.                                                                          |
| 550  | اسم النطاق غير صالح. يجب أن يكون النطاق من {0} إلى {1} حرف. اسم النطاق المطلوب هو {2} حرف.                                     |
| 560  | عدد خوادم الأسماء غير صالح. يجب أن يحتوي النطاق على {0} إلى {1} خادم أسماء. عدد خوادم الأسماء المطلوب هو {2}.                    |
| 561  | لم يتم العثور على معلومات خادم الأسماء في الطلب الوارد                                                                             |
| 570  | Idn غير مدعوم لـ TLD "{0}".                                                                                                          |
| 571  | الفترة غير صالحة.                                                                                                                   |
| 572  | الأمر غير صالح.                                                                                                                     |
| 573  | أسماء النطاقات غير موجودة.                                                                                                           |
| 574  | أسماء TLD غير موجودة.                                                                                                               |
| 575  | النطاق ليس في حالة قابلة للتحديث. يجب أن يكون نشطاً لتحديث خوادم الأسماء                                                            |
| 576  | يمكن تجديد النطاق في الشهر الأخير قبل تاريخ انتهاء الصلاحية                                                                        |
| 580  | النقل غير مدعوم لـ TLD "{0}".                                                                                                        |
| 581  | خادم الأسماء الفرعي غير موجود                                                                                                        |
| 582  | تم بدء النقل بواسطة موزع آخر.                                                                                                        |
| 583  | النقل غير مُعيَّن. يرجى الاتصال بفريق الدعم.                                                                                         |
| 584  | حالة الكائن تمنع العملية                                                                                                             |
| 590  | رمز التفويض مطلوب لهذا النقل.                                                                                                        |
| 591  | رمز التفويض غير صالح.                                                                                                               |
| 592  | قفل النقل موجود على النطاق.                                                                                                          |
| 593  | لا يمكن نقل النطاق، معلومات الحالة وقفل النقل يجب أن تتوافق مع المعايير المطلوبة. (معلومات الحالة: #ok)                           |
| 594  | لا يمكن حل عنوان خادم أسماء النطاق ({0})                                                                                            |
| 595  | لا يمكن قراءة معلومات الاتصال (whois.registrar.tld) تأكد من أن حالة حماية الخصوصية مفتوحة                                          |
| 596  | لا يمكن التحقق من معلومات الاتصال                                                                                                   |
| 597  | TLD غير موجود                                                                                                                       |
| 598  | حدث خطأ غير معروف                                                                                                                   |
| 599  | إعادة توجيه النطاق غير موجود                                                                                                          |





