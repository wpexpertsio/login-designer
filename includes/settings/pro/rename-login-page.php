<?php
/**
 * File: rename-login-page.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'login_designer_dummy[rename_login_page]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_dummy[rename_login_page]',
		array(
			'type'        => 'login-designer-title',
			'label'       => __( 'Rename Login Page', 'login-designer' ),
			'description' => esc_attr__( 'The Hide/Rename option lets you change the URL of the login page to something more uncommon, which prevents spammers from hacking your website.', 'login-designer' ),
			'section'     => 'login_designer__section--rename-login-page',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_dummy[rename_login_page_image]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Dummy_Control(
		$wp_customize,
		'login_designer_dummy[rename_login_page_image]',
		array(
			'type'        => 'login-designer-dummy-control',
			'label'       => __( 'Rename Login Page', 'login-designer' ),
			'description' => esc_attr__( 'The Hide/Rename option lets you change the URL of the login page to something more uncommon, which prevents spammers from hacking your website.', 'login-designer' ),
			'section'     => 'login_designer__section--rename-login-page',
			'image_src'   => esc_url( LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/rename-login-page.png' ),
		)
	)
);
