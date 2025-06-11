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

## 安装和集成指南

### 最低要求

- PHP7.4 或更高版本（推荐 8.1）
- PHP SOAPClient 扩展必须激活。

### A) 手动使用

下载文件并查看 [examples](examples) 文件夹中的示例。

```php
require_once __DIR__.'/src/DomainNameAPI_PHPLibrary.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### B) 与 Composer 集成

```bash
composer require domainreseller/php-dna 
```

```php
require_once __DIR__.'/vendor/autoload.php';

$dna = new \DomainNameApi\DomainNameAPI_PHPLibrary('username','password');
```

### 使用方法

#### 域名注册操作

注意：.tr 域名需要额外参数。Additional 参数用于需要额外信息的域名，如 .tr。

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
    //Additional 属性仅对 .tr 域名必需。
    [
        'TRABISDOMAINCATEGORY' => 1,
        'TRABISCITIZIENID'     => '12345678901',
        'TRABISNAMESURNAME'    => 'John Doe',
        'TRABISCOUNTRYID'      => '840',
        'TRABISCITYID'        => '17'
    ]);
```

<details>
<summary>域名注册示例输出</summary>

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

#### 域名续费

```php
$dna->Renew('example.com', 1);
```
<details>
<summary>域名续费示例输出</summary>

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

#### 域名转移

```php
$dna->Transfer('example.com', 'Xy9#mK2$', 3);
```

<details>
<summary>域名转移示例输出</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### 删除域名

```php
$dna->DeleteDomain('example.com');
```

<details>
<summary>删除域名示例输出</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### 获取域名信息

```php
$dna->GetDetails('example.com');
```

<details>
<summary>获取域名信息示例输出</summary>

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

#### 获取名称服务器信息

```php
$dna->GetNameServer('example.com');
```

<details>
<summary>获取名称服务器信息示例输出</summary>

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

#### 修改名称服务器

```php
$dna->ModifyNameServer('example.com', ["ns1.example.com", "ns2.example.com"]);
```

<details>
<summary>修改名称服务器示例输出</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### 启用域名锁定

```php
$lock = $dna->EnableTheftProtectionLock('example.com');
```

<details>
<summary>启用域名锁定示例输出</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### 禁用域名锁定

```php
$unlock = $dna->DisableTheftProtectionLock('example.com');
```

<details>
<summary>禁用域名锁定示例输出</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### 添加子名称服务器

