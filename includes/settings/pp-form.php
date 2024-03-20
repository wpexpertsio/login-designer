<?php
/**
 * File: pp-form.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'password_protected[form]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[form]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_attr__( 'Form Background', 'login-designer' ),
			'description' => esc_html__( 'Customize your login form', 'login-designer' ),
			'section'     => 'password_protected__section--form-background',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[form_bg]',
	array(
		'default'           => $defaults['form_bg'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[form_bg]',
		array(
			'label'   => esc_html__( 'Background', 'login-designer' ),
			'section' => 'password_protected__section--form-background',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[form_radius]',
	array(
		'default'           => $defaults['form_radius'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[form_radius]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Radius', 'login-designer' ),
			'section'     => 'password_protected__section--form-background',
			'description' => 'px',
			'default'     => $defaults['form_radius'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 50,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[form_shadow]',
	array(
		'default'           => $defaults['form_shadow'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[form_shadow]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Shadow', 'login-designer' ),
			'section'     => 'password_protected__section--form-background',
			'description' => 'px',
			'default'     => $defaults['form_shadow'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 70,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[form_shadow_opacity]',
	array(
		'default'           => $defaults['form_shadow_opacity'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[form_shadow_opacity]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Shadow Opacity', 'login-designer' ),
			'section'     => 'password_protected__section--form-background',
			'description' => '%',
			'default'     => $defaults['form_shadow_opacity'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[form_side_padding]',
	array(
		'default'           => $defaults['form_side_padding'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[form_side_padding]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Side Padding', 'login-designer' ),
			'section'     => 'password_protected__section--form-background',
			'description' => 'px',
			'default'     => $defaults['form_side_padding'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 2,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[form_bg_transparency]',
	array(
		'default'           => $defaults['form_bg_transparency'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize,
		'password_protected[form_bg_transparency]',
		array(
			'label'    => esc_html__( 'Transparent', 'login-designer' ),
			'section'  => 'password_protected__section--form-background',
			'type'     => 'login-designer-toggle',
			'settings' => 'password_protected[form_bg_transparency]',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[form_vertical_padding]',
	array(
		'default'           => $defaults['form_vertical_padding'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[form_vertical_padding]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Vertical Padding', 'login-designer' ),
			'section'     => 'password_protected__section--form-background',
			'description' => 'px',
			'default'     => $defaults['form_vertical_padding'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 2,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[form_width]',
	array(
		'default'           => $defaults['form_width'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[form_width]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Width', 'login-designer' ),
			'section'     => 'password_protected__section--form-background',
			'description' => 'px',
			'default'     => $defaults['form_width'],
			'input_attrs' => array(
				'min'  => 300,
				'max'  => 800,
				'step' => 2,
			),
		)
	)
);
