<?php
/**
 * Test base per DigitaleZen CF7 Antispam.
 */
class DZ_CF7_Antispam_Core_Test extends WP_UnitTestCase {

    public function test_wordpress_caricato() {
        $this->assertTrue( function_exists( 'do_action' ), 'WP non è caricato' );
    }

    public function test_plugin_caricato() {
        if ( ! function_exists( 'dz_cf7_fs_put_contents' ) ) {
            $this->markTestSkipped( 'dz_cf7_fs_put_contents() non disponibile: helper FS non caricato.' );
        }
        $this->assertTrue( function_exists( 'dz_cf7_fs_put_contents' ) );
    }

    public function test_fs_write_scrive_un_file() {
        $uploads = wp_upload_dir();
        $dir     = trailingslashit( $uploads['basedir'] ) . 'dz-cf7-tests';
        $file    = trailingslashit( $dir ) . 'probe.txt';

        if ( file_exists( $file ) ) {
            @unlink( $file );
        }

        $ok = dz_cf7_fs_put_contents( $file, 'ok' );
        $this->assertTrue( (bool) $ok, 'dz_cf7_fs_put_contents() ha restituito falso' );
        $this->assertFileExists( $file );
        $this->assertSame( 'ok', file_get_contents( $file ) );
    }
}
