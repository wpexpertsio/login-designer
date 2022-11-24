<?php
/**
 * File: google-fonts.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'login_designer_dummy[google_fonts]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_dummy[google_fonts]',
		array(
			'type'        => 'login-designer-title',
			'label'       => __( 'Google Fonts', 'login-designer' ),
			'description' => esc_attr__( 'Do more customization on your login pages with 700+ beautiful Google fonts that can match any style.', 'login-designer' ),
			'section'     => 'login_designer__section--google-fonts',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_dummy[google_fonts_image]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Dummy_Control(
		$wp_customize,
		'login_designer_dummy[google_fonts_image]',
		array(
			'type'        => 'login-designer-dummy-control',
			'label'       => __( 'Google Fonts', 'login-designer' ),
			'description' => esc_attr__( 'some description', 'login-designer' ),
			'section'     => 'login_designer__section--google-fonts',
			'image_src'   => esc_url( LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/google-fonts.jpg' ),
		)
	)
);
