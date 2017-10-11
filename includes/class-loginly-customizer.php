<?php
/**
 * Customizer functionality
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 * @version   @@pkg.version
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Loginly_Customizer' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Loginly_Customizer {

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

			// Register background control JS template.
			$wp_customize->register_control_type( 'Loginly_Background_Control' );

			/**
			 * Add custom controls.
			 */
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-controls/class-loginly-range-control.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-controls/class-loginly-template-control.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-controls/class-loginly-title-control.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-controls/class-loginly-background-control.php';

			/**
			 * Add the main panel and sections.
			 */
			$wp_customize->add_panel( 'loginly__panel', array(
				'title'           => esc_html__( 'Login Designer', '@@textdomain' ),
				'priority'        => 150,
			) );

			// Section.
			$wp_customize->add_section( 'loginly__section--templates', array(
				'title'           => esc_html__( 'Templates', '@@textdomain' ),
				'panel'           => 'loginly__panel',
			) );

			// Section.
			$wp_customize->add_section( 'loginly__section--styles', array(
				'title'           => esc_html__( 'Style Editor', '@@textdomain' ),
				'panel'           => 'loginly__panel',
			) );

			// Section.
			$wp_customize->add_section( 'loginly__section--background', array(
				'title'           => esc_html__( 'Background', '@@textdomain' ),
				'panel'           => 'loginly__panel',
			) );

			// Section.
			$wp_customize->add_section( 'loginly__section--settings', array(
				'title'           => esc_html__( 'Settings', '@@textdomain' ),
				'panel'           => 'loginly__panel',
			) );

			/**
			 * Add sections.
			 */
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-sections/templates.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-sections/style-editor.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-sections/background.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-sections/settings.php';
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
		 * Returns an array of theme layout choices registered for @@pkg.name.
		 *
		 * @return array of theme skins.
		 */
		function get_choices( $choices ) {
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
		function get_templates() {

			$image_dir  = LOGINLY_PLUGIN_URL . 'assets/images/';

			return apply_filters( 'loginly_templates', array(
				'default' => array(
					'title' => esc_html__( 'Default', '@@textdomain' ),
					'image' => esc_url( $image_dir ) . 'default.jpg',
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
	}

endif;

new Loginly_Customizer();
