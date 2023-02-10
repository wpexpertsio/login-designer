<?php
/**
 * Login Error Messges.
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'login_designer_error_messages[page_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_error_messages[page_title]',
		array(
			'type'    => 'login-designer-title',
			'label'   => esc_attr__( 'Login Error Messages', 'login-designer' ),
			'section' => 'login_designer__section--error-messages',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_error_messages[username_error]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'login_designer_error_messages[username_error]',
	array(
		'label'       => esc_attr__( 'Enter Username required message', 'login-designer' ),
		'section'     => 'login_designer__section--error-messages',
		'description' => esc_attr__( 'Enter the message which will display when Username field is empty', 'login-designer' ),
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'login_designer_error_messages[password_error]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'login_designer_error_messages[password_error]',
	array(
		'label'       => esc_attr__( 'Enter Password required message', 'login-designer' ),
		'section'     => 'login_designer__section--error-messages',
		'description' => esc_attr__( 'Enter the message which will display when Password field is empty', 'login-designer' ),
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'login_designer_error_messages[username_not_found]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'login_designer_error_messages[username_not_found]',
	array(
		'label'       => esc_attr__( 'Enter Username invalid message', 'login-designer' ),
		'section'     => 'login_designer__section--error-messages',
		'description' => esc_attr__( 'Enter the message which will display when Username is invalid', 'login-designer' ),
		'type'        => 'text',
	)
);

$wp_customize->add_setting(
	'login_designer_error_messages[password_incorrect]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'login_designer_error_messages[password_incorrect]',
	array(
		'label'       => esc_attr__( 'Enter Password invalid message', 'login-designer' ),
		'section'     => 'login_designer__section--error-messages',
		'description' => esc_attr__( 'Enter the message which will display when Password is invalid', 'login-designer' ),
		'type'        => 'text',
	)
);
