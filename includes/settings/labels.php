<?php
/**
 * Labels Customizer Section.
 *
 * @package Login Designer
 */

$wp_customize->add_setting(
	'login_designer[labels_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer[labels_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Labels', 'login-designer' ),
			'description' => esc_html__( 'Modify the text labels and style them however you like.', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[username_label]',
	array(
		'default'           => $defaults['username_label'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control(
	'login_designer[username_label]',
	array(
		'label'   => esc_html__( 'Username', 'login-designer' ),
		'section' => 'login_designer__section--styles',
		'type'    => 'text',
	)
);

$wp_customize->add_setting(
	'login_designer[password_label]',
	array(
		'default'           => $defaults['password_label'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control(
	'login_designer[password_label]',
	array(
		'label'   => esc_html__( 'Password', 'login-designer' ),
		'section' => 'login_designer__section--styles',
		'type'    => 'text',
	)
);

$wp_customize->add_setting(
	'login_designer[label_font]',
	array(
		'default'           => $defaults['label_font'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	)
);

$wp_customize->add_control(
	'login_designer[label_font]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Font', 'login-designer' ),
		'section' => 'login_designer__section--styles',
		'choices' => $this->get_fonts(),
	)
);

$wp_customize->add_setting(
	'login_designer[label_font_size]',
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
		'login_designer[label_font_size]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Size', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[label_position]',
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
		'login_designer[label_position]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Spacing', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[label_color]',
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
		'login_designer[label_color]',
		array(
			'label'   => esc_html__( 'Color', 'login-designer' ),
			'section' => 'login_designer__section--styles',
		)
	)
);
