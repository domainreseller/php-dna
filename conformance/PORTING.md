# Porting php-dna to another language

This is the contract for the DomainNameAPI client libraries in other languages
(python-dna, go-dna, dotnet-dna, java-dna, ruby-dna, rust-dna). Each one is a
faithful port of php-dna: same methods, same requests on the wire, same return
values. When this document and php-dna disagree, php-dna wins.

## Sources of truth

| What | Where |
|---|---|
| Behaviour | `php-dna/DomainNameApi/DNARest.php` (all methods), `SharedApiConfigAndUtilsTrait.php` (errors, telemetry, utilities), `DomainNameAPI_PHPLibrary.php` (facade) |
| Expected results | `php-dna/conformance/fixtures/*.json` (see `conformance/README.md`) |
| Structure of an existing port | `nodejs-dna/` (`src/DNARest.js`, `rest-normalize.js`, `shared.js`, `telemetry.js`, `examples/`) |
| Gateway API | `https://api.domainresellerapi.com/swagger/v1/swagger.json` |
| Usage examples to mirror | `php-dna/examples/*.php` |

nodejs-dna predates the DNS zone and forwarding methods. It is a guide to
structure, not to coverage.

## Public API

One facade class (or package-level client) with these 45 methods. Use the
language's own naming convention (`get_details` in Python/Ruby/Rust,
`GetDetails` in Go/C#, `getDetails` in Java), keep the parameter order and
defaults of php-dna.

Account: `getResellerDetails()`, `getCurrentBalance(currency='USD')`

Search and lists: `checkAvailability(domains, extensions, period, command='create')`,
`getList(extraParameters={})`, `getTldList(count=20)`

Domain: `getDetails(domain)`, `syncFromRegistry(domain)`, `getContacts(domain)`,
`saveContacts(domain, contacts)`, `modifyNameServer(domain, nameServers)`,
`enableTheftProtectionLock(domain)`, `disableTheftProtectionLock(domain)`,
`modifyPrivacyProtectionStatus(domain, status, reason='Owner request')`,
`renew(domain, period)`,
`registerWithContactInfo(domain, period, contacts, nameServers=[], eppLock=true, privacyLock=false, additionalAttributes={})`

Child nameservers: `addChildNameServer(domain, nameServer, ip)`,
`deleteChildNameServer(domain, nameServer)`, `modifyChildNameServer(domain, nameServer, ip)`

Transfers: `transfer(domain, eppCode, period, contacts={})`, `cancelTransfer(domain)`,
`approveTransfer(domain)`, `rejectTransfer(domain)`, `checkTransfer(domain, authCode)`

DNS zone: `getResourceRecords(domain)`,
`addResourceRecord(domain, name, type, content, ttl=3600, apply=true)`,
`editResourceRecord(domain, recordName, name, type, content, ttl=3600, apply=true)`,
`deleteResourceRecord(domain, name, record, recordType, apply=true)`,
`applyResourceRecords(domain)`,
`setResourceRecordSet(domain, name, type, contents, ttl=3600, apply=true)`,
`deleteResourceRecordSet(domain, name, type, apply=true, knownValue='')`,
`addResourceRecordValue(domain, name, type, value, ttl=null, apply=true)`,
`removeResourceRecordValue(domain, name, type, value, apply=true)`,
`replaceResourceRecordValue(domain, name, type, oldValue, newValue, ttl=null, apply=true)`

Forwarding: `getForwarding(domain)`, `setForwarding(domain, address, type='Standard')`,
`deleteForwarding(domain)`

Utilities (no network): `isTrTLD(domain)`, `validateContact(contact)`

Diagnostics: `getRequestData()`, `getResponseData()`, `getResponseHeaders()`,
`getParsedResponseData()`, `getLastFunction()`, `getServiceUrl()`, `setServiceUrl(url)`

Settings: `setErrorReportingEnabled(bool)`, `setTelemetryMinimal(bool)`,
`setSslVerification(bool)`

### Return values

