<?php
/**
 * Plugin Name: Loginly
 * Plugin URI: https://loginlywp.com
 * Description: @@pkg.description
 * Author: @@pkg.author
 * Author URI: https://loginlywp.com
 * Version: @@pkg.version
 * Text Domain: @@pkg.textdomain
 * Domain Path: languages
 * Requires at least: 4.7
 * Tested up to: 4.9
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
 * @author    @@pkg.author
 * @license   @@pkg.license
 * @version   @@pkg.version
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Loginly' ) ) :

	/**
	 * Main Loginly Class.
	 *
	 * @since 1.0.0
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
		 * @since 1.0.0
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
			$this->define( 'LOGINLY_VERSION', '@@pkg.version' );
			$this->define( 'LOGINLY_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
			$this->define( 'LOGINLY_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
			$this->define( 'LOGINLY_PLUGIN_FILE', __FILE__ );
			$this->define( 'LOGINLY_ABSPATH', dirname( __FILE__ ) . '/' );
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
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-customizer.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-customizer-css.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-customizer-scripts.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-frontend-settings.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-templates.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/class-loginly-esc-login.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/admin/admin-bar.php';

			if ( is_admin() ) {
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
			add_action( 'init', array( $this, 'redirect_customizer' ) );
			add_action( 'wp_head', array( $this, 'version_in_header' ) );
			add_action( 'admin_menu', array( $this, 'options_page' ) );
		}

		/**
		 * Add the plugin version to the header.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function version_in_header() {
			echo '<meta name="generator" content="Loginly ' . esc_attr( LOGINLY_VERSION ). '" />' . "\n";
		}

		/**
		 * Add a page under the "Apperance" menu, that links to the Customizer.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function options_page() {
			add_theme_page( esc_html__( 'Loginly', '@@textdomain' ), esc_html__( 'Loginly', '@@textdomain' ), 'manage_options', 'loginly_customizer', '__return_null' );
		}

		/**
		 * Hook to redirect the page for the Customizer.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function redirect_customizer() {
			if ( ! empty( $_GET['page'] ) ) { // Input var okay.
				if ( 'loginly_customizer' === $_GET['page'] ) { // Input var okay.
					wp_redirect( admin_url( '/customize.php?autofocus[panel]=loginly__panel&url='.home_url( '/loginly' ) ) );
				}
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
			load_plugin_textdomain( '@@textdomain', false, dirname( plugin_basename( LOGINLY_PLUGIN_DIR ) ) . '/languages/' );
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
 * @since 1.0.0
 * @return object|Loginly The one true Loginly Instance.
 */
function loginly() {
	return Loginly::instance();
}

// Get Loginly Running.
loginly();
