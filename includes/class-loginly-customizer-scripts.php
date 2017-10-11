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

if ( ! class_exists( 'Loginly_Customizer_Scripts' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Loginly_Customizer_Scripts {

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

			$css_dir = LOGINLY_PLUGIN_URL . 'assets/css/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

			wp_enqueue_style( 'loginly-customize-preview', $css_dir . 'loginly-customize-preview' . $suffix . '.css', null );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_preview() {

			$js_dir  = LOGINLY_PLUGIN_URL . 'assets/js/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

			wp_enqueue_script( 'loginly-customize-preview', $js_dir . 'loginly-customize-preview' . $suffix . '.js', array( 'customize-preview' ), LOGINLY_VERSION, true );

			// Localization.
			$loginly_localize = array(
				'admin_url'         => admin_url(),
				'plugin_url'        => plugins_url(),
			);

			wp_localize_script( 'loginly-customize-preview', 'loginly_script', $loginly_localize );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_controls() {

			$js_dir  = LOGINLY_PLUGIN_URL . 'assets/js/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

			wp_enqueue_script( 'loginly-customize-controls', $js_dir . 'loginly-customize-controls' . $suffix . '.js', array( 'customize-controls' ), LOGINLY_VERSION, true );
		}
	}

endif;

new Loginly_Customizer_Scripts();
