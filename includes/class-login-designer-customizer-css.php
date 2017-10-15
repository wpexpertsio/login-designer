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

if ( ! class_exists( 'Login_Designer_Customizer_CSS' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Customizer_CSS {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'login_enqueue_scripts', array( $this, 'customizer_css' ) );
			add_action( 'body_class', array( $this, 'body_class' ) );
		}

		/**
		 * Adds the associated template to the body.
		 *
		 * @access public
		 * @param array $classes Existing body classes to be filtered.
		 */
		public function body_class( $classes ) {

			if ( is_customize_preview() ) {
				$classes[] = 'customize-partial-edit-shortcuts-shown';
			}

			return $classes;
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

			$form_padding_side			= get_theme_mod( 'login_designer_form_padding_side', null ) . 'px';
			$form_padding_top_bottom 		= get_theme_mod( 'login_designer_form_padding_top_bottom', null ) . 'px';
			$form_background_color 			= get_theme_mod( 'login_designer_form_background_color', null );
			$form_width				= get_theme_mod( 'login_designer_form_width', null ) . 'px';
			$form_border_radius			= get_theme_mod( 'login_designer_form_border_radius', null );
			$form_box_shadow			= get_theme_mod( 'login_designer_form_box_shadow', null ) . 'px';
			$form_box_shadow_opacity		= get_theme_mod( 'login_designer_form_box_shadow_opacity', null ) * .01;

			$logo_css = null;
			$logo_margin_bottom_css = null;
			$login_background_color_css = null;
			$login_background_image_css = null;
			$form_background_color_css = null;
			$form_width_css = null;
			$form_border_radius_css = null;
			$form_padding_side_css = null;
			$form_padding_top_bottom_css = null;
			$form_box_shadow_css = null;

			// Styles that fix the default form.
			$default = '
				#login > p {
					text-align: center;
					padding: 0;
					margin: 10px 0;
				}

				#loginform {
					overflow: visible;
				}

				#loginform p.submit {
					padding-bottom: 25px !important;
				}

				.login form .forgetmenot {
					margin-top: 5px;
				}

				h1#login-designer-logo-h1 {
					margin: 0 auto;
					width: 84px;
				}
			';

			if ( $logo ) {
				$size = getimagesize( $logo );

				$logo_css = '
					body.login #login h1 a {
						background-image: url("'. esc_url( $logo ) .'");
						background-size: '. esc_attr( $size[0] / 2 ) .'px '. esc_attr( $size[1] / 2 ) .'px ;
						background-position: center center;
					}

					h1#login-designer-logo-h1 {
						width: '. esc_attr( $size[0] / 2 ) .'px;
					}

					#login h1 a {
						width: auto;
					}
				';
			}

			if ( $logo_margin_bottom ) {

				$logo_margin_bottom_css = '
					body.login #login h1 a {
						margin-bottom: '. esc_attr( $logo_margin_bottom ) .'px;
					}
				';
			}

			if ( $login_background_color ) {
				$login_background_color_css = '
					body.login {
						background-color: '. esc_attr( $login_background_color ) .';
					}
				';
			}

			if ( $login_background_image_url ) {
				$login_background_image_css = '
					body.login {
						background-image: url("'. esc_attr( $login_background_image_url ) .'");
						background-repeat: '. esc_attr( $login_background_image_repeat ) .';
						background-position: '. esc_attr( $login_background_image_position ) .';
						background-size: '. esc_attr( $login_background_image_size ) .';
						background-attachment: '. esc_attr( $login_background_image_attachment ) .';
					}
				';
			}

			if ( $form_background_color ) {
				$form_background_color_css = '
					#loginform {
						background-color: '. esc_attr( $form_background_color ) .';
					}
				';
			}

			if ( $form_border_radius ) {
				$form_border_radius_css = '
					#loginform,
					#loginform::after {
						border-radius: '. esc_attr( $form_border_radius ) .'px;
					}
				';
			}

			if ( $form_width ) {
				$form_width_css = '
					#login {
						width: '. esc_attr( $form_width ) .';
					}
				';
			}

			if ( $form_padding_side ) {
				$form_padding_side_css = '
					#loginform {
						padding-left: '. esc_attr( $form_padding_side ) .';
						padding-right: '. esc_attr( $form_padding_side ) .';
					}
				';
			}

			if ( $form_padding_top_bottom ) {
				$form_padding_top_bottom_css = '
					#loginform {
						padding-top: '. esc_attr( $form_padding_top_bottom ) .';
						padding-bottom: '. esc_attr( $form_padding_top_bottom ) .';
					}
				';
			}

			if ( $form_box_shadow || $form_box_shadow_opacity ) {

				$opacity = ( $form_box_shadow_opacity ) ? $form_box_shadow_opacity : 0;

				$form_box_shadow_css = '
					#loginform {
						box-shadow: 0 1px '. esc_attr( $form_box_shadow ) .' rgba(0, 0, 0, '. esc_attr( $opacity ) .');
					}
				';
			}













			/**
			* Combine the values from above and minifiy them.
			*/
			$minified_css = $default .
					$logo_css .
					$logo_margin_bottom_css .
					$login_background_color_css .
					$login_background_image_css .
					$form_background_color_css .
					$form_border_radius_css .
					$form_width_css .
					$form_padding_side_css .
					$form_padding_top_bottom_css .
					$form_box_shadow_css;

			// $minified_css = preg_replace( '#/\*.*?\*/#s', '', $minified_css );
			// $minified_css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $minified_css );
			// $minified_css = preg_replace( '/\s\s+(.*)/', '$1', $minified_css );

			wp_add_inline_style( 'login', wp_strip_all_tags( $minified_css ) );
		}
	}

endif;

new Login_Designer_Customizer_CSS();

















