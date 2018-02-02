<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
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
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function control_styles() {

			$dir = Login_Designer()->asset_source( 'css' );

			wp_enqueue_style( 'login-designer-customize-controls', $dir . 'login-designer-customize-controls' . LOGIN_DESIGNER_ASSET_SUFFIX . '.css', null );
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

			$dir = Login_Designer()->asset_source( 'css' );

			wp_enqueue_style( 'login-designer-customize-preview', $dir . 'login-designer-customize-preview' . LOGIN_DESIGNER_ASSET_SUFFIX . '.css', LOGIN_DESIGNER_VERSION, 'all' );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_preview() {

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

			$localize = apply_filters( 'login_designer_customize_preview_localization', $localize );

			wp_localize_script( 'login-designer-customize-preview', 'login_designer_script', $localize );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_controls() {

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

			$localize = apply_filters( 'login_designer_control_localization', $localize );

			wp_localize_script( 'login-designer-customize-controls', 'login_designer_controls', $localize );
		}

		/**
		 * Enqueues control scripts for custom controls.
		 *
		 * If SCRIPT_DEBUG is on, pull each control's scripts for their own files instead.
		 */
		public function custom_controls() {

			// Use this only if SCRIPT_DEBUG is turned off.
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				return;
			}

			$js_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/';

			wp_enqueue_script( 'login-designer-customize-custom-controls', $js_dir . 'login-designer-customize-custom-controls.min.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
		}

		/**
		 * Localize Customizer ontrols.
		 *
		 * If SCRIPT_DEBUG is on, we need to localize each separate file that's loading.
		 * Otherwise, localize our minified/concated scripts. This way we don't have to load
		 * a separate JS file for each control (which can get quite heavy).
		 */
		public function localization() {

			// Localization.
			$localize = array(
				'btn_default' => esc_html__( 'Install New Template', '@@textdomain' ),
				'btn_close'   => esc_html__( 'Close', '@@textdomain' ),
				'confirm'     => esc_html__( 'Attention! You are attempting to reset all custom styling added to Login Designer. Please note that this action is irreversible. Proceed?', '@@textdomain' ),
				'nonce'       => array( 'activate' => wp_create_nonce( 'login-designer-activate-license' ), 'deactivate' => wp_create_nonce( 'login-designer-deactivate-license' ) ),
				'ajaxurl'     => admin_url( 'admin-ajax.php' ),
			);

			// If SCRIPT_DEBUG is turned on.
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				wp_localize_script( 'login-designer-license-control', 'login_designer_custom_controls', $localize );
				wp_localize_script( 'login-designer-template-control', 'login_designer_custom_controls', $localize );
			} else {
				wp_localize_script( 'login-designer-customize-custom-controls', 'login_designer_custom_controls', $localize );
			}

		}
	}

endif;

new Login_Designer_Customizer_Scripts();
