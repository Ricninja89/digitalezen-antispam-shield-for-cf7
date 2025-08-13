<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * File Name: admin-dashboard.php
 * Plugin Name: DigitaleZen AntiSpam Shield for CF7
 * Author: DigitaleZen
 * License: GPLv2 or later
 */

// 🔧 Aggiunge la voce di menu in admin
add_action('admin_menu', function () {
	add_menu_page(
            __('CF7 AntiSpam', 'digitalezen-antispam-shield-for-cf7'),
            __('CF7 AntiSpam', 'digitalezen-antispam-shield-for-cf7'),
	    'manage_options',
	    'cf7-antispam',
	    'dz_cf7_render_dashboard',
	    'dashicons-shield-alt',
	    80
	);
});

// 💾 Salva le impostazioni dal form
add_action('admin_init', function () {
    if (
        isset($_POST['dz_cf7_settings_submit'], $_POST['dz_cf7_log_email']) &&
        check_admin_referer('dz_cf7_save_settings')
    ) {
        $email = sanitize_email( wp_unslash( $_POST['dz_cf7_log_email'] ) );
        if ( is_email( $email ) ) {
            update_option( 'dz_cf7_log_email', $email );
        }
    }
});

// 📄 Mostra la dashboard (carica template)
function dz_cf7_render_dashboard()
{
	// 📸 Banner e logo nella parte alta della dashboard
        echo '<div style="text-align: center; padding: 20px 0;">';
        $banner_url = plugins_url( 'assets/img/banner2.png', dirname( __DIR__ ) . '/digitalezen-antispam-shield-for-cf7.php' );
        echo wp_kses(
            sprintf(
                '<img src="%1$s" alt="%2$s" style="max-width: 100%%; height: auto; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); margin-bottom: 20px;">',
                esc_url( $banner_url ),
                esc_attr__('Banner DigitaleZen', 'digitalezen-antispam-shield-for-cf7')
            ),
            array(
                'img' => array(
                    'src'   => array(),
                    'alt'   => array(),
                    'style' => array(),
                ),
            )
        );
        echo '</div>';

	include DZ_CF7_DIR . 'templates/dashboard.php';
}

// 🔍 Permette la visualizzazione di file JSON direttamente dal backend
add_action( 'admin_init', function () {
    if ( isset( $_GET['action'], $_GET['f'], $_GET['_wpnonce'] ) && 'dz_cf7_view_json' === $_GET['action'] ) {
        if ( wp_verify_nonce( sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ), 'dz_cf7_view_json' ) ) {
            $file       = sanitize_text_field( wp_unslash( $_GET['f'] ) );
            $_GET['f'] = $file;
            include_once DZ_CF7_DIR . 'includes/view-json.php';
            exit;
        }
    }
} );

// 📊 Enqueue degli script solo nella pagina CF7 AntiSpam
add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook !== 'toplevel_page_cf7-antispam') return;

    // Chart.js locale
    wp_enqueue_script(
        'chartjs',
        plugin_dir_url(__DIR__) . 'assets/chart.js',
        [],
        filemtime(plugin_dir_path(__DIR__) . 'assets/chart.js'),
        true
    );

    // Il tuo script personalizzato
    wp_enqueue_script(
        'dz-cf7-dashboard',
        plugin_dir_url(__DIR__) . 'assets/script.js',
        ['chartjs'],
        filemtime(plugin_dir_path(__DIR__) . 'assets/script.js'),
        true
    );
});
