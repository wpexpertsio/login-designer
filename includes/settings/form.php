<?php
/**
 * Form Customizer Section.
 *
 * @package Login Designer
 */

$wp_customize->add_setting(
	'login_designer[form_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer[form_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Form', 'login-designer' ),
			'description' => esc_html__( 'Easily customize the login form wrapper default styling.', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[form_bg]',
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
		'login_designer[form_bg]',
		array(
			'label'   => esc_html__( 'Background', 'login-designer' ),
			'section' => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[form_radius]',
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
		'login_designer[form_radius]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Radius', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[form_shadow]',
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
		'login_designer[form_shadow]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Shadow', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[form_shadow_opacity]',
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
		'login_designer[form_shadow_opacity]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Shadow Opacity', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[form_side_padding]',
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
		'login_designer[form_side_padding]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Horizontal Padding', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[form_bg_transparency]',
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
		'login_designer[form_bg_transparency]',
		array(
			'label'    => esc_html__( 'Transparent', 'login-designer' ),
			'section'  => 'login_designer__section--styles',
			'type'     => 'login-designer-toggle',
			'settings' => 'login_designer[form_bg_transparency]',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[form_vertical_padding]',
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
		'login_designer[form_vertical_padding]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Vertical Padding', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[form_width]',
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
		'login_designer[form_width]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Width', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
