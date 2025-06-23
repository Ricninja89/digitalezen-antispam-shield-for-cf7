<?php
/**
 * File Name: logger.php
 * Plugin Name: DigitaleZen CF7 AntiSpam Shield
 * Autore: DigitaleZen
 * Licenza: MIT
 */

// 📦 Logging CSV + IP/email tracking
function dz_cf7_log_spam($reason, $data, $log_path, $trigger = '')
{
	$dir = dirname($log_path);
	if (!file_exists($dir)) {
	    wp_mkdir_p($dir);
	}

	$email = sanitize_email($data['your-email'] ?? 'unknown');
	$ip    = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? 'unknown');
	$row = [date('Y-m-d H:i:s'), $email, $ip, $reason, $trigger];
	$line = implode(',', array_map('dz_cf7_csv_escape', $row)) . "\n";
	file_put_contents($log_path, $line, FILE_APPEND);

	// Blocco IP temporaneo
	$blockfile = WP_CONTENT_DIR . '/block-ip.txt';
	$block_until = time() + 600; // 10 minuti
	file_put_contents($blockfile, "$ip|$block_until\n", FILE_APPEND);

	dz_cf7_track_attempts($ip, $email);
}

function dz_cf7_csv_escape($value)
{
	return '"' . str_replace('"', '""', $value) . '"';
}

// 👁️‍🗨️ Flood detection IP/email
function dz_cf7_check_flood($ip, $email)
{
	$window = 900; // 15 minuti
	$limit = 3;

	$ip_path = WP_CONTENT_DIR . '/ip-attempts.json';
	$mail_path = WP_CONTENT_DIR . '/email-attempts.json';

	$ip_attempts = file_exists($ip_path) ? json_decode(file_get_contents($ip_path), true) ?? [] : [];
	$mail_attempts = file_exists($mail_path) ? json_decode(file_get_contents($mail_path), true) ?? [] : [];

	$now = time();

	$ip_attempts[$ip] = array_filter($ip_attempts[$ip] ?? [], fn($ts) => ($now - $ts) < $window);
	$ip_attempts[$ip][] = $now;

	$mail_attempts[$email] = array_filter($mail_attempts[$email] ?? [], fn($ts) => ($now - $ts) < $window);
	$mail_attempts[$email][] = $now;

	file_put_contents($ip_path, json_encode($ip_attempts));
	file_put_contents($mail_path, json_encode($mail_attempts));

	return (count($ip_attempts[$ip]) >= $limit || count($mail_attempts[$email]) >= $limit);
}

function dz_cf7_track_attempts($ip, $email)
{
	// Intenzionalmente vuoto: la funzione sopra fa tutto
}

// 📬 Invio settimanale CSV
add_action('dz_cf7_send_log', 'dz_cf7_send_spam_log_email');

function dz_cf7_send_spam_log_email()
{
	$path = wp_upload_dir()['basedir'] . '/cf7-logs/cf7-spam-log.csv';

	// Se il file non esiste o è vuoto, non inviare nulla
	if (!file_exists($path) || filesize($path) == 0) return;

	// Recupera l'email dal campo personalizzato oppure usa quella dell'amministratore
	$email_destinatario = get_option('dz_cf7_log_email');
	if (empty($email_destinatario) || !is_email($email_destinatario)) {
	    $email_destinatario = get_option('admin_email');
	}

	// Invia email con allegato
	wp_mail(
	    $email_destinatario,
	    __('Report settimanale CF7 - Spam bloccato', 'digitalezen-cf7'),
	    __('In allegato il file con i tentativi bloccati tramite il filtro anti-spam.', 'digitalezen-cf7'),
	    ['Content-Type: text/plain; charset=UTF-8'],
	    [$path]
	);

	// Svuota il file dopo l'invio
	file_put_contents($path, '');
}

// ⏰ Pianifica cron settimanale
if (!wp_next_scheduled('dz_cf7_send_log')) {
	wp_schedule_event(strtotime('next Monday 02:00'), 'weekly', 'dz_cf7_send_log');
}
