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

if ( ! class_exists( 'LoginDesigner_Customizer_CSS' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class LoginDesigner_Customizer_CSS {

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

			$logo 					= get_theme_mod( 'login_designer_custom_logo', '' );
			$logo_margin_bottom 			= get_theme_mod( 'login_designer_custom_logo_margin_bottom', '25' );
			$login_background_color 		= get_theme_mod( 'login_designer_body_bg_color', null );
			$login_background_image_url 		= get_theme_mod( 'login_designer_body_bg_img__url', null );
			$login_background_image_repeat 		= get_theme_mod( 'login_designer_body_bg_img__repeat', 'no-repeat' );
			$login_background_image_position 	= get_theme_mod( 'login_designer_body_bg_img__position', 'center-center' );
			$login_background_image_position 	= str_replace( '-', ' ', $login_background_image_position );
			$login_background_image_size 		= get_theme_mod( 'login_designer_body_bg_img__size', 'cover' );
			$login_background_image_attachment 	= get_theme_mod( 'login_designer_body_bg_img__attach', 'fixed' );

			$form_background_color 			= get_theme_mod( 'login_designer_form_background_color', null );
			$form_width				= get_theme_mod( 'login_designer_form_width_css', null );
			$form_border_radius			= get_theme_mod( 'login_designer_form_border_radius', null );

			$logo_css = null;
			$logo_margin_bottom_css = null;
			$login_background_color_css = null;
			$login_background_image_css = null;
			$form_background_color_css = null;
			$form_width_css = null;
			$form_border_radius_css = null;

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
					body.login {
						background-color: '. esc_attr( $login_background_color ).';
					}
				';
			}

			if ( $login_background_image_url ) {
				$login_background_image_css = '
					body.login {
						background-image: url("'. esc_attr( $login_background_image_url ).'");
						background-repeat: '. esc_attr( $login_background_image_repeat ).';
						background-position: '. esc_attr( $login_background_image_position ).';
						background-size: '. esc_attr( $login_background_image_size ).';
						background-attachment: '. esc_attr( $login_background_image_attachment ).';
					}
				';
			}

			if ( $login_background_color ) {
				$form_background_color_css = '
					#loginform {
						background-color: '. esc_attr( $form_background_color ).';
					}
				';
			}

			if ( $form_border_radius ) {
				$form_border_radius_css = '
					#loginform,
					#loginform::after {
						border-radius: '. esc_attr( $form_border_radius ).'px;
					}
				';
			}

			if ( $form_width ) {
				$form_width_css = '
					#login {
						width: '. esc_attr( $form_width ).';
					}
				';
			}

			wp_add_inline_style( 'login', wp_strip_all_tags( $logo_css . $logo_margin_bottom_css . $login_background_color_css . $login_background_image_css . $form_background_color_css . $form_border_radius_css . $form_width_css ) );
		}
	}

endif;

new LoginDesigner_Customizer_CSS();

















