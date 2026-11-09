<?php
/**
 * Regenerate conformance fixtures from php-dna.
 *
 *   php conformance/generate.php            # all scenarios
 *   php conformance/generate.php getDetails # only ids starting with this prefix
 *
 * Starts the mock gateway (server.php) on a free local port, runs every
 * scenario from scenarios.php through the public facade and writes
 * fixtures/<id>.json:
 *
 *   { id, call, args, responses[], requests[], output, ignore[] }
 *
 * Telemetry is switched off; the clock-dependent RemainingDays values are
 * listed in `ignore` when php-dna derived them from the current date.
 */
date_default_timezone_set('UTC');
require dirname(__DIR__) . '/DomainNameApi/DomainNameAPI_PHPLibrary.php';

use DomainNameApi\DomainNameAPI_PHPLibrary;

const RESELLER = '00000000-0000-4000-8000-000000000001';
const API_KEY  = 'conformance-api-key';

$filter = $argv[1] ?? '';
$out    = __DIR__ . '/fixtures';
$state  = sys_get_temp_dir() . '/dna-conformance-' . getmypid();
@mkdir($state, 0700, true);
@mkdir($out, 0755, true);

$sock = stream_socket_server('tcp://127.0.0.1:0');
$port = (int) substr(strrchr(stream_socket_get_name($sock, false), ':'), 1);
fclose($sock);

$cmd  = sprintf('DNA_CONFORMANCE_STATE=%s exec %s -S 127.0.0.1:%d %s >/dev/null 2>&1',
    escapeshellarg($state), escapeshellarg(PHP_BINARY), $port, escapeshellarg(__DIR__ . '/server.php'));
$proc = proc_open($cmd, [], $pipes);
register_shutdown_function(function () use ($proc, $state) {
    proc_terminate($proc);
    array_map('unlink', glob("$state/*") ?: []);
    @rmdir($state);
});
for ($i = 0; $i < 50 && !@fsockopen('127.0.0.1', $port); $i++) {
    usleep(100000);
}

$scenarios = require __DIR__ . '/scenarios.php';
$written   = 0;
foreach ($scenarios as $s) {
    if ($filter !== '' && strpos($s['id'], $filter) !== 0) {
        continue;
    }
    file_put_contents("$state/queue.json", json_encode($s['responses']));
    file_put_contents("$state/log.json", '[]');

    $api = new DomainNameAPI_PHPLibrary(RESELLER, API_KEY, false);
    $api->setErrorReportingEnabled(false);
    $api->setServiceUrl("http://127.0.0.1:$port/api/v1");

    $output   = call_user_func_array([$api, $s['call']], $s['args']);
    $requests = json_decode(file_get_contents("$state/log.json"), true);
    // Keep only the responses php-dna actually consumed, so a port that makes
    // an extra request fails instead of silently reading a spare response.
    $responses = array_slice($s['responses'], 0, count($requests));

    $fixture = [
        'id'        => $s['id'],
        'call'      => $s['call'],
        'args'      => $s['args'],
        'note'      => $s['note'],
        'responses' => $responses,
        'requests'  => $requests,
        'output'    => $output,
        'ignore'    => volatilePaths($output, $responses),
    ];
    if ($fixture['note'] === '') {
        unset($fixture['note']);
    }
    file_put_contents("$out/{$s['id']}.json",
        json_encode($fixture, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION) . "\n");
    $written++;
}
echo "$written fixture(s) written to $out\n";

/**
 * RemainingDays computed from "now" (the gateway sent no remainingDay) changes
 * every day, so ports only check it is a non-negative integer.
 */
function volatilePaths($output, array $responses, string $prefix = ''): array
{
    $sentRemaining = false;
    foreach ($responses as $r) {
        if (preg_match('/"remainingDay"\s*:\s*\d/', (string) $r['body'])) {
            $sentRemaining = true;
        }
    }
    $paths = [];
    $walk  = function ($node, $path) use (&$walk, &$paths, $sentRemaining) {
        if (!is_array($node)) {
            return;
        }
        foreach ($node as $k => $v) {
            $p = $path === '' ? (string) $k : "$path.$k";
            if ($k === 'RemainingDays' && !$sentRemaining) {
                $paths[] = $p;
            }
            $walk($v, $p);
        }
    };
    $walk($output, $prefix);
    return $paths;
}
