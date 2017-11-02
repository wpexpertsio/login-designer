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

if ( ! class_exists( 'Login_Designer_Customizer_Output' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Customizer_Output {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'login_enqueue_scripts', array( $this, 'customizer_css' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'enqueue_fonts' ) );
			add_filter( 'gettext',  array( $this, 'custom_username_label' ) , 20, 3 );
			add_filter( 'gettext',  array( $this, 'custom_password_label' ) , 20, 3 );
			add_filter( 'wp_resource_hints',  array( $this, 'fonts_resource_hints' ) , 10, 2 );
		}

		/**
		 * Options wrapper.
		 *
		 * @param string|string $option The option in question.
		 * @return string
		 */
		public function option_wrapper( $option ) {

			$options = get_option( 'login_designer' );

			// Check if options exist.
			if ( ! $options ) {
				return false;
			}

			// Check if the option exists.
			if ( isset( $options[ $option ] ) ) {
				return $options[ $option ];
			} else {
				return false;
			}
		}

		/**
		 * Set default options.
		 *
		 * @return array $defaults
		 */
		function defaults() {

			$defaults = array(
				'template' 		=> 'default',

				'bg_image' 		=> '',
				'bg_image_gallery' 	=> '',
				'bg_repeat' 		=> 'no-repeat',
				'bg_size' 		=> 'cover',
				'bg_position' 		=> 'center-center',
				'bg_attach' 		=> 'fixed',
				'bg_color' 		=> '#f1f1f1',

				'logo' 			=> '',
				'logo_margin_bottom' 	=> '25',
				'disable_logo' 		=> false,

				'form_bg' 		=> '#ffffff',
				'form_width' 		=> '320',
				'form_side_padding' 	=> '24',
				'form_vertical_padding' => '26',
				'form_radius' 		=> '0',
				'form_shadow' 		=> '3',
				'form_shadow_opacity' 	=> '13',

				'field_bg' 		=> '#fbfbfb',
				'field_padding_top' 	=> '3',
				'field_padding_bottom' 	=> '3',
				'field_side_padding' 	=> '12',
				'field_border' 		=> '1',
				'field_border_color' 	=> '#dddddd',
				'field_radius' 		=> '0',
				'field_shadow' 		=> '2',
				'field_shadow_opacity' 	=> '7',
				'field_shadow_inset' 	=> true,
				'field_font' 		=> 'default',
				'field_font_size' 	=> '24',
				'field_color' 		=> '#32373c',

				'username_label' 	=> esc_html__( 'Username or Email Address', '@@textdomain' ),
				'password_label' 	=> esc_html__( 'Password', '@@textdomain' ),
				'label_font' 		=> 'default',
				'label_position' 	=> '2',
				'label_font_size' 	=> '14',
				'label_color' 		=> '#72777c',

				'button_bg' 		=> '#0085ba',
				'button_height' 	=> '4',
				'button_side_padding' 	=> '12',
				'button_border' 	=> '1',
				'button_border_color' 	=> '#0073aa',
				'button_radius' 	=> '3',
				'button_shadow' 	=> '0',
				'button_shadow_opacity' => '0',

				'button_font' 		=> 'default',
				'button_font_size' 	=> '13',
				'button_color' 		=> '#fff',


			);

			return apply_filters( 'login_designer_defaults', $defaults );
		}

		/**
		 * Admin options wrapper.
		 *
		 * @param string|string $option The option in question.
		 * @return string
		 */
		public function admin_option_wrapper( $option ) {

			$options = get_option( 'login_designer_admin' );

			// Check if options exist.
			if ( ! $options ) {
				return false;
			}

			// Check if the option exists.
			if ( isset( $options[ $option ] ) ) {
				return $options[ $option ];
			} else {
				return false;
			}
		}

		/**
		 * License options wrapper.
		 *
		 * @param string|string $option The option in question.
		 * @return string
		 */
		public function license_option_wrapper( $option ) {

			$options = get_option( 'login_designer_license' );

			// Check if options exist.
			if ( ! $options ) {
				return false;
			}

			// Check if the option exists.
			if ( isset( $options[ $option ] ) ) {
				return $options[ $option ];
			} else {
				return false;
			}
		}

		/**
		 * Set admin defaults.
		 * Admin settings are separated because we don't want to reset them if the reset Customizer action is triggered.
		 *
		 * @return array $defaults
		 */
		function admin_defaults() {

			$admin_defaults = array(
				'login_designer_page'	=> '',
				'logo_url' 		=> '',
				'login_redirect' 	=> '',
				'logout_redirect' 	=> '',
				'login_message' 	=> '',

			);

			return apply_filters( 'login_designer_admin_defaults', $admin_defaults );
		}

		/**
		 * Set license defaults.
		 *
		 * @return array $defaults
		 */
		function license_defaults() {

			$license_defaults = array(
				'key'		=> '',
				'status'	=> '',
				'expiration'	=> '',

			);

			return apply_filters( 'login_designer_license', $license_defaults );
		}

		/**
		 * Create a filter to for extenstions to add background collections.
		 *
		 * @return array $backgrounds
		 */
		function extension_backgrounds() {

			$backgrounds = array();

			return apply_filters( 'login_designer_extension_background_options', $backgrounds );
		}

		/**
		 * Create a filter to for extenstions to add background collections.
		 *
		 * @return array $backgrounds
		 */
		function extension_colors() {

			$colors = array();

			return apply_filters( 'login_designer_extension_color_options', $colors );
		}

		/**
		 * Retreive Google fonts from the Customizer options.
		 *
		 * @return string Google fonts URL for the theme.
		 */
		function fonts() {

			$fonts_url = '';
			$fonts     = array();

			$field_font = $this->option_wrapper( 'field_font' );
			$label_font = $this->option_wrapper( 'label_font' );

			/**
			 * Get fonts from the Customizer.
			 */
			if ( $field_font ) {
				if ( 'default' !== $field_font ) {
					$fonts[] = $field_font;
				}
			}

			if ( $label_font ) {
				if ( 'default' !== $label_font ) {
					$fonts[] = $label_font;
				}
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
		 * Register Google fonts from the Customizer.
		 */
		function enqueue_fonts() {
			wp_enqueue_style( 'login-designer-fonts', $this->fonts(), array(), null );
		}

		/**
		 * Add preconnect for Google Fonts.
		 *
		 * @param  array|array   $urls           URLs to print for resource hints.
		 * @param  string|string $relation_type  The relation type the URLs are printed.
		 * @return array|array   $urls           URLs to print for resource hints.
		 */
		function fonts_resource_hints( $urls, $relation_type ) {

			if ( wp_style_is( 'login-designer-fonts', 'queue' ) && 'preconnect' === $relation_type ) {
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

			// If the option does not exist, return.
			if ( ! $this->option_wrapper( 'username_label' ) ) {
				return $translated_text;
			}

			if ( 'Username or Email Address' === $text ) {
				$translated_text = esc_html( $this->option_wrapper( 'username_label' ) );
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

			// If the option does not exist, return.
			if ( ! $this->option_wrapper( 'password_label' ) ) {
				return $translated_text;
			}

			if ( 'Password' === $text ) {
				$translated_text = esc_html( $this->option_wrapper( 'password_label' ) );
			}

			return $translated_text;
		}

		/**
		 * Enqueue Customizer styles.
		 *
		 * @access public
		 */
		public function customizer_css() {

			// Get the default options.
			$defaults = $this->defaults();

			$options = get_option( 'login_designer' );

			// Merge the $options and $defaults.
			$options = wp_parse_args( $options, $defaults );

			if ( $options ) {
				$options = array_filter( $options );
			}

			// Start CSS Variable.
			$css = '';

			// Default overrides to clean up the standard WordPress login form.
			$css .= '
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

				#loginform .forgetmenot {
					margin-top: 5px;
				}

				#login-designer-logo-h1 {
					margin: 0 auto;
				}

				#login-designer-logo {
					transition-duration: 0;
				}

				#login h1 a:focus {
					box-shadow: none;
				}

				#loginform .submit .button {
					box-shadow: 0 0 0;
					text-shadow: none;
					height: auto !important;
					line-height: inherit;
				}
			';

			if ( ! empty( $options ) ) :

				// Background color.
				if ( isset( $options['bg_color'] ) ) {
					$css .= 'body.login { background-color:' . esc_attr( $options['bg_color'] ) . ';}';
				}

				// Custom background image.
				if ( isset( $options['bg_image'] ) ) {
					$css .= 'body.login, #login-designer-background { background-image: url(" ' . $options['bg_image'] . ' "); }';
				}

				// Background image gallery. Only display if there's no custom background image.
				if ( isset( $options['bg_image_gallery'] ) && 'none' !== $options['bg_image_gallery'] && empty( $options['bg_image'] ) ) {

					// If this is an extenstion image, stop here. The extenstion takes over styling.
					if ( ! in_array( $options['bg_image_gallery'], $this->extension_backgrounds(), true ) ) {

						$image_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/';

						// Get the image's url.
						$url = $image_dir . $options['bg_image_gallery'] . '.jpg';

						$css .= 'body.login, #login-designer-background { background-image: url(" ' . esc_url( $url ) . ' "); }';
					}
				}

				// Background image repeat.
				if ( isset( $options['bg_repeat'] ) ) {
					$css .= 'body.login, #login-designer-background { background-repeat: ' . esc_attr( $options['bg_repeat'] ) . ' }';
				}

				// Background image position.
				if ( isset( $options['bg_position'] ) ) {
					$css .= 'body.login, #login-designer-background { background-position: ' . esc_attr( $options['bg_position'] ) . ' }';
				}

				// Background image size.
				if ( isset( $options['bg_size'] ) ) {
					$css .= 'body.login, #login-designer-background { background-size: ' . esc_attr( $options['bg_size'] ) . ' }';
				}

				// Background image attachment.
				if ( isset( $options['bg_attach'] ) ) {
					$css .= 'body.login, #login-designer-background { background-attachment: ' . esc_attr( $options['bg_attach'] ) . ' }';
				}

				// Logo.
				if ( isset( $options['logo'] ) ) {

					$size = getimagesize( $options['logo'] );

					$css .= '
						#login-designer-logo,
						body.login #login h1 a {
							background-image: url(" ' . esc_url( $options['logo'] ) . ' ");
							background-size: 100%;
							background-size: '. esc_attr( $size[0] / 2 ) .'px '. esc_attr( $size[1] / 2 ) .'px ;
							background-position: center center;
						}

						#login-designer-logo-h1,
						body.login #login h1 a {
							margin: 0 auto;
							width: '. esc_attr( $size[0] / 2 ) .'px;
						}

						#login h1 a { width: auto; }
					';
				}

				// Logo display.
				if ( isset( $options['disable_logo'] ) && true === $options['disable_logo'] ) {
					$css .= 'body.login #login h1 a { display: none; }';
					$css .= 'body.login #login h1 a, body #login-designer-logo-h1 { margin-bottom: 0 }';
				}

				// Logo margin bottom.
				if ( isset( $options['logo_margin_bottom'] ) && ! empty( $options['logo'] ) ) {
					$css .= 'body.login #login h1 a, #login-designer-logo-h1 { margin-bottom: ' . esc_attr( $options['logo_margin_bottom'] ) . 'px; }';
				}

				// Form background color.
				if ( isset( $options['form_bg'] ) ) {
					$css .= '#loginform, .login-designer-template-01 #login { background-color: ' . $options['form_bg'] . '; }';
				}

				// Form width.
				if ( isset( $options['form_width'] ) ) {
					$css .= '#login { width: ' . esc_attr( $options['form_width'] ) . 'px; }';
				}

				// Form side padding.
				if ( isset( $options['form_side_padding'] ) ) {
					$css .= '#loginform { padding-left: ' . esc_attr( $options['form_side_padding'] ) . 'px; padding-right: ' . esc_attr( $options['form_side_padding'] ) . 'px; }';
				}

				// Form side padding.
				if ( isset( $options['form_vertical_padding'] ) ) {
					$css .= '#loginform { padding-top: ' . esc_attr( $options['form_vertical_padding'] ) . 'px; padding-bottom: ' . esc_attr( $options['form_vertical_padding'] ) . 'px; }';
				}

				// Form side padding.
				if ( isset( $options['form_radius'] ) ) {
					$css .= '#loginform { border-radius: ' . esc_attr( $options['form_radius'] ) . 'px; }';
				}

				// Form box-shadow.
				if ( isset( $options['form_shadow'] ) ) {

					$opacity = ( isset( $options['form_shadow_opacity'] ) * .01 ) ? $options['form_shadow_opacity'] * .01 : 0;

					$css .= '#loginform { box-shadow: 0 0 '. esc_attr( $options['form_shadow'] ) .'px rgba(0, 0, 0, '. esc_attr( $opacity ) .'); }';
				} else {
					$css .= '#loginform { box-shadow: none; }';
				}

				// Field background.
				if ( isset( $options['field_bg'] ) ) {
					$css .= '#loginform .input { background-color: ' . esc_attr( $options['field_bg'] ) . '; }';
				}

				// Field top padding.
				if ( isset( $options['field_padding_top'] ) ) {
					$css .= '#loginform .input { padding-top: ' . esc_attr( $options['field_padding_top'] ) . 'px; }';
				}

				// Field bottom padding.
				if ( isset( $options['field_padding_bottom'] ) ) {
					$css .= '#loginform .input { padding-bottom: ' . esc_attr( $options['field_padding_bottom'] ) . 'px; }';
				}

				// Field side padding.
				if ( isset( $options['field_side_padding'] ) ) {
					$css .= '#loginform .input { padding-left: ' . esc_attr( $options['field_side_padding'] ) . 'px; }';
				}

				// Field border width.
				if ( isset( $options['field_border'] ) ) {
					$css .= '#loginform .input { border-style: solid; border-width: ' . esc_attr( $options['field_border'] ) . 'px; }';
				} else {
					$css .= '#loginform .input { border: 0 }';
				}

				// Field border color.
				if ( isset( $options['field_border_color'] ) ) {
					$css .= '#loginform .input { border-color: ' . esc_attr( $options['field_border_color'] ) . '; }';
				}

				// Field border radius.
				if ( isset( $options['field_radius'] ) ) {
					$css .= '#loginform .input, #loginform div .login-designer-event-button { border-radius: ' . esc_attr( $options['field_radius'] ) . 'px; }';
				}

				// Field box-shadow.
				if ( isset( $options['field_shadow'] ) ) {

					$opacity = ( isset( $options['field_shadow_opacity'] ) * .01 ) ? $options['field_shadow_opacity'] * .01 : 0;

					$inset = isset( $options['field_shadow_inset'] ) ? 'inset' : '';

					$css .= '#loginform .input { box-shadow: ' . esc_attr( $inset ) . ' 0 0 '. esc_attr( $options['field_shadow'] ) .'px rgba(0, 0, 0, '. esc_attr( $opacity ) .'); }';
				} else {
					$css .= '#loginform .input { box-shadow: none; }';
				}

				// Field font, as long as it's not 'default'.
				if ( isset( $options['field_font'] ) && 'default' !== $options['field_font'] ) {
					$css .= '#loginform .input { font-family: ' . esc_attr( $options['field_font'] ) . '; }';
				}

				// Field font size.
				if ( isset( $options['field_font_size'] ) ) {
					$css .= '#loginform .input { font-size: ' . esc_attr( $options['field_font_size'] ) . 'px }';
				}

				// Field font color.
				if ( isset( $options['field_color'] ) ) {
					$css .= '#loginform .input { color: ' . esc_attr( $options['field_color'] ) . ' }';
				}

				// Label font, as long as it's not 'default'.
				if ( isset( $options['label_font'] ) && 'default' !== $options['label_font'] ) {
					$css .= '#loginform label:not([for=rememberme]) { font-family: ' . esc_attr( $options['label_font'] ) . '; }';
				}

				// Label font size.
				if ( isset( $options['label_font_size'] ) ) {
					$css .= '#loginform label:not([for=rememberme]) { font-size: ' . esc_attr( $options['label_font_size'] ) . 'px }';
				}

				// Label font color.
				if ( isset( $options['label_color'] ) ) {
					$css .= '#loginform label:not([for=rememberme]) { color: ' . esc_attr( $options['label_color'] ) . ' }';
				}

				// Label position.
				if ( isset( $options['label_position'] ) ) {
					$css .= '#loginform .input { margin-top: ' . esc_attr( $options['label_position'] ) . 'px }';

					if ( is_customize_preview() ) {
						$css .= '#loginform div .login-designer-event-button { top: ' . esc_attr( $options['label_position'] ) . 'px }';
					}
				}

				// Button background color.
				if ( isset( $options['button_bg'] ) ) {
					$css .= '#loginform .submit .button { background-color: ' . $options['button_bg'] . '; }';
				}

				// Button height.
				if ( isset( $options['button_height'] ) ) {
					$css .= '#loginform .submit .button { padding-top: ' . esc_attr( $options['button_height'] ) . 'px; padding-bottom: ' . esc_attr( $options['button_height'] ) . 'px; }';
				}

				// Button side padding.
				if ( isset( $options['button_side_padding'] ) ) {
					$css .= '#loginform .submit .button { padding-left: ' . esc_attr( $options['button_side_padding'] ) . 'px; padding-right: ' . esc_attr( $options['button_side_padding'] ) . 'px; }';
				}

				// Button border width.
				if ( isset( $options['button_border'] ) ) {
					$css .= '#loginform .submit .button { border-style: solid; border-width: ' . esc_attr( $options['button_border'] ) . 'px; }';
				}

				// Button border color.
				if ( isset( $options['button_border_color'] ) ) {
					$css .= '#loginform .submit .button { border-color: ' . $options['button_border_color'] . '; }';
				}

				// Button border radius.
				if ( isset( $options['button_radius'] ) ) {
					$css .= '#loginform .submit .button, #loginform .submit .login-designer-event-button { border-radius: ' . esc_attr( $options['button_radius'] ) . 'px; }';
				}

				// Field box-shadow.
				if ( isset( $options['button_shadow'] ) ) {

					$opacity = ( isset( $options['button_shadow_opacity'] ) * .01 ) ? $options['button_shadow_opacity'] * .01 : 0;

					$css .= '#loginform .submit .button { box-shadow: 0 0 '. esc_attr( $options['button_shadow'] ) .'px rgba(0, 0, 0, '. esc_attr( $opacity ) .'); }';
				}

				// Button font, as long as it's not 'default'.
				if ( isset( $options['button_font'] ) && 'default' !== $options['button_font'] ) {
					$css .= '#loginform .submit .button { font-family: ' . esc_attr( $options['button_font'] ) . '; }';
				}

				// Button font size.
				if ( isset( $options['button_font_size'] ) ) {
					$css .= '#loginform .submit .button { font-size: ' . esc_attr( $options['button_font_size'] ) . 'px }';
				}

				// Button font color.
				if ( isset( $options['button_color'] ) ) {
					$css .= '#loginform .submit .button { color: ' . esc_attr( $options['button_color'] ) . ' }';
				}

			endif;

			// Combine the values from above and minifiy them.
			$css = preg_replace( '#/\*.*?\*/#s', '', $css );
			$css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css );
			$css = preg_replace( '/\s\s+(.*)/', '$1', $css );

			// Add inline style.
			wp_add_inline_style( 'login', wp_strip_all_tags( $css ) );
		}
	}

endif;

new Login_Designer_Customizer_Output();
