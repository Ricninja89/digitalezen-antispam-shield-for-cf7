<?php
/**
 * Logging utilities.
 *
 * @package Digitalezen_Cf7_Antispam
 */

if ( ! defined( 'ABSPATH' ) ) {
		exit;
}

// Logging CSV + IP/email tracking.
/**
 * Registra tentativi di spam.
 *
 * @param string $reason  Motivo del blocco.
 * @param array  $data    Dati inviati.
 * @param string $log_path Percorso del file di log.
 * @param string $trigger  Informazione aggiuntiva.
 */
function dz_cf7_log_spam( $reason, $data, $log_path, $trigger = '' ) {
	$dir = dirname( $log_path );
	if ( ! file_exists( $dir ) ) {
		wp_mkdir_p( $dir );
	}

	$email = sanitize_email( $data['your-email'] ?? 'unknown' );
	$ip    = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ?? 'unknown' ) );
	$row   = array( gmdate( 'Y-m-d H:i:s' ), $email, $ip, $reason, $trigger );
	$line  = implode( ',', array_map( 'dz_cf7_csv_escape', $row ) ) . "\n";
	dz_cf7_fs_append( $log_path, $line );

		// Blocco IP temporaneo.
	if ( ! file_exists( DZ_CF7_UPLOAD_DIR ) ) {
		wp_mkdir_p( DZ_CF7_UPLOAD_DIR );
	}
		$blockfile   = DZ_CF7_UPLOAD_DIR . 'block-ip.txt';
		$block_until = time() + 600; // 10 minuti.
	dz_cf7_fs_append( $blockfile, "$ip|$block_until\n" );

	dz_cf7_track_attempts( $ip, $email );
}

/**
 * Escape per valori CSV.
 *
 * @param string $value Valore da escapare.
 * @return string
 */
function dz_cf7_csv_escape( $value ) {
		return '"' . str_replace( '"', '""', $value ) . '"';
}

// Flood detection IP/email.
/**
 * Controlla se un IP o email hanno superato il limite di invii.
 *
 * @param string $ip    Indirizzo IP.
 * @param string $email Email.
 * @return bool
 */
function dz_cf7_check_flood( $ip, $email ) {
		$window = 900; // 15 minuti.
	$limit      = 3;

		$base_dir = DZ_CF7_UPLOAD_DIR;
	if ( ! file_exists( $base_dir ) ) {
		wp_mkdir_p( $base_dir );
	}
		$ip_path   = $base_dir . 'ip-attempts.json';
		$mail_path = $base_dir . 'email-attempts.json';

	$ip_attempts   = file_exists( $ip_path ) ? json_decode( dz_cf7_fs_get_contents( $ip_path ), true ) ?? array() : array();
	$mail_attempts = file_exists( $mail_path ) ? json_decode( dz_cf7_fs_get_contents( $mail_path ), true ) ?? array() : array();

	$now = time();

	$ip_attempts[ $ip ]   = array_filter( $ip_attempts[ $ip ] ?? array(), fn( $ts ) => ( $now - $ts ) < $window );
	$ip_attempts[ $ip ][] = $now;

	$mail_attempts[ $email ]   = array_filter( $mail_attempts[ $email ] ?? array(), fn( $ts ) => ( $now - $ts ) < $window );
	$mail_attempts[ $email ][] = $now;

		dz_cf7_fs_put_contents( $ip_path, wp_json_encode( $ip_attempts ) );
		dz_cf7_fs_put_contents( $mail_path, wp_json_encode( $mail_attempts ) );

	return ( count( $ip_attempts[ $ip ] ) >= $limit || count( $mail_attempts[ $email ] ) >= $limit );
}

/**
 * Funzione placeholder per compatibilità futura.
 *
 * @param string $ip    Indirizzo IP.
 * @param string $email Email.
 */
function dz_cf7_track_attempts( $ip, $email ) {
		// Intenzionalmente vuoto: la funzione sopra fa tutto.
}

// Invio settimanale CSV.
add_action( 'dz_cf7_send_log', 'dz_cf7_send_spam_log_email' );

/**
 * Invia il log di spam via email.
 */
function dz_cf7_send_spam_log_email() {
		$path = DZ_CF7_UPLOAD_DIR . 'cf7-spam-log.csv';

		// Se il file non esiste o è vuoto, non inviare nulla.
	if ( ! file_exists( $path ) || 0 === filesize( $path ) ) {
			return;
	}

		// Recupera l'email dal campo personalizzato oppure usa quella dell'amministratore.
		$email_destinatario = get_option( 'dz_cf7_log_email' );
	if ( empty( $email_destinatario ) || ! is_email( $email_destinatario ) ) {
			$email_destinatario = get_option( 'admin_email' );
	}

		// Invia email con allegato.
		wp_mail(
			$email_destinatario,
			__( 'Weekly CF7 report - Blocked spam', 'digitalezen-antispam-shield-for-cf7' ),
			__( 'Attached is the file with attempts blocked by the anti-spam filter.', 'digitalezen-antispam-shield-for-cf7' ),
			array( 'Content-Type: text/plain; charset=UTF-8' ),
			array( $path )
		);

		// Svuota il file dopo l'invio.
		dz_cf7_fs_put_contents( $path, '' );
}

// Pianifica cron settimanale.
if ( ! wp_next_scheduled( 'dz_cf7_send_log' ) ) {
	wp_schedule_event( strtotime( 'next Monday 02:00' ), 'weekly', 'dz_cf7_send_log' );
}
