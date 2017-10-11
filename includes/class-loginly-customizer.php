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

			/**
			 * Add custom controls.
			 */
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-controls/class-loginly-range-control.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-controls/class-loginly-template-control.php';
			require_once LOGINLY_PLUGIN_DIR . 'includes/customize-controls/class-loginly-background-control.php';

			/**
			 * Add the main panel and sections.
			 */
			$wp_customize->add_panel( 'loginly__panel', array(
				'title'           => esc_html__( 'Loginly', '@@textdomain' ),
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
			$wp_customize->add_section( 'loginly__section--settings', array(
				'title'           => esc_html__( 'Settings', '@@textdomain' ),
				'panel'           => 'loginly__panel',
			) );


			/**
			 * Templates Section.
			 */
			$wp_customize->add_setting( 'loginly__template-selector', array(
				'default'               => 'loginly__template--01',
				'transport'             => 'postMessage',
			) );

			$wp_customize->add_control( new Loginly_Template_Control( $wp_customize, 'loginly__template-selector', array(
				'type'                  => 'loginly-template-selector',
				'description'           => esc_html__( 'You can switch templates at any time. Previewing a template allows you to make style changes without changing the live template visitors see.', '@@textdomain' ),
				'section'               => 'loginly__section--templates',
				'choices'               => $this->get_choices( $this->get_templates() ),
			) ) );


			/**
			 * Style Editor.
			 */
			$wp_customize->add_setting( 'loginly__custom-background-image--url', array(
				'sanitize_callback' 	=> 'esc_url',
			) );

			$wp_customize->add_setting( 'loginly__custom-background-image--id', array(
				'sanitize_callback' 	=> 'absint',
			) );

			$wp_customize->add_setting( 'loginly__custom-background-image--repeat', array(
				'default' 		=> 'repeat',
				'sanitize_callback' 	=> 'sanitize_text_field',
			) );

			$wp_customize->add_setting( 'loginly__custom-background-image--size', array(
				'default' 		=> 'auto',
				'sanitize_callback' 	=> 'sanitize_text_field',
			) );

			$wp_customize->add_setting( 'loginly__custom-background-image--attach', array(
				'default' 		=> 'center-center',
				'sanitize_callback' 	=> 'sanitize_text_field',
			) );

			$wp_customize->add_setting( 'loginly__custom-background-image--position', array(
				'default' 		=> 'scroll',
				'sanitize_callback' 	=> 'sanitize_text_field',
			) );

			$wp_customize->add_control( new Loginly_Background_Control( $wp_customize, 'loginly__custom-background-image', array(
					'label'				=> esc_html__( 'Background', '@@textdomain' ),
					'section'			=> 'loginly__section--styles',
					'settings'    			=> array(
						'image_url' 		=> 'loginly__custom-background-image--url',
						'image_id' 		=> 'loginly__custom-background-image--id',
						'repeat' 		=> 'loginly__custom-background-image--repeat',
						'size' 			=> 'loginly__custom-background-image--size',
						'attach' 		=> 'loginly__custom-background-image--attach',
						'position' 		=> 'loginly__custom-background-image--position',
					),
				)
			) );

			/**
			 * Add the background color selector.
			 */
			$wp_customize->add_setting( 'loginly__custom-background-color', array(
				'default'               => null,
				'transport'             => 'postMessage',
				'sanitize_callback'     => 'sanitize_hex_color',
			) );

			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'loginly__custom-background-color', array(
				'label'                 => esc_html__( 'Color', '@@textdomain' ),
				'section'               => 'loginly__section--styles',
			) ) );

			/**
			 * Add the custom logo uploader.
			 */
			$wp_customize->add_setting( 'loginly_custom_logo', array(
				'transport'             => 'postMessage',
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'loginly_custom_logo', array(
				'label'                => esc_html__( 'Logo', '@@textdomain' ),
				'section'              => 'loginly__section--styles',
				'settings'             => 'loginly_custom_logo',
			) ) );

			/**
			 * Add the max width option, to be applied to the custom logo.
			 */
			$wp_customize->add_setting( 'loginly_custom_logo_margin_bottom', array(
				'default'               => '25',
				'transport'             => 'postMessage',
				'sanitize_callback'     => '',
			) );

			$wp_customize->add_control( new Loginly_Range_Control( $wp_customize, 'loginly_custom_logo_margin_bottom', array(
				'type'                  => 'loginly-range',
				'label'                 => esc_html__( 'Bottom Spacing', '@@textdomain' ),
				'section'               => 'loginly__section--styles',
				'description'           => 'px',
				'default'               => '25',
				'input_attrs'           => array(
					'min'               => 0,
					'max'               => 100,
					'step'              => 1,
					),
				)
			) );


			/**
			 * Settings Section.
			 */
			$wp_customize->add_setting( 'loginly__logo-url', array(
				'default'           => '',
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			) );

			$wp_customize->add_control( 'loginly__logo-url', array(
				'label'          => esc_html__( 'Logo URL', '@@textdomain' ),
				'section'        => 'loginly__section--settings',
				'type'           => 'dropdown-pages',
				'allow_addition' => true,
			) );

			$wp_customize->add_setting( 'loginly__login-redirect', array(
				'default'           => '',
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			) );

			$wp_customize->add_control( 'loginly__login-redirect', array(
				'label'          => esc_html__( 'Login Redirect', '@@textdomain' ),
				'section'        => 'loginly__section--settings',
				'type'           => 'dropdown-pages',
				'allow_addition' => true,
			) );

			$wp_customize->add_setting( 'loginly__logout-redirect', array(
				'default'           => '',
				'sanitize_callback' => 'absint',
				'transport'         => 'postMessage',
			) );

			$wp_customize->add_control( 'loginly__logout-redirect', array(
				'label'          => esc_html__( 'Logout Redirect', '@@textdomain' ),
				'section'        => 'loginly__section--settings',
				'type'           => 'dropdown-pages',
				'allow_addition' => true,
			) );

			$wp_customize->add_setting( 'loginly__login-message', array(
				'default'           => '',
				'sanitize_callback' => 'esc_textarea',
				'transport'         => '',
			) );

			$wp_customize->add_control( 'loginly__login-message', array(
				'label'          => esc_html__( 'Login Message', '@@textdomain' ),
				'section'        => 'loginly__section--settings',
				'type'           => 'textarea',
			) );
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
