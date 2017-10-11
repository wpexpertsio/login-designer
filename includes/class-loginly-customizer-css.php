<?php
/**
 * Front-end styles for the Customizer options.
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

if ( ! class_exists( 'Loginly_Customizer_CSS' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Loginly_Customizer_CSS {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'login_enqueue_scripts', array( $this, 'customizer_css' ) );
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function customizer_css() {

			$logo 					= get_theme_mod( 'loginly_custom_logo', '' );
			$logo_margin_bottom 			= get_theme_mod( 'loginly_custom_logo_margin_bottom', '25' );
			$login_background_color 		= get_theme_mod( 'loginly__custom-background-color', null );

			$logo_css = null;
			$logo_margin_bottom_css = null;
			$login_background_color_css = null;

			if ( $logo ) {
				$size = getimagesize( $logo );

				$logo_css = '
					body.login #login h1 a {
						background-image: url("'. esc_url( $logo ).'");
						background-size: '. esc_attr( $size[0] / 2 ).'px '. esc_attr( $size[1] / 2 ).'px ;
						background-position: center center;
					}

					#login h1 a {
						width: auto;
					}
				';
			}

			if ( $logo_margin_bottom ) {

				$logo_margin_bottom_css = '
					body.login #login h1 a {
						margin-bottom: '. esc_attr( $logo_margin_bottom ).'px;
					}
				';
			}

			if ( $login_background_color ) {
				$login_background_color_css = '
					body.login.login-action-login {
						background-color: '. esc_attr( $login_background_color ).';
					}
				';
			}

			wp_add_inline_style( 'login', wp_strip_all_tags( $logo_css . $logo_margin_bottom_css . $login_background_color_css ) );
		}
	}

endif;

new Loginly_Customizer_CSS();
