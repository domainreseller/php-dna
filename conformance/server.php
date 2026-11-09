<?php
/**
 * Mock gateway for the conformance generator (php -S 127.0.0.1:PORT server.php).
 * Serves the queued responses from $STATE/queue.json in order and records every
 * request to $STATE/log.json.
 */
$state = getenv('DNA_CONFORMANCE_STATE') ?: sys_get_temp_dir() . '/dna-conformance';
$queue = json_decode(@file_get_contents("$state/queue.json") ?: '[]', true);
$log   = json_decode(@file_get_contents("$state/log.json") ?: '[]', true);

$uri   = $_SERVER['REQUEST_URI'];
$path  = parse_url($uri, PHP_URL_PATH);
$query = [];
parse_str((string) parse_url($uri, PHP_URL_QUERY), $query);
$raw   = file_get_contents('php://input');

$log[] = [
    'method' => $_SERVER['REQUEST_METHOD'],
    'path'   => preg_replace('#^/api/v1/#', '', $path),
    'query'  => $query,
    'body'   => $raw === '' ? null : json_decode($raw, true),
    'headers' => [
        'X-API-KEY'  => $_SERVER['HTTP_X_API_KEY'] ?? null,
        '__reseller' => $_SERVER['HTTP___RESELLER'] ?? null,
    ],
];
file_put_contents("$state/log.json", json_encode($log));

$next = array_shift($queue);
file_put_contents("$state/queue.json", json_encode($queue));
if ($next === null) {
    $next = ['status' => 500, 'body' => '{"error":{"message":"conformance: no queued response"}}'];
}
http_response_code((int) $next['status']);
header('Content-Type: application/json');
echo $next['body'];
