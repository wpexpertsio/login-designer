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
				'bg_image_gallery'      => '', //not going to add
				'bg_repeat'             => 'no-repeat', //not going to add
				'bg_size'               => 'cover', //not going to add
				'bg_position'           => 'center center', //not going to add
				'bg_attach'             => 'fixed', //not going to add
				'bg_color'              => '#f1f1f1',
				'logo'                  => '', //added
				'logo_width'            => '84', //added
				'logo_height'           => '84', //added
				'logo_margin_bottom'    => '25', //added
				'disable_logo'          => false, //added
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
			wp_enqueue_style( 'login-designer-fonts', $this->fonts(), array(), LOGIN_DESIGNER_VERSION );
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
			$logo = $this->option_wrapper( 'logo' );
			$logo = wp_get_attachment_image_src( $logo, 'full' );

			wp_send_json(
				array(
					'done'   => 1,
					'url'    => esc_url( $logo[0] ),
					'width'  => absint( $logo[1] ),
					'height' => absint( $logo[2] ),
				)
			);

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

			$css = '';

			if ( ! empty( $options ) ) :

				// Output CSS Custom Properties
				$css .= ':root{ ';
					if ( isset( $options['bg_color'] ) ) {
						$css .= '--ld-backgroundcolor: ' . esc_attr( $options['bg_color'] ) . ';';
					}

					if ( isset( $options['bg_image'] ) ) {
						$css .= '--ld-backgroundimage: ' . esc_attr( $options['bg_image'] ) . ';';
					}

					if ( isset( $options['logo'] ) ) {
						$css .= '--ld-logo: url(' . esc_attr( $options['logo'] ) . ');';

						if ( isset( $options['logo_width'] ) ) {
							$css .= '--ld-logo-width: ' . esc_attr( $options['logo_width'] ) . 'px; }';
						}

						if ( isset( $options['logo_height'] ) ) {
							$css .= '--ld-logo-height: ' . esc_attr( $options['logo_height'] ) . 'px; }';
						}
					}

					if ( isset( $options['disable_logo'] ) && true === $options['disable_logo'] ) {
						$css .= '--ld-logo-display: none;';
						$css .= '--ld-logo-spacing: 0;';
					}

					if ( isset( $options['logo_margin_bottom'] ) ) {
						$css .= '--ld-logo-spacing: ' . esc_attr( $options['logo_margin_bottom'] ) . 'px;';
					}

					if ( isset( $options['form_bg'] ) ) {
						$css .= '--ld-form-backgroundcolor: ' . esc_attr( $options['form_bg'] ) . ';';
					}

					if ( isset( $options['form_width'] ) ) {
						$css .= '--ld-form-width: ' . esc_attr( $options['form_bg'] ) . ';';
					}

					if ( isset( $options['form_side_padding'] ) ) {
						$css .= '--ld-form-padding-x: ' . esc_attr( $options['form_side_padding'] ) . 'px; }';
					}

					if ( isset( $options['form_vertical_padding'] ) ) {
						$css .= '--ld-form-padding-y: ' . esc_attr( $options['form_vertical_padding'] ) . 'px; }';
					}

					if ( isset( $options['form_radius'] ) ) {
						$css .= '--ld-form-radius: ' . esc_attr( $options['form_radius'] ) . 'px; }';
					}

					if ( isset( $options['field_bg'] ) ) {
						$css .= '--ld-input-backgroundcolor: ' . esc_attr( $options['field_bg'] ) . '; }';
					}


			// 	// Form box-shadow.
			// 	if ( isset( $options['form_shadow'] ) ) {
			// 		$opacity = ( isset( $options['form_shadow_opacity'] ) * .01 ) ? $options['form_shadow_opacity'] * .01 : 0;

			// 		$css .= '#login form { box-shadow: 0 0 ' . esc_attr( $options['form_shadow'] ) . 'px rgba(0, 0, 0, ' . esc_attr( $opacity ) . '); }';
			// 	} else {
			// 		$css .= '#login form { box-shadow: none; }';
			// 	}

			// 	// Field top padding.
			// 	if ( isset( $options['field_padding_top'] ) ) {
			// 		$css .= '#login form .input { padding-top: ' . esc_attr( $options['field_padding_top'] ) . 'px; }';
			// 	}

			// 	// Field bottom padding.
			// 	if ( isset( $options['field_padding_bottom'] ) ) {
			// 		$css .= '#login form .input { padding-bottom: ' . esc_attr( $options['field_padding_bottom'] ) . 'px; }';
			// 	}

			// 	// Field side padding.
			// 	if ( isset( $options['field_side_padding'] ) ) {
			// 		$css .= '#login form .input { padding-left: ' . esc_attr( $options['field_side_padding'] ) . 'px; }';
			// 	}

			// 	// Field margin bottom.
			// 	if ( isset( $options['field_margin_bottom'] ) ) {
			// 		if ( is_customize_preview() ) {
			// 			$css .= '#login-designer--username { margin-bottom: ' . esc_attr( $options['field_margin_bottom'] ) . 'px }';
			// 		} else {
			// 			$css .= '#login form #user_login { margin-bottom: ' . esc_attr( $options['field_margin_bottom'] ) . 'px; }';
			// 		}
			// 	}

			// 	// Field border width.
			// 	if ( isset( $options['field_border'] ) ) {
			// 		$css .= '#login form .input { border-style: solid; border-width: ' . esc_attr( $options['field_border'] ) . 'px; }';
			// 	} else {
			// 		$css .= '#login form .input { border: 0 }';
			// 	}

			// 	// Field border color.
			// 	if ( isset( $options['field_border_color'] ) ) {
			// 		$css .= '#login form .input { border-color: ' . esc_attr( $options['field_border_color'] ) . '; }';
			// 	}

			// 	// Field border radius.
			// 	if ( isset( $options['field_radius'] ) ) {
			// 		$css .= '#login form .input, #login form div .login-designer-event-button { border-radius: ' . esc_attr( $options['field_radius'] ) . 'px; }';
			// 	}

			// 	// Field box-shadow.
			// 	if ( isset( $options['field_shadow'] ) ) {
			// 		$opacity = ( isset( $options['field_shadow_opacity'] ) * .01 ) ? $options['field_shadow_opacity'] * .01 : 0;

			// 		$inset = isset( $options['field_shadow_inset'] ) ? 'inset' : '';

			// 		$shadow = esc_attr( $inset ) . ' 0 0 ' . esc_attr( $options['field_shadow'] ) . 'px rgba(0, 0, 0, ' . esc_attr( $opacity ) . ')';

			// 		if ( isset( $options['field_bg'] ) ) {
			// 			$css .= '#login form .input { box-shadow: ' . $shadow . ', inset 0 0 0 9999px ' . esc_attr( $options['field_bg'] ) . ' }';
			// 		} else {
			// 			$css .= '#login form .input { box-shadow: ' . $shadow;
			// 		}
			// 	} else {
			// 		if ( isset( $options['field_bg'] ) ) {
			// 			$css .= '#login form .input { box-shadow: inset 0 0 0 9999px ' . esc_attr( $options['field_bg'] ) . ' }';
			// 		} else {
			// 			$css .= '#login form .input { box-shadow: none; }';
			// 		}
			// 	}

			// 	// Field font, as long as it's not 'default'.
			// 	if ( isset( $options['field_font'] ) && 'default' !== $options['field_font'] ) {
			// 		$css .= '#login form .input { font-family: ' . esc_attr( $options['field_font'] ) . '; }';
			// 	}

			// 	// Field font size.
			// 	if ( isset( $options['field_font_size'] ) ) {
			// 		$css .= '#login form .input { font-size: ' . esc_attr( $options['field_font_size'] ) . 'px }';
			// 	}

			// 	// Field font color.
			// 	if ( isset( $options['field_color'] ) ) {
			// 		$css .= '#login form .input { color: ' . esc_attr( $options['field_color'] ) . ' }';
			// 		$css .= '#login .button.wp-hide-pw { color: ' . esc_attr( $options['field_color'] ) . '; }';
			// 		$css .= '#login .button.wp-hide-pw:focus { border-color: currentColor; box-shadow: 0 0 0 1px currentColor; }';
			// 	}

			// 	// Label font, as long as it's not 'default'.
			// 	if ( isset( $options['label_font'] ) && 'default' !== $options['label_font'] ) {
			// 		$css .= '#login form label:not([for=rememberme]), #login .message { font-family: ' . esc_attr( $options['label_font'] ) . '; }';
			// 	}

			// 	// Label font size.
			// 	if ( isset( $options['label_font_size'] ) ) {
			// 		$css .= '#login form label:not([for=rememberme]), #login .message { font-size: ' . esc_attr( $options['label_font_size'] ) . 'px }';
			// 	}

			// 	// Label font color.
			// 	if ( isset( $options['label_color'] ) ) {
			// 		$css .= '#login form label:not([for=rememberme]), #login .message { color: ' . esc_attr( $options['label_color'] ) . ' }';
			// 	}

			// 	// Label position.
			// 	if ( isset( $options['label_position'] ) ) {
			// 		$css .= '#login form .input { margin-top: ' . esc_attr( $options['label_position'] ) . 'px }';

			// 		if ( is_customize_preview() ) {
			// 			$css .= '#login form div .login-designer-event-button { top: ' . esc_attr( $options['label_position'] ) . 'px }';
			// 		}
			// 	}

			// 	// Button background color.
			// 	if ( isset( $options['button_bg'] ) ) {
			// 		$css .= '#login form .submit .button { background-color: ' . $options['button_bg'] . '; }';
			// 	}

			// 	// Button top padding.
			// 	if ( isset( $options['button_padding_top'] ) ) {
			// 		$css .= '#login form .submit .button { padding-top: ' . esc_attr( $options['button_padding_top'] ) . 'px; }';
			// 	}

			// 	// Button bottom padding.
			// 	if ( isset( $options['button_padding_bottom'] ) ) {
			// 		$css .= '#login form .submit .button { padding-bottom: ' . esc_attr( $options['button_padding_bottom'] ) . 'px; }';
			// 	}

			// 	// Button side padding.
			// 	if ( isset( $options['button_side_padding'] ) ) {
			// 		$css .= '#login form .submit .button { padding-left: ' . esc_attr( $options['button_side_padding'] ) . 'px; padding-right: ' . esc_attr( $options['button_side_padding'] ) . 'px; }';
			// 	}

			// 	// Button border width.
			// 	if ( isset( $options['button_border'] ) ) {
			// 		$css .= '#login form .submit .button { border-style: solid; border-width: ' . esc_attr( $options['button_border'] ) . 'px; }';
			// 	} else {
			// 		$css .= '#login form .submit .button { border: 0 }';
			// 	}

			// 	// Button border color.
			// 	if ( isset( $options['button_border_color'] ) ) {
			// 		$css .= '#login form .submit .button { border-color: ' . $options['button_border_color'] . '; }';
			// 	}

			// 	// Button border radius.
			// 	if ( isset( $options['button_radius'] ) ) {
			// 		$css .= '#login form .submit .button, #login form .submit .login-designer-event-button { border-radius: ' . esc_attr( $options['button_radius'] ) . 'px; }';
			// 	}

			// 	// Field box-shadow.
			// 	if ( isset( $options['button_shadow'] ) ) {
			// 		$opacity = ( isset( $options['button_shadow_opacity'] ) * .01 ) ? $options['button_shadow_opacity'] * .01 : 0;

			// 		$css .= '#login form .submit .button { box-shadow: 0 0 ' . esc_attr( $options['button_shadow'] ) . 'px rgba(0, 0, 0, ' . esc_attr( $opacity ) . '); }';
			// 	}

			// 	// Button font, as long as it's not 'default'.
			// 	if ( isset( $options['button_font'] ) && 'default' !== $options['button_font'] ) {
			// 		$css .= '#login form .submit .button { font-family: ' . esc_attr( $options['button_font'] ) . '; }';
			// 	}

			// 	// Button font size.
			// 	if ( isset( $options['button_font_size'] ) ) {
			// 		$css .= '#login form .submit .button { font-size: ' . esc_attr( $options['button_font_size'] ) . 'px }';
			// 	}

			// 	// Button font color.
			// 	if ( isset( $options['button_color'] ) ) {
			// 		$css .= '#login form .submit .button { color: ' . esc_attr( $options['button_color'] ) . ' }';
			// 	}

			// 	// Lost Password.
			// 	if ( false === isset( $options['lost_password'] ) ) {
			// 		if ( is_customize_preview() ) {
			// 			$css .= '#login #nav { opacity: 0; }';
			// 		} else {
			// 			$css .= '#login #nav { display: none; }';
			// 		}
			// 	}

			// 	// Back to blog.
			// 	if ( false === isset( $options['back_to'] ) ) {
			// 		if ( is_customize_preview() ) {
			// 			$css .= '#login #backtoblog { opacity: 0; }';
			// 		} else {
			// 			$css .= '#login #backtoblog { display: none; }';
			// 		}
			// 	}

			// 	// Remember font, as long as it's not 'default'.
			// 	if ( isset( $options['remember_font'] ) && 'default' !== $options['remember_font'] ) {
			// 		$css .= '#login .forgetmenot label { font-family: ' . esc_attr( $options['remember_font'] ) . '; }';
			// 	}

			// 	// Remember font size.
			// 	if ( isset( $options['remember_font_size'] ) ) {
			// 		$css .= '#login .forgetmenot label { font-size: ' . esc_attr( $options['remember_font_size'] ) . 'px }';
			// 	}

			// 	// Remember color.
			// 	if ( isset( $options['remember_color'] ) ) {
			// 		$css .= '#login .forgetmenot label { color: ' . esc_attr( $options['remember_color'] ) . ' }';
			// 	}

			// 	// Remember positioning.
			// 	if ( isset( $options['remember_position'] ) ) {
			// 		$css .= '#login form .forgetmenot { margin-top: ' . esc_attr( $options['remember_position'] ) . 'px }';
			// 	}

			// 	// Checkbox size.
			// 	if ( isset( $options['checkbox_size'] ) ) {
			// 		$css .= '#login form input[type=checkbox] { height: ' . esc_attr( $options['checkbox_size'] ) . 'px;  width: ' . esc_attr( $options['checkbox_size'] ) . 'px }';
			// 	}

			// 	// Checkbox border width.
			// 	if ( isset( $options['checkbox_border'] ) ) {
			// 		$css .= '#login form input[type=checkbox] { border-style: solid; border-width: ' . esc_attr( $options['checkbox_border'] ) . 'px; }';
			// 	} else {
			// 		$css .= '#login form input[type=checkbox] { border: 0 }';
			// 	}

			// 	// Checkbox border color.
			// 	if ( isset( $options['checkbox_border_color'] ) ) {
			// 		$css .= '#login form input[type=checkbox] { border-color: ' . $options['checkbox_border_color'] . '; }';
			// 	}

			// 	// Checkbox border radius.
			// 	if ( isset( $options['checkbox_radius'] ) ) {
			// 		$css .= '#login form input[type=checkbox] { border-radius: ' . esc_attr( $options['checkbox_radius'] ) . 'px; }';
			// 	}

			// 	// Checkbox background.
			// 	if ( isset( $options['checkbox_bg'] ) ) {
			// 		$css .= '#login form input[type=checkbox] { background-color: ' . esc_attr( $options['checkbox_bg'] ) . '; }';
			// 	}

			// 	// Below form color.
			// 	if ( isset( $options['below_color'] ) ) {
			// 		$css .= '#login #nav, #login #nav a, #login #backtoblog a { color: ' . esc_attr( $options['below_color'] ) . ' }';
			// 	}

			// 	// Below form positioning.
			// 	if ( isset( $options['below_position'] ) ) {
			// 		$css .= '.login #login form + p, #login-designer--below-form { margin-top: ' . esc_attr( $options['below_position'] ) . 'px }';
			// 	}

			// 	// Below form font, as long as it's not 'default'.
			// 	if ( isset( $options['below_font'] ) && 'default' !== $options['below_font'] ) {
			// 		$css .= '#login #nav, #login #nav a, #login #backtoblog a { font-family: ' . esc_attr( $options['below_font'] ) . '; }';
			// 	}

			// 	// Below form font size.
			// 	if ( isset( $options['below_font_size'] ) ) {
			// 		$css .= '#login #nav, #login #nav a, #login #backtoblog a { font-size: ' . esc_attr( $options['below_font_size'] ) . 'px }';
			// 	}
				$css .= '}';
			endif;

			// // Combine the values from above and minifiy them.
			// $css = preg_replace( '#/\*.*?\*/#s', '', $css );
			// $css = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $css );
			// $css = preg_replace( '/\s\s+(.*)/', '$1', $css );

			// Add inline style.
			wp_add_inline_style( 'login', wp_strip_all_tags( $css ) );
		}
	}

endif;

new Login_Designer_Customizer_Output();
