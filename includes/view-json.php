<?php
// Sicurezza: accetta solo nomi autorizzati
$whitelist = [
    'cf7-blacklist.json' => WP_CONTENT_DIR . '/uploads/cf7-logs/cf7-blacklist.json',
    'ip-attempts.json'   => WP_CONTENT_DIR . '/ip-attempts.json',
    'email-attempts.json'=> WP_CONTENT_DIR . '/email-attempts.json',
];

$file_key = $_GET['f'] ?? '';
if (!isset($whitelist[$file_key])) {
    http_response_code(403);
    exit("⛔ Accesso non autorizzato.");
}

$file_path = $whitelist[$file_key];

if (!file_exists($file_path)) {
    http_response_code(404);
    exit("❌ File non trovato.");
}

header("Content-Type: text/plain; charset=UTF-8");
readfile($file_path);
exit;
