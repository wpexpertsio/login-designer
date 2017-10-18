<?php
/**
 * Background Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Set background choices from the Customize class.
$background_choices = $this->get_background_choices();

/**
 * Settings.
 */
$wp_customize->add_setting( 'login_designer_title_bg', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_bg', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Upload Background', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer_bg_image', array(
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'esc_html',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'login_designer_bg_image', array(
	'section'              => 'login_designer__section--styles',
	'settings'             => 'login_designer_bg_image',
) ) );

$wp_customize->add_setting( 'login_designer_bg_image_gallery', array(
	'default'               => null,
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'esc_html',
) );

$wp_customize->add_control( new Login_Designer_Background_Gallery_Control( $wp_customize, 'login_designer_bg_image_gallery', array(
	'label'                 => esc_html__( 'Background Gallery', '@@textdomain' ),
	'description'           => esc_html__( 'Pick a background image from this curated collection of beautiful images.', '@@textdomain' ),
	'type'                  => 'login-designer-gallery',
	'section'               => 'login_designer__section--styles',
	'choices'               => $this->get_choices( $this->get_background_images() ),
) ) );

$wp_customize->add_setting( 'login_designer_bg_image_repeat', array(
	'default'               => 'no-repeat',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( 'login_designer_bg_image_repeat', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Repeat', '@@textdomain' ),
	'section'           => 'login_designer__section--styles',
	'choices'           => $background_choices['repeat'],
) );

$wp_customize->add_setting( 'login_designer_bg_image_size', array(
	'default'               => 'cover',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( 'login_designer_bg_image_size', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Size', '@@textdomain' ),
	'section'           => 'login_designer__section--styles',
	'choices'           => $background_choices['size'],
) );

$wp_customize->add_setting( 'login_designer_bg_image_attach', array(
	'default'               => 'center-center',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( 'login_designer_bg_image_attach', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Attachment', '@@textdomain' ),
	'section'           => 'login_designer__section--styles',
	'choices'           => $background_choices['attach'],
) );

$wp_customize->add_setting( 'login_designer_bg_image_position', array(
	'default'               => 'fixed',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( 'login_designer_bg_image_position', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Position', '@@textdomain' ),
	'section'           => 'login_designer__section--styles',
	'choices'           => $background_choices['position'],
) );

$wp_customize->add_setting( 'login_designer_bg_color', array(
	'default'               => null,
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_bg_color', array(
	'label'                 => esc_html__( 'Background Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );
