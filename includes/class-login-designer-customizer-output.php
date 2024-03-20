<?php
/**
 * Front-end styles for the Customizer options.
 *
 * @package Login Designer
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
			add_action( 'login_head', array( $this, 'login_form' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'customizer_css' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'enqueue_fonts' ) );
			add_filter( 'wp_resource_hints', array( $this, 'fonts_resource_hints' ), 10, 2 );
			add_action( 'wp_ajax_get_logo_info', array( $this, 'get_logo_info_callback' ) );
		}


		/**
		 * Custom Labels.
		 */
		public function login_form() {
			add_filter( 'gettext', array( $this, 'custom_username_label' ), 20, 3 );
			add_filter( 'gettext', array( $this, 'custom_password_label' ), 20, 3 );

			if ( isset( get_option( 'login_designer', array() )['remember_hide'] ) && get_option( 'login_designer', array() )['remember_hide'] ) {
				echo '<style type="text/css" class="login-designer-hide-rememberme">
				.forgetmenot {
					visibility: hidden;
				}
			</style>';
			}
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
		public function defaults() {
			$defaults = array(
				'bg_image'              => '',
				'bg_image_gallery'      => '',
				'bg_repeat'             => 'no-repeat',
				'bg_size'               => 'cover',
				'bg_position'           => 'center center',
				'bg_attach'             => 'fixed',
				'bg_color'              => '#f1f1f1',
				'logo'                  => '',
				'logo_width'            => '84',
				'logo_height'           => '84',
				'logo_margin_bottom'    => '25',
				'disable_logo'          => false,
				'form_bg'               => '#ffffff',
				'form_bg_transparency'  => false,
				'form_width'            => '320',
				'form_side_padding'     => '24',
				'form_vertical_padding' => '26',
				'form_radius'           => '0',
				'form_shadow'           => '3',
				'form_shadow_opacity'   => '13',
				'field_bg'              => '#fbfbfb',
				'field_padding_top'     => '3',
				'field_padding_bottom'  => '3',
				'field_side_padding'    => '12',
				'field_margin_bottom'   => '16',
				'field_border'          => '1',
				'field_border_color'    => '#dddddd',
				'field_radius'          => '0',
				'field_shadow'          => '2',
				'field_shadow_opacity'  => '7',
				'field_shadow_inset'    => true,
				'field_font'            => 'default',
				'field_font_size'       => '24',
				'field_color'           => '#32373c',
				'username_label'        => esc_html__( 'Username or Email Address', 'login-designer' ),
				'password_label'        => esc_html__( 'Password', 'login-designer' ),
				'label_font'            => 'default',
				'label_position'        => '2',
				'label_font_size'       => '14',
				'label_color'           => '#72777c',
				'button_bg'             => '#0085ba',
				'button_padding_top'    => '4',
				'button_padding_bottom' => '4',
				'button_side_padding'   => '12',
				'button_border'         => '1',
				'button_border_color'   => '#0073aa',
				'button_radius'         => '3',
				'button_shadow'         => '0',
				'button_shadow_opacity' => '0',
				'button_font'           => 'default',
				'button_font_size'      => '13',
				'button_color'          => '#ffffff',
				'lost_password'         => true,
				'back_to'               => true,
				'below_color'           => '#444',
				'below_position'        => '0',
				'below_font'            => 'default',
				'below_font_size'       => '13',
				'remember_color'        => '#72777c',
				'remember_font'         => 'default',
				'remember_font_size'    => '12',
				'remember_position'     => '5',
				'checkbox_size'         => '16',
				'checkbox_bg'           => '#fbfbfb',
				'checkbox_border'       => '1',
				'checkbox_border_color' => '#b4b9be',
				'checkbox_radius'       => '0',
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
			$options = get_option( 'login_designer_settings' );

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
		public function admin_defaults() {
			$admin_defaults = array(
				'login_designer_page' => '',
				'logo_url'            => '',
				'login_redirect'      => '',
				'logout_redirect'     => '',
				'login_message'       => '',
				'branding'            => false,
				'branding_position'   => 'right',
				'branding_color'      => '#444444',
				'branding_icon_color' => '#32373c',

			);

			return apply_filters( 'login_designer_settings_defaults', $admin_defaults );
		}

		/**
		 * Create a filter to for extenstions to add background collections.
		 *
		 * @return array $backgrounds
		 */
		public function extension_backgrounds() {
			$backgrounds = array();

			return apply_filters( 'login_designer_extension_background_options', $backgrounds );
		}

		/**
		 * Create a filter to for extenstions to add background collections.
		 *
		 * @return array $backgrounds
		 */
		public function extension_colors() {
			$colors = array();

			return apply_filters( 'login_designer_extension_color_options', $colors );
		}

		/**
		 * Retreive Google fonts from the Customizer options.
		 *
		 * @return string Google fonts URL for the theme.
		 */
		public function fonts() {
			$fonts_url = '';
			$fonts     = array();

			$field_font    = $this->option_wrapper( 'field_font' );
			$label_font    = $this->option_wrapper( 'label_font' );
			$button_font   = $this->option_wrapper( 'button_font' );
			$remember_font = $this->option_wrapper( 'remember_font' );
			$below_font    = $this->option_wrapper( 'below_font' );

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

			if ( $button_font ) {
				if ( 'default' !== $button_font ) {
					$fonts[] = $button_font;
				}
			}

			if ( $remember_font ) {
				if ( 'default' !== $remember_font ) {
					$fonts[] = $remember_font;
				}
			}

			if ( $below_font ) {
				if ( 'default' !== $below_font ) {
					$fonts[] = $below_font;
				}
			}

			if ( $fonts ) {
				$fonts_url = add_query_arg(
					array(
						'family' => rawurlencode( implode( '|', array_unique( $fonts ) ) ),
						'subset' => rawurlencode( 'latin,latin-ext' ),
					),
					'https://fonts.googleapis.com/css'
				);
			}

			return esc_url_raw( $fonts_url );
		}

		/**
		 * Register Google fonts from the Customizer.
		 */
		public function enqueue_fonts() {
			$css_url = get_option( 'login_designer_fonts_url', false );

			if ( empty( $css_url ) ) {
				$css_url = $this->fonts();
			}
			wp_enqueue_style( 'login-designer-fonts', $css_url, array(), LOGIN_DESIGNER_VERSION );
		}

		/**
		 * Add preconnect for Google Fonts.
		 *
		 * @param  array|array   $urls           URLs to print for resource hints.
		 * @param  string|string $relation_type  The relation type the URLs are printed.
		 * @return array|array   $urls           URLs to print for resource hints.
		 */
		public function fonts_resource_hints( $urls, $relation_type ) {
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
			$default = 'Username or Email Address';
			$options = get_option( 'login_designer' );
			$label   = $this->option_wrapper( 'username_label' );

			// If the option does not exist, return the text unchanged.
			if ( ! $options && $default === $text ) {
				return $translated_text;
			}

			// If options exsit, then translate away.
			if ( $options && $default === $text ) {

				// Check if the option exists.
				if ( isset( $options['username_label'] ) ) {
					$translated_text = esc_html( $label );
				} else {
					return $translated_text;
				}
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
			$default = 'Password';
			$options = get_option( 'login_designer' );
			$label   = $this->option_wrapper( 'password_label' );

			// If the option does not exist, return the text unchanged.
			if ( ! $options && $default === $text ) {
				return $translated_text;
			}

			// If options exsit, then translate away.
			if ( $options && $default === $text ) {

				// Check if the option exists.
				if ( isset( $options['password_label'] ) ) {
					$translated_text = esc_html( $label );
				} else {
					return $translated_text;
				}
			}

			return $translated_text;
		}

		/**
		 * Callback to retrieve the custom logo via AJAX from within the live previewer.
		 */
		public function get_logo_info_callback() {
			// phpcs:disable WordPress.Security.NonceVerification.Recommended
			if ( isset( $_REQUEST['method'] ) ) {
				$method = sanitize_text_field( wp_unslash( $_REQUEST['method'] ) );
				if ( 'login_form' === $method ) {
					$logo = $this->option_wrapper( 'logo' );
					$logo = wp_get_attachment_image_src( $logo, 'full' );
				}

				if ( 'password_protected_form' === $method ) {
					$logo = get_option( 'password_protected' );
					$logo = wp_get_attachment_image_src( $logo['logo'], 'full' );
				}

				wp_send_json(
					array(
						'done'   => 1,
						'url'    => esc_url( $logo[0] ),
						'width'  => absint( $logo[1] ),
						'height' => absint( $logo[2] ),
					)
				);
			}
			// phpcs:enable

			wp_die();
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

				#login-designer-sprite {
					display: none !important;
				}

				#login {
					width: 100%;
				}

				#login > p {
					text-align: center;
					padding: 0;
					margin: 10px 0;
				}

				#login form {
					border: 0;
					overflow: visible;
					margin-top: 0;
				}

				@media screen and (max-width: 600px) {
					#login form {
						margin-right: 10px;
						margin-left: 10px;
					}
				}

				#login form p.submit {
					padding-bottom: 25px !important;
					transform: initial !important;
				}

				#login form p label br {
					display: none;
				}

				#login form .forgetmenot {
					margin-top: 5px;
				}

				.wp-pwd {
					margin-bottom: 16px;
				}

				#user_pass {
					margin-bottom: 0;
				}

				.login .button.wp-hide-pw {
					line-height: 1;
					bottom: 0;
					height: calc(100% - 5px);
					top: 5px;
				}

				.login .button.wp-hide-pw .dashicons {
					top: 0;
				}

				#login-designer-logo-h1 {
					margin-right: auto;
					margin-left: auto;
				}

				#login-designer-logo {
					transition-duration: 0;
				}

				#login h1 a:focus {
					box-shadow: none;
				}

				#login input[type=checkbox] {
					box-shadow: none;
				}

				#login input[type=checkbox]:checked:before {
					font: 400 24px/1 dashicons;
					margin: -4px -6px;
				}

				#login form .submit .button {
					box-shadow: none;
					text-shadow: none;
					height: auto !important;
					line-height: inherit;
					transform: translateY(0px) !important;
				}

				#login-designer--below-form {
					text-align: center;
				}

				#login .message {
					background: transparent;
					border: 0;
					box-shadow: none;
					padding: 5px 0;
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
					$image = wp_get_attachment_image_src( $options['logo'], 'full' );

					if ( $image ) {
						$width  = isset( $options['logo_width'] ) ? $options['logo_width'] : $image[1] / 2;
						$height = isset( $options['logo_height'] ) ? $options['logo_height'] : $image[2] / 2;

						$css .= '

						#login h1 a { width: auto; }

						#login-designer-logo,
						body.login #login h1 a {
							background-image: url(" ' . esc_url( $image[0] ) . ' ");
							background-position: center center;
						}

						#login-designer-logo-h1,
						body.login #login h1 a {
							margin-left: auto;
							margin-right: auto;
						}

						#login-designer-logo,
						body.login #login h1 a {
							background-size: ' . absint( $width ) . 'px ' . absint( $height ) . 'px ;
						}

						#login-designer-logo-h1,
						body.login #login h1 a {
							width: ' . absint( $width ) . 'px;
							height: ' . absint( $height ) . 'px;
						}

						#login-designer-logo-h1 {
							width: ' . absint( $width ) . 'px !important;
						}
					';
					}
				}

				// Logo display.
				if ( isset( $options['disable_logo'] ) && true === $options['disable_logo'] ) {
					$css .= 'body.login #login h1 a { display: none; } #login-designer-logo-h1 { height: 0;}';
					$css .= 'body.login #login h1 a, body #login-designer-logo-h1 { margin-bottom: 0 }';
				}

				// Logo margin bottom.
				if ( isset( $options['logo_margin_bottom'] ) ) {
					$css .= 'body.login #login h1 a, #login-designer-logo-h1 { margin-bottom: ' . esc_attr( $options['logo_margin_bottom'] ) . 'px !important ; }';
				}

				// Form background color.
				if ( isset( $options['form_bg'] ) ) {
					$css .= '#login form, .login-designer-template-01 #login, .login-designer-template-04 #login { background-color: ' . $options['form_bg'] . '; }';
				}

				// Form background transparency.
				if ( true === isset( $options['form_bg_transparency'] ) ) {
					$css .= '#login form, .login-designer-template-01 #login, .login-designer-template-04 #login { background: none; }';
				}

				// Form width.
				if ( isset( $options['form_width'] ) ) {
					$css .= '#login { max-width: ' . esc_attr( $options['form_width'] ) . 'px; }';
				}

				// Form side padding.
				if ( isset( $options['form_side_padding'] ) ) {
					$css .= '#login form { padding-left: ' . esc_attr( $options['form_side_padding'] ) . 'px; padding-right: ' . esc_attr( $options['form_side_padding'] ) . 'px; }';
				}

				// Form side padding.
				if ( isset( $options['form_vertical_padding'] ) ) {
					$css .= '#login form { padding-top: ' . esc_attr( $options['form_vertical_padding'] ) . 'px; padding-bottom: ' . esc_attr( $options['form_vertical_padding'] ) . 'px; }';
				}

				// Form side padding.
				if ( isset( $options['form_radius'] ) ) {
					$css .= '#login form { border-radius: ' . esc_attr( $options['form_radius'] ) . 'px; }';
				}

				// Form box-shadow.
				if ( isset( $options['form_shadow'] ) ) {
					$opacity = ( isset( $options['form_shadow_opacity'] ) * .01 ) ? $options['form_shadow_opacity'] * .01 : 0;

					$css .= '#login form { box-shadow: 0 0 ' . esc_attr( $options['form_shadow'] ) . 'px rgba(0, 0, 0, ' . esc_attr( $opacity ) . '); }';
				} else {
					$css .= '#login form { box-shadow: none; }';
				}

				// Field background.
				if ( isset( $options['field_bg'] ) ) {
					$css .= '#login form .input { background-color: ' . esc_attr( $options['field_bg'] ) . '; -webkit-box-shadow: inset 0 0 0px 9999px ' . esc_attr( $options['field_bg'] ) . ' }';
				}

				// Field top padding.
				if ( isset( $options['field_padding_top'] ) ) {
					$css .= '#login form .input { padding-top: ' . esc_attr( $options['field_padding_top'] ) . 'px; }';
				}

				// Field bottom padding.
				if ( isset( $options['field_padding_bottom'] ) ) {
					$css .= '#login form .input { padding-bottom: ' . esc_attr( $options['field_padding_bottom'] ) . 'px; }';
				}

				// Field side padding.
				if ( isset( $options['field_side_padding'] ) ) {
					$css .= '#login form .input { padding-left: ' . esc_attr( $options['field_side_padding'] ) . 'px; }';
				}

				// Field margin bottom.
				if ( isset( $options['field_margin_bottom'] ) ) {
					if ( is_customize_preview() ) {
						$css .= '#login-designer--username, #login-designer--password { margin-bottom: ' . esc_attr( $options['field_margin_bottom'] ) . 'px }';
					} else {
						$css .= '#login form #user_login, #login form .wp-pwd { margin-bottom: ' . esc_attr( $options['field_margin_bottom'] ) . 'px; }';
					}
				}

				// Field border width.
				if ( isset( $options['field_border'] ) ) {
					$css .= '#login form .input { border-style: solid; border-width: ' . esc_attr( $options['field_border'] ) . 'px; }';
				} else {
					$css .= '#login form .input { border: 0 }';
				}

				// Field border color.
				if ( isset( $options['field_border_color'] ) ) {
					$css .= '#login form .input { border-color: ' . esc_attr( $options['field_border_color'] ) . '; }';
				}

				// Field border radius.
				if ( isset( $options['field_radius'] ) ) {
					$css .= '#login form .input, #login form div .login-designer-event-button { border-radius: ' . esc_attr( $options['field_radius'] ) . 'px; }';
				}

				// Field box-shadow.
				if ( isset( $options['field_shadow'] ) ) {
					$opacity = ( isset( $options['field_shadow_opacity'] ) * .01 ) ? $options['field_shadow_opacity'] * .01 : 0;

					$inset = isset( $options['field_shadow_inset'] ) ? 'inset' : '';

					$shadow = esc_attr( $inset ) . ' 0 0 ' . esc_attr( $options['field_shadow'] ) . 'px rgba(0, 0, 0, ' . esc_attr( $opacity ) . ')';

					if ( isset( $options['field_bg'] ) ) {
						$css .= '#login form .input { box-shadow: ' . $shadow . ', inset 0 0 0 9999px ' . esc_attr( $options['field_bg'] ) . ' }';
					} else {
						$css .= '#login form .input { box-shadow: ' . $shadow;
					}
				} else {
					if ( isset( $options['field_bg'] ) ) {
						$css .= '#login form .input { box-shadow: inset 0 0 0 9999px ' . esc_attr( $options['field_bg'] ) . ' }';
					} else {
						$css .= '#login form .input { box-shadow: none; }';
					}
				}

				// Field font, as long as it's not 'default'.
				if ( isset( $options['field_font'] ) && 'default' !== $options['field_font'] ) {
					$css .= '#login form .input { font-family: ' . esc_attr( $options['field_font'] ) . '; }';
				}

				// Field font size.
				if ( isset( $options['field_font_size'] ) ) {
					$css .= '#login form .input { font-size: ' . esc_attr( $options['field_font_size'] ) . 'px }';
				}

				// Field font color.
				if ( isset( $options['field_color'] ) ) {
					$css .= '#login form .input { color: ' . esc_attr( $options['field_color'] ) . ' }';
					$css .= '#login .button.wp-hide-pw { color: ' . esc_attr( $options['field_color'] ) . '; }';
					$css .= '#login .button.wp-hide-pw:focus { border-color: currentColor; box-shadow: 0 0 0 1px currentColor; }';
				}

				// Label font, as long as it's not 'default'.
				if ( isset( $options['label_font'] ) && 'default' !== $options['label_font'] ) {
					$css .= '#login form label:not([for=rememberme]), #login .message { font-family: ' . esc_attr( $options['label_font'] ) . '; }';
				}

				// Label font size.
				if ( isset( $options['label_font_size'] ) ) {
					$css .= '#login form label:not([for=rememberme]), #login .message { font-size: ' . esc_attr( $options['label_font_size'] ) . 'px }';
				}

				// Label font color.
				if ( isset( $options['label_color'] ) ) {
					$css .= '#login form label:not([for=rememberme]), #login .message { color: ' . esc_attr( $options['label_color'] ) . ' }';
				}

				// Label position.
				if ( isset( $options['label_position'] ) ) {
					$css .= '#login form .input { margin-top: ' . esc_attr( $options['label_position'] ) . 'px }';

					if ( is_customize_preview() ) {
						$css .= '#login form div .login-designer-event-button { top: ' . esc_attr( $options['label_position'] ) . 'px }';
					}
				}

				// Button background color.
				if ( isset( $options['button_bg'] ) ) {
					$css .= '#login form .submit .button { background-color: ' . $options['button_bg'] . '; }';
				}

				// Button top padding.
				if ( isset( $options['button_padding_top'] ) ) {
					$css .= '#login form .submit .button { padding-top: ' . esc_attr( $options['button_padding_top'] ) . 'px; }';
				}

				// Button bottom padding.
				if ( isset( $options['button_padding_bottom'] ) ) {
					$css .= '#login form .submit .button { padding-bottom: ' . esc_attr( $options['button_padding_bottom'] ) . 'px; }';
				}

				// Button side padding.
				if ( isset( $options['button_side_padding'] ) ) {
					$css .= '#login form .submit .button { padding-left: ' . esc_attr( $options['button_side_padding'] ) . 'px; padding-right: ' . esc_attr( $options['button_side_padding'] ) . 'px; }';
				}

				// Button border width.
				if ( isset( $options['button_border'] ) ) {
					$css .= '#login form .submit .button { border-style: solid; border-width: ' . esc_attr( $options['button_border'] ) . 'px; }';
				} else {
					$css .= '#login form .submit .button { border: 0 }';
				}

				// Button border color.
				if ( isset( $options['button_border_color'] ) ) {
					$css .= '#login form .submit .button { border-color: ' . $options['button_border_color'] . '; }';
				}

				// Button border radius.
				if ( isset( $options['button_radius'] ) ) {
					$css .= '#login form .submit .button, #login form .submit .login-designer-event-button { border-radius: ' . esc_attr( $options['button_radius'] ) . 'px; }';
				}

				// Field box-shadow.
				if ( isset( $options['button_shadow'] ) ) {
					$opacity = ( isset( $options['button_shadow_opacity'] ) * .01 ) ? $options['button_shadow_opacity'] * .01 : 0;

					$css .= '#login form .submit .button { box-shadow: 0 0 ' . esc_attr( $options['button_shadow'] ) . 'px rgba(0, 0, 0, ' . esc_attr( $opacity ) . '); }';
				}

				// Button font, as long as it's not 'default'.
				if ( isset( $options['button_font'] ) && 'default' !== $options['button_font'] ) {
					$css .= '#login form .submit .button { font-family: ' . esc_attr( $options['button_font'] ) . '; }';
				}

				// Button font size.
				if ( isset( $options['button_font_size'] ) ) {
					$css .= '#login form .submit .button { font-size: ' . esc_attr( $options['button_font_size'] ) . 'px }';
				}

				// Button font color.
				if ( isset( $options['button_color'] ) ) {
					$css .= '#login form .submit .button { color: ' . esc_attr( $options['button_color'] ) . ' }';
				}

				// Lost Password.
				if ( false === isset( $options['lost_password'] ) ) {
					if ( is_customize_preview() ) {
						$css .= '#login #nav { opacity: 0; }';
					} else {
						$css .= '#login #nav { display: none; }';
					}
				}

				// Back to blog.
				if ( false === isset( $options['back_to'] ) ) {
					if ( is_customize_preview() ) {
						$css .= '#login #backtoblog { opacity: 0; }';
					} else {
						$css .= '#login #backtoblog { display: none; }';
					}
				}

				// Remember font, as long as it's not 'default'.
				if ( isset( $options['remember_font'] ) && 'default' !== $options['remember_font'] ) {
					$css .= '#login .forgetmenot label { font-family: ' . esc_attr( $options['remember_font'] ) . '; }';
				}

				// Remember font size.
				if ( isset( $options['remember_font_size'] ) ) {
					$css .= '#login .forgetmenot label { font-size: ' . esc_attr( $options['remember_font_size'] ) . 'px }';
				}

				// Remember color.
				if ( isset( $options['remember_color'] ) ) {
					$css .= '#login .forgetmenot label { color: ' . esc_attr( $options['remember_color'] ) . ' }';
				}

				// Remember positioning.
				if ( isset( $options['remember_position'] ) ) {
					$css .= '#login form .forgetmenot { margin-top: ' . esc_attr( $options['remember_position'] ) . 'px }';
				}

				// Checkbox size.
				if ( isset( $options['checkbox_size'] ) ) {
					$css .= '#login form input[type=checkbox] { height: ' . esc_attr( $options['checkbox_size'] ) . 'px;  width: ' . esc_attr( $options['checkbox_size'] ) . 'px }';
				}

				// Checkbox border width.
				if ( isset( $options['checkbox_border'] ) ) {
					$css .= '#login form input[type=checkbox] { border-style: solid; border-width: ' . esc_attr( $options['checkbox_border'] ) . 'px; }';
				} else {
					$css .= '#login form input[type=checkbox] { border: 0 }';
				}

				// Checkbox border color.
				if ( isset( $options['checkbox_border_color'] ) ) {
					$css .= '#login form input[type=checkbox] { border-color: ' . $options['checkbox_border_color'] . '; }';
				}

				// Checkbox border radius.
				if ( isset( $options['checkbox_radius'] ) ) {
					$css .= '#login form input[type=checkbox] { border-radius: ' . esc_attr( $options['checkbox_radius'] ) . 'px; }';
				}

				// Checkbox background.
				if ( isset( $options['checkbox_bg'] ) ) {
					$css .= '#login form input[type=checkbox] { background-color: ' . esc_attr( $options['checkbox_bg'] ) . '; }';
				}

				// Below form color.
				if ( isset( $options['below_color'] ) ) {
					$css .= '#login #nav, #login #nav a, #login #backtoblog a { color: ' . esc_attr( $options['below_color'] ) . ' }';
				}

				// Below form positioning.
				if ( isset( $options['below_position'] ) ) {
					$css .= '.login #login form + p, #login-designer--below-form { margin-top: ' . esc_attr( $options['below_position'] ) . 'px }';
				}

				// Below form font, as long as it's not 'default'.
				if ( isset( $options['below_font'] ) && 'default' !== $options['below_font'] ) {
					$css .= '#login #nav, #login #nav a, #login #backtoblog a { font-family: ' . esc_attr( $options['below_font'] ) . '; }';
				}

				// Below form font size.
				if ( isset( $options['below_font_size'] ) ) {
					$css .= '#login #nav, #login #nav a, #login #backtoblog a { font-size: ' . esc_attr( $options['below_font_size'] ) . 'px }';
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
