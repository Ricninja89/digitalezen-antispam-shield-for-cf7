<?php
/**
 * File Name: admin-dashboard.php
 * Plugin Name: DigitaleZen CF7 AntiSpam Shield
 * Autore: DigitaleZen
 * Licenza: MIT
 */

// 🔧 Aggiunge la voce di menu in admin
add_action('admin_menu', function () {
	add_menu_page(
	    __('CF7 AntiSpam', 'digitalezen-cf7'),
	    __('CF7 AntiSpam', 'digitalezen-cf7'),
	    'manage_options',
	    'cf7-antispam',
	    'dz_cf7_render_dashboard',
	    'dashicons-shield-alt',
	    80
	);
});

// 💾 Salva le impostazioni dal form
add_action('admin_init', function () {
	if (isset($_POST['dz_cf7_settings_submit']) && check_admin_referer('dz_cf7_save_settings')) {
	    $email = sanitize_email($_POST['dz_cf7_log_email'] ?? '');
	    if (is_email($email)) {
	        update_option('dz_cf7_log_email', $email);
	    }
	}
});

// 📄 Mostra la dashboard (carica template)
function dz_cf7_render_dashboard()
{
	include DZ_CF7_DIR . 'templates/dashboard.php';
}

add_action('admin_init', function () {
	$action = isset($_GET['action']) ? sanitize_text_field($_GET['action']) : '';
	$file   = isset($_GET['f']) ? sanitize_text_field($_GET['f']) : '';

	if ($action === 'dz_cf7_view_json' && $file) {
	    $_GET['f'] = $file;
	    include_once DZ_CF7_DIR . 'includes/view-json.php';
	    exit;
	}
});
