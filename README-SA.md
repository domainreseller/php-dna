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

## 📦 التنزيل — استخدم دائمًا صفحة الإصدارات (Releases)!

⬇️ **احصل على أحدث نسخة مختبَرة من هنا: https://github.com/domainreseller/php-dna/releases/latest**

> ⚠️ **لا** تستخدم الزر الأخضر **Code → Download ZIP** — فهو ينزّل فرع التطوير الخام. حزم الإصدارات مرقّمة الإصدار ومختبَرة وجاهزة لبيئة الإنتاج.

## دليل التثبيت والتكامل

### الحد الأدنى من المتطلبات

- PHP7.4 أو أعلى (يوصى بـ 8.1)
- يجب تفعيل إضافة PHP SOAPClient (لوضع SOAP).
- يجب تفعيل إضافة PHP cURL (لوضع REST).

## 🔑 بيانات اعتماد API — اسم المستخدم/كلمة المرور أم Reseller ID/API Key؟

كلاهما مدعوم — أدخلهما في نفس مُعامِلَي الدالة الإنشائية (constructor)؛ وستكتشف المكتبة تلقائيًا أي API يجب استخدامه:

| ما لديك | المُعامِل الأول | المُعامِل الثاني | API المستخدم |
|---|---|---|---|
| **بيانات اللوحة الجديدة** (موصى به) | Reseller ID — بصيغة UUID مثل `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx` | API Key | REST |
| **البيانات القديمة (Legacy)** | اسم مستخدم API | كلمة مرور API | SOAP |

> 💡 ستجد **Reseller ID** و **API Key** في لوحة DomainNameAPI الخاصة بك ضمن **إعدادات API**.
> ⚠️ هذه **بيانات اعتماد API** — البريد الإلكتروني وكلمة المرور الخاصان بتسجيل الدخول إلى اللوحة **لن يعملا** هنا.

لا حاجة إلى أي إعداد إضافي: إذا كان المُعامِل الأول بصيغة UUID فستتواصل المكتبة مع REST API الحديثة، وإلا فستعود إلى SOAP الكلاسيكية. كلا الوضعين يُرجعان نفس هيكل الاستجابة تمامًا، لذا لن يتغير كود التكامل الخاص بك أبدًا.

```php
// بيانات اللوحة الجديدة (REST)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', 'your-api-key');

// البيانات القديمة (SOAP)
$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('your-api-username', 'your-api-password');
```

### أ) الاستخدام اليدوي

قم بتنزيل الملفات وراجع الأمثلة في مجلد [examples](examples).

```php
require_once __DIR__.'/DomainNameApi/DomainNameAPI_PHPLibrary.php';

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
    // Additional attributes مطلوبة فقط لنطاقات .tr
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'         => '17'
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
$dna->CheckAvailability(['hello','world123x0'], ['com','net'], 1, 'create');
```

<details>
<summary>مثال على مخرجات التحقق من توفر النطاق</summary>

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

#### تعديل خوادم الأسماء

```php
$dna->ModifyNameServer('example.com', ['ns1.example.com', 'ns2.example.com']);
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
                    [0] => ns1.example.com
                    [1] => ns2.example.com
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
    [data] => Array
        (
            [NameServer] => ns1.example.com
        )
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
    [data] => Array
        (
            [PrivacyProtectionStatus] => true
        )
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### حفظ معلومات الاتصال للنطاق

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



### الاختبارات

تتضمن المكتبة اختبارات PHPUnit التي تتحقق من تطابق هياكل استجابة SOAP و REST API.

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





