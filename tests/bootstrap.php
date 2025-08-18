<?php
$tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $tests_dir ) {
    $tests_dir = '/tmp/wordpress-tests-lib';
}
if ( ! file_exists( $tests_dir . '/includes/functions.php' ) ) {
    echo "Impossibile trovare la WordPress tests library in {$tests_dir}\n";
    exit(1);
}

require $tests_dir . '/includes/functions.php';

// Carica il plugin PRIMA del bootstrap di WP.
tests_add_filter( 'muplugins_loaded', function () {
    require dirname( __DIR__ ) . '/digitalezen-antispam-shield-for-cf7.php';
} );

require $tests_dir . '/includes/bootstrap.php';
