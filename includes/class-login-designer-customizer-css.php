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
			add_action( 'body_class', array( $this, 'body_class' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'customizer_css' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'enqueue_fonts' ) );

			// @todo. Only do these on the Login page and the Login template. Make sure.
			add_filter( 'gettext',  array( $this, 'custom_username_label' ) , 20, 3 );
			add_filter( 'gettext',  array( $this, 'custom_password_label' ) , 20, 3 );
			add_filter( 'wp_resource_hints',  array( $this, 'ava_resource_hints' ) , 10, 2 );
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
		 * Retreive Google fonts from the Customizer options.
		 *
		 * @return string Google fonts URL for the theme.
		 */
		function fonts() {

			$field_font = get_theme_mod( 'login_designer_form_field_font', 'default' );
			$label_font = get_theme_mod( 'login_designer_form_label_font', 'default' );

			$fonts_url = '';
			$fonts     = array();

			/**
			 * Get fonts from the Customizer.
			 */
			if ( 'default' !== $field_font ) {
				$fonts[] = $field_font;
			}

			if ( 'default' !== $label_font ) {
				$fonts[] = $label_font;
			}

			if ( $fonts ) {
				$fonts_url = add_query_arg( array(
					'family' => urlencode( implode( '|', array_unique( $fonts ) ) ),
					'subset' => urlencode( 'latin,latin-ext' ),
				), 'https://fonts.googleapis.com/css' );
			}

			return esc_url_raw( $fonts_url );
		}

		/**
		 * Register Google fonts from the Customizer options.
		 *
		 * @return string Google fonts URL for the theme.
		 */
		function enqueue_fonts() {

			$field_font = get_theme_mod( 'login_designer_form_field_font', 'default' );
			$label_font = get_theme_mod( 'login_designer_form_label_font', 'default' );

			if ( 'default' === $field_font && 'default' === $label_font ) {
				return;
			}

			wp_enqueue_style( 'login-designer-fonts', $this->fonts(), array(), null );
		}

		/**
		 * Add preconnect for Google Fonts.
		 *
		 * @param  array|array   $urls           URLs to print for resource hints.
		 * @param  string|string $relation_type  The relation type the URLs are printed.
		 * @return array|array   $urls           URLs to print for resource hints.
		 */
		function ava_resource_hints( $urls, $relation_type ) {
			if ( wp_style_is( 'ava-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
				$urls[] = array(
					'href' => 'https://fonts.gstatic.com',
					'crossorigin',
				);
			}

			return $urls;
		}

		/**
		 * Customizer output for custom username label.
		 *
		 * @param string|string $translated_text The translated text.
		 * @param string|string $text The label we want to replace.
		 * @param string|string $domain The domain of the site.
		 * @return string
		 */
		public function custom_username_label( $translated_text, $text, $domain ) {

			$username_label = get_theme_mod( 'login_designer_form_label_username_text', null );

			if ( ! $username_label ) {
				return $translated_text;
			}

			if ( 'Username or Email Address' === $text ) {
				$translated_text = esc_html( $username_label );
			}

			return $translated_text;
		}

		/**
		 * Customizer output for custom password label.
		 *
		 * @param string|string $translated_text The translated text.
		 * @param string|string $text The label we want to replace.
		 * @param string|string $domain The domain of the site.
		 * @return string
		 */
		public function custom_password_label( $translated_text, $text, $domain ) {

			$username_label = get_theme_mod( 'login_designer_form_label_password_text', null );

			if ( ! $username_label ) {
				return $translated_text;
			}

			if ( 'Password' === $text ) {
				$translated_text = esc_html( $username_label );
			}

			return $translated_text;
		}

		/**
		 * Enqueue the stylesheets required.
		 *
		 * @access public
		 */
		public function customizer_css() {

			$logo 					= get_theme_mod( 'login_designer_custom_logo', '' );
			$logo_margin_bottom 			= get_theme_mod( 'login_designer_custom_logo_margin_bottom', '25' );

			$login_background_color 		= get_theme_mod( 'login_designer_bg_color', null );
			$login_background_image_url 		= get_theme_mod( 'login_designer_bg_image', null );
			$login_background_image_repeat 		= get_theme_mod( 'login_designer_bg_image_repeat', 'no-repeat' );
			$login_background_image_position 	= get_theme_mod( 'login_designer_bg_image_position', 'center-center' );
			$login_background_image_position 	= str_replace( '-', ' ', $login_background_image_position );
			$login_background_image_size 		= get_theme_mod( 'login_designer_bg_image_size', 'cover' );
			$login_background_image_attachment 	= get_theme_mod( 'login_designer_bg_image_attach', 'fixed' );

			$form_padding_side			= get_theme_mod( 'login_designer_form_padding_side', '24' ) . 'px';
			$form_padding_top_bottom 		= get_theme_mod( 'login_designer_form_padding_top_bottom', '26' ) . 'px';
			$form_background_color 			= get_theme_mod( 'login_designer_form_background_color', null );
			$form_width				= get_theme_mod( 'login_designer_form_width', '320' ) . 'px';
			$form_border_radius			= get_theme_mod( 'login_designer_form_border_radius', null );
			$form_box_shadow			= get_theme_mod( 'login_designer_form_box_shadow', null ) . 'px';
			$form_box_shadow_opacity		= get_theme_mod( 'login_designer_form_box_shadow_opacity', null ) * .01;

			$form_field_background_color		= get_theme_mod( 'login_designer_form_field_background', null );
			$form_field_border_size			= get_theme_mod( 'login_designer_form_field_border_size', '1' ) . 'px';
			$form_field_border_color		= get_theme_mod( 'login_designer_form_field_border_color', null );

			$form_field_side_padding		= get_theme_mod( 'login_designer_form_field_side_padding', null ) . 'px';
			$form_field_text_size			= get_theme_mod( 'login_designer_form_field_text_size', null ) . 'px';
			$form_field_text_color			= get_theme_mod( 'login_designer_form_field_text_color', null );

			$form_field_box_shadow			= get_theme_mod( 'login_designer_form_field_box_shadow', null ) . 'px';
			$form_field_box_shadow_opacity		= get_theme_mod( 'login_designer_form_field_box_shadow_opacity', null ) * .01;
			$form_field_box_shadow_inset		= get_theme_mod( 'login_designer_form_field_box_shadow_inset', true );

			$form_label_color			= get_theme_mod( 'login_designer_form_label_color', null );
			$form_label_size			= get_theme_mod( 'login_designer_form_label_size', '14' ) . 'px';

			$form_field_font			= get_theme_mod( 'login_designer_form_field_font', 'default' );
			$form_label_font			= get_theme_mod( 'login_designer_form_label_font', 'default' );

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

			$form_field_background_css = null;
			$form_field_border_size_css = null;
			$form_field_border_color_css = null;
			$form_field_side_padding_css = null;
			$form_field_text_size_css = null;
			$form_field_text_color_css = null;
			$form_field_box_shadow_css = null;

			$form_label_color_css = null;
			$form_label_size_css = null;

			$form_field_font_css = null;
			$form_label_font_css = null;

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

			if ( '25px' !== $logo_margin_bottom ) {

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

			if ( '320px' !== $form_width ) {
				$form_width_css = '
					#login {
						width: '. esc_attr( $form_width ) .';
					}
				';
			}

			if ( '24px' !== $form_padding_side ) {
				$form_padding_side_css = '
					#loginform {
						padding-left: '. esc_attr( $form_padding_side ) .';
						padding-right: '. esc_attr( $form_padding_side ) .';
					}
				';
			}

			if ( '26px' !== $form_padding_side ) {
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

			if ( $form_field_background_color ) {
				$form_field_background_css = '
					#loginform .input {
						background-color: '. esc_attr( $form_field_background_color ) .';
					}
				';
			}

			if ( $form_field_border_size ) {

				$form_field_border_size_css = '
					#loginform .input {
						border-style: solid;
						border-width:  '. esc_attr( $form_field_border_size ) .';
					}
				';
			}

			if ( $form_field_border_color ) {

				$form_field_border_color_css = '
					#loginform .input {
						border-color: '. esc_attr( $form_field_border_color ) .';
					}
				';
			}

			if ( $form_field_side_padding ) {
				$form_field_side_padding_css = '
					#loginform .input {
						padding-left: '. esc_attr( $form_field_side_padding ) .';
						padding-right: '. esc_attr( $form_field_side_padding ) .';
					}
				';
			}

			if ( $form_field_text_size ) {
				$form_field_text_size_css = '
					#loginform .input {
						font-size: '. esc_attr( $form_field_text_size ) .';
					}
				';
			}

			if ( $form_field_text_color ) {
				$form_field_text_color_css = '
					#loginform .input {
						color: '. esc_attr( $form_field_text_color ) .';
					}
				';
			}

			if ( $form_field_box_shadow || $form_field_box_shadow_opacity ) {

				$opacity = ( $form_field_box_shadow_opacity ) ? $form_field_box_shadow_opacity : 0;

				$inset = ( $form_field_box_shadow_inset ) ? 'inset' : null;

				$form_field_box_shadow_css = '
					#loginform .input  {
						box-shadow: '. esc_attr( $inset ) .' 0 0 '. esc_attr( $form_field_box_shadow ) .' rgba(0, 0, 0, '. esc_attr( $opacity ) .');
					}
				';
			}

			if ( $form_label_color ) {
				$form_label_color_css = '
					#loginform label:not([for=rememberme]) {
						color: '. esc_attr( $form_label_color ) .';
					}
				';
			}

			if ( '14px' !== $form_label_size ) {
				$form_label_size_css = '
					#loginform label:not([for=rememberme]) {
						font-size: '. esc_attr( $form_label_size ) .';
					}
				';
			}

			if ( 'default' !== $form_label_font ) {
				$form_label_font_css = '
					#loginform label:not([for=rememberme]) {
						font-family: '. esc_attr( $form_label_font ) .';
					}
				';
			}

			if ( 'default' !== $form_field_font ) {
				$form_field_font_css = '
					#loginform .input {
						font-family: '. esc_attr( $form_field_font ) .';
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
					$form_box_shadow_css .
					$form_field_background_css .
					$form_field_border_size_css .
					$form_field_border_color_css .
					$form_field_side_padding_css .
					$form_field_text_size_css .
					$form_field_text_color_css .
					$form_field_box_shadow_css .
					$form_label_color_css .
					$form_label_size_css .
					$form_label_font_css .
					$form_field_font_css;

			// $minified_css = preg_replace( '#/\*.*?\*/#s', '', $minified_css );
			// $minified_css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $minified_css );
			// $minified_css = preg_replace( '/\s\s+(.*)/', '$1', $minified_css );

			wp_add_inline_style( 'login', wp_strip_all_tags( $minified_css ) );
		}
	}

endif;

new Login_Designer_Customizer_CSS();

















