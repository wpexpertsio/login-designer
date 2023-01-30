<?php
/**
 * File: form-animation.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'login_designer_dummy[form_animation]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_dummy[form_animation]',
		array(
			'type'        => 'login-designer-title',
			'label'       => __( 'Form Animation', 'login-designer' ),
			'description' => esc_attr__( 'Are you looking for ways to make your login page impressive? With the login designer pro version, you can add animation to your logo and login form on the login page with more the 30+ effects.', 'login-designer' ),
			'section'     => 'login_designer__section--form-animation',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_dummy[form_animation_image]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Dummy_Control(
		$wp_customize,
		'login_designer_dummy[form_animation_image]',
		array(
			'type'        => 'login-designer-dummy-control',
			'label'       => __( 'Form Animation', 'login-designer' ),
			'description' => esc_attr__( 'some description', 'login-designer' ),
			'section'     => 'login_designer__section--form-animation',
			'image_src'   => esc_url( LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/form-animation.gif' ),
		)
	)
);
