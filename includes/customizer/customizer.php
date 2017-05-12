<?php
/**
 * Customizer functionality
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */


// Add theme support for selective refresh for widgets.
add_theme_support( 'customize-selective-refresh-widgets' );


/**
 * Register Customizer Settings.
 *
 * @param WP_Customize_Manager $wp_customize the Customizer object.
 */
function loginly_customize_register( $wp_customize ) {

	// Register background control JS template.
	$wp_customize->register_control_type( 'Loginly_Background_Control' );

	/**
	 * Create the primary panel, and all secondary sections within the panel.
	 */

		/**
		 * Add the "Loginly" panel.
		 */
		$wp_customize->add_panel( 'loginly__panel', array(
			'title'           => esc_html__( 'Loginly', '@@textdomain' ),
			'priority'        => 1,
		) );

		/**
		 * Add the "Templates" section.
		 */
		$wp_customize->add_section( 'loginly__section--templates', array(
			'title'           => esc_html__( 'Templates', '@@textdomain' ),
			'panel'           => 'loginly__panel',
		) );

		/**
		 * Add the "Styles" section.
		 */
		$wp_customize->add_section( 'loginly__section--styles', array(
			'title'           => esc_html__( 'Style Editor', '@@textdomain' ),
			'panel'           => 'loginly__panel',
		) );

		/**
		 * Add the "Settings" section.
		 */
		$wp_customize->add_section( 'loginly__section--settings', array(
			'title'           => esc_html__( 'Settings', '@@textdomain' ),
			'panel'           => 'loginly__panel',
		) );

	/**
	 * "Loginly Editor" > "Templates" settings and controls.
	 */

		/**
		 * Add the template selector setting and control.
		 */
		$wp_customize->add_setting( 'loginly__template-selector', array(
			'default'               => '',
			'transport'             => '',
			'sanitize_callback'     => '',
		) );

		$wp_customize->add_control( new Loginly_Templates_Control( $wp_customize, 'loginly__template-selector', array(
			'type'                  => 'loginly-template-selector',
			'description'           => esc_html__( 'You can switch templates at any time. Previewing a template allows you to make style changes without changing the live template visitors see.', '@@textdomain' ),
			'section'               => 'loginly__section--templates',
			'choices'               => ava_get_choices( ava_get_header_layouts() ),
		) ) );

	/**
	 * "Loginly Editor" > "Style Editor" settings and controls.
	 */

		/**
		 * Register settings for the "Background" control below.
		 */
		$wp_customize->add_setting( 'loginly__custom-background-image--url', array(
			'sanitize_callback' 	=> 'esc_url',
		) );

		$wp_customize->add_setting( 'loginly__custom-background-image--id', array(
			'sanitize_callback' 	=> 'absint',
		) );

		$wp_customize->add_setting( 'loginly__custom-background-image--repeat', array(
			'default' 				=> 'repeat',
			'sanitize_callback' 	=> 'sanitize_text_field',
		) );

		$wp_customize->add_setting( 'loginly__custom-background-image--size', array(
			'default' 				=> 'auto',
			'sanitize_callback' 	=> 'sanitize_text_field',
		) );

		$wp_customize->add_setting( 'loginly__custom-background-image--attach', array(
			'default' 				=> 'center-center',
			'sanitize_callback' 	=> 'sanitize_text_field',
		) );

		$wp_customize->add_setting( 'loginly__custom-background-image--position', array(
			'default' 				=> 'scroll',
			'sanitize_callback' 	=> 'sanitize_text_field',
		) );

		/**
		 * Register the "Background" control.
		 */
		$wp_customize->add_control( new Loginly_Background_Control( $wp_customize, 'loginly__custom-background-image', array(
				'label'				=> esc_html__( 'Background', '@@textdomain' ),
				'section'			=> 'loginly__section--styles',
				'settings'    		=> array(
					'image_url' 	=> 'loginly__custom-background-image--url',
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
			'default'               => '',
			'transport'             => '',
			'sanitize_callback'     => 'sanitize_hex_color',
		) );

		$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'loginly__custom-background-color', array(
			'label'                 => esc_html__( 'Color', '@@textdomain' ),
			'section'               => 'loginly__section--styles',
		) ) );

		/**
		 * Add the custom logo uploader.
		 */
		$wp_customize->add_setting( 'loginly__custom-logo', array(
			'sanitize_callback'     => '',
		) );

		$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'loginly__custom-logo', array(
			'label'                => esc_html__( 'Logo', '@@textdomain' ),
			'section'              => 'loginly__section--styles',
			'settings'             => 'loginly__custom-logo',
		) ) );

		/**
		 * Add the max width option, to be applied to the custom logo.
		 */
		$wp_customize->add_setting( 'loginly__custom-logo-maxwidth', array(
			'default'               => '100',
			'transport'             => 'postMessage',
			'sanitize_callback'     => '',
		) );

		$wp_customize->add_control( new Loginly_Range_Control( $wp_customize, 'loginly__custom-logo-maxwidth', array(
			'type'                  => 'loginly-range',
			'label'                 => esc_html__( 'Logo Width', '@@textdomain' ),
			'section'               => 'loginly__section--styles',
			'description'           => 'px',
			'default'               => '100',
			'input_attrs'           => array(
				'min'               => 0,
				'max'               => 200,
				'step'              => 2,
				),
			)
		) );

	













	/**
	 * "Loginly Editor" > "Settings" settings and controls.
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

add_action( 'customize_register', 'loginly_customize_register', 11 );















/**
 * Customizer Custom Callbacks
 *
 * Only displays the current skin customizer options, if neccessary.
 *
 * @return boolean
 */
function loginly__template_01( $control ) {
	if ( $control->manager->get_setting( 'loginly__template-selector' )->value() == 'loginly__template_01' ) {
		return true;
	} else {
		return false;
	}
}


if ( ! function_exists( 'ava_get_choices' ) ) :
/**
 * Returns an array of theme layout choices registered for @@pkg.name.
 *
 * @return array of theme skins.
 */
function ava_get_choices( $choices ) {
	$layouts = $choices;
	$layouts_control_options = array();

	foreach ( $layouts as $layout => $value ) {
		$layouts_control_options[ $layout ] = $value['image'];
	}

	return $layouts_control_options;
}
endif;





// /**
//  * Filter the number of Customizer sections.
//  *
//  * @param $num_sections integer
//  */
// $num_sections = apply_filters( 'loginly_customizer_template_sections', 3 );

// // Create a setting and control for each of the sections available in the theme.
// for ( $i = 1; $i < ( 1 + $num_sections ); $i++ ) {

// 	$wp_customize->add_section( 'loginly__template_' . $i, array(
// 		/* translators: %d is the front page section number */
// 		'title'                 => sprintf( __( 'Template %d', '@@textdomain' ), $i ),
// 		'panel'                 => 'loginly__panel',
// 		'active_callback'       => 'loginly__template_' . $i,
// 	) );
// }


/*
 * Register header layouts
 */
function ava_get_header_layouts() {

	$image_dir  = LOGINLY_PLUGIN_URL . 'assets/images/';

	return apply_filters( 'ava_nav_layouts', array(
		'loginly__template--01' => array(
			'title' => esc_html__( 'Template 01 Name', '@@textdomain' ),
			'image' => esc_url( $image_dir ) . 'template-01/template-01.svg',
		),
	) );
}







