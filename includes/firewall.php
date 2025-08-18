<?php
/**
 * Simple IP blocking firewall.
 *
 * @package Digitalezen_Cf7_Antispam
 */

if ( ! defined( 'ABSPATH' ) ) {
		exit;
}

// Blocco IP – hook INIT.
add_action(
	'init',
	function () {
		$ip   = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? '' ) );
		$file = DZ_CF7_UPLOAD_DIR . 'block-ip.txt';

		if ( ! file_exists( $file ) ) {
			return;
		}

		$contents = dz_cf7_fs_get_contents( $file );
		if ( false === $contents ) {
			return;
		}
		$lines     = array_filter( array_map( 'trim', explode( "\n", $contents ) ) );
		$new_lines = array();

		foreach ( $lines as $line ) {
			list($blocked_ip, $until) = explode( '|', $line );

						// Mantieni solo le righe valide (non scadute).
			if ( time() < intval( $until ) ) {
				$new_lines[] = "$blocked_ip|$until";

								// Se l'IP corrente è bloccato → fermalo.
				if ( $ip === $blocked_ip ) {
					header( 'HTTP/1.1 403 Forbidden' );
					exit( esc_html__( '⛔ Access temporarily blocked due to suspicious behavior.', 'digitalezen-antispam-shield-for-cf7' ) );
				}
			}
		}

				// Sovrascrive il file con solo IP ancora validi.
		dz_cf7_fs_put_contents( $file, implode( "\n", $new_lines ) . "\n" );
	}
);
