<?php
/**
 * Background Customizer Section.
 *
 * @package Login Designer
 */

// Set background choices from the Customize class.
$login_designer_background_choices = $this->get_background_choices();

$wp_customize->add_setting(
	'login_designer[bg_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer[bg_title]',
		array(
			'type'    => 'login-designer-title',
			'label'   => esc_html__( 'Upload Background', 'login-designer' ),
			'section' => 'login_designer__section--styles',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[bg_image]',
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
		'login_designer[bg_image]',
		array(
			'section'  => 'login_designer__section--styles',
			'settings' => 'login_designer[bg_image]',
			'multiple' => 'add',
		)
	)
);

$wp_customize->add_setting(
	'login_designer[bg_image_gallery]',
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
		'login_designer[bg_image_gallery]',
		array(
			'label'       => esc_html__( 'Background Gallery', 'login-designer' ),
			'description' => esc_html__( 'Pick a background image from our curated collection of beautiful images.', 'login-designer' ),
			'type'        => 'login-designer-gallery',
			'section'     => 'login_designer__section--styles',
			'choices'     => $this->get_choices( $this->get_background_images() ),
		)
	)
);

$wp_customize->add_setting(
	'login_designer[bg_repeat]',
	array(
		'default'           => $defaults['bg_repeat'],
		'type'              => 'option',
		'default'           => 'no-repeat',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'login_designer[bg_repeat]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Repeat', 'login-designer' ),
		'section' => 'login_designer__section--styles',
		'choices' => $login_designer_background_choices['repeat'],
	)
);

$wp_customize->add_setting(
	'login_designer[bg_size]',
	array(
		'default'           => $defaults['bg_size'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'login_designer[bg_size]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Size', 'login-designer' ),
		'section' => 'login_designer__section--styles',
		'choices' => $login_designer_background_choices['size'],
	)
);

$wp_customize->add_setting(
	'login_designer[bg_attach]',
	array(
		'default'           => $defaults['bg_attach'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'login_designer[bg_attach]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Attachment', 'login-designer' ),
		'section' => 'login_designer__section--styles',
		'choices' => $login_designer_background_choices['attach'],
	)
);

$wp_customize->add_setting(
	'login_designer[bg_position]',
	array(
		'default'           => $defaults['bg_position'],
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	'login_designer[bg_position]',
	array(
		'type'    => 'select',
		'label'   => esc_html__( 'Position', 'login-designer' ),
		'section' => 'login_designer__section--styles',
		'choices' => $login_designer_background_choices['position'],
	)
);

$wp_customize->add_setting(
	'login_designer[bg_color]',
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
		'login_designer[bg_color]',
		array(
			'label'   => esc_html__( 'Color', 'login-designer' ),
			'section' => 'login_designer__section--styles',
		)
	)
);

do_action(
	'login_designer_background_customizer',
	$wp_customize,
	$this,
	array(
		'section'     => 'login_designer__section--styles',
		'panel'       => 'login_designer',
		'backgrounds' => $login_designer_background_choices,
	)
);
