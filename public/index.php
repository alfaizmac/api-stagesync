<?php

/**
 * Minimal standalone router for api-stagesync's internal docs-search
 * endpoint. Run it with PHP's built-in dev server:
 *
 *   php -S localhost:8081 -t public
 *
 * (run from the api-stagesync project root, not inside public/)
 *
 * This deliberately has no framework, no Composer dependencies -- it's
 * a demo standing in for "Project 2, the API's own backend". In your
 * real api-stagesync, this same logic would live inside whatever
 * framework that project already uses (a controller + route, same
 * shape as ChatController/ApiDocsService in my-chatbot-site).
 */

header('Content-Type: application/json');

// --- Auth --------------------------------------------------------------
// Server-to-server only: my-chatbot-site sends this header, nothing
// public-facing (browser, Claude, the end user) ever sees or sends it.
// Change this to something real -- and put the real value in each
// project's own .env, never hardcoded like this demo does -- before
// this leaves "demo" and touches anything real.
const INTERNAL_TOKEN = 'demo-internal-secret-change-me';

$providedToken = $_SERVER['HTTP_X_INTERNAL_TOKEN'] ?? '';

if (!hash_equals(INTERNAL_TOKEN, $providedToken)) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// --- Routing -------------------------------------------------------------

$requestPath = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);

if ($requestPath !== '/internal/docs/search') {
    http_response_code(404);
    echo json_encode(['error' => 'Not found']);
    exit;
}

// --- The actual search logic ---------------------------------------------
// Same shape as ApiDocsService::search()/isAllowed()/summarize() from
// my-chatbot-site -- just living here now, next to the spec it reads.

$allowlist = require __DIR__ . '/../config/allowed_endpoints.php';
$specPath = __DIR__ . '/../data/api-docs.json';

function isAllowed(string $method, string $path, array $allowlist): bool
{
    return in_array(strtoupper($method) . ' ' . $path, $allowlist, true);
}

function summarize(string $method, string $path, array $operation): array
{
    return [
        'method' => strtoupper($method),
        'path' => $path,
        'summary' => $operation['summary'] ?? null,
        'description' => $operation['description'] ?? null,
        'parameters' => array_map(fn ($p) => [
            'name' => $p['name'] ?? null,
            'in' => $p['in'] ?? null,
            'required' => $p['required'] ?? false,
            'description' => $p['description'] ?? null,
        ], $operation['parameters'] ?? []),
        'response_codes' => array_keys($operation['responses'] ?? []),
    ];
}

if (!file_exists($specPath)) {
    http_response_code(500);
    echo json_encode(['error' => 'Spec file not found on this server']);
    exit;
}

$spec = json_decode(file_get_contents($specPath), true) ?? [];
$query = strtolower(trim($_GET['q'] ?? ''));
$results = [];

foreach ($spec['paths'] ?? [] as $path => $methods) {
    foreach ($methods as $method => $operation) {
        if (!is_array($operation) || !isAllowed($method, $path, $allowlist)) {
            continue;
        }

        $haystack = strtolower(implode(' ', [
            $path,
            $operation['summary'] ?? '',
            $operation['description'] ?? '',
            implode(' ', $operation['tags'] ?? []),
        ]));

        if ($query === '' || str_contains($haystack, $query)) {
            $results[] = summarize($method, $path, $operation);
        }
    }
}

echo json_encode($results);
