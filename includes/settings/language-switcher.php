<?php
/**
 * Language Switcher Customizer Settings
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'login_designer_translations[translation_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_translations[translation_title]',
		array(
			'type'    => 'login-designer-title',
			'label'   => esc_html__( 'Language Switcher', 'login-designer' ),
			'section' => 'login_designer__section--translations',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_translations[translation]',
	array(
		'default'           => 0,
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize,
		'login_designer_translations[translation]',
		array(
			'label'    => esc_html__( 'Enable', 'login-designer' ),
			'type'     => 'login-designer-toggle',
			'settings' => 'login_designer_translations[translation]',
			'section'  => 'login_designer__section--translations',
		)
	)
);
