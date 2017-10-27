<?php
/**
 * Plugin Name: Login Designer
 * Plugin URI: https://logindesigner.com
 * Description: The easiest way to completly customize your WordPress login page. Create stunning login templates in seconds with the most beautiful and elegant login customizer WordPress plugin.
 * Author: Rich Tabor of ThemeBeans
 * Author URI: https://logindesigner.com
 * Version: @@pkg.version
 * Text Domain: @@pkg.textdomain
 * Domain Path: languages
 * Requires at least: 4.7
 * Tested up to: 4.9
 *
 * Login Designer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Login Designer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Login Designer. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 * @version   @@pkg.version
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer' ) ) :

	/**
	 * Main Login Designer Class.
	 *
	 * @since 1.0.0
	 */
	final class Login_Designer {
		/** Singleton *************************************************************/

		/**
		 * Login_Designer The one true Login_Designer
		 *
		 * @var string $instance
		 */
		private static $instance;

		/**
		 * Main Login_Designer Instance.
		 *
		 * Insures that only one instance of Login_Designer exists in memory at any one
		 * time. Also prevents needing to define globals all over the place.
		 *
		 * @since 1.0.0
		 * @static
		 * @staticvar array $instance
		 * @uses Login_Designer::setup_constants() Setup the constants needed.
		 * @uses Login_Designer::includes() Include the required files.
		 * @uses Login_Designer::load_textdomain() load the language files.
		 * @see LOGIN_DESIGNER()
		 * @return object|Login_Designer The one true Login_Designer
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Login_Designer ) ) {
				self::$instance = new Login_Designer;
				self::$instance->constants();
				self::$instance->actions();
				self::$instance->includes();
				self::$instance->load_textdomain();
			}

			return self::$instance;
		}

		/**
		 * Throw error on object clone.
		 *
		 * The whole idea of the singleton design pattern is that there is a single
		 * object therefore, we don't want the object to be cloned.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		public function __clone() {
			// Cloning instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', '@@textdomain' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			// Unserializing instances of the class is forbidden.
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', '@@textdomain' ), '1.0' );
		}

		/**
		 * Setup plugin constants.
		 *
		 * @access private
		 * @return void
		 */
		private function constants() {
			$this->define( 'LOGIN_DESIGNER_VERSION', '@@pkg.version' );
			$this->define( 'LOGIN_DESIGNER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			$this->define( 'LOGIN_DESIGNER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'LOGIN_DESIGNER_PLUGIN_FILE', __FILE__ );
			$this->define( 'LOGIN_DESIGNER_ABSPATH', dirname( __FILE__ ) . '/' );
			$this->define( 'LOGIN_DESIGNER_HAS_PRO', false );
		}

		/**
		 * Define constant if not already set.
		 *
		 * @param  string|string $name Name of the definition.
		 * @param  string|bool   $value Default value.
		 */
		private function define( $name, $value ) {
			if ( ! defined( $name ) ) {
				define( $name, $value );
			}
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @since  1.0.0
		 * @return void
		 */
		private function includes() {
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-customizer.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-customizer-output.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-customizer-scripts.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-frontend-settings.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-templates.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-theme-template.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/admin/admin-bar.php';

			if ( is_admin() ) {
				require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/admin/admin-action-links.php';
			}

			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/install.php';
		}

		/**
		 * Load the actions
		 *
		 * @return void
		 */
		public function actions() {
			add_action( 'init', array( $this, 'redirect_customizer' ) );
			add_action( 'wp_head', array( $this, 'version_in_header' ) );
			add_action( 'admin_menu', array( $this, 'options_page' ) );
		}

		/**
		 * Add the plugin version to the header.
		 *
		 * @access public
		 * @return void
		 */
		public function version_in_header() {
			echo '<meta name="generator" content="Login Designer ' . esc_attr( LOGIN_DESIGNER_VERSION ). '" />' . "\n";
		}

		/**
		 * Add a page under the "Apperance" menu, that links to the Customizer.
		 *
		 * @access public
		 * @return void
		 */
		public function options_page() {
			add_theme_page( esc_html__( 'Login Designer', '@@textdomain' ), esc_html__( 'Login', '@@textdomain' ), 'manage_options', 'login-designer', '__return_null' );
		}

		/**
		 * Hook to redirect the page for the Customizer.
		 *
		 * @access public
		 * @return void
		 */
		public function redirect_customizer() {
			if ( ! empty( $_GET['page'] ) ) { // Input var okay.
				if ( 'login-designer' === $_GET['page'] ) { // Input var okay.

					// Pull the Login Designer page from options.
					$page = get_permalink( $this->get_login_designer_page() );

					wp_safe_redirect( admin_url( '/customize.php?autofocus[panel]=login_designer&url=' . $page ) );
				}
			}
		}

		/**
		 * Pull the Login Designer page from options.
		 *
		 * @access public
		 */
		public function get_login_designer_page() {

			$admin_options 	= get_option( 'login_designer_admin', array() );
			$page 		= array_key_exists( 'login_designer_page', $admin_options ) ? get_post( $admin_options['login_designer_page'] ) : false;

			return $page;
		}

		/**
		 * Pull the Login Designer page from options.
		 *
		 * @access public
		 */
		public function has_pro() {

			if ( true === LOGIN_DESIGNER_HAS_PRO ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( '@@textdomain', false, dirname( plugin_basename( LOGIN_DESIGNER_PLUGIN_DIR ) ) . '/languages/' );
		}
	}

endif; // End if class_exists check.


/**
 * The main function for that returns Login_Designer
 *
 * The main function responsible for returning the one true Login_Designer
 * Instance to functions everywhere.
 *
 * Use this function like you would a global variable, except without needing
 * to declare the global.
 *
 * Example: <?php $login_designer = login_designer(); ?>
 *
 * @since 1.0.0
 * @return object|Login_Designer The one true Login_Designer Instance.
 */
function login_designer() {
	return Login_Designer::instance();
}

// Get Login_Designer Running.
login_designer();
