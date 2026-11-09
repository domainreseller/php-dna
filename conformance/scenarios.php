<?php
/**
 * Conformance scenarios: each one calls a single public php-dna method against
 * the mock gateway with a fixed queue of responses. generate.php runs them and
 * writes fixtures/<id>.json with the requests php-dna sent and the value it
 * returned. Ports in other languages replay the same fixtures.
 *
 * Bodies are taken from real OTE responses (2026-11-09) and the gateway
 * Swagger, with personal data replaced by example values.
 */

$ok    = fn ($body, $status = 200) => ['status' => $status, 'body' => is_string($body) ? $body : json_encode($body)];
$empty = fn ($status = 200) => ['status' => $status, 'body' => ''];
$abp   = fn ($status, $code, $message, $details = null, $validation = null) => [
    'status' => $status,
    'body'   => json_encode(['error' => [
        'code' => $code, 'message' => $message, 'details' => $details, 'data' => [], 'validationErrors' => $validation,
    ]]),
];

$notFound   = $abp(404, 'Dna.DomainService:Domain:10007', 'The domain name you requested could not be found. Please check and try again.', 'The domain could not be found. Please check and try again.');
$internal   = $abp(500, 'Dna.DomainService:General:10001', 'An internal error has occurred. Please contact the system administrator.');
$validation = $abp(400, null, 'Validation failed. Please check the provided information.',
    'The following errors were detected during validation.',
    [['message' => "The DomainName field is required.", 'members' => ['$.domainName']]]);
$boiler     = $abp(400, 'Dna.DomainService:Dns:10024', "Exception of type 'Volo.Abp.BusinessException' was thrown.", 'Dna Host is linked but not marked as linked in entity');
$echoCode   = $abp(400, 'Dna.DomainService:Dns:10030', 'Dna.DomainService:Dns:10030', null);
$balance    = $abp(400, 'Dna.DepositService:Deposit:10002', 'Insufficient balance.', 'Your balance is not sufficient for this operation.');
$tooMany    = $empty(429);
$badGateway = ['status' => 502, 'body' => '<html><body>502 Bad Gateway</body></html>'];
$redirect   = $empty(302);

$account = ['resellerId' => '00000000-0000-4000-8000-000000000001', 'resellerName' => 'example-reseller',
            'resellerGroupName' => 'Reseller', 'tryBalance' => 1250.5, 'usdBalance' => 601.64];

