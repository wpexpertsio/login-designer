<?php
/**
 * Customizer functionality
 *
 * @package   @@pkg.name
 * @author	@@pkg.author
 * @license   @@pkg.license
 * @version   @@pkg.version
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
			add_action( 'customize_register', array( $this, 'customize_register' ), 11 );
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
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-template-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-title-control.php';
			require_once LOGIN_DESIGNER_PLUGIN_DIR . 'includes/customize-controls/class-login-designer-gallery-control.php';

			/**
			 * Add the main panel and sections.
			 */
			$wp_customize->add_panel( 'login_designer', array(
				'title'		   => esc_html__( 'Login Designer', '@@textdomain' ),
				'priority'		=> 150,
				'priority'		=> 1,
			) );

			// Section.
			$wp_customize->add_section( 'login_designer__section--templates', array(
				'title'		   => esc_html__( 'Templates', '@@textdomain' ),
				'panel'		   => 'login_designer',
			) );

			// Section.
			$wp_customize->add_section( 'login_designer__section--styles', array(
				'title'		   => esc_html__( 'Style Editor', '@@textdomain' ),
				'panel'		   => 'login_designer',
			) );

			// Section.
			$wp_customize->add_section( 'login_designer__section--background', array(
				'title'		   => esc_html__( 'Background', '@@textdomain' ),
				'panel'		   => 'login_designer',
			) );

			// Section.
			$wp_customize->add_section( 'login_designer__section--settings', array(
				'title'		   => esc_html__( 'Settings', '@@textdomain' ),
				'panel'		   => 'login_designer',
			) );

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

			return apply_filters( 'login_designer_templates', array(
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
			) );
		}

		/**
		 * Register header layouts.
		 */
		public static function get_background_images() {

			$image_dir  = LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/';

			$backgrounds = array(
				'none' => array(
					'title' => esc_html__( 'None', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '00.jpg',
				),
				'01' => array(
					'title' => esc_html__( '01', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '01-sml.jpg',
				),
				'02' => array(
					'title' => esc_html__( '02', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '02-sml.jpg',
				),
				'03' => array(
					'title' => esc_html__( '03', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '03-sml.jpg',
				),
				'04' => array(
					'title' => esc_html__( '04', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '04-sml.jpg',
				),
				'05' => array(
					'title' => esc_html__( '05', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '05-sml.jpg',
				),
				'06' => array(
					'title' => esc_html__( '06', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '06-sml.jpg',
				),
				'07' => array(
					'title' => esc_html__( '07', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '07-sml.jpg',
				),
				'08' => array(
					'title' => esc_html__( '08', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . '08-sml.jpg',
				),
				'09' => array(
					'title' => esc_html__( '08', '@@textdomain' ),
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
					'no-repeat' => esc_html__( 'No Repeat', '@@textdomain' ),
					'repeat'	=> esc_html__( 'Tile', '@@textdomain' ),
					'repeat-x'  => esc_html__( 'Tile Horizontally', '@@textdomain' ),
					'repeat-y'  => esc_html__( 'Tile Vertically', '@@textdomain' ),
				),
				'size' => array(
					'auto'	=> esc_html__( 'Default', '@@textdomain' ),
					'cover'   => esc_html__( 'Cover', '@@textdomain' ),
					'contain' => esc_html__( 'Contain', '@@textdomain' ),
				),
				'position' => array(
					'left-top'	  => esc_html__( 'Left Top', '@@textdomain' ),
					'left-center'   => esc_html__( 'Left Center', '@@textdomain' ),
					'left-bottom'   => esc_html__( 'Left Bottom', '@@textdomain' ),
					'right-top'	 => esc_html__( 'Right Top', '@@textdomain' ),
					'right-center'  => esc_html__( 'Right Center', '@@textdomain' ),
					'right-bottom'  => esc_html__( 'Right Bottom', '@@textdomain' ),
					'center-top'	=> esc_html__( 'Center Top', '@@textdomain' ),
					'center-center' => esc_html__( 'Center Center', '@@textdomain' ),
					'center-bottom' => esc_html__( 'Center Bottom', '@@textdomain' ),
				),
				'attach' => array(
					'fixed'   => esc_html__( 'Fixed', '@@textdomain' ),
					'scroll'  => esc_html__( 'Scroll', '@@textdomain' ),
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
				'Abril Fatface'		 => 'Abril Fatface',
				'georgia'			   => 'Georgia',
				'helvetica'			 => 'Helvetica',
				'Lato'				  => 'Lato',
				'Lora'				  => 'Lora',
				'Karla'				 => 'Karla',
				'Josefin Sans'		  => 'Josefin Sans',
				'Montserrat'			=> 'Montserrat',
				'Open Sans'			 => 'Open Sans',
				'Oswald'				=> 'Oswald',
				'Overpass'			  => 'Overpass',
				'Poppins'			   => 'Poppins',
				'PT Sans'			   => 'PT Sans',
				'Roboto'				=> 'Roboto',
				'Fira Sans Condensed'   => 'Fira Sans',
				'times'				 => 'Times New Roman',
				'Nunito'				=> 'Nunito',
				'Merriweather'		  => 'Merriweather',
				'Rubik'				 => 'Rubik',
				'Playfair Display'	  => 'Playfair Display',
				'Spectral'			  => 'Spectral',
			);

			return apply_filters( 'login_designer_fonts', $fonts );
		}
	}

endif;

new Login_Designer_Customizer();
