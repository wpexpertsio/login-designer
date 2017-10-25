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
		 * Register Google fonts from the Customizer.
		 */
		function enqueue_fonts() {

			$field_font = $this->option_wrapper( 'field_font' );
			$label_font = $this->option_wrapper( 'label_font' );

			wp_enqueue_style( 'login-designer-fonts', $this->fonts(), array(), null );
		}

		/**
		 * Retreive Google fonts from the Customizer options.
		 *
		 * @return string Google fonts URL for the theme.
		 */
		function fonts() {

			$fonts_url = '';
			$fonts     = array();

			/**
			 * Get fonts from the Customizer.
			 */
			if ( $this->option_wrapper( 'field_font' ) ) {
				$fonts[] = $this->option_wrapper( 'field_font' );
			}

			if ( $this->option_wrapper( 'label_font' ) ) {
				$fonts[] = $this->option_wrapper( 'label_font' );
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
				'field_side_padding' 	=> '3',
				'field_border' 		=> '1',
				'field_border_color' 	=> '#dddddd',
				'field_radius' 		=> '0',
				'field_shadow' 		=> '2',
				'field_shadow_opacity' 	=> '7',
				'field_shadow_inset' 	=> '',
				'field_font' 		=> '',
				'field_font_size' 	=> '24',
				'field_color' 		=> '#32373c',

				'username_label' 	=> esc_html__( 'Username or Email Address', '@@textdomain' ),
				'password_label' 	=> esc_html__( 'Password', '@@textdomain' ),
				'label_font' 		=> '',
				'label_font_size' 	=> '14',
				'label_color' 		=> '#72777c',
			);

			return apply_filters( 'login_designer_defaults', $defaults );
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
		 * Create a filter to for extenstions to add background collections.
		 *
		 * @return array $backgrounds
		 */
		function extension_backgrounds() {

			$backgrounds = array();

			return apply_filters( 'login_designer_extension_background_options', $backgrounds );
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

				.login form .forgetmenot {
					margin-top: 5px;
				}

				h1#login-designer-logo-h1 {
					margin: 0 auto;
				}

				h1#login-designer-logo-h1 a {
					transition-duration: 0;
				}

				#login h1 a:focus {
					box-shadow: none;
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

						h1#login-designer-logo-h1,
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
					$css .= 'body.login #login h1 a, body h1#login-designer-logo-h1 { margin-bottom: 0 }';
				}

				// Logo margin bottom.
				if ( isset( $options['logo_margin_bottom'] ) && ! empty( $options['logo'] ) ) {
					$css .= 'body.login #login h1 a, h1#login-designer-logo-h1 { margin-bottom: ' . esc_attr( $options['logo_margin_bottom'] ) . 'px; }';
				}

				// Form background color.
				if ( isset( $options['form_bg'] ) ) {
					$css .= '#loginform { background-color: ' . $options['form_bg'] . '; }';
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
				if ( isset( $options['form_shadow'] ) && isset( $options['form_shadow_opacity'] ) ) {

					$opacity = ( $options['form_shadow_opacity'] * .01 ) ? $options['form_shadow_opacity'] * .01 : 0;

					$css .= '#loginform { box-shadow: 0 0 '. esc_attr( $options['form_shadow'] ) .'px rgba(0, 0, 0, '. esc_attr( $opacity ) .'); }';
				}

				// Field background.
				if ( isset( $options['field_bg'] ) ) {
					$css .= '#loginform .input { background-color: ' . esc_attr( $options['field_bg'] ) . '; }';
				}

				// Field side padding.
				if ( isset( $options['field_side_padding'] ) ) {
					$css .= '#loginform .input { padding-left: ' . esc_attr( $options['field_side_padding'] ) . 'px; padding-right: ' . esc_attr( $options['field_side_padding'] ) . 'px; }';
				}

				// Field border width.
				if ( isset( $options['field_border'] ) ) {
					$css .= '#loginform .input { border-style: solid; border-width: ' . esc_attr( $options['field_border'] ) . 'px; }';
				}

				// Field border color.
				if ( isset( $options['field_border_color'] ) ) {
					$css .= '#loginform .input { border-color: ' . esc_attr( $options['field_border_color'] ) . '; }';
				}

				// Field border radius.
				if ( isset( $options['field_radius'] ) ) {
					$css .= '#loginform .input { border-radius: ' . esc_attr( $options['field_radius'] ) . 'px; }';
				}

				// Field box-shadow.
				if ( isset( $options['field_shadow'] ) || isset( $options['field_shadow_opacity'] ) ) {

					$opacity = ( $options['field_shadow_opacity'] * .01 ) ? $options['field_shadow_opacity'] * .01 : 0;

					$inset = isset( $options['field_shadow_inset'] ) ? 'inset' : '';

					$css .= '#loginform .input { box-shadow: ' . esc_attr( $inset ) . ' 0 0 '. esc_attr( $options['field_shadow'] ) .'px rgba(0, 0, 0, '. esc_attr( $opacity ) .'); }';
				}

				// Field font, as long as it's not 'default'.
				if ( isset( $options['field_font'] ) && ! 'default' !== $options['field_font'] ) {
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
				if ( isset( $options['label_font'] ) && ! 'default' !== $options['label_font'] ) {
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

				// Combine the values from above and minifiy them.
				$css = preg_replace( '#/\*.*?\*/#s', '', $css );
				$css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css );
				$css = preg_replace( '/\s\s+(.*)/', '$1', $css );

				// Add inline style.
				wp_add_inline_style( 'login', wp_strip_all_tags( $css ) );

			endif;
		}
	}

endif;

new Login_Designer_Customizer_Output();
