<?php
/**
 * Lightweight wrappers around the WP_Filesystem API.
 *
 * @package Digitalezen_Cf7_Antispam
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Return a WP_Filesystem instance.
 *
 * @return WP_Filesystem_Base
 */
function dz_cf7_get_filesystem() {
	global $wp_filesystem;
	if ( ! $wp_filesystem ) {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		WP_Filesystem();
	}
	return $wp_filesystem;
}

/**
 * Write contents to a file using WP_Filesystem.
 *
 * @param string $path    Target path.
 * @param string $content Data to write.
 * @param int    $mode    Optional file mode.
 * @return bool
 */
function dz_cf7_fs_put_contents( $path, $content, $mode = FS_CHMOD_FILE ) {
	$fs = dz_cf7_get_filesystem();
	return $fs->put_contents( $path, $content, $mode );
}

/**
 * Retrieve file contents using WP_Filesystem.
 *
 * @param string $path Path to file.
 * @return string|false
 */
function dz_cf7_fs_get_contents( $path ) {
	$fs = dz_cf7_get_filesystem();
	return $fs->get_contents( $path );
}

/**
 * Append contents to a file using WP_Filesystem.
 *
 * @param string $path    Target path.
 * @param string $content Data to append.
 * @param int    $mode    Optional file mode.
 * @return bool
 */
function dz_cf7_fs_append( $path, $content, $mode = FS_CHMOD_FILE ) {
	$fs       = dz_cf7_get_filesystem();
	$existing = $fs->exists( $path ) ? $fs->get_contents( $path ) : '';
	return $fs->put_contents( $path, $existing . $content, $mode );
}
