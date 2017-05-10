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
			add_action( 'customize_controls_enqueue_scripts', array( $this, 'customize_controls_enqueue_scripts' ), 7 );
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
		 * Assets that have to be enqueued in 'customize_controls_enqueue_scripts'.
		 */
		public function customize_controls_enqueue_scripts() {

			$js_dir  = LOGINLY_PLUGIN_URL . 'assets/js/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '';

			//wp_register_script( 'loginly-customizer', $js_dir . 'loginly-customizer' . $suffix . '.js', array( 'customize-controls' ), LOGINLY_VERSION, 'all' );
			//wp_enqueue_script( 'loginly-customizer' );

			// wp_register_script( 'customizer-background-image-controls', esc_url( $js_dir . '/js/loginly-customizer.js' ), array( 'customize-controls' ) );
			// wp_enqueue_script( 'customizer-background-image-controls' );
		}
	}

endif;

new Loginly_Scripts();
