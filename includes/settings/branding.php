<?php
/**
 * Branding Customizer Section.
 *
 * @package Login Designer
 */

$wp_customize->add_setting(
	'login_designer_settings[branding_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_settings[branding_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Branding', 'login-designer' ),
			'description' => esc_html__( 'Show some love and add a Powered by Login Designer badge to your login page.', 'login-designer' ),
			'section'     => 'login_designer__section--settings',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_settings[branding]',
	array(
		'default'           => $admin_defaults['branding'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize,
		'login_designer_settings[branding]',
		array(
			'label'    => esc_html__( 'Enable', 'login-designer' ),
			'type'     => 'login-designer-toggle',
			'settings' => 'login_designer_settings[branding]',
			'section'  => 'login_designer__section--settings',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_settings[branding_color]',
	array(
		'default'           => $admin_defaults['branding_color'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'login_designer_settings[branding_color]',
		array(
			'label'   => esc_html__( 'Text', 'login-designer' ),
			'section' => 'login_designer__section--settings',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_settings[branding_icon_color]',
	array(
		'default'           => $admin_defaults['branding_icon_color'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'login_designer_settings[branding_icon_color]',
		array(
			'label'   => esc_html__( 'Logo', 'login-designer' ),
			'section' => 'login_designer__section--settings',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_settings[branding_position]',
	array(
		'default'           => $admin_defaults['branding_position'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	)
);

$wp_customize->add_control(
	'login_designer_settings[branding_position]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Position', 'login-designer' ),
		'section' => 'login_designer__section--settings',
		'choices' => array(
			'left'      => esc_html__( 'Bottom Left', 'login-designer' ),
			'right'     => esc_html__( 'Bottom Right', 'login-designer' ),
			'middle'    => esc_html__( 'Bottom Middle', 'login-designer' ),
			'top-right' => esc_html__( 'Upper Right', 'login-designer' ),
		),
	)
);
