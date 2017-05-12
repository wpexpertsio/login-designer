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

if ( ! class_exists( 'Loginly_Scripts' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Loginly_Scripts {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'customize_controls_print_styles', array( $this, 'customize_controls_print_styles' ), 99 );
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ) );
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function customize_controls_print_styles() {

			$css_dir = LOGINLY_PLUGIN_URL . 'assets/css/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_register_style( 'loginly-customizer', $css_dir . 'customizer' . $suffix . '.css', null );
			wp_enqueue_style( 'loginly-customizer' );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function customize_controls_enqueue_scripts() {

			$js_dir  = LOGINLY_PLUGIN_URL . 'assets/js/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

			wp_enqueue_script( 'loginly-customize-preview', $js_dir . 'loginly-customize-preview' . $suffix . '.js', array( 'customize-preview' ), LOGINLY_VERSION, true );
		}
	}

endif;

new Loginly_Scripts();