$domainInfo = [
    'domainName' => 'example.com', 'domainNameIdn' => 'example.com', 'isIdnName' => false,
    'startDate' => '2024-03-15T10:20:30', 'expirationDate' => '2027-03-15T10:20:30',
    'transferDate' => null, 'updatedDate' => '2026-10-01T08:00:00',
    'resellerId' => '00000000-0000-4000-8000-000000000001', 'renewalMode' => 'Manual',
    'authCode' => 'Ab1!xyZ9', 'lockStatus' => true, 'privacyProtectionStatus' => false,
    'remainingDay' => 126, 'statusCode' => 'clientTransferProhibited', 'objectId' => '123456_DOMAIN_COM-VRSN',
    'rgpStatues' => null, 'status' => 'Active', 'statusReason' => null, 'isForwarded' => false,
    'useTrusteeContact' => false, 'id' => 4321,
    'nameservers' => ['ns1.example.net', 'ns2.example.net'],
    'hosts' => [
        ['name' => 'ns1.example.com', 'ipAddresses' => [['ipAddress' => '192.0.2.10'], ['ipAddress' => '192.0.2.11']]],
        ['name' => 'ns2.example.com', 'ipAddresses' => []],
    ],
    'contacts' => [
        ['firstName' => 'Ada', 'lastName' => 'Lovelace', 'companyName' => 'Example Ltd', 'eMail' => 'ada@example.com',
         'address' => 'Example Street 1', 'phoneCountryCode' => '90', 'phone' => '5551234567', 'faxCountryCode' => '',
         'fax' => '', 'postalCode' => '34000', 'country' => 'TR', 'city' => 'Istanbul', 'state' => 'Istanbul',
         'discloseFlag' => false, 'contactType' => 'Registrant', 'handle' => 'DNA-R-1'],
        ['firstName' => 'Grace', 'lastName' => 'Hopper', 'companyName' => '', 'eMail' => 'grace@example.com',
         'address' => 'Example Street 2', 'phoneCountryCode' => '1', 'phone' => '2025550100', 'faxCountryCode' => '1',
         'fax' => '2025550101', 'postalCode' => '20001', 'country' => 'US', 'city' => 'Washington', 'state' => 'DC',
         'discloseFlag' => true, 'contactType' => 'Admin', 'handle' => 'DNA-A-2'],
        ['firstName' => 'Alan', 'lastName' => 'Turing', 'companyName' => '', 'eMail' => 'alan@example.com',
         'address' => 'Example Street 3', 'phoneCountryCode' => '44', 'phone' => '2071234567', 'faxCountryCode' => '',
         'fax' => '', 'postalCode' => 'SW1A 1AA', 'country' => 'GB', 'city' => 'London', 'state' => '',
         'discloseFlag' => false, 'contactType' => 'Tech', 'handle' => 'DNA-T-3'],
        ['firstName' => 'Ada', 'lastName' => 'Lovelace', 'companyName' => 'Example Ltd', 'eMail' => 'billing@example.com',
         'address' => 'Example Street 1', 'phoneCountryCode' => '90', 'phone' => '5551234567', 'faxCountryCode' => '',
         'fax' => '', 'postalCode' => '34000', 'country' => 'TR', 'city' => 'Istanbul', 'state' => 'Istanbul',
         'discloseFlag' => false, 'contactType' => 'Billing', 'handle' => 'DNA-B-4'],
    ],
    'additionalAttributes' => ['TRABISDOMAINCATEGORY' => '1'],
];
$domainInfoNumeric = array_merge($domainInfo, ['status' => 3, 'hosts' => [], 'contacts' => [], 'additionalAttributes' => null,
    'remainingDay' => null, 'startDate' => '0001-01-01T00:00:00', 'expirationDate' => 'not-a-date']);
$domainInfoTransferredOut = array_merge($domainInfo, ['status' => 4, 'lockStatus' => false]);

$listBody = ['totalCount' => 3, 'items' => [
    ['id' => 11, 'domainName' => 'example.com', 'startDate' => '2024-03-15T10:20:30', 'expirationDate' => '2027-03-15T10:20:30',
     'lockStatus' => true, 'privacyProtectionStatus' => true, 'status' => 0, 'statusCode' => 'ok', 'remainingDay' => 126,
     'nameServers' => ['ns1.example.net', 'ns2.example.net']],
    ['id' => 12, 'domainName' => 'example.net', 'startDate' => '2023-01-01T00:00:00', 'expirationDate' => '2026-01-01T00:00:00',
     'lockStatus' => false, 'privacyProtectionStatus' => false, 'status' => 8, 'statusCode' => '', 'remainingDay' => 0],
    ['id' => 13, 'domainName' => 'example.org', 'startDate' => null, 'expirationDate' => null,
     'status' => 1, 'statusCode' => '2', 'statusText' => 'WaitingForRegistration'],
]];

$tld = function ($name, $register, $renew, $transfer, $extra = []) {
    $row = fn ($pairs) => array_map(fn ($p) => ['period' => $p[0], 'price' => $p[1], 'currency' => $p[2] ?? 'USD'], $pairs);
    return array_merge([
        'name' => $name, 'minRegistrationPeriod' => 1, 'maxRegistrationPeriod' => 10,
        'registrationPeriods' => [1, 2, 3], 'renewalPeriods' => [1, 2, 3],
        'isSupportTransfer' => true, 'isRequireDocument' => false, 'availableInTestEnvironment' => true,
        'prices' => [['priceGroup' => 'Reseller', 'register' => $row($register), 'renew' => $row($renew), 'transfer' => $row($transfer)]],
    ], $extra);
};
$tldBody = ['totalCount' => 698, 'items' => [
    $tld('aero', [[1, 44.99], [2, 94.91], [3, 144.83]], [[1, 49.92], [2, 99.84]], [[1, 44.99]]),
    $tld('com.tr', [[2, 30], [1, 15.5, 'TRY']], [[1, 15.5, 'TRY']], [[0, 0]], ['constraints' => ['maxLenght' => 50, 'minLength' => 2], 'status' => 'Passive']),
    ['name' => 'xyz', 'prices' => []],
]];

