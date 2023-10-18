<?php
/**
 * Customizer functionality
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Customizer' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Customizer {

		/**
		 * The class constructor.
		 */
		public function __construct() {
			add_action( 'body_class', array( $this, 'body_class' ) );
			add_action( 'login_body_class', array( $this, 'body_class' ) );
			add_action( 'customize_register', array( $this, 'customize_register' ), 11 );
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

			if ( is_customize_preview() ) {
				if ( is_page_template( 'template-login-designer.php' ) ) {
					$classes[] = 'login-designer';
				}
				if ( is_page_template( 'template-password-protected.php' ) ) {
					$classes[] = 'password-protected';
				}
			}

			return $classes;
		}

		/**
		 * Register Customizer Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize the Customizer object.
		 */
		public function customize_register( $wp_customize ) {

			// Return early if the class is missing.
			if ( ! class_exists( 'Login_Designer_Customizer_Output' ) ) {
				return;
			}

			// Add custom section.
			require_once LOGIN_DESIGNER_CUSTOMIZE_SECTIONS_DIR . 'class-login-designer-section.php';

			// Register custom section.
			$wp_customize->register_section_type( 'Login_Designer_Section' );

			// Add custom controls.
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-range-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-toggle-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-template-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-title-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-gallery-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-upgrade-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-license-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-file-import-button-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-dummy-control.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-test-recaptcha.php';
			require_once LOGIN_DESIGNER_CUSTOMIZE_CONTROLS_DIR . 'class-login-designer-localize-google-fonts.php';

			// Register the control types that we're using as JavaScript controls.
			if ( class_exists( 'Login_Designer_Toggle_Control' ) ) {
				$wp_customize->register_control_type( 'Login_Designer_Toggle_Control' );
			}
			if ( class_exists( 'Login_Designer_Range_Control' ) ) {
				$wp_customize->register_control_type( 'Login_Designer_Range_Control' );
			}
			if ( class_exists( 'Login_Designer_Title_Control' ) ) {
				$wp_customize->register_control_type( 'Login_Designer_Title_Control' );
			}
			if ( class_exists( 'Login_Designer_Gallery_Control' ) ) {
				$wp_customize->register_control_type( 'Login_Designer_Gallery_Control' );
			}
			if ( class_exists( 'Login_Designer_Template_Control' ) ) {
				$wp_customize->register_control_type( 'Login_Designer_Template_Control' );
			}
			if ( class_exists( 'Login_Designer_Dummy_Control' ) ) {
				$wp_customize->register_control_type( 'Login_Designer_Dummy_Control' );
			}

			if ( class_exists( 'Login_Designer_Test_Recaptcha' ) ) {
				$wp_customize->register_control_type( 'Login_Designer_Test_Recaptcha' );
			}

			if ( class_exists( 'Login_Designer_Localize_Google_Fonts' ) ) {
				$wp_customize->register_control_type( 'Login_Designer_Localize_Google_Fonts' );
			}

			// Get the default options.
			$defaults = new Login_Designer_Customizer_Output();
			$defaults = $defaults->defaults();

			// Get the admin default options.
			$admin_defaults = new Login_Designer_Customizer_Output();
			$admin_defaults = $admin_defaults->admin_defaults();

			/**
			 * Add the main panel and sections.
			 */
			$wp_customize->add_panel(
				'login_designer',
				array(
					'title'       => esc_html__( 'Login Designer', 'login-designer' ),
					'capability'  => 'edit_theme_options',
					'description' => esc_html__( 'Click the Templates icon at the top left of the preview window to change your template. To customize further, simply click on any element, or it\'s corresponding shortcut icon, to edit it\'s styling. ', 'login-designer' ),
					'priority'    => 150,
				)
			);

			// Style Editor (Initially hidden from the Customizer).
			$wp_customize->add_section(
				'login_designer__section--styles',
				array(
					'title' => esc_html__( 'Styles', 'login-designer' ),
					'panel' => 'login_designer',
				)
			);

			// Templates.
			$wp_customize->add_section(
				'login_designer__section--templates',
				array(
					'title' => esc_html__( 'Templates', 'login-designer' ),
					'panel' => 'login_designer',
				)
			);

			// Settings.
			$wp_customize->add_section(
				'login_designer__section--settings',
				array(
					'title' => esc_html__( 'Branding', 'login-designer' ),
					'panel' => 'login_designer',
				)
			);

			// @todo need to add new Tag to the following sections.
			$wp_customize->add_section(
				new Login_Designer_Section(
					$wp_customize,
					'login_designer__section--error-messages',
					array(
						'title'                => esc_html__( 'Login Error Messages', 'login-designer' ),
						'type'                 => 'login-designer-section',
						'login_designer_type'  => 'free',
						'login_designer_title' => esc_attr__( 'New', 'login-designer' ),
						'panel'                => 'login_designer',
					)
				)
			);

			$wp_customize->add_section(
				new Login_Designer_Section(
					$wp_customize,
					'login_designer__section--google-recaptcha',
					array(
						'title'                => esc_html__( 'Google Recaptcha', 'login-designer' ),
						'type'                 => 'login-designer-section',
						'login_designer_type'  => 'free',
						'login_designer_title' => esc_attr__( 'New', 'login-designer' ),
						'panel'                => 'login_designer',
					)
				)
			);

			$languages = get_available_languages();
			if ( ! empty( $languages ) ) {
				$wp_customize->add_section(
					new Login_Designer_Section(
						$wp_customize,
						'login_designer__section--translations',
						array(
							'title'                => esc_html__( 'Language Switcher', 'login-designer' ),
							'type'                 => 'login-designer-section',
							'login_designer_type'  => 'free',
							'login_designer_title' => esc_attr__( 'New', 'login-designer' ),
							'panel'                => 'login_designer',
						)
					)
				);
			}

			$wp_customize->add_section(
				new Login_Designer_Section(
					$wp_customize,
					'login_designer__section--file-import-export',
					array(
						'title'                => esc_html__( 'Import & Export Settings', 'login-designer' ),
						'type'                 => 'login-designer-section',
						'login_designer_type'  => 'free',
						'login_designer_title' => esc_attr__( 'New', 'login-designer' ),
						'panel'                => 'login_designer',
					)
				)
			);

			if ( in_array( 'password-protected/password-protected.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
				$this->password_protected_customizer( $wp_customize, $defaults, $admin_defaults );
			}

			/**
			 * Add the theme upgrade section, only if the pro version is available.
			 *
			 * @see https://github.com/justintadlock/trt-customizer-pro
			 */
			if ( Login_Designer()->has_pro() ) {
				$wp_customize->register_section_type( 'Login_Designer_Upgrade_Control' );

				// Retrieve the Login Designer shop URL.
				$url = Login_Designer()->get_store_url(
					'extensions',
					array(
						'utm_medium'   => 'login-designer-lite',
						'utm_source'   => 'customizer',
						'utm_campaign' => 'extensions-section',
						'utm_content'  => 'discover-add-ons',
					)
				);

				$wp_customize->add_section(
					new Login_Designer_Upgrade_Control(
						$wp_customize,
						'upgrade',
						array(
							'type'     => 'upgrade',
							'panel'    => 'login_designer',
							'title'    => esc_html__( 'Extensions', 'login-designer' ),
							'pro_text' => esc_html__( 'Discover Add-ons', 'login-designer' ),
							'pro_url'  => $url,
						)
					)
				);
			}

			/**
			 * Add sections.
			 */
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/templates.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/logo.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/background.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/form.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/fields.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/labels.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/button.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/remember.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/checkbox.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/below.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/license.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/branding.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/language-switcher.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/login-error-messages.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/google-recaptcha.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/import-export-settings.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/google-fonts.php';

			do_action(
				'login_designer_customizer_control',
				$wp_customize,
				$this,
				array(
					'panel'                     => 'login_designer',
					'login_designer_plugin_dir' => LOGIN_DESIGNER_PLUGIN_DIR,
				)
			);

			// @todo Pro features sections.
			if ( apply_filters( 'login_designer_pro_dummy_sections', true ) ) {
				$this->login_designer_pro_dummy_sections( $wp_customize );
			}
		}

		/**
		 * Sanitize Checkbox.
		 *
		 * @param string|bool $checked Customizer option.
		 */
		public function sanitize_checkbox( $checked ) {
			return isset( $checked ) && true === $checked;
		}

		/**
		 * Image sanitization callback.
		 *
		 * Checks the image's file extension and mime type against a whitelist. If they're allowed,
		 * send back the filename, otherwise, return the setting default.
		 *
		 * - Sanitization: image file extension
		 * - Control: text, WP_Customize_Image_Control
		 *
		 * @see wp_check_filetype() https://developer.wordpress.org/reference/functions/wp_check_filetype/
		 *
		 * @param string|string        $image Image filename.
		 * @param WP_Customize_Setting $setting Setting instance.
		 * @return string The image filename if the extension is allowed; otherwise, the setting default.
		 */
		public static function sanitize_image( $image, $setting ) {

			// The array includes image mime types that are included in wp_get_mime_types().
			$mimes = array(
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
				'bmp'          => 'image/bmp',
				'tif|tiff'     => 'image/tiff',
				'ico'          => 'image/x-icon',
			);

			// Return an array with file extension and mime_type.
			$file = wp_check_filetype( $image, $mimes );

			// If $image has a valid mime_type, return it; otherwise, return the default.
			return ( $file['ext'] ? $image : $setting->default );
		}

		/**
		 * Returns an array of layout choices.
		 *
		 * @param array|array $choices Template option.
		 */
		public static function get_choices( $choices ) {
			$layouts                 = $choices;
			$layouts_control_options = array();

			foreach ( $layouts as $layout => $value ) {
				$layouts_control_options[ $layout ] = $value;
			}

			return $layouts_control_options;
		}

		/**
		 * Get background images.
		 */
		public static function get_background_images() {
			$image_dir = LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/';

			$backgrounds = array(
				'none'  => esc_url( $image_dir ) . '00.jpg',
				'bg_01' => esc_url( $image_dir ) . '01-sml.jpg',
				'bg_02' => esc_url( $image_dir ) . '02-sml.jpg',
				'bg_03' => esc_url( $image_dir ) . '03-sml.jpg',
				'bg_04' => esc_url( $image_dir ) . '04-sml.jpg',
				'bg_05' => esc_url( $image_dir ) . '05-sml.jpg',
				'bg_06' => esc_url( $image_dir ) . '06-sml.jpg',
				'bg_07' => esc_url( $image_dir ) . '07-sml.jpg',
				'bg_08' => esc_url( $image_dir ) . '08-sml.jpg',
				'bg_09' => esc_url( $image_dir ) . '09-sml.jpg',
			);

			return apply_filters( 'login_designer_backgrounds', $backgrounds );
		}

		/**
		 * Returns the background choices.
		 *
		 * @since 1.0.0
		 * @return array
		 */
		public static function get_background_choices() {
			$choices = array(
				'repeat'   => array(
					'no-repeat' => esc_html__( 'No Repeat', 'login-designer' ),
					'repeat'    => esc_html__( 'Tile', 'login-designer' ),
					'repeat-x'  => esc_html__( 'Tile Horizontally', 'login-designer' ),
					'repeat-y'  => esc_html__( 'Tile Vertically', 'login-designer' ),
				),
				'size'     => array(
					'auto'    => esc_html__( 'Auto', 'login-designer' ),
					'cover'   => esc_html__( 'Cover', 'login-designer' ),
					'contain' => esc_html__( 'Contain', 'login-designer' ),
				),
				'position' => array(
					'left top'      => esc_html__( 'Left Top', 'login-designer' ),
					'left center'   => esc_html__( 'Left Center', 'login-designer' ),
					'left bottom'   => esc_html__( 'Left Bottom', 'login-designer' ),
					'right top'     => esc_html__( 'Right Top', 'login-designer' ),
					'right center'  => esc_html__( 'Right Center', 'login-designer' ),
					'right bottom'  => esc_html__( 'Right Bottom', 'login-designer' ),
					'center top'    => esc_html__( 'Center Top', 'login-designer' ),
					'center center' => esc_html__( 'Center Center', 'login-designer' ),
					'center bottom' => esc_html__( 'Center Bottom', 'login-designer' ),
				),
				'attach'   => array(
					'fixed'  => esc_html__( 'Fixed', 'login-designer' ),
					'scroll' => esc_html__( 'Scroll', 'login-designer' ),
				),
			);

			return apply_filters( 'login_designer_background_choices', $choices );
		}

		/**
		 * Returns an array of Google Font options
		 *
		 * @return array of font styles.
		 */
		public static function get_fonts() {
			$fonts = array(
				'default'             => esc_html__( 'Default', 'login-designer' ),
				'Abril Fatface'       => 'Abril Fatface',
				'Georgia'             => 'Georgia',
				'Helvetica'           => 'Helvetica',
				'Lato'                => 'Lato',
				'Lora'                => 'Lora',
				'Karla'               => 'Karla',
				'Josefin Sans'        => 'Josefin Sans',
				'Montserrat'          => 'Montserrat',
				'Open Sans'           => 'Open Sans',
				'Oswald'              => 'Oswald',
				'Overpass'            => 'Overpass',
				'Poppins'             => 'Poppins',
				'PT Sans'             => 'PT Sans',
				'Roboto'              => 'Roboto',
				'Fira Sans Condensed' => 'Fira Sans',
				'Times New Roman'     => 'Times New Roman',
				'Nunito'              => 'Nunito',
				'Merriweather'        => 'Merriweather',
				'Rubik'               => 'Rubik',
				'Playfair Display'    => 'Playfair Display',
				'Spectral'            => 'Spectral',
			);

			return apply_filters( 'login_designer_fonts', $fonts );
		}

		/**
		 * Customizer data for password protected
		 *
		 * @param WP_Customize_Manager $wp_customize WP Customizer.
		 * @param array                $defaults Default settings.
		 * @param array                $admin_defaults Default settings.
		 */
		protected function password_protected_customizer( $wp_customize, $defaults, $admin_defaults ) {
			/**
			 * Password Protected Customization
			 */
			$wp_customize->add_panel(
				'password_protected',
				array(
					'title'       => esc_html__( 'Password Protected', 'login-designer' ),
					'capability'  => 'edit_theme_options',
					'description' => esc_html__( 'Using plugin to protect your site with password' ),
					'priority'    => 151,
				)
			);

			/**
			 * Things todo ↴
			 * @todo Logo section.
			 * @todo label section.
			 * @todo field section.
			 * @todo remember checkbox section.
			 * @todo remember label section.
			 * @todo login button section.
			 * @todo form background section.
			 * @todo body background section.
			 * @todo above form section.
			 * @todo below form section.
			 */

			// Logo section.
			$wp_customize->add_section(
				'password_protected__section--logo',
				array(
					'panel' => 'password_protected',
					'title' => esc_html__( 'Logo Styles', 'login-designer' ),
				)
			);

			// Label section.
			$wp_customize->add_section(
				'password_protected__section--label',
				array(
					'panel' => 'password_protected',
					'title' => esc_html__( 'Label Styles', 'login-designer' ),
				)
			);

			// Field section.
			$wp_customize->add_section(
				'password_protected__section--field',
				array(
					'panel' => 'password_protected',
					'title' => esc_html__( 'Field Styles', 'login-designer' ),
				)
			);

			// Submit button section.
			$wp_customize->add_section(
				'password_protected__section--button',
				array(
					'panel' => 'password_protected',
					'title' => esc_html__( 'Button Styles', 'login-desinger' ),
				)
			);

			// Remember me checkbox section.
			$wp_customize->add_section(
				'password_protected__section--checkbox',
				array(
					'panel' => 'password_protected',
					'title' => esc_html__( 'Remember me Style' ),
				)
			);

			// Remember me label section.
			$wp_customize->add_section(
				'password_protected__section--checkbox-label',
				array(
					'title' => esc_html__( 'Remember me Label Styles', 'login-designer' ),
					'panel' => 'password_protected',
				)
			);

			// Form Background section.
			$wp_customize->add_section(
				'password_protected__section--form-background',
				array(
					'title' => esc_html__( 'Form Background', 'login-designer' ),
					'panel' => 'password_protected',
				)
			);

			// Body background section.
			$wp_customize->add_section(
				'password_protected__section--body-background',
				array(
					'title' => esc_html__( 'Body Background', 'login-designer' ),
					'panel' => 'password_protected',
				)
			);

			// Below form section.
			$wp_customize->add_section(
				'password_protected__section--above-bellow-form',
				array(
					'title' => esc_html__( 'Bellow Form', 'login-designer' ),
					'panel' => 'password_protected',
				)
			);

			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-logo.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-labels.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-fields.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-button.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-checkbox.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-remember.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-form.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-background.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pp-form-above-bellow.php';
		}

		/**
		 * Login Designer Pro dummy sections.
		 *
		 * @param WP_Customize_Manager $wp_customize WP Customize Manager.
		 */
		protected function login_designer_pro_dummy_sections( $wp_customize ) {
			$wp_customize->add_section(
				new Login_Designer_Section(
					$wp_customize,
					'login_designer__section--background-slider',
					array(
						'title'                => esc_attr__( 'Background Slider', 'login-designer-pro' ),
						'type'                 => 'login-designer-section',
						'login_designer_type'  => 'pro',
						'login_designer_title' => esc_attr__( 'Pro', 'login-designer' ),
						'panel'                => 'login_designer',
					)
				)
			);

			$wp_customize->add_section(
				new Login_Designer_Section(
					$wp_customize,
					'login_designer__section--form-animation',
					array(
						'title'                => esc_attr__( 'Form Animation', 'login-designer-pro' ),
						'type'                 => 'login-designer-section',
						'login_designer_type'  => 'pro',
						'login_designer_title' => esc_attr__( 'Pro', 'login-designer' ),
						'panel'                => 'login_designer',
					)
				)
			);

			$wp_customize->add_section(
				new Login_Designer_Section(
					$wp_customize,
					'login_designer__section--rename-login-page',
					array(
						'title'                => esc_attr__( 'Rename Login Page', 'login-designer-pro' ),
						'type'                 => 'login-designer-section',
						'login_designer_type'  => 'pro',
						'login_designer_title' => esc_attr__( 'Pro', 'login-designer' ),
						'panel'                => 'login_designer',
					)
				)
			);

			$wp_customize->add_section(
				new Login_Designer_Section(
					$wp_customize,
					'login_designer__section--google-fonts',
					array(
						'title'                => esc_attr__( 'Google Fonts', 'login-designer-pro' ),
						'type'                 => 'login-designer-section',
						'login_designer_type'  => 'pro',
						'login_designer_title' => esc_attr__( 'Pro', 'login-designer' ),
						'panel'                => 'login_designer',
					)
				)
			);

			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pro/background-slider.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pro/form-animation.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pro/rename-login-page.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/settings/pro/google-fonts.php';
		}
	}

endif;

new Login_Designer_Customizer();