Methods return the same dynamic structure php-dna returns, not typed models:
`dict` (Python), `Hash` with string keys (Ruby), `map[string]any` (Go),
`serde_json::Value` (Rust), `JsonNode`/`JsonObject` (C#, System.Text.Json),
`Map<String, Object>` (Java). Key names, string flags (`"true"`/`"false"`),
formatted money strings (`"11.9900"`) and the OK/ERROR envelope must match
the fixtures. Several methods use a different envelope (for example
`getCurrentBalance` returns `OperationResult`, `checkAvailability` returns a
bare list on success); copy each one from php-dna.

Typed models can be added later as an extra layer; they are out of scope now.

Errors are returned, not thrown: every network method catches its failures and
returns the error envelope, exactly like php-dna. Only programmer errors
(wrong argument types) may raise.

### Inputs

Contacts, TR attributes and list filters are maps with php-dna's keys
(`FirstName`, `EMail`, `AddressLine1`, `PhoneCountryCode`, `TRABISCITIZIENID`,
`PageSize`, ...). Accept both the flat and the nested contact shape that
`parseContact()` accepts. Nameserver lists may be a list or a map (php-dna
takes the values).

### Constructor

`(resellerId, apiKey, testMode=false)`. Trim both credentials. `testMode`
also accepts strings: `"true"`, `"1"`, `"on"`, `"yes"` are true, everything
else is false (php-dna `FILTER_VALIDATE_BOOLEAN`, BUG-10284).

## HTTP

- Base URL: `https://api.domainresellerapi.com/api/v1` (live),
  `https://ote.domainresellerapi.com/api/v1` (test mode). `setServiceUrl()`
  overrides it.
- Headers: `Content-Type: application/json`, `Accept: application/json`,
  `X-API-KEY: <apiKey>`, `__reseller: <resellerId>`, and
  `User-Agent: DomainNameAPI-<Lang>/<version>`. The User-Agent is required:
  Cloudflare in front of the gateway answers default client agents
  (Python-urllib, Go-http-client, Java/x) with error 1010.
- GET and DELETE send their parameters as a query string with PHP
  `http_build_query` semantics (`true` → `1`, `false` → `0`, nested arrays as
  `key[0]=..`). POST and PUT send a JSON body. Some POST/PUT calls also carry a
  query string inside the endpoint (`domains/zones?domainName=...`).
- Timeouts: 30 s total, 10 s connect. TLS verification on unless
  `setSslVerification(false)`.
- Zone pacing: requests to `domains/zones*` keep at least `ZONE_MIN_INTERVAL`
  seconds apart (see `paceZoneRequest`). The conformance runner may set the
  interval to zero.
- The transport must be injectable so tests can replace it. No real network
  in unit or conformance tests.
- Prefer the standard library HTTP client. Keep runtime dependencies to zero
  where the language allows it (Rust: `ureq` or `reqwest` blocking +
  `serde_json`; Java: `java.net.http` + Jackson or a small JSON parser;
  C#: `HttpClient` + `System.Text.Json`).

### Error mapping

Follow `DNARest::request()` exactly:

- 2xx: parse JSON. An empty body or `null` is an empty response; the methods
  decide what that means (most return the `RESPONSE` error).
- 301/302: credentials error (`Invalid API credentials`).
- Other statuses: message from `message`, then `error.message`, else the raw
  body; empty message becomes `HTTP <status> - <reason>`; ABP boilerplate
  ("Exception of type '...' was thrown") or a message equal to the code is
  replaced by the details or a synthesised message; `validationErrors` are
  flattened into the details (`flattenValidationErrors`,
  `humanizeValidationMember`). Codes are formatted `API_<status>`.
- Transport failures (timeout, DNS, TLS, reset) are errors, never empty
  success. A timeout reads
  `Could not reach the DomainNameAPI service: the connection timed out. (...)`;
  other transport errors read `Curl error during request: ...`. Use the curl
  errno equivalents (28 timeout, 6 DNS, 7 connect refused, 35/60 TLS, 56
  reset). The returned envelope code is `CURL_<errno>` (e.g. `CURL_28`),
  never `API_<n>`, which is reserved for HTTP statuses.
- When the gateway sent its own error code (e.g.
  `Dna.DomainService:Domain:10007`), error envelopes with an `API_<status>`
  code also carry it as `GatewayCode` (see `setError`).

## Telemetry

Port `SharedApiConfigAndUtilsTrait` telemetry (see also nodejs-dna
`src/telemetry.js`):

- On by default, `setErrorReportingEnabled(false)` turns it off,
  `setTelemetryMinimal(true)` sends the minimal payload.
- Errors are posted to Sentry's store endpoint in the background (fire and
  forget, never blocks or throws into the caller). Messages matching
  `DEFAULT_IGNORED_ERRORS` are not sent.
- Mask credentials only (API key, reseller id in headers, passwords, auth
  codes per `telemetryMask`). Everything else (URL, operation, domain,
  contacts) is sent, as in php-dna.
- Successful calls are sampled for performance (`PERFORMANCE_SAMPLE_RATE`,
  slow calls over 1 s always).
- The DSN is a single constant `DEFAULT_SENTRY_DSN`, **empty for now**: the
  Sentry projects for the new languages are not created yet. With an empty
  DSN telemetry is a no-op. Leave a one-line comment saying the DSN is filled
  in when the Sentry project exists. Allow overriding the DSN by option.
- Tag every event with `application` = `DomainNameAPI-<Lang>` and the library
  version.

## Repository layout

Each port is its own git repository in `/Users/bunyaminakcay/Documents/Projeler/<lang>-dna`:

- The library in the language's standard layout and build tool
  (pyproject/hatchling, go.mod, .csproj + .sln, Maven pom.xml, gemspec,
  Cargo.toml).
- `examples/`: one runnable example per php-dna example file, same names in
  the language's case (`GetDetails`, `RegisterWithContactInfo-TR`, ...),
  placeholder credentials `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx` /
  `your-api-key`, plus examples for the DNS zone and forwarding methods.
- Unit tests for the HTTP layer, error mapping, telemetry masking and
  utilities, and a conformance test that runs every fixture from
  `testdata/conformance/` (copied from php-dna, keep the file names).
- `README.md` (English, complete) and translations `README-TR.md`,
  `README-DE.md`, `README-FR.md`, `README-IT.md`, `README-NL.md`,
  `README-AZ.md`, `README-SA.md` (Arabic), `README-CN.md` (Simplified Chinese),
  with the same flag header as php-dna's README. Content follows php-dna's
  README: download from Releases, requirements, install, credentials
  (Reseller ID + API Key, panel login does not work), quick start, every
  method with an example and a sample return value, error handling, test
  mode, telemetry and how to turn it off, license. The repository and
  release URLs are `https://github.com/domainreseller/<lang>-dna`.
- `CHANGELOG.md` (Keep a Changelog, first entry `1.0.0`).
- `LICENSE`: Apache-2.0, copied from php-dna.
- `.gitignore` for the language.
- `.github/workflows/ci.yml` running the tests on push and pull request.
- Version `1.0.0`, exposed as a constant.

## Git

- `git init -b main` in the new directory. Before the first commit set
  `git config user.name xa81` and `git config user.email poisonkid@gmail.com`
  locally in that repository, and check `git config user.name` prints `xa81`.
- No remotes. Do not push. The owner creates the GitHub repositories later.
- Commit messages in English, conventional style (`feat: ...`, `docs: ...`,
  `test: ...`). Never add Co-Authored-By, "Generated with" or any other
  attribution lines.
- Commit in a few meaningful steps (scaffold, client, tests, docs) rather
  than one dump.

## Toolchains

Python and Ruby are installed locally. For Go, .NET, Java and Rust use Docker
(Docker Desktop is running) instead of installing anything on the machine,
for example:

```bash
docker run --rm -v "$PWD":/src -w /src golang:1.23 go test ./...
docker run --rm -v "$PWD":/src -w /src mcr.microsoft.com/dotnet/sdk:8.0 dotnet test
docker run --rm -v "$PWD":/src -v dna-m2:/root/.m2 -w /src maven:3.9-eclipse-temurin-17 mvn -q verify
docker run --rm -v "$PWD":/src -v dna-cargo:/usr/local/cargo/registry -w /src rust:1.83 cargo test
```

Do not publish packages to any registry.
