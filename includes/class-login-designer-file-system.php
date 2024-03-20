<?php
/**
 * File System Class
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Login_Designer_File_System' ) ) {
	/**
	 * Login Designer File System Class
	 */
	class Login_Designer_File_System {
		/**
		 * Instance.
		 *
		 * @var Login_Designer_File_System $instance Instance.
		 */
		private static $instance;
		/**
		 * WordPress Filesystem.
		 *
		 * @var WP_Filesystem_Direct $wp_filesystem WordPress Filesystem.
		 */
		private $wp_filesystem;

		/**
		 * Filesystem.
		 *
		 * @var boolean $filesystem Filesystem.
		 */
		private $filesystem;

		/**
		 * Base directory.
		 *
		 * @var string $base_dir Base directory.
		 */
		private $base_dir;

		/**
		 * Upload directory.
		 *
		 * @var array $upload_dir Upload directory.
		 */
		private $upload_dir;

		/**
		 * File System Constructor.
		 */
		private function __construct() {
			if ( $this->filesystem_connect() ) {
				$this->upload_dir = wp_upload_dir();

				$this->wp_filesystem_create_directory_base();
			}
		}

		/**
		 * Get WP_Filesystem object.
		 *
		 * @return false|WP_Filesystem_Direct
		 */
		public function get_wp_filesystem() {
			if ( ! $this->filesystem ) {
				return false;
			}

			return $this->wp_filesystem;
		}

		/**
		 * File put content
		 *
		 * @param string $file File path.
		 * @param string $content File content.
		 * @param bool   $mode File mode.
		 * @param bool   $base_directory is base directory.
		 *
		 * @return bool|array
		 */
		public function put_content( $file, $content = '', $mode = false, $base_directory = false ) {
			$old_file = $file;
			if ( $base_directory ) {
				$file = $this->base_dir . '/' . $file;
			}

			$return = $this->wp_filesystem->put_contents( $file, $content, $mode );
			if ( ! $return ) {
				return false;
			}

			return array_map(
				function( $base_directory ) use ( $old_file ) {
					return $base_directory . $old_file;
				},
				$this->get_base_directory()
			);
		}

		/**
		 * File get content
		 *
		 * @param string $file File path.
		 * @param bool   $base_directory is base directory.
		 *
		 * @return bool|string
		 */
		public function get_content( $file, $base_directory = false ) {
			if ( $base_directory ) {
				$file = $this->base_dir . '/' . $file;
			}

			return $this->wp_filesystem->get_contents( $file );
		}

		/**
		 * File exists
		 *
		 * @return array
		 */
		public function get_base_directory() {
			$upload_dir = $this->upload_dir;

			$login_designer_upload_dir = array();

			$login_designer_upload_dir['basedir'] = $upload_dir['basedir'] . '/login-designer/';
			$login_designer_upload_dir['baseurl'] = $upload_dir['baseurl'] . '/login-designer/';

			return $login_designer_upload_dir;
		}

		/**
		 * Connect to the filesystem.
		 *
		 * @return bool
		 */
		private function filesystem_connect() {
			if ( ! function_exists( 'request_filesystem_credentials' ) ) {
				require_once ABSPATH . 'wp-admin/includes/file.php';
			}

			$credentials      = request_filesystem_credentials( site_url() . '/wp-admin/', '', false, false, array() );
			$this->filesystem = WP_Filesystem( $credentials );

			if ( ! $this->filesystem ) {
				return false;
			}

			global $wp_filesystem;
			$this->wp_filesystem = $wp_filesystem;

			return true;
		}

		/**
		 * Create the base directory.
		 */
		private function wp_filesystem_create_directory_base() {
			$upload_dir     = $this->upload_dir;
			$base_dir       = $upload_dir['basedir'] . '/login-designer';
			$this->base_dir = $base_dir;

			if ( ! $this->wp_filesystem->is_dir( $base_dir ) ) {
				$this->wp_filesystem->mkdir( $base_dir );
			}
		}

		/**
		 * Create directory.
		 *
		 * @param string $dirname Directory name.
		 *
		 * @return $this
		 */
		public function mkdir( $dirname ) {

			if ( ! $this->wp_filesystem->is_dir( $this->get_base_directory()['basedir'] . $dirname ) ) {
				$this->wp_filesystem->mkdir( $this->get_base_directory()['basedir'] . $dirname );
			}

			return $this;
		}

		/**
		 * Get instance.
		 *
		 * @return Login_Designer_File_System
		 */
		public static function get_instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new Login_Designer_File_System();
			}

			return self::$instance;
		}
	}
}