$bulkBody = ['operationMessage' => 'Command completed successfully', 'code' => '1000', 'reason' => null, 'success' => true, 'infos' => [
    ['domainName' => 'dnaprobexyz123.com', 'tld' => 'COM', 'isPremium' => false, 'isDocumentRequired' => false, 'currency' => 'USD', 'period' => 1, 'price' => 11.99, 'reason' => null, 'status' => 'AVAILABLE'],
    ['domainName' => 'dnaprobexyz123.net', 'tld' => 'NET', 'isPremium' => false, 'isDocumentRequired' => false, 'currency' => 'USD', 'period' => 1, 'price' => 13.99, 'reason' => null, 'status' => 'AVAILABLE'],
    ['domainName' => 'google.com', 'tld' => 'COM', 'isPremium' => false, 'isDocumentRequired' => false, 'currency' => 'USD', 'period' => 1, 'price' => 11.99, 'reason' => 'Domain exists', 'status' => 'NOTAVAILABLE'],
    ['domainName' => 'premium.net', 'tld' => 'NET', 'isPremium' => true, 'isDocumentRequired' => false, 'currency' => 'USD', 'period' => 1, 'price' => 2500, 'reason' => null, 'status' => 'AVAILABLE'],
]];

$zones = [
    ['name' => 'example.com.', 'ttl' => 3600, 'type' => 'A', 'changeType' => null, 'records' => [['content' => '192.0.2.1', 'disabled' => false]]],
    ['name' => 'www.example.com.', 'ttl' => 300, 'type' => 'CNAME', 'records' => [['content' => 'example.com.', 'disabled' => false]]],
    ['name' => 'example.com.', 'ttl' => 3600, 'type' => 'MX', 'records' => [['content' => '10 mx1.example.com.', 'disabled' => false], ['content' => '20 mx2.example.com.', 'disabled' => true]]],
    ['name' => 'example.com.', 'ttl' => 3600, 'type' => 'TXT', 'records' => [['content' => '"v=spf1 include:_spf.example.net ~all"']]],
    ['name' => 'empty.example.com.', 'ttl' => 60, 'type' => 'AAAA', 'records' => []],
];

$contact = [
    'FirstName' => 'Ahmet', 'LastName' => 'Yilmaz', 'Company' => '', 'EMail' => 'ahmet.yilmaz@example.com',
    'AddressLine1' => 'Ornek Sokak No: 123', 'AddressLine2' => 'Daire 4', 'AddressLine3' => '',
    'City' => 'Istanbul', 'Country' => 'TR', 'Fax' => '2121234567', 'FaxCountryCode' => '90',
    'Phone' => '5551234567', 'PhoneCountryCode' => 90, 'Type' => 'Contact', 'ZipCode' => '34000', 'State' => 'Istanbul',
];
$contactMessy = [
    'FirstName' => '  Jane 3rd ', 'LastName' => '', 'Company' => 'ACME', 'EMail' => 'jane@example.com',
    'Address' => ['Line1' => 'Main St 5', 'Line2' => 'Suite 9', 'City' => '', 'State' => '', 'Country' => 'Türkiye', 'ZipCode' => ''],
    'Phone' => ['Phone' => ['Number' => '+90 (532) 374 33 88', 'CountryCode' => ''], 'Fax' => ['Number' => '', 'CountryCode' => '']],
];
$contacts = ['Administrative' => $contact, 'Billing' => $contact, 'Technical' => $contact, 'Registrant' => $contact];
$trIndividual = [
    'TRABISDOMAINCATEGORY' => 1, 'TRABISCITIZIENID' => '11111111111', 'TRABISNAMESURNAME' => 'Ahmet Yilmaz',
    'TRABISCOUNTRYID' => '215', 'TRABISCITYID' => '34', 'TRABISCOUNTRYNAME' => 'Türkiye', 'TRABISCITYNAME' => 'Istanbul',
];
$trCommercial = [
    'TRABISDOMAINCATEGORY' => 0, 'TRABISORGANIZATION' => 'Example Ltd. Sti.', 'TRABISTAXOFFICE' => 'Istanbul VD',
    'TRABISTAXNUMBER' => '1234567890', 'TRABISCOUNTRYID' => '215', 'TRABISCITYID' => '34',
    'TRABISCOUNTRYNAME' => 'Türkiye', 'TRABISCITYNAME' => 'Istanbul',
];
$opOk = ['success' => true, 'message' => 'Command completed successfully', 'domainId' => '00000000-0000-4000-8000-0000000000aa',
         'status' => 'Active', 'expirationDate' => '2027-11-09T12:00:00'];
