<?php
/**
 * Below the Form Customizer Section.
 *
 * @package   @@pkg.title
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

$wp_customize->add_setting(
	'login_designer[below_title]', array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize, 'login_designer[below_title]', array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'Below Form', '@@textdomain' ),
			'description' => esc_html__( 'Modify elements below the login form.', '@@textdomain' ),
			'section'     => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[below_font]', array(
		'default'           => $defaults['below_font'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	)
);

$wp_customize->add_control(
	'login_designer[below_font]', array(
		'type'    => 'select',
		'label'   => esc_html__( 'Font', '@@textdomain' ),
		'section' => 'login_designer__section--styles',
		'choices' => $this->get_fonts(),
	)
);

$wp_customize->add_setting(
	'login_designer[below_font_size]', array(
		'default'           => $defaults['below_font_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize, 'login_designer[below_font_size]', array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Size', '@@textdomain' ),
			'section'     => 'login_designer__section--styles',
			'description' => 'px',
			'default'     => $defaults['below_font_size'],
			'input_attrs' => array(
				'min'  => 13,
				'max'  => 40,
				'step' => 1,
			),
		)
	)
);

$wp_customize->add_setting(
	'login_designer[below_color]', array(
		'default'           => $defaults['below_color'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize, 'login_designer[below_color]', array(
			'label'   => esc_html__( 'Color', '@@textdomain' ),
			'section' => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[below_position]', array(
		'default'           => $defaults['below_position'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
	)
);

$wp_customize->add_control(
	new Login_Designer_Range_Control(
		$wp_customize, 'login_designer[below_position]', array(
			'type'        => 'login-designer-range',
			'label'       => esc_html__( 'Position', '@@textdomain' ),
			'section'     => 'login_designer__section--styles',
			'description' => 'px',
			'default'     => $defaults['below_position'],
			'input_attrs' => array(
				'min'  => 20,
				'max'  => 80,
				'step' => 2,
			),
		)
	)
);

$wp_customize->add_setting(
	'login_designer[lost_password]', array(
		'default'           => $defaults['lost_password'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize, 'login_designer[lost_password]', array(
			'label'    => esc_html__( 'Lost Password', '@@textdomain' ),
			'section'  => 'login_designer__section--styles',
			'type'     => 'login-designer-toggle',
			'settings' => 'login_designer[lost_password]',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[back_to]', array(
		'default'           => $defaults['back_to'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize, 'login_designer[back_to]', array(
			'label'    => esc_html__( 'Back To', '@@textdomain' ),
			'section'  => 'login_designer__section--styles',
			'type'     => 'login-designer-toggle',
			'settings' => 'login_designer[back_to]',
		)
	)
);
