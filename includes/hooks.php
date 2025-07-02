<?php
/**
 * File Name: hooks.php
 * Plugin Name: DigitaleZen CF7 AntiSpam Shield
 * Autore: DigitaleZen
 * Licenza: MIT
 */

// ✅ Hook principale: blocca invio se sospetto
add_action('wpcf7_before_send_mail', 'dz_cf7_anti_spam_guard');

function dz_cf7_anti_spam_guard($cf7)
{
	$submission = WPCF7_Submission::get_instance();
	if (!$submission) return;

	$data = $submission->get_posted_data();
	$upload_dir = wp_upload_dir()['basedir'] . '/cf7-logs';
	$log_path = $upload_dir . '/cf7-spam-log.csv';
	$json_path = $upload_dir . '/cf7-blacklist.json';

	// 🧪 Token form anti-bot
	$form_id = $cf7->id();
	$hour_now = date('YmdH');
	$hour_prev = date('YmdH', strtotime('-1 hour'));
	$valid_token_now = hash('sha256', "form-$form_id::$hour_now");
	$valid_token_prev = hash('sha256', "form-$form_id::$hour_prev");
	$submitted_token = $data['form-token'] ?? '';

	if ($submitted_token !== $valid_token_now && $submitted_token !== $valid_token_prev) {
	    dz_cf7_log_spam('token_scaduto', $data, $log_path);
            $submission->set_response(__('⏳ Session expired. Refresh the page and try again.', 'digitalezen-cf7'));
	    $cf7->skip_mail = true;
	    return;
	}

	// 🕳️ Honeypot
	if (!empty($data['spamcheck'])) {
	    dz_cf7_log_spam('honeypot', $data, $log_path);
	    $cf7->skip_mail = true;
	    return;
	}

	// 🔍 Controlli da blacklist
	if (!file_exists($json_path)) return;
	$json = json_decode(file_get_contents($json_path), true);
	if (!$json || !is_array($json)) return;

	$blocked_ips = $json['ips'] ?? [];
	$blocked_emails = $json['emails'] ?? [];
	$blocked_domains = $json['domains'] ?? [];
	$blocked_usernames = $json['usernames'] ?? [];
	$blocked_keywords = $json['keywords'] ?? [];

	$client_ip = sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? '');
	$email     = sanitize_email($data['your-email'] ?? '');
	$domain = ($email && strpos($email, '@') !== false) ? strtolower(substr(strrchr($email, "@"), 1)) : '';

	if (in_array($client_ip, $blocked_ips)) {
	    dz_cf7_log_spam('ip', $data, $log_path, $client_ip);
	    $cf7->skip_mail = true;
	    return;
	}
	if (in_array($email, $blocked_emails)) {
	    dz_cf7_log_spam('email', $data, $log_path, $email);
	    $cf7->skip_mail = true;
	    return;
	}
	if (in_array($domain, $blocked_domains)) {
	    dz_cf7_log_spam('domain', $data, $log_path, $domain);
	    $cf7->skip_mail = true;
	    return;
	}

	foreach ($data as $value) {
	    foreach ($blocked_usernames as $username) {
	        if (stripos($value, $username) !== false) {
	            dz_cf7_log_spam('username', $data, $log_path, $username);
	            $cf7->skip_mail = true;
	            return;
	        }
	    }
	    foreach ($blocked_keywords as $keyword) {
	        if (stripos($value, $keyword) !== false) {
	            dz_cf7_log_spam('keyword', $data, $log_path, $keyword);
	            $cf7->skip_mail = true;
	            return;
	        }
	    }
	}

	// 🔥 Flood protection
	if (dz_cf7_check_flood($client_ip, $email)) {
	    dz_cf7_log_spam('flood', $data, $log_path, "$client_ip/$email");
	    $cf7->skip_mail = true;
	    return;
	}
}

// 🐌 Controlla tempo di invio (almeno 4s)
add_filter('wpcf7_validate', function($result, $tags) {
	$submission = WPCF7_Submission::get_instance();
	if (!$submission) return $result;
	$data = $submission->get_posted_data();

	$t0 = strtotime($data['timestamp'] ?? 'now');
	$t1 = time();
	if (($t1 - $t0) < 4) {
            $result->invalidate('*', __('Please do not submit so quickly.', 'digitalezen-cf7'));
	}
	return $result;
}, 10, 2);

// 🔐 Genera token invisibile [form-token]
add_filter('wpcf7_form_hidden_fields', function($hidden_fields) {
    $contact_form = WPCF7_ContactForm::get_current();
    $form_id = $contact_form ? $contact_form->id() : 'unknown';
	$hour = date('YmdH');
	$token = hash('sha256', "form-$form_id::$hour");
	$hidden_fields['form-token'] = $token;
	return $hidden_fields;
}, 10, 2);
