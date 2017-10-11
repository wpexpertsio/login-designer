<?php
/**
 * Style Editor Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Logo.
 */
$wp_customize->add_setting( 'loginly_title_logo', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Loginly_Title_Control( $wp_customize, 'loginly_title_logo', array(
	'type'                  => 'loginly-title',
	'label'                 => esc_html__( 'Logo', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
) ) );


$wp_customize->add_setting( 'loginly_custom_logo', array(
	'transport'             => 'postMessage',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'loginly_custom_logo', array(
	'label'                => esc_html__( 'Upload Image', '@@textdomain' ),
	'section'              => 'loginly__section--styles',
	'settings'             => 'loginly_custom_logo',
) ) );


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
 * Form.
 */
$wp_customize->add_setting( 'loginly_title_form', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Loginly_Title_Control( $wp_customize, 'loginly_title_form', array(
	'type'                  => 'loginly-title',
	'label'                 => esc_html__( 'Form', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
) ) );


$wp_customize->add_setting( 'loginly_form_background_color', array(
	'default'               => null,
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'loginly_form_background_color', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
) ) );


$wp_customize->add_setting( 'loginly_form_width', array(
	'default'               => '320',
	'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Loginly_Range_Control( $wp_customize, 'loginly_form_width', array(
	'type'                  => 'loginly-range',
	'label'                 => esc_html__( 'Width', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
	'description'           => 'px',
	'default'               => '320',
	'input_attrs'           => array(
		'min'               => 300,
		'max'               => 800,
		'step'              => 2,
		),
	)
) );



$wp_customize->add_setting( 'loginly_form_padding_left_right', array(
	'default'               => '24',
	'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Loginly_Range_Control( $wp_customize, 'loginly_form_padding_left_right', array(
	'type'                  => 'loginly-range',
	'label'                 => esc_html__( 'Side Padding', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
	'description'           => 'px',
	'default'               => '24',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 2,
		),
	)
) );


$wp_customize->add_setting( 'loginly_form_padding_top_bottom', array(
	'default'               => '26',
	'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Loginly_Range_Control( $wp_customize, 'loginly_form_padding_top_bottom', array(
	'type'                  => 'loginly-range',
	'label'                 => esc_html__( 'Vertical Padding', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
	'description'           => 'px',
	'default'               => '26',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 2,
		),
	)
) );


$wp_customize->add_setting( 'loginly_form_border_radius', array(
	'default'               => '0',
	'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Loginly_Range_Control( $wp_customize, 'loginly_form_border_radius', array(
	'type'                  => 'loginly-range',
	'label'                 => esc_html__( 'Border Radius', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
	'description'           => 'px',
	'default'               => '0',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 50,
		'step'              => 1,
		),
	)
) );



/**
 * Form.
 */
$wp_customize->add_setting( 'loginly_title_form_fields', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Loginly_Title_Control( $wp_customize, 'loginly_title_form_fields', array(
	'type'                  => 'loginly-title',
	'label'                 => esc_html__( 'Fields', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
) ) );


$wp_customize->add_setting( 'loginly_form_field_background', array(
	'default'               => null,
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'loginly_form_field_background', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'loginly__section--styles',
) ) );










