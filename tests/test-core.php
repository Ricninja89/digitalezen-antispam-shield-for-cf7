<?php
/**
 * Test base per DigitaleZen CF7 Antispam.
 */
class DZ_CF7_Antispam_Core_Test extends WP_UnitTestCase {

    public function test_wordpress_caricato() {
        $this->assertTrue( function_exists( 'do_action' ), 'WP non è caricato' );
    }

    public function test_plugin_caricato() {
        if ( ! function_exists( 'dz_fs_write' ) ) {
            $this->markTestSkipped( 'dz_fs_write() non disponibile: helper FS rinominato o non caricato.' );
        }
        $this->assertTrue( function_exists( 'dz_fs_write' ) );
    }

    public function test_fs_write_scrive_un_file() {
        $uploads = wp_upload_dir();
        $dir     = trailingslashit( $uploads['basedir'] ) . 'dz-cf7-tests';
        $file    = trailingslashit( $dir ) . 'probe.txt';

        if ( file_exists( $file ) ) { @unlink( $file ); }

        $ok = dz_fs_write( $file, 'ok' );
        $this->assertTrue( (bool) $ok, 'dz_fs_write() ha restituito falso' );
        $this->assertFileExists( $file );
        $this->assertSame( 'ok', file_get_contents( $file ) ); // ok nei test
    }

    public function test_http_mock() {
        add_filter( 'pre_http_request', function() {
            return array(
                'response' => array( 'code' => 200, 'message' => 'OK' ),
                'headers'  => array(),
                'body'     => '{"status":"ok"}',
            );
        } );

        $resp = wp_remote_get( 'https://example.test' );
        $this->assertFalse( is_wp_error( $resp ) );
        $this->assertSame( '{"status":"ok"}', wp_remote_retrieve_body( $resp ) );
    }
}