$opFail = ['success' => false, 'message' => 'Domain is not available for registration', 'domainId' => null, 'status' => null, 'expirationDate' => null];

$S = [];
$add = function ($id, $call, $args, $responses, $note = '') use (&$S) {
    $S[] = compact('id', 'call', 'args', 'responses', 'note');
};

// ---- account -----------------------------------------------------------------
$add('getResellerDetails.ok', 'getResellerDetails', [], [$ok($account)]);
$add('getResellerDetails.zero-usd', 'getResellerDetails', [], [$ok(array_merge($account, ['usdBalance' => 0, 'tryBalance' => 99.999]))]);
$add('getResellerDetails.unauthorized', 'getResellerDetails', [], [$empty(401)]);
$add('getResellerDetails.redirect', 'getResellerDetails', [], [$redirect], '302/301 means bad credentials');
$add('getResellerDetails.html-502', 'getResellerDetails', [], [$badGateway]);
$add('getCurrentBalance.usd', 'getCurrentBalance', ['USD'], [$ok($account)]);
$add('getCurrentBalance.try-lowercase', 'getCurrentBalance', ['try'], [$ok($account)]);
$add('getCurrentBalance.eur-missing', 'getCurrentBalance', ['EUR'], [$ok($account)]);
$add('getCurrentBalance.unknown', 'getCurrentBalance', ['JPY'], [$ok($account)]);
$add('getCurrentBalance.429', 'getCurrentBalance', ['USD'], [$tooMany]);

// ---- search / lists ------------------------------------------------------------
$add('checkAvailability.ok', 'checkAvailability', [['dnaprobexyz123', 'google', 'premium'], ['com', '.net'], 1, 'create'], [$ok($bulkBody)]);
$add('checkAvailability.plain-list', 'checkAvailability', [['a'], ['com'], 2, 'transfer'], [$ok([['domainName' => 'a.com', 'status' => 'available']])]);
$add('checkAvailability.empty-input', 'checkAvailability', [[], ['com'], 1, 'create'], []);
$add('checkAvailability.validation', 'checkAvailability', [['x'], ['com'], 1, 'create'], [$validation]);
$add('checkAvailability.429', 'checkAvailability', [['x'], ['com'], 1, 'create'], [$tooMany]);
$add('getList.defaults', 'getList', [], [$ok($listBody)]);
$add('getList.paging', 'getList', [['PageSize' => 50, 'PageNumber' => 2, 'OrderColumn' => 'ExpirationDate', 'OrderDirection' => 'desc', 'DomainName' => 'exa']], [$ok(['totalCount' => 0, 'items' => []])]);
$add('getList.no-items-key', 'getList', [['MaxResultCount' => 5]], [$ok(['totalCount' => 7])]);
$add('getList.500', 'getList', [], [$internal]);
$add('getTldList.ok', 'getTldList', [3], [$ok($tldBody)]);
$add('getTldList.default-count', 'getTldList', [], [$ok(['totalCount' => 0, 'items' => []])]);
$add('getTldList.error', 'getTldList', [5], [$internal]);

