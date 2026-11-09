# php-dna conformance fixtures

These fixtures define what a DomainNameAPI client library returns, so that the
ports in other languages (Python, Go, .NET, Java, Ruby, Rust, Node.js) behave
exactly like php-dna. php-dna is the reference: the fixtures are produced by
running php-dna itself against a mock gateway.

## Files

| File | What it is |
|---|---|
| `scenarios.php` | The scenario list: method, arguments, and the queue of gateway responses |
| `server.php` | Mock gateway used by the generator (serves the queue, records requests) |
| `generate.php` | Runs every scenario through php-dna and writes `fixtures/*.json` |
| `fixtures/*.json` | One fixture per scenario |
| `PORTING.md` | The contract every port follows |

Regenerate after any behaviour change in php-dna:

```bash
php conformance/generate.php
```

Then copy `fixtures/` into each port (`testdata/conformance/` or the
language's equivalent) and run its conformance test.

## Fixture format

```json
{
  "id": "getDetails.ok",
  "call": "getDetails",
  "args": ["example.com"],
  "responses": [{ "status": 200, "body": "{...}" }],
  "requests": [{
    "method": "GET",
    "path": "domains/info",
    "query": { "DomainName": "example.com" },
    "body": null,
    "headers": { "X-API-KEY": "conformance-api-key", "__reseller": "00000000-0000-4000-8000-000000000001" }
  }],
  "output": { "result": "OK", "data": { } },
  "ignore": []
}
```

- `call` is the php-dna (camelCase) method name. Ports map it to their own
  naming (`get_details`, `GetDetails`, ...).
- `args` are positional. Objects are PHP associative arrays (contacts,
  TR attributes, list filters); lists are JSON arrays.
- `responses` are served in order, one per HTTP request. `body` is the raw
  response text (it may be empty, `null`, HTML, or JSON).
- `requests` are what php-dna sent. `path` is relative to `/api/v1/`.
  `query` holds the decoded query string (all values are strings),
  `body` the decoded JSON body or `null` when no body was sent.
- `output` is php-dna's return value, JSON encoded.
- `ignore` lists dot paths in `output` whose value depends on the current date
  (`data.Dates.RemainingDays` derived from today). For these, only check that
  the port returns a non-negative integer.

## How a port runs a fixture

1. Build the client with reseller `00000000-0000-4000-8000-000000000001`,
   key `conformance-api-key`, test mode off, telemetry off.
2. Replace the HTTP transport with a fake that returns `responses` in order
   and records each request. Running out of responses is a failure.
3. Call the mapped method with `args`.
4. Compare:
   - the recorded requests with `requests` (method, path, query as a string
     map, JSON body by value, the two auth headers), in order and in number;
   - the return value with `output`, after a JSON round trip.

## Comparison rules

php-dna's JSON encoding has a few quirks a port must either reproduce or
tolerate in its comparator:

- An empty PHP array encodes as `[]` even where an object is meant
  (`"Additional": []`). Treat an empty list and an empty object as equal.
- Numbers compare by value: `1` equals `1.0`.
- Money and price fields are strings formatted by php-dna (`"11.9900"`,
  `"601.64"`). These must match exactly; they are not numbers.
- Flags such as `LockStatus` are the strings `"true"` / `"false"`, not
  booleans. Keep them as strings.
- Maps keyed by period (`"pricing": {"registration": {"1": "44.9900"}}`)
  are objects with string keys in ascending numeric order.
- Key order inside objects does not matter.

## Coverage

126 fixtures over the 38 methods that talk to the gateway or are pure
utilities (diagnostics and settings are left to each port's unit tests): success, gateway errors (400/404/429/500,
empty bodies, HTML bodies, 302 credential redirects, ABP boilerplate
messages, validation error lists), and the pure utilities
(`isTrTLD`, `validateContact`). Transport failures (timeouts, DNS errors)
are not in the fixtures; `PORTING.md` describes the required behaviour.
