<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * File Name: firewall.php
 * Plugin Name: DigitaleZen AntiSpam Shield for CF7
 * Author: DigitaleZen
 * License: GPLv2 or later
 */

// 🔒 BLOCCO IP – Hook INIT
add_action('init', function () {
	$ip  = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );
	$file = WP_CONTENT_DIR . '/block-ip.txt';

	if (!file_exists($file)) return;

	$lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$new_lines = [];

	foreach ($lines as $line) {
	    list($blocked_ip, $until) = explode('|', $line);

	    // Mantieni solo le righe valide (non scadute)
	    if (time() < intval($until)) {
	        $new_lines[] = "$blocked_ip|$until";

	        // Se l'IP corrente è bloccato → fermalo
	        if ($ip === $blocked_ip) {
	            header('HTTP/1.1 403 Forbidden');
                exit(esc_html__('⛔ Access temporarily blocked due to suspicious behavior.', 'digitalezen-antispam-shield-for-cf7'));
	        }
	    }
	}

	// Sovrascrive il file con solo IP ancora validi
	file_put_contents($file, implode("\n", $new_lines) . "\n");
});