// ---- domain info ---------------------------------------------------------------
$add('getDetails.ok', 'getDetails', ['example.com'], [$ok($domainInfo)]);
$add('getDetails.numeric-status-bad-dates', 'getDetails', ['example.com'], [$ok($domainInfoNumeric)]);
$add('getDetails.transferred-out', 'getDetails', ['example.com'], [$ok($domainInfoTransferredOut)]);
$add('getDetails.not-found', 'getDetails', ['missing.com'], [$notFound]);
$add('getDetails.empty-body', 'getDetails', ['example.com'], [$ok('')]);
$add('getDetails.null-body', 'getDetails', ['example.com'], [$ok('null')]);
$add('getDetails.500-empty', 'getDetails', ['example.com'], [$empty(500)]);
$add('syncFromRegistry.ok', 'syncFromRegistry', ['example.com'], [$ok($domainInfo)]);
$add('syncFromRegistry.not-found', 'syncFromRegistry', ['missing.com'], [$notFound]);
$add('getContacts.ok', 'getContacts', ['example.com'], [$ok($domainInfo)]);
$add('getContacts.no-contacts', 'getContacts', ['example.com'], [$ok(array_merge($domainInfo, ['contacts' => []]))]);
$add('getContacts.error', 'getContacts', ['example.com'], [$notFound]);

// ---- nameservers / locks / hosts --------------------------------------------------
$add('modifyNameServer.ok', 'modifyNameServer', ['example.com', ['ns1.example.net', 'ns2.example.net']], [$ok('')]);
$add('modifyNameServer.assoc', 'modifyNameServer', ['example.com', ['ns1' => 'NS1.Example.NET', 'ns2' => 'ns2.example.net', 'ns3' => '']], [$ok('{}')]);
$add('modifyNameServer.error', 'modifyNameServer', ['example.com', ['ns1.bad']], [$abp(400, 'Dna.DomainService:Dns:10010', 'Nameserver could not be resolved.', 'ns1.bad')]);
$add('enableTheftProtectionLock.ok', 'enableTheftProtectionLock', ['example.com'], [$ok('')]);
$add('enableTheftProtectionLock.error', 'enableTheftProtectionLock', ['example.com'], [$internal]);
$add('disableTheftProtectionLock.ok', 'disableTheftProtectionLock', ['example.com'], [$ok('')]);
$add('disableTheftProtectionLock.error', 'disableTheftProtectionLock', ['example.com'], [$boiler]);
$add('addChildNameServer.ok', 'addChildNameServer', ['example.com', 'ns1.example.com', '192.0.2.10'], [$ok('')]);
$add('addChildNameServer.error', 'addChildNameServer', ['example.com', 'ns1.example.com', '192.0.2.10'], [$echoCode]);
$add('deleteChildNameServer.ok', 'deleteChildNameServer', ['example.com', 'ns1.example.com'], [$ok('')]);
$add('deleteChildNameServer.error', 'deleteChildNameServer', ['example.com', 'ns1.example.com'], [$notFound]);
$add('modifyChildNameServer.ok', 'modifyChildNameServer', ['example.com', 'ns1.example.com', '192.0.2.20'], [$ok('')]);
$add('modifyChildNameServer.error', 'modifyChildNameServer', ['example.com', 'ns1.example.com', '192.0.2.20'], [$validation]);

