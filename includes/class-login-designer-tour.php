<?php
/**
 * Getting started tour.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Tour' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Tour {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'customize_preview_init', array( $this, 'scripts' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'styles' ), 99 );
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function styles() {

			if ( ! is_customize_preview() ) {
				return;
			}

			$css_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/css/';

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_style( 'login-designer-tour', $css_dir . 'login-designer-tour' . $suffix . '.css', LOGIN_DESIGNER_VERSION, 'all' );
		}

		/**
		 * Enqueues scripts in the Customizer.
		 */
		public function scripts() {

			// Change to the minified asset directory.
			if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
				$js_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/';
			} else {
				$js_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/js/dist/';
			}

			// Use minified libraries if SCRIPT_DEBUG is turned off.
			$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

			wp_enqueue_script( 'login-designer-intro', $js_dir . 'intro.min.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );
			wp_enqueue_script( 'login-designer-intro-tour', $js_dir . 'login-designer-tour' . $suffix . '.js', array( 'customize-preview' ), LOGIN_DESIGNER_VERSION, true );

			// Localization.
			$localize = array(
				'btn_close' => esc_html__( 'Close', '@@textdomain' ),
			);

			$localize = apply_filters( 'login_designer_tour_localization', $localize );

			wp_localize_script( 'login-designer-tour', 'login_designer_tour', $localize );
		}
	}

endif;

new Login_Designer_Tour();
