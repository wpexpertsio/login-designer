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

if ( ! class_exists( 'Loginly_Frontend_CSS' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Loginly_Frontend_CSS {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'login_enqueue_scripts', array( $this, 'login_enqueue_scripts' ) );
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function login_enqueue_scripts() {
			$logo_maxwidth = get_theme_mod( 'loginly__custom-logo-maxwidth', '100' );

			$custom_css = ' 
			#login h1 a { width: '. esc_attr( $logo_maxwidth ).'px; }
			';

			wp_add_inline_style( 'login', wp_strip_all_tags( $custom_css ) );
		}
	}

endif;

new Loginly_Frontend_CSS();