// ---- DNS zone ------------------------------------------------------------------
$add('getResourceRecords.ok', 'getResourceRecords', ['example.com'], [$ok($zones)]);
$add('getResourceRecords.empty', 'getResourceRecords', ['example.com'], [$ok([])]);
$add('getResourceRecords.error', 'getResourceRecords', ['example.com'], [$tooMany]);
$add('addResourceRecord.apply', 'addResourceRecord', ['example.com', 'www.example.com', 'a', '192.0.2.5', 300, true], [$ok(''), $ok('')]);
$add('addResourceRecord.no-apply-list', 'addResourceRecord', ['example.com', '@', 'TXT', ['v=spf1 -all', 'hello'], 999999, false], [$ok('')]);
$add('addResourceRecord.ttl-zero', 'addResourceRecord', ['example.com', 'example.com.', 'MX', '10 mx.example.com', 0, false], [$ok('')]);
$add('addResourceRecord.unsupported-ns', 'addResourceRecord', ['example.com', 'sub', 'NS', 'ns1.example.net'], []);
$add('addResourceRecord.unsupported-spf', 'addResourceRecord', ['example.com', 'sub', 'spf', 'v=spf1'], []);
$add('addResourceRecord.error', 'addResourceRecord', ['example.com', 'www', 'A', '192.0.2.5'], [$validation]);
$add('addResourceRecord.apply-fails', 'addResourceRecord', ['example.com', 'www', 'A', '192.0.2.5'], [$ok(''), $internal]);
$add('editResourceRecord.ok', 'editResourceRecord', ['example.com', 'www', 'www', 'A', '192.0.2.6', 600, true], [$ok(''), $ok('')]);
$add('editResourceRecord.rename-fqdn', 'editResourceRecord', ['example.com', 'old.example.com.', 'new.example.com', 'CNAME', 'example.com.', 3600, false], [$ok('')]);
$add('editResourceRecord.error', 'editResourceRecord', ['example.com', 'www', 'www', 'A', '192.0.2.6'], [$notFound]);
$add('deleteResourceRecord.ok', 'deleteResourceRecord', ['example.com', 'www', '192.0.2.5', 'A', true], [$ok(''), $ok('')]);
$add('deleteResourceRecord.no-apply', 'deleteResourceRecord', ['example.com', 'example.com', '10 mx1.example.com.', 'mx', false], [$ok('')]);
$add('deleteResourceRecord.error', 'deleteResourceRecord', ['example.com', 'www', '192.0.2.5', 'A'], [$internal]);
$add('applyResourceRecords.ok', 'applyResourceRecords', ['example.com'], [$ok('')]);
$add('applyResourceRecords.error', 'applyResourceRecords', ['example.com'], [$tooMany]);
$add('setResourceRecordSet.ok', 'setResourceRecordSet', ['example.com', '@', 'MX', ['10 mx1.example.com', '20 mx2.example.com'], 3600, true], [$ok($zones), $ok(''), $ok(''), $ok('')]);
$add('setResourceRecordSet.new', 'setResourceRecordSet', ['example.com', 'api', 'A', ['192.0.2.7'], 120, true], [$ok($zones), $ok(''), $ok('')]);
$add('setResourceRecordSet.unsupported', 'setResourceRecordSet', ['example.com', 'api', 'NS', ['ns1.example.net']], []);
$add('deleteResourceRecordSet.ok', 'deleteResourceRecordSet', ['example.com', '@', 'MX', true], [$ok($zones), $ok(''), $ok(''), $ok('')]);
$add('deleteResourceRecordSet.missing', 'deleteResourceRecordSet', ['example.com', 'nothing', 'A', true], [$ok($zones), $ok('')]);
$add('deleteResourceRecordSet.known-value', 'deleteResourceRecordSet', ['example.com', 'gone', 'A', false, '192.0.2.99'], [$ok([]), $ok('')]);
$add('addResourceRecordValue.ok', 'addResourceRecordValue', ['example.com', '@', 'MX', '30 mx3.example.com', null, true], [$ok($zones), $ok(''), $ok(''), $ok('')]);
$add('addResourceRecordValue.duplicate', 'addResourceRecordValue', ['example.com', '@', 'MX', '10 MX1.example.com.', null, true], [$ok($zones), $ok(''), $ok(''), $ok('')]);
$add('addResourceRecordValue.new-set', 'addResourceRecordValue', ['example.com', 'new', 'A', '192.0.2.8', 300, false], [$ok($zones), $ok('')]);
$add('removeResourceRecordValue.ok', 'removeResourceRecordValue', ['example.com', '@', 'MX', '20 mx2.example.com.', true], [$ok($zones), $ok(''), $ok(''), $ok('')]);
$add('removeResourceRecordValue.last', 'removeResourceRecordValue', ['example.com', 'www', 'CNAME', 'example.com.', true], [$ok($zones), $ok(''), $ok(''), $ok('')]);
$add('removeResourceRecordValue.absent', 'removeResourceRecordValue', ['example.com', '@', 'A', '198.51.100.1', true], [$ok($zones), $ok(''), $ok('')]);
$add('replaceResourceRecordValue.ok', 'replaceResourceRecordValue', ['example.com', '@', 'A', '192.0.2.1', '192.0.2.2', null, true], [$ok($zones), $ok(''), $ok(''), $ok('')]);
$add('replaceResourceRecordValue.absent', 'replaceResourceRecordValue', ['example.com', '@', 'A', '198.51.100.1', '192.0.2.2', 120, false], [$ok($zones), $ok(''), $ok('')]);
$add('replaceResourceRecordValue.zone-error', 'replaceResourceRecordValue', ['example.com', '@', 'A', '192.0.2.1', '192.0.2.2'], [$internal]);

