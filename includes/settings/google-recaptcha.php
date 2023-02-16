<?php
/**
 * Google Recaptcha
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'login_designer_google_recaptcha[page_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_google_recaptcha[page_title]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_attr__( 'Google Recaptcha' ),
			'description' => esc_attr__( 'Now we are able to secure your login form using Google Recaptcha, We are using Google Recaptcha V3', 'login-designer' ),
			'section'     => 'login_designer__section--google-recaptcha',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_google_recaptcha[enable_google_recaptcha]',
	array(
		'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	new Login_Designer_Toggle_Control(
		$wp_customize,
		'login_designer_google_recaptcha[enable_google_recaptcha]',
		array(
			'label'    => esc_attr__( 'Enable', 'login-designer' ),
			'type'     => 'login-designer-toggle',
			'section'  => 'login_designer__section--google-recaptcha',
			'settings' => 'login_designer_google_recaptcha[enable_google_recaptcha]',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_google_recaptcha[recaptcha_version]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
		'type'              => 'option',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'login_designer_google_recaptcha[recaptcha_version]',
	array(
		'label'   => esc_attr__( 'Google Recaptcha Version', 'login-designer' ),
		'type'    => 'radio',
		'section' => 'login_designer__section--google-recaptcha',
		'choices' => array(
			'2' => esc_attr__( 'V2', 'login-designer' ),
			'3' => esc_attr__( 'V3', 'login-designer' ),
		),
	)
);

$wp_customize->add_setting(
	'login_designer_google_recaptcha[google_recaptcha_api_key]',
	array(
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'login_designer_google_recaptcha[google_recaptcha_api_key]',
	array(
		'type'    => 'text',
		'label'   => esc_attr__( 'Enter your Recaptcha API Key', 'login-designer' ),
		'section' => 'login_designer__section--google-recaptcha',
	)
);

$wp_customize->add_setting(
	'login_designer_google_recaptcha[google_recaptcha_secrete_key]',
	array(
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'postMessage',
	)
);

$wp_customize->add_control(
	'login_designer_google_recaptcha[google_recaptcha_secrete_key]',
	array(
		'type'    => 'text',
		'label'   => esc_attr__( 'Enter your Recaptcha Secret Key', 'login-designer' ),
		'section' => 'login_designer__section--google-recaptcha',
	)
);

$wp_customize->add_setting(
	'login_designer_google_recaptcha[test_site_and_secrete_key]',
	array(
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
		'transport'         => 'refresh',
	)
);

$wp_customize->add_control(
	new Login_Designer_Test_Recaptcha(
		$wp_customize,
		'login_designer_google_recaptcha[test_site_and_secrete_key]',
		array(
			'type'    => 'login-designer-test-recaptcha',
			'label'   => esc_attr__( 'Test Site and Secret Key', 'login-designer' ),
			'section' => 'login_designer__section--google-recaptcha',
		)
	)
);
