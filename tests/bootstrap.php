<?php
$tests_dir    = getenv( 'WP_TESTS_DIR' );
if ( ! $tests_dir ) {
    $tests_dir = '/tmp/wordpress-tests-lib';
}
$develop_dir = sys_get_temp_dir() . '/wordpress-develop';

if ( ! file_exists( $tests_dir . '/includes/functions.php' ) ) {
    if ( ! file_exists( $develop_dir . '/tests/phpunit/includes/functions.php' ) ) {
        echo "Cloning wordpress-develop...\n";
        system( 'git clone --depth=1 https://github.com/WordPress/wordpress-develop ' . escapeshellarg( $develop_dir ), $retval );
        if ( 0 !== $retval ) {
            echo "Impossibile clonare wordpress-develop\n";
            exit( 1 );
        }
    }

    if ( ! file_exists( $tests_dir ) ) {
        mkdir( $tests_dir, 0777, true );
    }

    // Copia la libreria dei test.
    system( 'cp -r ' . escapeshellarg( $develop_dir . '/tests/phpunit/includes' ) . ' ' . escapeshellarg( $tests_dir ) );
    system( 'cp -r ' . escapeshellarg( $develop_dir . '/tests/phpunit/data' ) . ' ' . escapeshellarg( $tests_dir ) );
}

if ( ! defined( 'WP_CORE_DIR' ) ) {
    define( 'WP_CORE_DIR', $develop_dir . '/src' );
}

if ( ! defined( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH' ) ) {
    $polyfills = getenv( 'HOME' ) . '/.local/share/mise/installs/php/8.4.11/.composer/vendor/yoast/phpunit-polyfills';
    if ( ! file_exists( $polyfills . '/phpunitpolyfills-autoload.php' ) ) {
        $polyfills = sys_get_temp_dir() . '/phpunit-polyfills';
        if ( ! file_exists( $polyfills . '/phpunitpolyfills-autoload.php' ) ) {
            echo "Cloning PHPUnit Polyfills...\n";
            system( 'git clone --depth=1 https://github.com/Yoast/PHPUnit-Polyfills ' . escapeshellarg( $polyfills ) );
            system( 'cd ' . escapeshellarg( $polyfills ) . ' && composer install >/tmp/polyfills.log 2>&1' );
        }
    }
    define( 'WP_TESTS_PHPUNIT_POLYFILLS_PATH', $polyfills );
}

if ( ! defined( 'FS_CHMOD_FILE' ) ) {
    define( 'FS_CHMOD_FILE', 0644 );
}

if ( ! function_exists( 'dz_cf7_fs_put_contents' ) ) {
    function dz_cf7_fs_put_contents( $path, $content, $mode = 0644 ) {
        $dir = dirname( $path );
        if ( ! is_dir( $dir ) ) {
            mkdir( $dir, 0777, true );
        }
        return file_put_contents( $path, $content );
    }
}
if ( ! function_exists( 'dz_cf7_fs_get_contents' ) ) {
    function dz_cf7_fs_get_contents( $path ) {
        return file_exists( $path ) ? file_get_contents( $path ) : false;
    }
}
if ( ! function_exists( 'dz_cf7_fs_append' ) ) {
    function dz_cf7_fs_append( $path, $content, $mode = 0644 ) {
        $dir = dirname( $path );
        if ( ! is_dir( $dir ) ) {
            mkdir( $dir, 0777, true );
        }
        return file_put_contents( $path, $content, FILE_APPEND );
    }
}

require $tests_dir . '/includes/functions.php';

// Carica il plugin PRIMA del bootstrap di WP.
tests_add_filter( 'muplugins_loaded', function () {
    require dirname( __DIR__ ) . '/digitalezen-antispam-shield-for-cf7.php';
} );

require $tests_dir . '/includes/bootstrap.php';
