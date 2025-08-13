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

 */

if ( ! defined( 'ABSPATH' ) ) exit;

// Costanti di base
define('DZ_CF7_DIR', plugin_dir_path(__FILE__));
define('DZ_CF7_URL', plugin_dir_url(__FILE__));

// Includi moduli
require_once DZ_CF7_DIR . 'includes/firewall.php';
require_once DZ_CF7_DIR . 'includes/hooks.php';
require_once DZ_CF7_DIR . 'includes/logger.php';
require_once DZ_CF7_DIR . 'includes/api-fetcher.php';
require_once DZ_CF7_DIR . 'includes/admin-dashboard.php';

// Carica assets per l’admin
add_action('admin_enqueue_scripts', function($hook) {
        if (strpos($hook, 'cf7-antispam') !== false) {
            wp_enqueue_style(
                'dz-cf7-style',
                DZ_CF7_URL . 'assets/style.css',
                [],
                filemtime(DZ_CF7_DIR . 'assets/style.css')
            );
            wp_enqueue_script(
                'dz-cf7-script',
                DZ_CF7_URL . 'assets/script.js',
                [],
                filemtime(DZ_CF7_DIR . 'assets/script.js'),
                true
            );
        }
});
