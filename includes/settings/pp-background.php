<?php
/**
 * File: pp-background.php
 *
 * @package Login Desinger
 */

defined( 'ABSPATH' ) || exit;

$password_protected_background_choices = $this->get_background_choices();

$wp_customize->add_setting(
	'password_protected[background]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'password_protected[background]',
		array(
			'type'    => 'login-designer-title',
			'label'   => esc_attr__( 'Change your background', 'login-designer' ),
			'section' => 'password_protected__section--body-background',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[bg_image]',
	array(
		'default'           => $defaults['bg_image'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control(
	new WP_Customize_Image_Control(
		$wp_customize,
		'password_protected[bg_image]',
		array(
			'section'  => 'password_protected__section--body-background',
			'settings' => 'password_protected[bg_image]',
		)
	)
);

$wp_customize->add_setting(
	'password_protected[bg_image_gallery]',
	array(
		'default'           => $defaults['bg_image_gallery'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'esc_html',
	)
);

$wp_customize->add_control(
	new Login_Designer_Gallery_Control(
		$wp_customize,
		'password_protected[bg_image_gallery]',
		array(
			'label'       => esc_html__( 'Background Gallery', 'login-designer' ),
			'description' => esc_html__( 'Pick a background image from our curated collection of beautiful images.', 'login-designer' ),
			'type'        => 'login-designer-gallery',
			'section'     => 'password_protected__section--body-background',
			'choices'     => $this->get_choices( $this->get_background_images() ),
		)
	)
);

$wp_customize->add_setting(
	'password_protected[bg_repeat]',
	array(
		'default'           => $defaults['bg_repeat'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'password_protected[bg_repeat]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Repeat', 'login-designer' ),
		'section' => 'password_protected__section--body-background',
		'choices' => $password_protected_background_choices['repeat'],
	)
);

$wp_customize->add_setting(
	'password_protected[bg_size]',
	array(
		'default'           => $defaults['bg_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'password_protected[bg_size]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Size', 'login-designer' ),
		'section' => 'password_protected__section--body-background',
		'choices' => $password_protected_background_choices['size'],
	)
);

$wp_customize->add_setting(
	'password_protected[bg_attach]',
	array(
		'default'           => $defaults['bg_attach'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'password_protected[bg_attach]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Attachment', 'login-designer' ),
		'section' => 'password_protected__section--body-background',
		'choices' => $password_protected_background_choices['attach'],
	)
);

$wp_customize->add_setting(
	'password_protected[bg_position]',
	array(
		'default'           => $defaults['bg_position'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'password_protected[bg_position]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Position', 'login-designer' ),
		'section' => 'password_protected__section--body-background',
		'choices' => $password_protected_background_choices['position'],
	)
);

$wp_customize->add_setting(
	'password_protected[bg_color]',
	array(
		'default'           => $defaults['bg_color'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_hex_color',
	)
);

$wp_customize->add_control(
	new WP_Customize_Color_Control(
		$wp_customize,
		'password_protected[bg_color]',
		array(
			'label'   => esc_html__( 'Color', 'login-designer' ),
			'section' => 'password_protected__section--body-background',
		)
	)
);
