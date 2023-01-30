<?php
/**
 * File: pp-fields.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'password_protected[fields_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[field_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Fields', 'login-designer' ),
			'description' => 'You can change the color of your Password field using this settings.',
			'section'     => 'password_protected__section--field',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_background_color]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['field_bg'],
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[field_background_color]',
		array(
			'label'   => esc_html__( 'Fields', 'login-designer' ),
			'section' => 'password_protected__section--field',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_border]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'default'           => $defaults['field_border'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_border]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Border', 'login-designer' ),
			'description' => 'px',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 10,
				'step' => 1,
			),
			'section'     => 'password_protected__section--field',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_border_color]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['field_border_color'],
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[field_border_color]',
		array(
			'label'   => esc_html__( 'Border Color', 'login-designer' ),
			'section' => 'password_protected__section--field',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_margin_bottom]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'default'           => $defaults['field_margin_bottom'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_margin_bottom]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Margin Bottom', 'login-designer' ),
			'section'     => 'password_protected__section--field',
			'description' => 'px',
			'input_attrs' => array(
				'min'  => 1,
				'max'  => 60,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_side_padding]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'defaults'          => $defaults['field_side_padding'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_side_padding]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Padding', 'login-designer' ),
			'section'     => 'password_protected__section--field',
			'description' => 'px',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 40,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_padding_top]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'default'           => $defaults['field_padding_top'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_padding_top]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Padding Top', 'login-designer' ),
			'section'     => 'password_protected__section--field',
			'description' => 'px',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 40,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_padding_bottom]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'default'           => $defaults['field_padding_bottom'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_padding_bottom]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Padding Bottom', 'login-designer' ),
			'section'     => 'password_protected__section--field',
			'description' => 'px',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 40,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_radius]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'defaults'          => $defaults['field_radius'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_radius]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Radius', 'login-designer' ),
			'section'     => 'password_protected__section--field',
			'description' => 'px',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 60,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_shadow]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'default'           => $defaults['field_radius'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_shadow]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Shadow', 'login-designer' ),
			'section'     => 'password_protected__section--field',
			'description' => 'px',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 30,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_shadow_opacity]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'default'           => $defaults['field_shadow_opacity'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_shadow_opacity]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Shadow Opacity', 'login-designer' ),
			'section'     => 'password_protected__section--field',
			'description' => '%',
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_shadow_inset]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		'default'           => $defaults['field_shadow_inset'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize,
		'password_protected[field_shadow_inset]',
		array(
			'label'    => esc_html__( 'Shadow Inset', 'login-designer' ),
			'section'  => 'password_protected__section--field',
			'type'     => 'login-designer-toggle',
			'settings' => 'password_protected[field_shadow_inset]',
		)
	)
);

/**
 * Fields Text.
 */
$wp_customize->add_setting(
	'password_protected[field_text_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[field_text_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Text', 'login-designer' ),
			'description' => esc_html__( 'Change the text field font, color and size.', 'login-designer' ),
			'section'     => 'password_protected__section--field',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_font_size]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
		'default'           => $defaults['field_font_size'],
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[field_font_size]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Size', 'login-designer' ),
			'section'     => 'password_protected__section--field',
			'description' => 'px',
			'input_attrs' => array(
				'min'  => 13,
				'max'  => 40,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[field_color]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
		'default'           => $defaults['field_font_size'],
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[field_color]',
		array(
			'label'   => esc_html__( 'Color', 'login-designer' ),
			'section' => 'password_protected__section--field',
		)
	)
);
