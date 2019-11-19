<?php
/**
 * Logo Customizer Section.
 *
 * @package Login Designer
 */

$wp_customize->add_setting(
	'login_designer[logo_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer[logo_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Logo', 'login-designer' ),
			'description' => esc_html__( 'Add your own logo. Logos will display at 50% height and width to account for retina devices. Modify the height and width below.', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[logo]',
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
		'login_designer[logo]',
		array(
			'section'  => 'login_designer__section--styles',
			'settings' => 'login_designer[logo]',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_settings[logo_url]',
	array(
		'default'           => $admin_defaults['logo_url'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	'login_designer_settings[logo_url]',
	array(
		'label'          => esc_html__( 'URL', 'login-designer' ),
		'description'    => esc_html__( 'Select a page for your logo to link to. This is typically your site\'s home page.', 'login-designer' ),
		'section'        => 'login_designer__section--styles',
		'type'           => 'dropdown-pages',
		'allow_addition' => false,
	)
);

$wp_customize->add_setting(
	'login_designer[logo_width]',
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
		'login_designer[logo_width]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Width', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[logo_height]',
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
		'login_designer[logo_height]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Height', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[logo_margin_bottom]',
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
		'login_designer[logo_margin_bottom]',
		array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Position', 'login-designer' ),
			'section'     => 'login_designer__section--styles',
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
	'login_designer[disable_logo]',
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
		'login_designer[disable_logo]',
		array(
			'label'    => esc_html__( 'Disable Logo', 'login-designer' ),
			'section'  => 'login_designer__section--styles',
			'type'     => 'login-designer-toggle',
			'settings' => 'login_designer[disable_logo]',
		)
	)
);
