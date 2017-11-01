<?php
/**
 * Customizer functionality
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

			// AJAX license.
			add_action( 'wp_ajax_activate_license', array( $this, 'ajax_activate_license' ) );
			add_action( 'wp_ajax_deactivate_license', array( $this, 'ajax_deactivate_license' ) );
		}

		/**
		 * Get the license key.
		 *
		 * @access public
		 */
		public function key() {

			$options 	= get_option( 'login_designer_license', array() );
			$key 		= array_key_exists( 'key', $options ) ? sanitize_text_field( $options['key'] ) : false;

			return $key;
		}

		/**
		 * Get the license status.
		 *
		 * @access public
		 */
		public function status() {

			$options 	= get_option( 'login_designer_license', array() );
			$status 	= array_key_exists( 'status', $options ) ? sanitize_text_field( $options['status'] ) : false;

			return $status;
		}

		/**
		 * Get the license's expiration date.
		 *
		 * @access public
		 */
		public function expiration() {

			$options 	= get_option( 'login_designer_license', array() );
			$expiration 	= array_key_exists( 'expiration', $options ) ? sanitize_text_field( $options['expiration'] ) : false;

			return $expiration;
		}

		/**
		 * Get status.
		 *
		 * @access public
		 */
		public function site_count() {

			$options 	= get_option( 'login_designer_license', array() );
			$site_count 	= array_key_exists( 'site_count', $options ) ? sanitize_text_field( $options['site_count'] ) : false;

			return $site_count;
		}

		/**
		 * Get status.
		 *
		 * @access public
		 */
		public function activations_left() {

			$options 		= get_option( 'login_designer_license', array() );
			$activations_left 	= array_key_exists( 'activations_left', $options ) ? sanitize_text_field( $options['activations_left'] ) : false;

			return $activations_left;
		}

		/**
		 * Get the license status.
		 *
		 * @access public
		 */
		public function is_valid_license() {

			// Get the status of the license.
			$status = $this->status();

			if ( 'valid' === $status ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Makes a call to the API.
		 *
		 * @param array $api_params to be used for wp_remote_get.
		 * @return array $response decoded JSON response.
		 */
		function get_api_response( $api_params ) {

			// Call the custom API.
			$response = wp_remote_post( 'https://themebeans.com/', array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

			// Make sure the response came back okay.
			if ( is_wp_error( $response ) ) {
				return false;
			}

			$response = json_decode( wp_remote_retrieve_body( $response ) );

			return $response;
		}

		/**
		 * License Activation AJAX.
		 */
		public function ajax_activate_license() {

			if ( ! check_ajax_referer( 'login-designer-license', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			$this->activate_license();
		}

		/**
		 * License Deactivation AJAX.
		 */
		public function ajax_deactivate_license() {

			if ( ! check_ajax_referer( 'login-designer-deactivate-license', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			$this->deactivate_license();
		}

		/**
		 * Check the license and activate it.
		 *
		 * Development test license: de5d3d143d81b95a6d89568848e43a8e
		 * https://themebeans.com/?edd_action=activate_license&item_id=105665&license=de5d3d143d81b95a6d89568848e43a8e
		 */
		public function activate_license() {

			// Veritfy and validate the request.
			if ( isset( $_POST['key'], $_POST['login-designer-license'] ) && wp_verify_nonce( sanitize_key( $_POST['login-designer-license'] ), 'nonce' ) ) {  // Input var okay.
				return;
			}

			// Get the option from AJAX and save it to our options array.
			$key = sanitize_text_field( wp_unslash( $_POST['key'] ) );  // Input var okay.

			// Data to send in our API request.
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => urlencode( $key ),
				'item_id'    => '105665',
			);

			// Get the response.
			$response = $this->get_api_response( $api_params );

			// If response doesn't include license data, return.
			if ( ! isset( $response->license ) ) {
				return;
			}

			// We need to update the license at the same time the message is updated.
			if ( $response && isset( $response->license ) ) {

				// Set up options.
				$options = array();

				// Pull options from WP.
				$license_options = get_option( 'login_designer_license', array() );

				// Get the license key (from the AJAX $_POST call up above).
				$options['key'] = $key;

				// Get the license status.
				$response_status = $response->license;
				$options['status'] = $response_status;

				// Get the license expiration date.
				$response_expiration = date_i18n( get_option( 'date_format' ), strtotime( $response->expires ) );
				$options['expiration'] = $response_expiration;

				// Get the number of activations left.
				$response_site_count = $response->site_count;
				$options['site_count'] = $response_site_count;

				// Get the number of activations left.
				$response_activations_left = $response->activations_left;
				$options['activations_left'] = $response_activations_left;

				// Merge options.
				$merged_options   = array_merge( $license_options, $options );
				$license_options  = $merged_options;

				update_option( 'login_designer_license', $license_options );

				wp_send_json(
					array(
						'done' 			=> 1,
						'expiration' 		=> $response_expiration,
						'status' 		=> $response_status,
						'site_count' 		=> $response_site_count,
						'activations_left' 	=> $response_activations_left,
					)
				);
			}
		}

		/**
		 * Deactivates the license key.
		 */
		public function deactivate_license() {

			// Veritfy and validate the request.
			if ( isset( $_POST['login-designer-deactivate-license'] ) && wp_verify_nonce( sanitize_key( $_POST['login-designer-deactivate-license'] ), 'nonce' ) ) {  // Input var okay.
				return;
			}

			// Get the license key that we want to deactivate.
			$key = $this->key();

			// Data to send in our API request.
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => urlencode( $key ),
				'item_id'    => '105665',
			);

			$response = $this->get_api_response( $api_params );

			// $response->license will be either "deactivated" or "failed".
			if ( $response && ( 'deactivated' === $response->license ) ) {

				// Remove the license option entirely.
				delete_option( 'login_designer_license' );

				// Let the Customizer know we're done here.
				wp_send_json(
					array(
						'done' 			=> 1,
					)
				);
			}
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
		 * Register Customizer Settings.
		 *
		 * @param WP_Customize_Manager $wp_customize the Customizer object.
		 */
		function customize_register( $wp_customize ) {

			/**
			 * Add custom controls.
			 */
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-range-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-toggle-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-template-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-title-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-gallery-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-alpha-color-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-upgrade-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-license-control.php';

			// Get the default options.
			$defaults 	= new Login_Designer_Customizer_Output();
			$defaults 	= $defaults->defaults();

			// Get the admin default options.
			$admin_defaults 	= new Login_Designer_Customizer_Output();
			$admin_defaults 	= $admin_defaults->admin_defaults();

			/**
			 * Add the main panel and sections.
			 */
			$wp_customize->add_panel( 'login_designer', array(
				'title'		   	=> esc_html__( 'Login Designer', '@@textdomain' ),
				'capability' 		=> 'edit_theme_options',
				'description'		=> esc_html__( 'Click the Templates icon at the top left of the preview window to change your template. To customize further, simply click on any element, or it\'s corresponding shortcut icon, to edit it\'s styling. ', '@@textdomain' ),
				'priority'		=> 150,
			) );

			// Style Editor (visually hidden from the Customizer).
			$wp_customize->add_section( 'login_designer__section--styles', array(
				'title'		   	=> esc_html__( 'Styles', '@@textdomain' ),
				'panel'		  	=> 'login_designer',
			) );

			// Templates.
			$wp_customize->add_section( 'login_designer__section--templates', array(
				'title'		   	=> esc_html__( 'Templates', '@@textdomain' ),
				'panel'		   	=> 'login_designer',
			) );

			// Settings.
			$wp_customize->add_section( 'login_designer__section--settings', array(
				'title'		   	=> esc_html__( 'Settings', '@@textdomain' ),
				'panel'		   	=> 'login_designer',
			) );

			// License.
			$wp_customize->add_section( 'login_designer__section--license', array(
				'title'		   	=> esc_html__( 'License', '@@textdomain' ),
				'panel'		   	=> 'login_designer',
			) );

			/**
			 * Add the theme upgrade section, only if the pro version is available.
			 *
			 * @see https://github.com/justintadlock/trt-customizer-pro
			 */
			if ( Login_Designer()->has_pro() ) {

				$wp_customize->register_section_type( 'Login_Designer_Upgrade_Control' );

				$url = esc_url( add_query_arg( array(
					'utm_source'   => 'customizer',
					'utm_medium'   => 'extensions-section',
					'utm_campaign' => 'customizer',
					'utm_content' => 'discover-add-ons',
					),
				'https://logindesigner.com/extensions' ) );


				$wp_customize->add_section( new Login_Designer_Upgrade_Control( $wp_customize, 'upgrade', array(
					'type'                  => 'upgrade',
					'panel'		  	=> 'login_designer',
					'title'    		=> esc_html__( 'Extensions', '@@textdomain' ),
					'pro_text' 		=> esc_html__( 'Discover Add-ons', '@@textdomain' ),
					'pro_url'  		=> esc_url( $url ),
				) ) );
			}

			/**
			 * Add sections.
			 */
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-settings/templates.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-settings/logo.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-settings/background.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-settings/form.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-settings/fields.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-settings/labels.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-settings/button.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-settings/settings.php';
		}

		/**
		 * Sanitize Checkbox.
		 *
		 * @param string|bool $checked Customizer option.
		 */
		public function sanitize_checkbox( $checked ) {
			return ( ( isset( $checked ) && true === $checked ) ? true : false );
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
				'jpg|jpeg|jpe' 	=> 'image/jpeg',
				'gif'		=> 'image/gif',
				'png'		=> 'image/png',
				'bmp'		=> 'image/bmp',
				'tif|tiff'	=> 'image/tiff',
				'ico'		=> 'image/x-icon',
			);

			// Return an array with file extension and mime_type.
			$file = wp_check_filetype( $image, $mimes );

			// If $image has a valid mime_type, return it; otherwise, return the default.
			return ( $file['ext'] ? $image : $setting->default );
		}

		/**
		 * Sanitize RGBA colors
		 *
		 * @param string|string $value Color value.
		 * @return string
		 */
		public static function sanitize_rgba( $value ) {

			// If empty or an array return transparent.
			if ( empty( $value ) || is_array( $value ) ) {
				return 'rgba(0,0,0,0)';
			}

			// By now we know the string is formatted as an rgba color so we need to further sanitize it.
			$value = str_replace( ' ', '', $value );
			sscanf( $value, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
			return 'rgba('.$red.','.$green.','.$blue.','.$alpha.')';
		}

		/**
		 * Returns an array of layout choices.
		 *
		 * @param array|array $choices Template option.
		 */
		public static function get_choices( $choices ) {
			$layouts = $choices;
			$layouts_control_options = array();

			foreach ( $layouts as $layout => $value ) {
				$layouts_control_options[ $layout ] = $value['image'];
			}

			return $layouts_control_options;
		}

		/**
		 * Register header layouts.
		 */
		public static function get_templates() {

			$image_dir  = LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/';

			$templates = array(
				'default' => array(
					'title' => esc_html__( 'Default', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . 'template-01/template-01.svg',
				),
				'01' => array(
					'title' => esc_html__( 'Template 01', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . 'template-01/template-01.svg',
				),
				'02' => array(
					'title' => esc_html__( 'Template 02', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . 'template-01/template-01.svg',
				),
			);

			return apply_filters( 'login_designer_templates', $templates );
		}

		/**
		 * Get background images.
		 */
		public static function get_background_images() {

			$image_dir  = LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/';

			$backgrounds = array(
				'none' => array(
					'title' => esc_html__( 'None', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '00.jpg',
				),
				'bg_01' => array(
					'title' => esc_html__( '01', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '01-sml.jpg',
				),
				'bg_02' => array(
					'title' => esc_html__( '02', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '02-sml.jpg',
				),
				'bg_03' => array(
					'title' => esc_html__( '03', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '03-sml.jpg',
				),
				'bg_04' => array(
					'title' => esc_html__( '04', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '04-sml.jpg',
				),
				'bg_05' => array(
					'title' => esc_html__( '05', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '05-sml.jpg',
				),
				'bg_06' => array(
					'title' => esc_html__( '06', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '06-sml.jpg',
				),
				'bg_07' => array(
					'title' => esc_html__( '07', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '07-sml.jpg',
				),
				'bg_08' => array(
					'title' => esc_html__( '08', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '08-sml.jpg',
				),
				'bg_09' => array(
					'title' => esc_html__( '09', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '09-sml.jpg',
				),
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
				'repeat' => array(
					'no-repeat' 	=> esc_html__( 'No Repeat', '@@textdomain' ),
					'repeat'	=> esc_html__( 'Tile', '@@textdomain' ),
					'repeat-x'  	=> esc_html__( 'Tile Horizontally', '@@textdomain' ),
					'repeat-y'  	=> esc_html__( 'Tile Vertically', '@@textdomain' ),
				),
				'size' => array(
					'auto'		=> esc_html__( 'Auto', '@@textdomain' ),
					'cover'   	=> esc_html__( 'Cover', '@@textdomain' ),
					'contain' 	=> esc_html__( 'Contain', '@@textdomain' ),
				),
				'position' => array(
					'left-top'	=> esc_html__( 'Left Top', '@@textdomain' ),
					'left-center'   => esc_html__( 'Left Center', '@@textdomain' ),
					'left-bottom'   => esc_html__( 'Left Bottom', '@@textdomain' ),
					'right-top'	=> esc_html__( 'Right Top', '@@textdomain' ),
					'right-center'  => esc_html__( 'Right Center', '@@textdomain' ),
					'right-bottom'  => esc_html__( 'Right Bottom', '@@textdomain' ),
					'center-top'	=> esc_html__( 'Center Top', '@@textdomain' ),
					'center-center' => esc_html__( 'Center Center', '@@textdomain' ),
					'center-bottom' => esc_html__( 'Center Bottom', '@@textdomain' ),
				),
				'attach' => array(
					'fixed'   	=> esc_html__( 'Fixed', '@@textdomain' ),
					'scroll'  	=> esc_html__( 'Scroll', '@@textdomain' ),
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
				'default' 		=> esc_html__( 'Default', '@@textdomain' ),
				'Abril Fatface'		=> 'Abril Fatface',
				'Georgia'		=> 'Georgia',
				'Helvetica'		=> 'Helvetica',
				'Lato'			=> 'Lato',
				'Lora'			=> 'Lora',
				'Karla'			=> 'Karla',
				'Josefin Sans'		=> 'Josefin Sans',
				'Montserrat'		=> 'Montserrat',
				'Open Sans'		=> 'Open Sans',
				'Oswald'		=> 'Oswald',
				'Overpass'		=> 'Overpass',
				'Poppins'		=> 'Poppins',
				'PT Sans'		=> 'PT Sans',
				'Roboto'		=> 'Roboto',
				'Fira Sans Condensed'   => 'Fira Sans',
				'Times New Roman'	=> 'Times New Roman',
				'Nunito'		=> 'Nunito',
				'Merriweather'		=> 'Merriweather',
				'Rubik'			=> 'Rubik',
				'Playfair Display'	=> 'Playfair Display',
				'Spectral'		=> 'Spectral',
			);

			return apply_filters( 'login_designer_fonts', $fonts );
		}
	}

endif;

new Login_Designer_Customizer();
