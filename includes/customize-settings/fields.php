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
$wp_customize->add_setting( 'login_designer_title_form_fields', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_form_fields', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Fields', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer_form_field_background', array(
	'default'               => null,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_field_background', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );


$wp_customize->add_setting( 'login_designer_form_field_side_padding', array(
	'default'               => '3',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_side_padding', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Side Padding', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '3',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 40,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_border_size', array(
	'default'               => '1',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_border_size', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Border', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '1',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 10,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_border_color', array(
	'default'               => '#dddddd',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_field_border_color', array(
	'label'                 => esc_html__( 'Border Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer_form_field_border_radius', array(
	'default'               => '0',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_border_radius', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Border Radius', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '0',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 60,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_box_shadow', array(
	'default'               => '2',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_box_shadow', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '2',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 30,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_box_shadow_opacity', array(
	'default'               => '7',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_box_shadow_opacity', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow Opacity', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => '%',
	'default'               => '7',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_box_shadow_inset', array(
	'default'               => true,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => array( $this, 'sanitize_checkbox' ),
) );

$wp_customize->add_control( 'login_designer_form_field_box_shadow_inset', array(
	'type'                  => 'checkbox',
	'label'                 => esc_html__( 'Shadow Inset', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) );


/**
 * Fields Text.
 */
$wp_customize->add_setting( 'login_designer_title_form_field_text', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_form_field_text', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Field Text', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer_form_field_font', array(
	'default'               => 'default',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'wp_filter_nohtml_kses',
) );

$wp_customize->add_control( 'login_designer_form_field_font', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Font', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'choices'           => $this->get_fonts(),
) );

$wp_customize->add_setting( 'login_designer_form_field_text_size', array(
	'default'               => '24',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_text_size', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Font Size', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '24',
	'input_attrs'           => array(
		'min'               => 13,
		'max'               => 40,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_text_color', array(
	'default'               => null,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_field_text_color', array(
	'label'                 => esc_html__( 'Font Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );
