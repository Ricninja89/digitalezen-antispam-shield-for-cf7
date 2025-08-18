<?php
// phpcs:ignoreFile
/**
 * Test antispam features for DigitaleZen CF7 plugin.
 */

if ( ! class_exists( 'WPCF7_Submission' ) ) {
	class WPCF7_Submission {
		private static $instance;
		private $data;
		private $response = '';

		public static function mock( $data ) {
			self::$instance = $data ? new self( $data ) : null;
		}

		public static function get_instance() {
			return self::$instance;
		}

		public function __construct( $data ) {
			$this->data = $data;
		}

		public function get_posted_data() {
			return $this->data;
		}

		public function set_response( $response ) {
			$this->response = $response;
		}

		public function get_response() {
			return $this->response;
		}
	}
}

if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
	class WPCF7_ContactForm {
		public $skip_mail = false;
		private $id;

		public function __construct( $id = 1 ) {
			$this->id = $id;
		}

		public function id() {
			return $this->id;
		}
	}
}

class DZ_CF7_Antispam_Spam_Test extends WP_UnitTestCase {

	protected function setUp(): void {
		parent::setUp();
		wp_mkdir_p( DZ_CF7_UPLOAD_DIR );
		foreach ( array( 'cf7-spam-log.csv', 'cf7-blacklist.json', 'ip-attempts.json', 'email-attempts.json', 'block-ip.txt' ) as $file ) {
			$path = DZ_CF7_UPLOAD_DIR . $file;
			if ( file_exists( $path ) ) {
				unlink( $path );
			}
		}
		WPCF7_Submission::mock( null );
	}

	public function test_invalid_token_blocks_submission() {
		$form_id = 10;
		$cf7     = new WPCF7_ContactForm( $form_id );
		$data    = array(
			'form-token' => 'wrong',
			'your-email' => 'user@example.com',
		);
		WPCF7_Submission::mock( $data );

		dz_cf7_anti_spam_guard( $cf7 );

		$this->assertTrue( $cf7->skip_mail, 'Submission with invalid token should be blocked' );
		$log = DZ_CF7_UPLOAD_DIR . 'cf7-spam-log.csv';
		$this->assertFileExists( $log );
		$this->assertStringContainsString( 'token_scaduto', dz_cf7_fs_get_contents( $log ) );
	}

	public function test_honeypot_blocks_submission() {
		$form_id = 11;
		$token   = hash( 'sha256', "form-$form_id::" . gmdate( 'YmdH' ) );
		$cf7     = new WPCF7_ContactForm( $form_id );
		$data    = array(
			'form-token' => $token,
			'spamcheck'  => 'bot',
			'your-email' => 'user@example.com',
		);
		WPCF7_Submission::mock( $data );

		dz_cf7_anti_spam_guard( $cf7 );

		$this->assertTrue( $cf7->skip_mail, 'Honeypot field should block submission' );
		$log = DZ_CF7_UPLOAD_DIR . 'cf7-spam-log.csv';
		$this->assertFileExists( $log );
		$this->assertStringContainsString( 'honeypot', dz_cf7_fs_get_contents( $log ) );
	}

        public function test_blacklist_blocks_email() {
                $blacklist = array(
                        'ips'       => array(),
                        'emails'    => array( 'bad@example.com' ),
                        'domains'   => array(),
                        'usernames' => array(),
                        'keywords'  => array(),
                );
                dz_cf7_fs_put_contents( DZ_CF7_UPLOAD_DIR . 'cf7-blacklist.json', wp_json_encode( $blacklist ) );

		$form_id = 12;
		$token   = hash( 'sha256', "form-$form_id::" . gmdate( 'YmdH' ) );
		$cf7     = new WPCF7_ContactForm( $form_id );
		$data    = array(
			'form-token' => $token,
			'your-email' => 'bad@example.com',
		);
		WPCF7_Submission::mock( $data );

		dz_cf7_anti_spam_guard( $cf7 );

		$this->assertTrue( $cf7->skip_mail, 'Blacklisted email should block submission' );
                $log = DZ_CF7_UPLOAD_DIR . 'cf7-spam-log.csv';
                $this->assertFileExists( $log );
                $this->assertStringContainsString( 'email', dz_cf7_fs_get_contents( $log ) );
        }

        public function test_blacklist_blocks_domain() {
                $blacklist = array(
                        'ips'       => array(),
                        'emails'    => array(),
                        'domains'   => array( 'spam.com' ),
                        'usernames' => array(),
                        'keywords'  => array(),
                );
                dz_cf7_fs_put_contents( DZ_CF7_UPLOAD_DIR . 'cf7-blacklist.json', wp_json_encode( $blacklist ) );

                $form_id = 13;
                $token   = hash( 'sha256', "form-$form_id::" . gmdate( 'YmdH' ) );
                $cf7     = new WPCF7_ContactForm( $form_id );
                $data    = array(
                        'form-token' => $token,
                        'your-email' => 'user@spam.com',
                );
                WPCF7_Submission::mock( $data );

                dz_cf7_anti_spam_guard( $cf7 );

                $this->assertTrue( $cf7->skip_mail, 'Blacklisted domain should block submission' );
        }

	public function test_flood_detection_limit() {
		$ip    = '9.9.9.9';
		$email = 'flood@example.com';

		$this->assertFalse( dz_cf7_check_flood( $ip, $email ), 'First attempt should pass' );
		$this->assertFalse( dz_cf7_check_flood( $ip, $email ), 'Second attempt should pass' );
		$this->assertTrue( dz_cf7_check_flood( $ip, $email ), 'Third attempt should be blocked' );
	}
}
