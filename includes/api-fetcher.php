<?php
if ( ! defined( 'ABSPATH' ) ) exit;
/**
 * File Name: api-fetcher.php
 * Plugin Name: DigitaleZen AntiSpam Shield for CF7
 * Author: DigitaleZen
 * License: GPLv2 or later
 */

// 🔁 Scarica la blacklist da Google Apps Script
function dz_cf7_update_blacklist_json()
{
	$url = 'https://script.google.com/macros/s/AKfycbzTI7i_j2D7oe70RKcPDY0iT_meq'
	    . 'Sh_-RhQsPzQvdDhDUe8IiJhD4OdExWMgwpKM8r5/exec';

	$upload_dir = wp_upload_dir()['basedir'] . '/cf7-logs';
	$path = $upload_dir . '/cf7-blacklist.json';

	// Crea directory se non esiste
	if (!file_exists($upload_dir)) {
	    wp_mkdir_p($upload_dir);
	}

	// Effettua richiesta remota
	$res = wp_remote_get($url);
	if (is_wp_error($res)) return;

	$json = json_decode(wp_remote_retrieve_body($res), true);

	// Se valido → salva il file
	if (is_array($json)) {
	    file_put_contents($path, json_encode($json));
	}
}

// 🔁 Hook pianificazione CRON
add_action('dz_cf7_blacklist_daily', 'dz_cf7_update_blacklist_json');

if (!wp_next_scheduled('dz_cf7_blacklist_daily')) {
	wp_schedule_event(time(), 'daily', 'dz_cf7_blacklist_daily');
}
