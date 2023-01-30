<?php
/**
 * File: pp-remember.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'password_protected[remember_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[remember_title]',
		array(
			'label'       => esc_html__( 'Remember', 'login-designer' ),
			'description' => 'Customize your remember label',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[remember_font]',
	array(
		'default'           => $defaults['remember_font'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	)
);

$wp_customize->add_control(
	'password_protected[remember_font]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Font', 'login-designer' ),
		'section' => 'password_protected__section--checkbox-label',
		'choices' => $this->get_fonts(),
	)
);

$wp_customize->add_setting(
	'password_protected[remember_font_size]',
	array(
		'default'           => $defaults['remember_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[remember_font_size]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Size', 'login-designer' ),
			'section'     => 'password_protected__section--checkbox-label',
			'description' => 'px',
			'default'     => $defaults['remember_font_size'],
			'input_attrs' => array(
				'min'  => 8,
				'max'  => 20,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[remember_position]',
	array(
		'default'           => $defaults['remember_position'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[remember_position]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Position', 'login-designer' ),
			'section'     => 'password_protected__section--checkbox-label',
			'description' => 'px',
			'default'     => $defaults['remember_position'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 20,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[remember_color]',
	array(
		'default'           => $defaults['remember_color'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[remember_color]',
		array(
			'label'   => esc_html__( 'Color', 'login-designer' ),
			'section' => 'password_protected__section--checkbox-label',
		)
	)
);
