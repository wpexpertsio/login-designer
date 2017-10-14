<?php
/**
 * Background Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Add the background color selector.
 */
$wp_customize->add_setting( 'login_designer_body_bg_color', array(
	'default'               => null,
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_body_bg_color', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'login_designer__section--background',
) ) );

$wp_customize->add_setting( 'login_designer_body_bg_img__url', array(
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'esc_url',
) );

$wp_customize->add_setting( 'login_designer_body_bg_img__id', array(
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'absint',
) );

$wp_customize->add_setting( 'login_designer_body_bg_img__repeat', array(
	'default' 		=> 'repeat',
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'sanitize_text_field',
) );

$wp_customize->add_setting( 'login_designer_body_bg_img__size', array(
	'default' 		=> 'cover',
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'sanitize_text_field',
) );

$wp_customize->add_setting( 'login_designer_body_bg_img__attach', array(
	'default' 		=> 'center-center',
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'sanitize_text_field',
) );

$wp_customize->add_setting( 'login_designer_body_bg_img__position', array(
	'default' 		=> 'fixed',
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'sanitize_text_field',
) );

$wp_customize->add_control( new LoginDesigner_Background_Control( $wp_customize, 'login_designer__custom-background-image', array(
		'label'				=> esc_html__( 'Background Image', '@@textdomain' ),
		'section'			=> 'login_designer__section--background',
		'settings'    			=> array(
			'image_url' 		=> 'login_designer_body_bg_img__url',
			'image_id' 		=> 'login_designer_body_bg_img__id',
			'repeat' 		=> 'login_designer_body_bg_img__repeat',
			'size' 			=> 'login_designer_body_bg_img__size',
			'attach' 		=> 'login_designer_body_bg_img__attach',
			'position' 		=> 'login_designer_body_bg_img__position',
		),
	)
) );

$wp_customize->add_setting( 'login_designer__gallery', array(
	'default'               => null,
	'transport'             => 'postMessage',
) );

$wp_customize->add_control( new LoginDesigner_Background_Gallery_Control( $wp_customize, 'login_designer__gallery', array(
	'label'			=> esc_html__( 'Background Gallery', '@@textdomain' ),
	'description'		=> esc_html__( 'Or choose an image from our human-curated collection of beautiful backgrounds.', '@@textdomain' ),
	'type'                  => 'login-designer-gallery',
	'section'               => 'login_designer__section--background',
	'choices'               => $this->get_choices( $this->get_background_images() ),
) ) );


