<?php
/**
 * Customizer functionality
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Register Customizer Settings.
 *
 * @param WP_Customize_Manager $wp_customize the Customizer object.
 */
function loginly_customize_register( $wp_customize ) {
	/**
	 * Add the main panel.
	 */
	$wp_customize->add_section( 'loginly__panel', array(
		'title'           => esc_html__( 'Loginly', '@@textdomain' ),
		'description'     => esc_html__( '', '@@textdomain' ),
		'priority'        => 1,
	) );

	/**
	 * Add the template selector control.
	 */
	$wp_customize->add_setting( 'loginly__template-selector', array(
		'default'               => '',
		'sanitize_callback'     => '',
	) );

	$wp_customize->add_control( new Loginly_Template_Selector( $wp_customize, 'loginly__template-selector', array(
		'type'                  => 'layout',
		'description'           => esc_html__( 'You can switch templates at any time. Previewing a template allows you to make style changes without changing the live template visitors see.', '@@textdomain' ),
		'section'               => 'loginly__panel',
		'choices'               => ava_get_choices( ava_get_header_layouts() ),
	) ) );


























	$wp_customize->add_setting( 'loginly__test', array(
		'default'               => '',
		'sanitize_callback'     => '',
	) );

	$wp_customize->add_control( 'loginly__test', array(
		'type'                  => 'checkbox',
		'label'                 => esc_html__( 'Show Checkout', '@@textdomain' ),
		'description'           => '',
		'section'               => 'loginly__template_1',
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