// ---- forwarding ----------------------------------------------------------------
$add('getForwarding.ok', 'getForwarding', ['example.com'], [$ok(['redirectAlias' => 'https://www.example.org/landing', 'redirectType' => 'Frame'])]);
$add('getForwarding.not-set', 'getForwarding', ['example.com'], [$abp(404, 'Dna.DomainService:Domain:10061', 'Redirect information not found')]);
$add('getForwarding.error', 'getForwarding', ['example.com'], [$internal]);
$add('setForwarding.standard', 'setForwarding', ['example.com', 'https://www.example.org'], [$ok('')]);
$add('setForwarding.frame', 'setForwarding', ['example.com', 'example.org/path', 'frame'], [$ok('')]);
$add('setForwarding.invalid-type', 'setForwarding', ['example.com', 'https://www.example.org', 'Permanent'], []);
$add('setForwarding.error', 'setForwarding', ['example.com', 'https://www.example.org'], [$validation]);
$add('deleteForwarding.ok', 'deleteForwarding', ['example.com'], [$ok('')]);
$add('deleteForwarding.not-set', 'deleteForwarding', ['example.com'], [$abp(404, 'Dna.DomainService:Domain:10061', 'Redirect information not found')]);

// ---- contacts ------------------------------------------------------------------
$add('saveContacts.ok', 'saveContacts', ['example.com', $contacts], [$ok('')]);
$add('saveContacts.messy', 'saveContacts', ['example.com', ['Registrant' => $contactMessy, 'Administrative' => $contactMessy, 'Technical' => $contactMessy, 'Billing' => $contactMessy]], [$ok('')]);
$add('saveContacts.validation', 'saveContacts', ['example.com', $contacts], [$abp(400, null, 'Validation failed. Please check the provided information.', null,
    [['message' => 'The field Phone must be a string with a maximum length of 16.', 'members' => ['$.contacts[0].phone']],
     ['message' => 'The EMail field is required.', 'members' => ['$.contacts[2].eMail']]])]);

// ---- transfers -----------------------------------------------------------------
$add('transfer.ok', 'transfer', ['example.com', 'Ab1!xyZ9', 1], [$ok($opOk)]);
$add('transfer.with-contacts', 'transfer', ['example.com', 'Ab1!xyZ9', 2, $contacts], [$ok($opOk)]);
$add('transfer.fail-flag', 'transfer', ['example.com', 'bad', 1], [$ok($opFail)]);
$add('transfer.balance', 'transfer', ['example.com', 'Ab1!xyZ9', 1], [$balance]);
$add('cancelTransfer.ok', 'cancelTransfer', ['example.com'], [$ok('')]);
$add('cancelTransfer.error', 'cancelTransfer', ['example.com'], [$notFound]);
$add('approveTransfer.ok', 'approveTransfer', ['example.com'], [$ok('')]);
$add('approveTransfer.error', 'approveTransfer', ['example.com'], [$internal]);
$add('rejectTransfer.ok', 'rejectTransfer', ['example.com'], [$ok('')]);
$add('rejectTransfer.error', 'rejectTransfer', ['example.com'], [$boiler]);
$add('checkTransfer.ok', 'checkTransfer', ['example.com', 'Ab1!xyZ9'], [$ok(['messageKey' => 'TransferAvailable', 'message' => 'Domain can be transferred', 'authCodeIsRequired' => true,
    'authCodeIsValid' => true, 'userTransferRequired' => false, 'transferLock' => false, 'transferAvailabilityStatus' => true,
    'domainStatuses' => ['ok'], 'additionalAttributes' => [], 'isPremium' => false, 'premiumPrice' => 0, 'premiumCurrency' => null])]);
