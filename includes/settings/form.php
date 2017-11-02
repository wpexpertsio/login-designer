<?php
/**
 * Form Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Settings.
 */
$wp_customize->add_setting( 'login_designer[form_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[form_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Form', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[form_bg]', array(
	'default'               => $defaults['form_bg'],
	'type' 			=> 'option',
	'transport'   		=> 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer[form_bg]', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[form_width]', array(
	'default'               => $defaults['form_width'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[form_width]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Width', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['form_width'],
	'input_attrs'           => array(
		'min'               => 300,
		'max'               => 800,
		'step'              => 2,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[form_side_padding]', array(
	'default'               => $defaults['form_side_padding'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[form_side_padding]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Side Padding', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['form_side_padding'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 2,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[form_vertical_padding]', array(
	'default'               => $defaults['form_vertical_padding'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[form_vertical_padding]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Vertical Padding', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['form_vertical_padding'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 2,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[form_radius]', array(
	'default'               => $defaults['form_radius'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[form_radius]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Radius', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['form_radius'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 50,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[form_shadow]', array(
	'default'               => $defaults['form_shadow'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[form_shadow]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['form_shadow'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 70,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[form_shadow_opacity]', array(
	'default'               => $defaults['form_shadow_opacity'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[form_shadow_opacity]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow Opacity', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => '%',
	'default'               => $defaults['form_shadow_opacity'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 1,
		),
	)
) );
