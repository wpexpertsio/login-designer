<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
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

if ( ! class_exists( 'LoginDesigner_Customizer_Scripts' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class LoginDesigner_Customizer_Scripts {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'customize_controls_print_styles', array( $this, 'styles' ), 99 );
			add_action( 'customize_preview_init', array( $this, 'customize_preview' ) );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls' ) );
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function styles() {

			$css_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/css/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

			wp_enqueue_style( 'login-designer-customize-preview', $css_dir . 'login-designer-customize-preview' . $suffix . '.css', null );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_preview() {

			$js_dir  = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

			wp_enqueue_script( 'login-designer-customize-live', $js_dir . 'login-designer-customize-live' . $suffix . '.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );
			wp_enqueue_script( 'login-designer-customize-preview', $js_dir . 'login-designer-customize-preview' . $suffix . '.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );

			// Localization.
			$login_designer_localize = array(
				'admin_url'         => admin_url(),
				'plugin_url'        => LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/',
			);

			wp_localize_script( 'login-designer-customize-preview', 'login_designer_script', $login_designer_localize );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_controls() {

			$js_dir  = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

			wp_enqueue_script( 'login-designer-customize-controls', $js_dir . 'login-designer-customize-controls' . $suffix . '.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
			wp_enqueue_script( 'login-designer-customize-events', $js_dir . 'login-designer-customize-events' . $suffix . '.js', array( 'customize-controls' ), LOGIN_DESIGNER_VERSION, true );
		}
	}

endif;

new LoginDesigner_Customizer_Scripts();
