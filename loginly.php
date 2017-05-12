<?php
/**
 * Plugin Name: Loginly
 * Plugin URI: https://loginly.xyz
 * Description: The easiest way to customize your WordPress login.
 * Author: Loginly
 * Author URI: https://loginly.xyz
 * Version: 1.0.0
 * Text Domain: loginly
 * Domain Path: languages
 *
 * Loginly is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Loginly is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Loginly. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Loginly' ) ) :

	/**
	 * Main Loginly Class.
	 *
	 * @since 1.4
	 */
	final class Loginly {
		/** Singleton *************************************************************/

		/**
		 * Loginly The one true Loginly
		 *
		 * @var string $instance
		 */
		private static $instance;

		/**
		 * Main Loginly Instance.
		 *
		 * Insures that only one instance of Loginly exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.4
		 * @static
		 * @staticvar array $instance
		 * @uses Loginly::setup_constants() Setup the constants needed.
		 * @uses Loginly::includes() Include the required files.
		 * @uses Loginly::load_textdomain() load the language files.
		 * @see LOGINLY()
		 * @return object|Loginly The one true Loginly
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Loginly ) ) {
				self::$instance = new Loginly;
				self::$instance->setup_constants();
				self::$instance->actions();
				self::$instance->includes();
			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.6
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', '@@textdomain' ), '1.6' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.6
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', '@@textdomain' ), '1.6' );
		}

		/**
		 * Setup plugin constants.
		 *
		 * @access private
		 * @since 1.4
		 * @return void
		 */
		private function setup_constants() {

			// Plugin version.
			if ( ! defined( 'LOGINLY_VERSION' ) ) {
				define( 'LOGINLY_VERSION', '1.0.0' );
			}

			// Plugin Folder Path.
			if ( ! defined( 'LOGINLY_PLUGIN_DIR' ) ) {
				define( 'LOGINLY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			}

			// Plugin Folder URL.
			if ( ! defined( 'LOGINLY_PLUGIN_URL' ) ) {
				define( 'LOGINLY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			}

			// Plugin Root File.
			if ( ! defined( 'LOGINLY_PLUGIN_FILE' ) ) {
				define( 'LOGINLY_PLUGIN_FILE', __FILE__ );
			}
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @since 1.4
		 * @return void
		 */
		private function includes() {

			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-scripts.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-frontend.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-frontend-css.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-esc-login.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customizer/customizer.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/misc-functions.php';

			if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
				require_once LOGINLY_PLUGIN_DIR . 'includes/admin/admin-footer.php';
				require_once LOGINLY_PLUGIN_DIR . 'includes/admin/admin-action-links.php';
			}
		}

		/**
		 * Load the actions
		 *
		 * @since  1.0.0
		 * @return void
		 */
		public function actions() {
			add_action( 'init', array( $this, 'load_textdomain' ), -1 );
			add_action( 'init', array( $this, 'redirect_to_custom_page' ) );
			add_action( 'wp_head', array( $this, 'version_in_header' ) );
			add_action( 'admin_menu', array( $this, 'register_options_page' ) );
			add_action( 'customize_register', array( $this, 'load_customizer_controls' ), 11 );
		}

		/**
		 * Register Customizer Controls.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function load_customizer_controls() {
			require_once LOGINLY_PLUGIN_DIR . 'includes/customizer/class-loginly-range-control.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customizer/class-loginly-templates-control.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customizer/class-loginly-background-control.php';
		}

		/**
		 * Add the plugin version to the header.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function version_in_header() {
			echo '<meta name="generator" content="Loginly ' . esc_html( LOGINLY_VERSION ). '" />' . "\n";
		}

		/**
		 * Add a page under the "Apperance" menu, that links to the Customizer.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
	    public function register_options_page() {
	    	add_theme_page( esc_html__( 'Loginly', '@@textdomain' ), esc_html__( 'Loginly', '@@textdomain' ), 'manage_options', 'loginly_customizer', '__return_null' );
	    }

		/**
		 * Hook to Redirect Page for Customize.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function redirect_to_custom_page() {
			if ( ! empty( $_GET['page'] ) ) {
				if ( ( 'loginly_customizer' == $_GET['page'] ) ) {
					wp_redirect( admin_url( '/customize.php?url='.wp_login_url( '/' ) ) );
				}
			}
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access public
		 * @since 1.4
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'loginly', false, dirname( plugin_basename( LOGINLY_PLUGIN_DIR ) ) . '/languages/' );
		}
	}

endif; // End if class_exists check.


/**
 * The main function for that returns Loginly
 *
 * The main function responsible for returning the one true Loginly
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $loginly = loginly(); ?>
 *
 * @since 1.4
 * @return object|Loginly The one true Loginly Instance.
 */
function loginly() {
	return Loginly::instance();
}

// Get Loginly Running.
loginly();