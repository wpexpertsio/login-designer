<?php
/**
 * File: pp-logo.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'password_protected[logo_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[logo_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_attr__( 'Logo', 'login-designer' ),
			'description' => esc_attr__( 'Customize your Logo sizes, change you Logo and Remove your logo using these settings', 'login-designer' ),
			'section'     => 'password_protected__section--logo',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[logo]',
	array(
		'default'           => $defaults['logo'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new WP_Customize_Media_Control(
		$wp_customize,
		'password_protected[logo]',
		array(
			'section'  => 'password_protected__section--logo',
			'settings' => 'password_protected[logo]',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[logo_url]',
	array(
		'default'           => $admin_defaults['logo_url'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	'password_protected[logo_url]',
	array(
		'label'          => esc_attr__( 'URL', 'login-designer' ),
		'description'    => esc_attr__( 'URL', 'login-designer' ),
		'section'        => 'password_protected__section--logo',
		'type'           => 'dropdown-pages',
		'allow_addition' => false,
	)
);

$wp_customize->add_setting(
	'password_protected[logo_width]',
	array(
		'default'           => $defaults['logo_width'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[logo_width]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_attr__( 'Width', 'login-designer' ),
			'section'     => 'password_protected__section--logo',
			'description' => 'px',
			'default'     => $defaults['logo_width'],
			'input_attrs' => array(
				'min'  => 30,
				'max'  => 400,
				'step' => 2,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[logo_height]',
	array(
		'default'           => $defaults['logo_height'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[logo_height]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Height', 'login-designer' ),
			'section'     => 'password_protected__section--logo',
			'description' => 'px',
			'default'     => $defaults['logo_height'],
			'input_attrs' => array(
				'min'  => 30,
				'max'  => 300,
				'step' => 2,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[logo_margin_bottom]',
	array(
		'default'           => $defaults['logo_margin_bottom'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[logo_margin_bottom]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Position', 'login-designer' ),
			'section'     => 'password_protected__section--logo',
			'description' => 'px',
			'default'     => $defaults['logo_margin_bottom'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 100,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[disable_logo]',
	array(
		'default'           => $defaults['disable_logo'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize,
		'password_protected[disable_logo]',
		array(
			'label'    => esc_html__( 'Disable Logo', 'login-designer' ),
			'section'  => 'password_protected__section--logo',
			'type'     => 'login-designer-toggle',
			'settings' => 'password_protected[disable_logo]',
		)
	)
);
