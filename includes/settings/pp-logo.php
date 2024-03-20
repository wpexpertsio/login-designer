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
			'description' => esc_attr__( 'Customize your Logo sizes, change your Logo and Remove your logo using these settings', 'login-designer' ),
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
		'description'    => esc_html__( 'Select a page for your logo to link to. This is typically your site\'s home page.', 'login-designer' ),
		'section'        => 'password_protected__section--logo',
		'type'           => 'dropdown-pages',
		'allow_addition' => false,
	)
);

/**
 * In future add new settings here.
 *
 * @todo add Logo Width Settings.
 * @todo add Logo Height Settings.
 * @todo add Logo Position Settings.
 */
$wp_customize->add_setting(
	'password_protected[logo_width]',
	array(
		'default'           => $defaults['logo_width'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
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


$wp_customize->add_setting(
	'password_protected[logo_margin_bottom]',
	array(
		'default'           => $defaults['logo_margin_bottom'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'absint',
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
