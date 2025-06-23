<?php

// 🔧 Aggiunge la voce di menu in admin
add_action('admin_menu', function () {
    add_menu_page(
        'CF7 AntiSpam',
        'CF7 AntiSpam',
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
function dz_cf7_render_dashboard() {
    include DZ_CF7_DIR . 'templates/dashboard.php';
}

add_action('admin_init', function () {
    if (isset($_GET['action']) && $_GET['action'] === 'dz_cf7_view_json' && isset($_GET['f'])) {
        include_once DZ_CF7_DIR . 'includes/view-json.php';
        exit;
    }
});