```php
$dna->AddChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>添加子名称服务器示例输出</summary>

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

#### 删除子名称服务器

```php
$dna->DeleteChildNameServer('example.com', 'ns1.example.com');
```

<details>
<summary>删除子名称服务器示例输出</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### 修改子名称服务器

```php
$dna->ModifyChildNameServer('example.com', 'ns1.example.com', '1.2.3.4');
```

<details>
<summary>修改子名称服务器示例输出</summary>

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

#### 修改隐私保护状态

```php
$lock = $dna->ModifyPrivacyProtectionStatus('example.com', true, '所有者可选注释');
```

<details>
<summary>修改隐私保护状态示例输出</summary>

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

#### 保存域名联系人

```php
$contact = [
    "FirstName"        => 'Bunyamin',
    "LastName"         => 'Mutlu',
    "Company"          => '',
    "EMail"            => 'bun.mutlu@gmail.com',
    "AddressLine1"     => '地址 1 地址 1 地址 1 ',
    "AddressLine2"     => '测试 测试',
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
<summary>保存域名联系人示例输出</summary>

```php
Array
(
    [result] => OK
)
```

</details>

<hr style="border: 4px solid #000; border-style: dashed;">

#### 获取经销商详细信息

```php
$dna->GetResellerDetails();
```

<details>
<summary>获取经销商详细信息示例输出</summary>

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

## 返回和错误代码及说明

| 代码 | 描述 | 详细 |
|------|------|------|
| 1000 | 命令成功完成 | 操作成功。 |
| 1001 | 命令成功完成；操作待处理 | 操作成功。但是，操作当前已排队等待完成。 |
| 2003 | 缺少必需参数 | 参数缺失错误。例如：联系信息中没有电话输入。 |
| 2105 | 对象不符合续费条件 | 域名状态不适合续费，已锁定更新操作。状态不应为"clientupdateprohibited"。可能由于其他状态条件。 |
| 2200 | 身份验证错误 | 授权错误，安全代码不正确或域名在另一个注册商处注册。 |
| 2302 | 对象已存在 | 域名或名称服务器信息已存在于数据库中。无法注册。 |
| 2303 | 对象不存在 | 域名或名称服务器信息在数据库中不存在。需要新注册。 |
| 2304 | 对象状态禁止操作 | 域名状态不适合更新，已锁定更新操作。状态不应为"clientupdateprohibited"。可能由于其他状态条件。 |

| 代码 | 详细 |
|------|------|
| 101 | 系统错误详细信息 ({0})！ |
| 102 | 多个错误详细信息 ({0})！ |
| 103 | 未知错误详细信息 ({0})！ |
| 200 | 未找到 API 命令 ({0})！ |
| 210 | 未找到 API 服务 ({0})！ |
| 211 | 未设置 API 服务提供商！ |
| 300 | 未找到经销商！ |
| 301 | 您当前的 IP 地址未被授权访问。请确保您从授权的 IP 地址连接并重试 |
| 310 | 不支持 TLD！ |
| 320 | 未找到 API！ |
| 321 | 不支持货币！ |
| 330 | 未设置必需参数 ({0})。 |
| – | 确保您完整发送所有联系对象 |
| 340 | 未找到价格定义 ({0}[{1}]-{2}{3})。 |
| 350 | 经销商余额不足。(经销商 Id : {0} - 当前余额 : {1} {2})。 |
| 350 | 会计货币不匹配或余额不足。 |
| 360 | 字段 ({0}) 的无效 API 请求。 |
| 360 | API 配额已超出！ |
| 361 | 限流错误！ |
| 362 | 高级域名目前无法注册。 |
| 363 | 由于域名处于自动续费期间，操作已取消 |
| 364 | 由于注册处问题，此域名目前无法进行交易 |

| 代码 | 详细 |
|------|------|
| 400 | 无效联系人 ({0})。 |
| 401 | 联系信息无法同步。 |
| 402 | 无法从注册处访问联系信息。 |
| 403 | 系统缺少信息。输入您的默认信息或联系支持团队。 |
| 404 | 域名联系人无法更新。来自注册处的权限。 |
| 410 | 未找到联系人。 |
| 410 | 未找到联系人 ({0})。 |
| 420 | 联系人 {0} 的无效 Api 命令。 |
| 430 | 未找到联系人 api。 |
| 440 | 联系人未同步。 |
| 450 | 域名联系人太多..！ |
| 451 | 无法继续进行联系人更新。 |

| 代码 | 详细 |
|------|------|
| 500 | 无效域名 id。 |
| 500 | 无效域名 id ({0})。 |
| 501 | 域名无法同步({0}) |
| 502 | 内部转移失败 |
| 503 | 域名注册不可用。 |
| 504 | 域名信息不匹配 .. 之前 :{0} |
| 505 | 输入 IP 地址。 |
| 506 | 域名转移已开始但无法读取联系信息 .. |
| 507 | 授权错误。 |
| 510 | 未找到域名。 |
| 511 | 无法找到过期域名。 |
| 512 | 域名不可续费。 |
| 513 | 域名不处于可更新状态。必须处于活动状态才能更新 |
| 514 | 预期赎回期。 |
| 520 | 域名 "{0}" 的无效 Api 命令。 |
| 530 | 无效域名期限。期限必须为 {0} 到 {1} 年。请求的期限为 {2} 年。 |
| 540 | 域名无法延长到当前日期 {0} 年以后。 |
| 550 | 无效域名。域名必须为 {0} 到 {1} 个字符长度。请求的域名为 {2} 个字符。 |
| 560 | 无效名称服务器数量。域名必须有 {0} 到 {1} 个名称服务器。请求的名称服务器数量为 {2}。 |
| 561 | 在传入请求中未找到名称服务器信息 |
| 570 | tld "{0}" 不支持 Idn。 |
| 571 | 期限无效。 |
| 572 | 命令无效。 |
| 573 | 未找到域名。 |
| 574 | 未找到 TLD 名称。 |
| 575 | 域名不处于可更新状态。必须处于活动状态才能更新名称服务器 |
| 576 | 域名可在到期日期前最后 1 个月内续费 |
| 580 | tld "{0}" 不支持转移。 |
| 581 | 未找到子名称服务器 |
| 582 | 转移由其他经销商发起。 |
| 583 | 转移未初始化。请联系支持团队。 |
| 584 | 对象状态禁止操作 |
| 590 | 此转移需要授权代码。 |
| 591 | 授权代码无效。 |
| 592 | 域名上存在转移锁定。 |
| 593 | 域名无法转移，状态信息和转移锁定必须符合所需标准。(状态信息: #ok) |
| 594 | 域名服务器地址无法解析 ({0}) |
| 595 | 无法读取联系信息 (whois.registrar.tld) 请确保隐私保护状态开放 |
| 596 | 联系信息无法验证 |
| 597 | 未找到 Tld |
| 598 | 发生未知错误 |
| 599 | 未找到域名转发 |
</div> 