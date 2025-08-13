<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * File Name: view-json.php
 * Plugin Name: DigitaleZen AntiSpam Shield for CF7
 * Author: DigitaleZen
 * License: GPLv2 or later
 */

// Sicurezza: accetta solo nomi autorizzati
$whitelist = [
    'cf7-blacklist.json'    => WP_CONTENT_DIR . '/uploads/cf7-logs/cf7-blacklist.json',
    'ip-attempts.json'      => WP_CONTENT_DIR . '/ip-attempts.json',
    'email-attempts.json'   => WP_CONTENT_DIR . '/email-attempts.json',
];

if (
    ! isset($_GET['f'], $_GET['_wpnonce']) ||
    ! wp_verify_nonce(sanitize_text_field(wp_unslash($_GET['_wpnonce'])), 'dz_cf7_view_json')
) {
    http_response_code(403);
    exit(esc_html__('⛔ Unauthorized access.', 'digitalezen-antispam-shield-for-cf7'));
}

$file_key = sanitize_text_field(wp_unslash($_GET['f']));

if (! isset($whitelist[$file_key])) {
    http_response_code(403);
    exit(esc_html__('⛔ Unauthorized access.', 'digitalezen-antispam-shield-for-cf7'));
}

$file_path = $whitelist[$file_key];

if (! file_exists($file_path)) {
    http_response_code(404);
    exit(esc_html__('❌ File not found.', 'digitalezen-antispam-shield-for-cf7'));
}

// Inizializza wp_filesystem se necessario
global $wp_filesystem;
if (empty($wp_filesystem)) {
    require_once ABSPATH . 'wp-admin/includes/file.php';
    WP_Filesystem();
}

$content = $wp_filesystem->get_contents($file_path);

// Verifica se è JSON valido
$json_decoded = json_decode($content, true);
if (json_last_error() === JSON_ERROR_NONE) {
    header('Content-Type: application/json; charset=UTF-8');
    echo wp_json_encode($json_decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} else {
    // Fallback in plain text (escaped)
    header('Content-Type: text/plain; charset=UTF-8');
    echo esc_html($content);
}

exit;
