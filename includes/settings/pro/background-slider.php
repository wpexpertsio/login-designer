<?php
/**
 * File: background-slider.php
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'login_designer_dummy[background_slider]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_dummy[background_slider]',
		array(
			'type'        => 'login-designer-title',
			'label'       => __( 'Background Slider', 'login-designer' ),
			'description' => esc_attr__( 'Add more interaction with the image slider in the background and get complete control over effects and transition speed.', 'login-designer' ),
			'section'     => 'login_designer__section--background-slider',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_dummy[background_slider_image]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Dummy_Control(
		$wp_customize,
		'login_designer_dummy[background_slider_image]',
		array(
			'type'        => 'login-designer-dummy-control',
			'label'       => __( 'Background Slider', 'login-designer' ),
			'description' => esc_attr__( 'some description', 'login-designer' ),
			'section'     => 'login_designer__section--background-slider',
			'image_src'   => esc_url( LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/background-slider.gif' ),
		)
	)
);
