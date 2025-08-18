<?php
/**
 * File Name: DigitaleZen AntiSpam Shield for CF7
 * Plugin Name: DigitaleZen AntiSpam Shield for CF7
 * Description: Advanced protection against spam for Contact Form 7. Blacklist, logging, flood control and a sleek dashboard.
 * Version: 1.0.0
 * Author: DigitaleZen
 * Author URI: https://digitalezen.it
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Requires Plugins: contact-form-7
 * Text Domain: digitalezen-antispam-shield-for-cf7
 *
 * @package Digitalezen_Cf7_Antispam
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Costanti di base.
define( 'DZ_CF7_DIR', plugin_dir_path( __FILE__ ) );
define( 'DZ_CF7_URL', plugin_dir_url( __FILE__ ) );

// Directory e URL per i file generati dal plugin.
$dz_cf7_upload = wp_upload_dir();
define( 'DZ_CF7_UPLOAD_DIR', trailingslashit( trailingslashit( $dz_cf7_upload['basedir'] ) . 'digitalezen-antispam-shield-for-cf7' ) );
define( 'DZ_CF7_UPLOAD_URL', trailingslashit( trailingslashit( $dz_cf7_upload['baseurl'] ) . 'digitalezen-antispam-shield-for-cf7' ) );

// Slug univoco per la pagina di amministrazione.
define( 'DZ_CF7_MENU_SLUG', 'dzcf7-antispam' );

// Includi moduli.
require_once DZ_CF7_DIR . 'includes/firewall.php';
require_once DZ_CF7_DIR . 'includes/hooks.php';
require_once DZ_CF7_DIR . 'includes/logger.php';
require_once DZ_CF7_DIR . 'includes/api-fetcher.php';
require_once DZ_CF7_DIR . 'includes/admin-dashboard.php';

// Carica assets per l’admin.
add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		if ( strpos( $hook, DZ_CF7_MENU_SLUG ) !== false ) {
			wp_enqueue_style(
				'dz-cf7-style',
				DZ_CF7_URL . 'assets/style.css',
				array(),
				filemtime( DZ_CF7_DIR . 'assets/style.css' )
			);
			wp_enqueue_script(
				'dz-cf7-script',
				DZ_CF7_URL . 'assets/script.js',
				array(),
				filemtime( DZ_CF7_DIR . 'assets/script.js' ),
				true
			);
		}
	}
);
