<?php
/**
 * File: pp-labels.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'password_protected[labels_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[labels_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Labels', 'login-designer' ),
			'description' => esc_html__( 'Customize your Label, change you Label color, position and font-size using these settings.', 'login-designer' ),
			'section'     => 'password_protected__section--label',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[password_label]',
	array(
		'default'           => __( 'Password', 'login-designer' ),
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'password_protected[password_label]',
	array(
		'label'   => esc_attr__( 'Label', 'login-designer' ),
		'type'    => 'text',
		'section' => 'password_protected__section--label',
	)
);

$wp_customize->add_setting(
	'password_protected[label_font]',
	array(
		'default'           => $defaults['label_font'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	)
);

$wp_customize->add_control(
	'password_protected[label_font]',
	array(
		'type'    => 'select',
		'label'   => esc_attr__( 'Font', 'password-protected' ),
		'choices' => $this->get_fonts(),
		'section' => 'password_protected__section--label',
	)
);

$wp_customize->add_setting(
	'password_protected[label_font_size]',
	array(
		'default'           => $defaults['label_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[label_font_size]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Size', 'login-designer' ),
			'section'     => 'password_protected__section--label',
			'description' => 'px',
			'default'     => $defaults['label_font_size'],
			'input_attrs' => array(
				'min'  => 13,
				'max'  => 40,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[label_position]',
	array(
		'default'           => $defaults['label_position'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize,
		'password_protected[label_position]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Position', 'login-designer' ),
			'section'     => 'password_protected__section--label',
			'description' => 'px',
			'default'     => $defaults['label_position'],
			'input_attrs' => array(
				'min'  => 0,
				'max'  => 20,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[label_color]',
	array(
		'default'           => $defaults['label_color'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[label_color]',
		array(
			'label'   => esc_html__( 'Color', 'login-designer' ),
			'section' => 'password_protected__section--label',
		)
	)
);
