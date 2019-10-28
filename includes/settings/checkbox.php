<?php
/**
 * Remember Me Checkbox Customizer Section.
 *
 * @package Login Designer
 */

$wp_customize->add_setting(
	'login_designer[checkbox_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer[checkbox_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Checkbox', 'login-designer' ),
			'description' => esc_html__( 'Customize the Remember Me checkbox input element on the login form.', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[checkbox_size]',
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
		'login_designer[checkbox_size]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Size', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[checkbox_bg]',
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
		'login_designer[checkbox_bg]',
		array(
			'label'   => esc_html__( 'Background', 'login-designer' ),
			'section' => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[checkbox_border]',
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
		'login_designer[checkbox_border]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Border', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[checkbox_border_color]',
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
		'login_designer[checkbox_border_color]',
		array(
			'label'   => esc_html__( 'Border Color', 'login-designer' ),
			'section' => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[checkbox_radius]',
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
		'login_designer[checkbox_radius]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Radius', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
