<?php
/**
 * Logo Customizer Section.
 *
 * @package   @@pkg.name
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
	'label'                => esc_html__( 'Logo', '@@textdomain' ),
	'description'           => esc_html__( 'Add your own logo. Logos will display at 50% height & width, to account for retina.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[logo]', array(
	'default'               => $defaults['logo'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => array( $this, 'sanitize_image' ),
) );

$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'login_designer[logo]', array(
	'section'              => 'login_designer__section--styles',
	'settings'             => 'login_designer[logo]',
) ) );

$wp_customize->add_setting( 'login_designer_settings[logo_url]', array(
	'default'               => $admin_defaults['logo_url'],
	'type' 			=> 'option',
	'transport'         	=> 'postMessage',
	'sanitize_callback' 	=> 'absint',
) );

$wp_customize->add_control( 'login_designer_settings[logo_url]', array(
	'label'          	=> esc_html__( 'Logo URL', '@@textdomain' ),
	'description'           => esc_html__( 'Select a page for your logo to link to. This is typically your site\'s home page.', '@@textdomain' ),
	'section'        	=> 'login_designer__section--styles',
	'type'           	=> 'dropdown-pages',
	'allow_addition' 	=> false,
) );

$wp_customize->add_setting( 'login_designer[logo_margin_bottom]', array(
	'default'               => $defaults['logo_margin_bottom'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
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

$wp_customize->add_setting( 'login_designer[disable_logo]', array(
	'default'               => $defaults['disable_logo'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => array( $this, 'sanitize_checkbox' ),
) );

$wp_customize->add_control( new Login_Designer_Toggle_Control( $wp_customize, 'login_designer[disable_logo]', array(
	'label'	      => esc_html__( 'Disable Logo', '@@textdomain' ),
	'section'     => 'login_designer__section--styles',
	'type'        => 'toggle',
	'settings'    => 'login_designer[disable_logo]',
) ) );
