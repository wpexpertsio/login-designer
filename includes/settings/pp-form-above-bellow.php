<?php

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'password_protected[password_below_password_title_field]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[password_below_password_title_field]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Text below form', 'login-designer' ),
			'description' => esc_html__( 'Customize your Label, change you Label color, position and font-size using these settings.', 'login-designer' ),
			'section'	  => 'password_protected__section--above-bellow-form',
		)
	),
);

// font settings
$wp_customize->add_setting(
	'password_protected[password_below_password_font]',
	array(
		'section' => 'password_protected__section--above-bellow-form',
		'sanitize_callback' => 'sanitize_text_field',
		'type'  		    => 'option',
		'transport'		    => 'postMessage',
		'default'			=> 'default',
	)
);

$wp_customize->add_control(
	'password_protected[password_below_password_font]',
	array(
		'type' => 'select',
		'label' => esc_html__( 'Font', 'login-designer' ),
		'section' => 'password_protected__section--above-bellow-form',
		'choices' => Login_Designer_Customizer::get_fonts(),
	)
);

// font size settings
$wp_customize->add_setting(
	'password_protected[password_below_password_font_size]',
	array(
		'section' => 'password_protected__section--above-bellow-form',
		'sanitize_callback' => 'sanitize_text_field',
		'type'  		    => 'option',
		'transport'		    => 'postMessage',
		'default'           => '14',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[password_below_password_font_size]',
		array(
			'type' => 'login-designer-range',
			'label' => esc_html__( 'Font Size', 'login-designer' ),
			'section' => 'password_protected__section--above-bellow-form',
			'input_attrs' => array(
				'min' => 0,
				'max' => 100,
				'step' => 1,
			),
		)
	)
);

// position settings
$wp_customize->add_setting(
	'password_protected[password_below_password_position]',
	array(
		'section' => 'password_protected__section--above-bellow-form',
		'sanitize_callback' => 'sanitize_text_field',
		'type'  		    => 'option',
		'transport'		    => 'postMessage',
		'default'           => 0,
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[password_below_password_position]',
		array(
			'type' => 'login-designer-range',
			'label' => esc_html__( 'Position', 'login-designer' ),
			'section' => 'password_protected__section--above-bellow-form',
			'input_attrs' => array(
				'min' => 0,
				'max' => 100,
				'step' => 1,
			),
		)
	)
);

// color settings
$wp_customize->add_setting(
	'password_protected[password_below_password_color]',
	array(
		'section' => 'password_protected__section--above-bellow-form',
		'sanitize_callback' => 'sanitize_text_field',
		'type'  		    => 'option',
		'transport'		    => 'postMessage',
		'default'           => '#72777c',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[password_below_password_color]',
		array(
			'type' => 'color',
			'label' => esc_html__( 'Color', 'login-designer' ),
			'section' => 'password_protected__section--above-bellow-form',
		)
	)
);

// color settings
$wp_customize->add_setting(
	'password_protected[password_below_password_alignment]',
	array(
		'section' => 'password_protected__section--above-bellow-form',
		'sanitize_callback' => 'sanitize_text_field',
		'type'  		    => 'option',
		'transport'		    => 'postMessage',
		'default'           => 'center',
	)
);

$wp_customize->add_control(
	'password_protected[password_below_password_alignment]',
	array(
		'type' => 'select',
		'label' => esc_html__( 'Text Alignment', 'login-designer' ),
		'section' => 'password_protected__section--above-bellow-form',
		'choices' => array(
			'left' => esc_html__( 'Left', 'login-designer' ),
			'center' => esc_html__( 'Center', 'login-designer' ),
			'right' => esc_html__( 'Right', 'login-designer' ),
		),
	)
);
