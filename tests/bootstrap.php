<?php
// Dove la CI mette la WordPress tests library.
$tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $tests_dir ) {
    $tests_dir = '/tmp/wordpress-tests-lib';
}
if ( ! file_exists( $tests_dir . '/includes/functions.php' ) ) {
    echo "Impossibile trovare la WordPress tests library in {$tests_dir}\n";
    exit(1);
}

// Carica il plugin PRIMA del bootstrap di WP.
tests_add_filter( 'muplugins_loaded', function () {
    // Adatta se il nome del file principale cambia.
    require dirname( __DIR__ ) . '/digitalezen-antispam-shield-for-cf7.php';
});

// Avvia la WP test suite.
require $tests_dir . '/includes/functions.php';
require $tests_dir . '/includes/bootstrap.php';
