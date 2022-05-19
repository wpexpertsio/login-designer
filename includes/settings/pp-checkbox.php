<?php
/**
 * File: pp-checkbox.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'password_protected[checkbox_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[checkbox_title]',
		array(
			'label'       => esc_html__( 'Checkbox styles' ),
			'description' => 'Customize your checkbox',
			'section'     => 'password_protected__section--checkbox',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[checkbox_size]',
	array(
		'default'           => $defaults['checkbox_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[checkbox_size]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Size', 'login-designer' ),
			'section'     => 'password_protected__section--checkbox',
			'description' => 'px',
			'default'     => $defaults['checkbox_size'],
			'input_attrs' => array(
				'min'  => 16,
				'max'  => 28,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[checkbox_bg]',
	array(
		'default'           => $defaults['checkbox_bg'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[checkbox_bg]',
		array(
			'label'   => esc_html__( 'Background', 'login-designer' ),
			'section' => 'password_protected__section--checkbox',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[checkbox_border]',
	array(
		'default'           => $defaults['checkbox_border'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[checkbox_border]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Border', 'login-designer' ),
			'section'     => 'password_protected__section--checkbox',
			'description' => 'px',
			'default'     => $defaults['checkbox_border'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 3,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[checkbox_border_color]',
	array(
		'default'           => $defaults['checkbox_border_color'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[checkbox_border_color]',
		array(
			'label'   => esc_html__( 'Border Color', 'login-designer' ),
			'section' => 'password_protected__section--checkbox',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[checkbox_radius]',
	array(
		'default'           => $defaults['checkbox_radius'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[checkbox_radius]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Radius', 'login-designer' ),
			'section'     => 'password_protected__section--checkbox',
			'description' => 'px',
			'default'     => $defaults['checkbox_radius'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 30,
				'step' => 1,
			),
		)
	)
);