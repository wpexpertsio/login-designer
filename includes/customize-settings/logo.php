<?php
/**
 * Logo Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Settings.
 */
$wp_customize->add_setting( 'login_designer[logo_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[logo_title]', array(
	'type'                  => 'login-designer-title',
	'label'                => esc_html__( 'Login Logo', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[logo]', array(
	'default'               => $defaults['logo'],
	'type' 			=> 'option',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => array( $this, 'sanitize_image' ),
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'login_designer[logo]', array(
	'section'              => 'login_designer__section--styles',
	'settings'             => 'login_designer[logo]',
) ) );

$wp_customize->add_setting( 'login_designer[logo_margin_bottom]', array(
	'default'               => $defaults['logo_margin_bottom'],
	'type' 			=> 'option',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[logo_margin_bottom]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Bottom Spacing', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['logo_margin_bottom'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[logo_url]', array(
	'default'               => $defaults['logo_url'],
	'type' 			=> 'option',
	'transport'         	=> 'postMessage',
	'sanitize_callback' 	=> 'absint',
) );

$wp_customize->add_control( 'login_designer[logo_url]', array(
	'label'          	=> esc_html__( 'Logo URL', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'        	=> 'login_designer__section--styles',
	'type'           	=> 'dropdown-pages',
	'allow_addition' 	=> false,
) );