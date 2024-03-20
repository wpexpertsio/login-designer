<?php
/**
 * Plugin Name:     Login Designer
 * Plugin URI:      https://logindesigner.com
 * Description:     The easiest way to completely customize your WordPress login page. Create stunning login templates in seconds with the most beautiful and elegant login customizer WordPress plugin.
 * Author:          LoginDesigner
 * Author URI:      https://logindesigner.com/
 * Text Domain:     login-designer
 * Domain Path:     /languages
 * Version:         1.6.4
 *
 * Login Designer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * any later version.
 *
 * You should have received a copy of the GNU General Public License
 * along with Login Designer. If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'LOGIN_DESIGNER_VERSION', '1.6.4' );
define( 'LOGIN_DESIGNER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LOGIN_DESIGNER_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'LOGIN_DESIGNER_PLUGIN_FILE', __FILE__ );
define( 'LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR', plugin_dir_path( __FILE__ ) . 'includes/controls/' );
define( 'LOGIN_DESIGNER_CUSTOMIZE_SECTIONS_DIR', plugin_dir_path( __FILE__ ) . 'includes/sections/' );
define( 'LOGIN_DESIGNER_DEBUG', true );
define( 'LOGIN_DESIGNER_HAS_PRO', false );
define( 'LOGIN_DESIGNER_STORE_URL', 'https://logindesigner.com/' );

require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/freemius.php';

if ( ! class_exists( 'Login_Designer' ) ) :

	/**
	 * Main Login Designer Class.
	 *
	 * @since 1.0.0
	 */
	final class Login_Designer {

		/**
		 * This plugin's instance.
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
		 * @return object|Login_Designer The one true Login_Designer
		 */
		public static function instance() {
			if ( ! isset( self::$instance ) && ! ( self::$instance instanceof Login_Designer ) ) {
				self::$instance = new Login_Designer();
				self::$instance->init();
				self::$instance->asset_suffix();
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
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'login-designer' ), '1.0' );
		}

		/**
		 * Disable unserializing of the class.
		 *
		 * @since 1.0.0
		 * @access protected
		 * @return void
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, esc_html__( 'Something went wrong.', 'login-designer' ), '1.0' );
		}

		/**
		 * Load the actions
		 *
		 * @return void
		 */
		public function init() {
			add_action( 'admin_init', array( $this, 'check_login_designer_page' ) );
			add_action( 'admin_init', array( $this, 'redirect_customizer' ) );
			add_action( 'admin_init', array( $this, 'redirect_edit_page' ) );
			add_action( 'admin_menu', array( $this, 'options_page' ) );
			add_action( 'admin_bar_menu', array( $this, 'admin_bar_link' ), 999 );
			add_filter( 'plugin_row_meta', array( $this, 'plugin_row_meta' ), 10, 2 );
			add_filter( 'plugin_row_meta', array( $this, 'extension_plugin_row_meta' ), 10, 2 );
			add_filter( 'plugin_action_links_' . plugin_basename( LOGIN_DESIGNER_PLUGIN_DIR . 'login-designer.php' ), array( $this, 'plugin_action_links' ) );
		}

		/**
		 * Include required files.
		 *
		 * @access private
		 * @since  1.0.0
		 * @return void
		 */
		private function includes() {
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/functions.php';

			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-file-system.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-fonts-downloader.php';

			if ( is_admin() ) {
				require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/admin/class-login-designer-notices.php';
				require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/admin/class-login-designer-feedback.php';
				require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/migration.php';
			}

			if ( in_array( 'password-protected/password-protected.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
				require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-password-protected.php';
			}

			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-customizer.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-features.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-customizer-output.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-customizer-scripts.php';
			// require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-intro.php';.
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-brand.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-frontend-settings.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-templates.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/class-login-designer-theme-template.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/filters.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/install.php';
		}

		/**
		 * Is this a Pro Version of Login Designer?.
		 *
		 * @access public
		 */
		public function has_pro() {

			// If there's no pro mode defined, return false.
			if ( ! defined( 'LOGIN_DESIGNER_HAS_PRO' ) ) {
				return false;
			}

			if ( true === LOGIN_DESIGNER_HAS_PRO ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Change the plugin's minified or src file name, based on debug mode.
		 *
		 * @since 1.1.3
		 */
		public function asset_suffix() {

			// If there's no debug mode, use the minified assets supplied.
			if ( ! defined( 'LOGIN_DESIGNER_DEBUG' ) ) {
				define( 'LOGIN_DESIGNER_ASSET_SUFFIX', '.min' );
				return;
			}

			if ( true === LOGIN_DESIGNER_DEBUG ) {
				define( 'LOGIN_DESIGNER_ASSET_SUFFIX', null );
			} else {
				define( 'LOGIN_DESIGNER_ASSET_SUFFIX', '.min' );
			}
		}

		/**
		 * If debug is on, serve unminified source assets.
		 *
		 * @since 1.1.3
		 * @param string $type The type of resource.
		 * @param string $directory Any extra directories needed.
		 */
		public function asset_source( $type = 'js', $directory = null ) {

			// If there's no debug mode, use the minified sources.
			if ( ! defined( 'LOGIN_DESIGNER_DEBUG' ) ) {
				return LOGIN_DESIGNER_PLUGIN_URL . 'assets/' . $type . '/' . $directory;
			}

			if ( true === LOGIN_DESIGNER_DEBUG ) {
				return LOGIN_DESIGNER_PLUGIN_URL . 'assets/' . $type . '/src/' . $directory;
			} else {
				return LOGIN_DESIGNER_PLUGIN_URL . 'assets/' . $type . '/' . $directory;
			}
		}

		/**
		 * Add a page under the "Apperance" menu, that links to the Customizer.
		 *
		 * @access public
		 * @return void
		 */
		public function options_page() {
			add_theme_page( esc_html__( 'Login Designer', 'login-designer' ), esc_html__( 'Login Designer', 'login-designer' ), 'manage_options', 'login-designer', array( $this, 'login_designer_page' ), 4 );
			if ( ! class_exists( 'Login_Designer_Pro' ) ) {
				add_theme_page( __( 'Get Pro', 'login-designer' ), __( '↳ ⭐ Get Pro', 'login-designer' ), 'manage_options', 'login-designer-get-pro', '__return_null', 5 );
			}

			if ( class_exists( 'Login_Designer_Password_Protected' ) ) {
				add_theme_page( esc_html__( 'Password Protected', 'login-designer' ), esc_html__( 'Password Protected', 'login-designer' ), 'manage_options', 'password-protected-designer', '__return_null' );
			}

		}

		/**
		 * Get the Login Designer page.
		 */
		public function login_designer_page() {

			$button_url = add_query_arg(
				array(
					'autofocus[section]' => 'login_designer__section--templates',
					'url'                => get_permalink( $this->get_login_designer_page() ),
					'return'             => admin_url( 'index.php' ),
				),
				admin_url( 'customize.php' )
			);
			echo '<h3>'
				. esc_attr__( 'If you have not been redirected automatically then click this button' ) .
			'	<a href="' . esc_url( $button_url ) . '" class="button button-primary">' . esc_attr__( 'Login Designer', 'login-designer' ) . '</a>
			</h3>';
		}

		/**
		 * Add a link to the "Customizer" admin bar item.
		 *
		 * @access public
		 * @param WP_Admin_Bar $admin_bar WP_Admin_Bar instance.
		 * @return void
		 */
		public function admin_bar_link( &$admin_bar ) {

			// Pull the Login Designer page from options.
			$page = get_permalink( $this->get_login_designer_page() );

			// Generate the url.
			$url = add_query_arg(
				array(
					'autofocus[section]' => 'login_designer__section--templates',
					'url'                => $page,
					'return'             => admin_url( 'index.php' ),
				),
				admin_url( 'customize.php' )
			);

			$admin_bar->add_menu(
				array(
					'id'     => 'my-sub-item',
					'parent' => 'customize',
					'title'  => esc_html__( 'Login Designer', 'login-designer' ),
					'href'   => esc_url( $url ),
				)
			);

			if ( in_array( 'password-protected/password-protected.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
				$admin_bar->add_menu(
					array(
						'id'     => 'password-protected-item',
						'parent' => 'customize',
						'title'  => esc_html__( 'Password Protected', 'login-designer' ),
						'href'   => add_query_arg(
							array(
								'autofocus[panel]' => 'password_protected',
								'url'              => get_permalink( Login_Designer_Password_Protected::get_password_protected_id() ),
								'return'           => admin_url( 'index.php' ),
							),
							admin_url( 'customize.php' )
						),
					)
				);
			}
		}

		/**
		 * Hook to redirect the page for the Customizer.
		 *
		 * @access public
		 * @return void
		 */
		public function redirect_customizer() {
			// phpcs:disable  WordPress.Security.NonceVerification
			if ( isset( $_GET['page'] ) && 'login-designer' === $_GET['page'] ) {

				// Pull the Login Designer page from options.
				$page = get_permalink( $this->get_login_designer_page() );

				// Generate the redirect url.
				$url = add_query_arg(
					array(
						'autofocus[section]' => 'login_designer__section--templates',
						'url'                => rawurlencode( $page ),
						'return'             => admin_url( 'index.php' ),
					),
					admin_url( 'customize.php' )
				);

				if ( ! ld_fs()->is_activation_mode() ) {
					wp_safe_redirect( $url );
				}
			}

			if ( isset( $_GET['page'] ) && 'password-protected-designer' === $_GET['page'] ) {
				if ( class_exists( 'Login_Designer_Password_Protected' ) ) {
					$page = get_permalink( Login_Designer_Password_Protected::get_password_protected_id() );
					$url  = add_query_arg(
						array(
							'autofocus[panel]' => 'password_protected',
							'url'              => rawurlencode( $page ),
							'return'           => admin_url( 'index.php' ),
						),
						admin_url( 'customize.php' )
					);
					wp_safe_redirect( $url );
				}
			}

			if ( isset( $_GET['page'] ) && 'login-designer-get-pro' === $_GET['page'] ) {
				$purchase_url = 'https://logindesigner.com/pricing/?utm_source=plugin&utm_medium=submenu';
				wp_redirect( $purchase_url );
				exit;
			}
			// phpcs:enable  WordPress.Security.NonceVerification
		}

		/**
		 * Redirect the editing function of the Login Designer page.
		 *
		 * @access public
		 * @return void
		 */
		public function redirect_edit_page() {
			global $pagenow;

			// Pull the Login Designer page from options.
			$page = $this->get_login_designer_page();

			if ( ! $page ) {
				return;
			}

			$page_url = get_permalink( $page );
			$page_id  = get_post( $page );
			$page_id  = $page->ID;

			// Generate the redirect url.
			$url = add_query_arg(
				array(
					'autofocus[section]' => 'login_designer__section--templates',
					'url'                => rawurlencode( $page_url ),
					'return'             => admin_url( 'index.php' ),
				),
				admin_url( 'customize.php' )
			);

			// phpcs:disable  WordPress.Security.NonceVerification
			if ( 'post.php' === $pagenow && isset( $_GET['post'] ) ) {
				if ( intval( $page_id ) === intval( $_GET['post'] ) ) {
					wp_safe_redirect( $url );
				}

				if ( in_array( 'password-protected/password-protected.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
					$page_id = Login_Designer_Password_Protected::get_password_protected_id();
					if ( intval( $page_id ) === intval( $_GET['post'] ) ) {
						$url = add_query_arg(
							array(
								'autofocus[panel]' => 'password_protected',
								'url'              => rawurlencode( get_permalink( $page_id ) ),
								'return'           => admin_url( 'index.php' ),
							),
							admin_url( 'customize.php' )
						);
						wp_safe_redirect( $url );
					}
				}
			}
			// phpcs:enable  WordPress.Security.NonceVerification
		}

		/**
		 * Double-check that we have a page assigned.
		 *
		 * @access public
		 * @return void
		 */
		public function check_login_designer_page() {

			// Retrieve the Login Designer admin page option, that was created during the activation process.
			$option = $this->get_login_designer_page();

			// Retrieve the status of the page, if the option is available.
			if ( $option ) {
				$page   = get_post( $option );
				$status = $page->post_status;
			} else {
				$status = null;
			}

			// Check the status of the page. Let's fix it, if the page is missing or in the trash.
			if ( empty( $status ) || 'trash' === $status ) {
				$this->fix_login_designer_page();
			}
		}

		/**
		 * Recreate the Login Designer page if one is not available.
		 *
		 * @return void
		 */
		public function fix_login_designer_page() {

			// Set up options.
			$options = array();

			// Pull options from WP.
			$admin_options = get_option( 'login_designer_settings', array() );

			// Array of allowed HTML in the page content.
			$allowed_html_array = array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			);

			/* translators: Name of this plugin */
			$post_content = sprintf( wp_kses( __( '<p>This page is used by <a href="%1$s">%2$s</a> to preview the login forms in the Customizer. Please don\'t delete this page. Thanks!</p>', 'login-designer' ), $allowed_html_array ), 'https://logindesigner.com', 'Login Designer' );

			// Create the page.
			$page = wp_insert_post(
				array(
					'post_title'     => 'Login Designer',
					'post_content'   => $post_content,
					'post_status'    => 'publish',
					'post_author'    => 1,
					'post_type'      => 'page',
					'comment_status' => 'closed',
				)
			);

			$options['login_designer_page'] = $page;

			$page = isset( $page ) ? $page : $admin_options['login_designer_page'];

			$merged_options = array_merge( $admin_options, $options );
			$admin_options  = $merged_options;

			update_option( 'login_designer_settings', $admin_options );

			// Assign the Login Designer template.
			login_designer_attach_template_to_page( $page, 'template-login-designer.php' );
		}

		/**
		 * Pull the Login Designer page from options.
		 *
		 * @access public
		 */
		public function get_login_designer_page() {
			$admin_options = get_option( 'login_designer_settings', array() );
			$page          = array_key_exists( 'login_designer_page', $admin_options ) ? get_post( $admin_options['login_designer_page'] ) : false;

			return $page;
		}

		/**
		 * Returns the URL to upgrade the plugin to the pro version.
		 * Can be overridden by theme developers to use their affiliate
		 * link using the login_designer_affiliate_id filter.
		 *
		 * @since  1.0.0
		 * @return string
		 */
		public function get_affiliate_id() {
			$id = array( 'ref' => apply_filters( 'login_designer_affiliate_id', null ) );

			return $id;
		}

		/**
		 * Returns a URL that points to the Beaver Builder store.
		 *
		 * @since 1.0.0
		 * @param string|string $path A URL path to append to the store URL.
		 * @param array|array   $params An array of key/value params to add to the query string.
		 * @return string
		 */
		public function get_store_url( $path = '', $params = array() ) {
			$id = $this->get_affiliate_id();

			$params = array_merge( $params, $id );

			$url = trailingslashit( LOGIN_DESIGNER_STORE_URL . $path ) . '?' . http_build_query( $params, '', '&#038;' );

			return $url;
		}

		/**
		 * Add links to the settings page to the plugin.
		 *
		 * @param       array|array $actions The plugin.
		 * @return      array
		 */
		public function plugin_action_links( $actions ) {

			// Add the Settings link.
			$settings = array( 'settings' => sprintf( '<a href="%s">%s</a>', admin_url( 'themes.php?page=login-designer' ), esc_html__( 'Settings', 'login-designer' ) ) );

			// If there's no pro version, just return the settings link.
			if ( ! $this->has_pro() ) {
				return array_merge(
					$settings,
					$actions
				);
			}

			// Check if a license is valid. If it is, show the support link and remove the upgrade link.
			$license = new Login_Designer_License_Handler();

			if ( $license->is_valid_license() && $this->has_pro() ) {
				$title = esc_html__( 'Support', 'login-designer' );

				$url = Login_Designer()->get_store_url(
					'support',
					array(
						'utm_medium'   => 'login-designer-pro',
						'utm_source'   => 'plugins-page',
						'utm_campaign' => 'plugins-action-link',
						'utm_content'  => 'support',
					)
				);
			} else {
				$title = esc_html__( 'Pro', 'login-designer' );

				$url = Login_Designer()->get_store_url(
					'support',
					array(
						'utm_medium'   => 'login-designer-lite',
						'utm_source'   => 'plugins-page',
						'utm_campaign' => 'plugins-action-link',
						'utm_content'  => 'pro',
					)
				);
			}

			// Merge and display each link.
			return array_merge(
				$settings,
				array( 'url' => sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( $url ), $title ) ),
				$actions
			);
		}

		/**
		 * Plugin row meta links
		 *
		 * @param array|array   $input already defined meta links.
		 * @param string|string $file plugin file path and name being processed.
		 * @return array $input
		 */
		public function plugin_row_meta( $input, $file ) {

			// Return early, if a pro version is not available.
			if ( ! Login_Designer()->has_pro() ) {
				return $input;
			}

			if ( 'login-designer/login-designer.php' !== $file ) {
				return $input;
			}

			$url = Login_Designer()->get_store_url(
				'extensions',
				array(
					'utm_medium'   => 'login-designer-lite',
					'utm_source'   => 'plugins-page',
					'utm_campaign' => 'plugins-row',
					'utm_content'  => 'extensions',
				)
			);

			$links = array(
				'<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html__( 'Extensions', 'login-designer' ) . '</a>',
			);

			$input = array_merge( $input, $links );

			return $input;
		}

		/**
		 * Plugin row meta links for extensions.
		 *
		 * @param array|array   $input already defined meta links.
		 * @param string|string $file plugin file path and name being processed.
		 * @return array $input
		 */
		public function extension_plugin_row_meta( $input, $file ) {

			// Return early, if a pro version is not available.
			if ( ! Login_Designer()->has_pro() ) {
				return $input;
			}

			// Return early, if the file name does not contain "login-designer-", which is standard for extenstions.
			if ( strpos( $file, 'login-designer-' ) === false ) {
				return $input;
			}

			// Get the plugin name, so we can view the analytics properly.
			$plugin_name = substr( $file, 0, strpos( $file, '/' ) );

			$url = Login_Designer()->get_store_url(
				'extensions',
				array(
					'utm_medium'   => $plugin_name,
					'utm_source'   => 'plugins-page',
					'utm_campaign' => 'plugins-row',
					'utm_content'  => 'extensions',
				)
			);

			$links = array(
				'<a href="' . esc_url( $url ) . '" target="_blank">' . esc_html__( 'Extensions', 'login-designer' ) . '</a>',
			);

			$input = array_merge( $input, $links );

			return $input;
		}

		/**
		 * Loads the plugin language files.
		 *
		 * @access public
		 * @since 1.0.0
		 * @return void
		 */
		public function load_textdomain() {
			load_plugin_textdomain( 'login-designer', false, dirname( plugin_basename( LOGIN_DESIGNER_PLUGIN_DIR ) ) . '/languages/' );
		}
	}

endif;

/**
 * Returns the main instance of Login Designer.
 *
 * @return Login Designer
 */
function login_designer() {
	return Login_Designer::instance();
}

// Get Login_Designer Running.
login_designer();
