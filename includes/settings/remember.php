<?php
/**
 * Remember Me Customizer Section.
 *
 * @package Login Designer
 */

$wp_customize->add_setting(
	'login_designer[remember_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer[remember_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Remember', 'login-designer' ),
			'description' => esc_html__( 'Easily customize the Remember Me element on the login form.', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[remember_font]',
	array(
		'default'           => $defaults['remember_font'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	)
);

$wp_customize->add_control(
	'login_designer[remember_font]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Font', 'login-designer' ),
		'section' => 'login_designer__section--styles',
		'choices' => $this->get_fonts(),
	)
);

$wp_customize->add_setting(
	'login_designer[remember_font_size]',
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
		'login_designer[remember_font_size]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Size', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[remember_position]',
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
		'login_designer[remember_position]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Position', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[remember_color]',
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
		'login_designer[remember_color]',
		array(
			'label'   => esc_html__( 'Color', 'login-designer' ),
			'section' => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[remember_hide]',
	array(
		'default'           => false,
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize,
		'login_designer[remember_hide]',
		array(
			'label'   => esc_html__( 'Hide Remember Me', 'login-designer' ),
			'type'    => 'login-designer-toggle',
			'section' => 'login_designer__section--styles',
		)
	)
);
