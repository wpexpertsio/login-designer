<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Customizer_Scripts' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Customizer_Scripts {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'customize_controls_print_styles', array( $this, 'control_styles' ), 99 );
			add_action( 'customize_preview_init', array( $this, 'customize_preview' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'customize_styles' ), 99 );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'custom_controls' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'localization' ), 99 );
			add_action( 'wp_footer', array( $this, 'export_preview_data' ), 1000 );
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function control_styles() {

			// Define where the asset is loaded from.
			$dir = Login_Designer()->asset_source( 'css' );

			wp_enqueue_style( 'login-designer-customize-controls', $dir . 'login-designer-customize-controls' . LOGIN_DESIGNER_ASSET_SUFFIX . '.css', null, LOGIN_DESIGNER_VERSION );
			wp_enqueue_style( 'login-designer-custom-section-styles', LOGIN_DESIGNER_PLUGIN_URL . 'assets/css/sections/login-designer-section.css', array(), LOGIN_DESIGNER_VERSION, 'all' );
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function customize_styles() {
			if ( ! is_customize_preview() ) {
				return;
			}

			// Define where the asset is loaded from.
			$dir = Login_Designer()->asset_source( 'css' );

			wp_enqueue_style( 'login-designer-customize-preview', $dir . 'login-designer-customize-preview' . LOGIN_DESIGNER_ASSET_SUFFIX . '.css', LOGIN_DESIGNER_VERSION, 'all' );
			if ( in_array( 'password-protected/password-protected.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
				wp_enqueue_style( 'password-protected-customize-preview', $dir . 'password-protected-customize-preview' . LOGIN_DESIGNER_ASSET_SUFFIX . '.css', LOGIN_DESIGNER_VERSION, 'all' );
			}
			wp_enqueue_style( 'login-designer-customize-ripple-effects', $dir . 'login-designer-ripple-effects' . LOGIN_DESIGNER_ASSET_SUFFIX . '.css', LOGIN_DESIGNER_VERSION, 'all' );

			wp_enqueue_script( 'login-designer-customize-ripple-effects', LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/src/login-designer-ripple-effects.js', array( 'jquery' ), LOGIN_DESIGNER_VERSION, true );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_preview() {

			// Define where the asset is loaded from.
			$dir = Login_Designer()->asset_source( 'js' );

			wp_enqueue_script( 'login-designer-customize-live', $dir . 'login-designer-customize-live' . LOGIN_DESIGNER_ASSET_SUFFIX . '.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );
			wp_enqueue_script( 'login-designer-customize-preview', $dir . 'login-designer-customize-preview' . LOGIN_DESIGNER_ASSET_SUFFIX . '.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );

			// Pull the Login Designer page from options.
			$page = Login_Designer()->get_login_designer_page();

			// Look for extension backgrounds.
			$customizer = new Login_Designer_Customizer_Output();

			// Localization.
			$localize = array(
				'admin_url'             => admin_url(),
				'ajax_url'              => admin_url( 'admin-ajax.php' ),
				'plugins_url'           => plugins_url(),
				'plugin_url'            => LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/',
				'login_designer_page'   => get_permalink( $page ),
				'font_url'              => esc_url_raw( 'https://fonts.googleapis.com/css' ),
				'font_subset'           => '&latin,latin-ext',
				'extension_backgrounds' => $customizer->extension_backgrounds(),
			);

			if ( in_array( 'password-protected/password-protected.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
				$localize['password_protected_page'] = get_permalink( Login_Designer_Password_Protected::get_password_protected_id() );
				wp_enqueue_script( 'password-protected-customize-live', $dir . 'password-protected-customize-live' . LOGIN_DESIGNER_ASSET_SUFFIX . '.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );
				wp_enqueue_script( 'password-protected-customize-preview', $dir . 'password-protected-customize-preview' . LOGIN_DESIGNER_ASSET_SUFFIX . '.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );
				wp_localize_script( 'password-protected-customize-preview', 'password_protected_script', $localize );
			}

			$localize = apply_filters( 'login_designer_customize_preview_localization', $localize );

			wp_localize_script( 'login-designer-customize-preview', 'login_designer_script', $localize );

			$localization = array(
				'label_hidden' => false,
			);
			if ( isset( get_option( 'login_designer' )['remember_hide'] ) && get_option( 'login_designer' )['remember_hide'] ) {
				$localization['label_hidden'] = true;
			}
			wp_localize_script( 'login-designer-customize-live', 'login_designer_customize_live', $localization );
		}

		/**
		 * Add export_preview_data() core function, as its missing on the login page within the Customizer.
		 */
		public function export_preview_data() {
			if ( ! is_customize_preview() ) {
				return;
			}

			echo '<script>var _customizePartialRefreshExports = ""</script>';
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_controls() {

			// Define where the asset is loaded from.
			$dir = Login_Designer()->asset_source( 'js' );

			wp_enqueue_script( 'login-designer-customize-controls', $dir . 'login-designer-customize-controls' . LOGIN_DESIGNER_ASSET_SUFFIX . '.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
			wp_enqueue_script( 'login-designer-customize-events', $dir . 'login-designer-customize-events' . LOGIN_DESIGNER_ASSET_SUFFIX . '.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );

			// Pull the Login Designer page from options.
			$page = Login_Designer()->get_login_designer_page();

			// Customizer output.
			$customizer = new Login_Designer_Customizer_Output();

			// Localization.
			$localize = array(
				'plugin_url'          => LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/',
				'login_designer_page' => get_permalink( $page ),
				'extension_bg_colors' => $customizer->extension_colors(),
			);

			if ( in_array( 'password-protected/password-protected.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
				$localize['password_protected_page'] = get_permalink( Login_Designer_Password_Protected::get_password_protected_id() );
				wp_enqueue_script( 'password-protected-customize-controls', $dir . 'password-protected-customize-controls' . LOGIN_DESIGNER_ASSET_SUFFIX . '.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
				wp_enqueue_script( 'password-protected-customize-events', $dir . 'password-protected-customize-events' . LOGIN_DESIGNER_ASSET_SUFFIX . '.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
				wp_localize_script( 'password-protected-customize-controls', 'password_protected_controls', $localize );
			}

			$localize = apply_filters( 'login_designer_control_localization', $localize );

			$localize['my_cb'] = function( $t, $x ) use ( $localize ) {
				return $localize;
			};

			wp_localize_script( 'login-designer-customize-controls', 'login_designer_controls', $localize );
		}

		/**
		 * Enqueues control scripts for custom controls.
		 *
		 * If LOGIN_DESIGNER_DEBUG is active, pull each control's scripts for their own files instead.
		 */
		public function custom_controls() {

			// Use this only if LOGIN_DESIGNER_DEBUG is not active.
			// If it is active, we're loading the individual controls' assets from within each controls' class.
			if ( defined( 'LOGIN_DESIGNER_DEBUG' ) && true === LOGIN_DESIGNER_DEBUG ) {
				return;
			}

			// Define where the asset is loaded from.
			$dir = Login_Designer()->asset_source( 'js' );

			// Enqueue the asset. Note that there is no minified version of this singular asset.
			wp_enqueue_script( 'login-designer-customize-custom-controls', $dir . 'login-designer-customize-custom-controls.min.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
		}

		/**
		 * Localize Customizer ontrols.
		 *
		 * If LOGIN_DESIGNER_DEBUG is active, we need to localize each separate file that's loading.
		 * Otherwise, localize our minified/concated scripts. This way we don't have to load
		 * a separate JS file for each control (which can get quite heavy).
		 */
		public function localization() {

			// Localization.
			$localize = array(
				'ajaxurl'     => admin_url( 'admin-ajax.php' ),
				'btn_default' => esc_html__( 'Install New Template', 'login-designer' ),
				'btn_close'   => esc_html__( 'Close', 'login-designer' ),
				'confirm'     => esc_html__( 'Attention! You are attempting to reset all custom styling added to Login Designer. Please note that this action is irreversible. Proceed?', 'login-designer' ),
				'nonce'       => array(
					'activate'   => wp_create_nonce( 'login-designer-activate-license' ),
					'deactivate' => wp_create_nonce( 'login-designer-deactivate-license' ),
				),
			);

			// If LOGIN_DESIGNER_DEBUG is active.
			if ( defined( 'LOGIN_DESIGNER_DEBUG' ) && LOGIN_DESIGNER_DEBUG ) {
				wp_localize_script( 'login-designer-license-control', 'login_designer_custom_controls', $localize );
				wp_localize_script( 'login-designer-template-control', 'login_designer_custom_controls', $localize );
			} else {
				wp_localize_script( 'login-designer-customize-custom-controls', 'login_designer_custom_controls', $localize );
			}
		}
	}

endif;

new Login_Designer_Customizer_Scripts();