$add('checkTransfer.locked', 'checkTransfer', ['example.com', 'wrong'], [$ok(['messageKey' => 'TransferLocked', 'message' => 'Domain is locked', 'authCodeIsRequired' => true,
    'authCodeIsValid' => false, 'userTransferRequired' => false, 'transferLock' => true, 'transferAvailabilityStatus' => false,
    'domainStatuses' => ['clientTransferProhibited'], 'isPremium' => true, 'premiumPrice' => 120.5, 'premiumCurrency' => 'USD'])]);
$add('checkTransfer.error', 'checkTransfer', ['google.com', 'abc123'], [$internal]);

// ---- renew / register / privacy --------------------------------------------------
$add('renew.ok', 'renew', ['example.com', 1], [$ok($opOk)]);
$add('renew.fail-flag', 'renew', ['example.com', 3], [$ok($opFail)]);
$add('renew.balance', 'renew', ['example.com', 1], [$balance]);
$add('registerWithContactInfo.ok', 'registerWithContactInfo', ['example.com', 1, $contacts, ['ns1.example.net', 'ns2.example.net'], true, false, []], [$ok($opOk)]);
$add('registerWithContactInfo.default-ns', 'registerWithContactInfo', ['example.com', 2, $contacts], [$ok($opOk)]);
$add('registerWithContactInfo.tr-individual', 'registerWithContactInfo', ['example.com.tr', 1, $contacts, ['ns1.example.net', 'ns2.example.net'], true, false, $trIndividual], [$ok($opOk)]);
$add('registerWithContactInfo.tr-commercial', 'registerWithContactInfo', ['example.com.tr', 1, $contacts, ['ns1.example.net', 'ns2.example.net'], false, true, $trCommercial], [$ok($opOk)]);
$add('registerWithContactInfo.messy-contact', 'registerWithContactInfo', ['example.net', 1, ['Registrant' => $contactMessy, 'Administrative' => $contactMessy, 'Technical' => $contactMessy, 'Billing' => $contactMessy], ['ns1.example.net'], true, true], [$ok($opOk)]);
$add('registerWithContactInfo.fail-flag', 'registerWithContactInfo', ['example.com', 1, $contacts], [$ok($opFail)]);
$add('registerWithContactInfo.balance', 'registerWithContactInfo', ['example.com', 1, $contacts], [$balance]);
$add('registerWithContactInfo.validation', 'registerWithContactInfo', ['example.com', 1, $contacts], [$abp(400, null, 'Validation failed. Please check the provided information.', null,
    [['message' => 'Invalid citizen id.', 'members' => ['$.additionalAttributes.TRABISCITIZIENID']]])]);
$add('modifyPrivacyProtectionStatus.on', 'modifyPrivacyProtectionStatus', ['example.com', true], [$ok('')]);
$add('modifyPrivacyProtectionStatus.off-reason', 'modifyPrivacyProtectionStatus', ['example.com', false, 'Customer asked'], [$ok('')]);
$add('modifyPrivacyProtectionStatus.error', 'modifyPrivacyProtectionStatus', ['example.com', true], [$abp(400, 'Dna.DomainService:Domain:10040', 'Privacy protection is not supported for this TLD.')]);

// ---- pure utilities ------------------------------------------------------------
$add('isTrTLD.com-tr', 'isTrTLD', ['example.com.tr'], []);
$add('isTrTLD.upper', 'isTrTLD', ['EXAMPLE.TR'], []);
$add('isTrTLD.com', 'isTrTLD', ['example.com'], []);
$add('isTrTLD.tricky', 'isTrTLD', ['example.trade'], []);
$add('validateContact.complete', 'validateContact', [$contact], []);
$add('validateContact.empty', 'validateContact', [[]], []);
$add('validateContact.messy', 'validateContact', [['FirstName' => ' Jo ', 'Phone' => '+1 (202) 555-0100', 'Country' => 'Turkey', 'City' => '', 'Fax' => '0090 212 123 45 67']], []);

return $S;
