<?php
/**
 * Fields Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Settings.
 */
$wp_customize->add_setting( 'login_designer[fields_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[fields_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Fields', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[field_bg]', array(
	'default'               => $defaults['field_bg'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer[field_bg]', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[field_side_padding]', array(
	'default'               => $defaults['field_side_padding'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[field_side_padding]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Side Padding', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['field_side_padding'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 40,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[field_border]', array(
	'default'               => $defaults['field_border'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[field_border]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Border', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['field_border'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 10,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[field_border_color]', array(
	'default'               => $defaults['field_border_color'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer[field_border_color]', array(
	'label'                 => esc_html__( 'Border Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[field_radius]', array(
	'default'               => $defaults['field_radius'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[field_radius]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Border Radius', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['field_radius'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 60,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[field_shadow]', array(
	'default'               => $defaults['field_shadow'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[field_shadow]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['field_shadow'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 30,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[field_shadow_opacity]', array(
	'default'               => $defaults['field_shadow_opacity'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[field_shadow_opacity]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow Opacity', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => '%',
	'default'               => $defaults['field_shadow_opacity'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[field_shadow_inset]', array(
	'default'               => $defaults['field_shadow_inset'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => array( $this, 'sanitize_checkbox' ),
) );

$wp_customize->add_control( 'login_designer[field_shadow_inset]', array(
	'type'                  => 'checkbox',
	'label'                 => esc_html__( 'Shadow Inset', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) );


/**
 * Fields Text.
 */
$wp_customize->add_setting( 'login_designer[field_text_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[field_text_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Field Text', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[field_font]', array(
	'default'               => $defaults['field_font'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'wp_filter_nohtml_kses',
) );

$wp_customize->add_control( 'login_designer[field_font]', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Font', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'choices'           => $this->get_fonts(),
) );

$wp_customize->add_setting( 'login_designer[field_font_size]', array(
	'default'               => $defaults['field_font_size'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[field_font_size]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Font Size', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['field_font_size'],
	'input_attrs'           => array(
		'min'               => 13,
		'max'               => 40,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[field_color]', array(
	'default'               => $defaults['field_color'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer[field_color]', array(
	'label'                 => esc_html__( 'Font Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );
