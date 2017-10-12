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
$wp_customize->add_setting( 'loginly__custom-background-color', array(
	'default'               => null,
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'loginly__custom-background-color', array(
	'label'                 => esc_html__( 'Background Color', '@@textdomain' ),
	'section'               => 'loginly__section--background',
) ) );

$wp_customize->add_setting( 'loginly__custom-background-image--url', array(
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'esc_url',
) );

$wp_customize->add_setting( 'loginly__custom-background-image--id', array(
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'absint',
) );

$wp_customize->add_setting( 'loginly__custom-background-image--repeat', array(
	'default' 		=> 'repeat',
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'sanitize_text_field',
) );

$wp_customize->add_setting( 'loginly__custom-background-image--size', array(
	'default' 		=> 'cover',
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'sanitize_text_field',
) );

$wp_customize->add_setting( 'loginly__custom-background-image--attach', array(
	'default' 		=> 'center-center',
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'sanitize_text_field',
) );

$wp_customize->add_setting( 'loginly__custom-background-image--position', array(
	'default' 		=> 'fixed',
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'sanitize_text_field',
) );

$wp_customize->add_control( new Loginly_Background_Control( $wp_customize, 'loginly__custom-background-image', array(
		'label'				=> esc_html__( 'Background Image', '@@textdomain' ),
		'section'			=> 'loginly__section--background',
		'settings'    			=> array(
			'image_url' 		=> 'loginly__custom-background-image--url',
			'image_id' 		=> 'loginly__custom-background-image--id',
			'repeat' 		=> 'loginly__custom-background-image--repeat',
			'size' 			=> 'loginly__custom-background-image--size',
			'attach' 		=> 'loginly__custom-background-image--attach',
			'position' 		=> 'loginly__custom-background-image--position',
		),
	)
) );

$wp_customize->add_setting( 'loginly__background-gallery', array(
	'default'               => null,
	'transport'             => 'postMessage',
) );

$wp_customize->add_control( new Loginly_Background_Gallery_Control( $wp_customize, 'loginly__background-gallery', array(
	'label'			=> esc_html__( 'Background Gallery', '@@textdomain' ),
	'description'		=> esc_html__( 'Or choose an image from our human-curated collection of beautiful backgrounds.', '@@textdomain' ),
	'type'                  => 'loginly-background-gallery',
	'section'               => 'loginly__section--background',
	'choices'               => $this->get_choices( $this->get_background_images() ),
) ) );


