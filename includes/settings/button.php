<?php
/**
 * Button Customizer Section.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 * @version   @@pkg.version
 */

/**
 * Settings.
 */
$wp_customize->add_setting( 'login_designer[button_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[button_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Button', '@@textdomain' ),
	'description'           => esc_html__( 'Customize the full display appearance of the login submit button.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[button_bg]', array(
	'default'               => $defaults['button_bg'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer[button_bg]', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[button_height]', array(
	'default'               => $defaults['button_height'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[button_height]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Height', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['button_height'],
	'input_attrs'           => array(
		'min'               => 1,
		'max'               => 20,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[button_side_padding]', array(
	'default'               => $defaults['button_side_padding'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[button_side_padding]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Padding', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['button_side_padding'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 60,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[button_border]', array(
	'default'               => $defaults['button_border'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[button_border]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Border', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['button_border'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 10,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[button_border_color]', array(
	'default'               => $defaults['button_border_color'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer[button_border_color]', array(
	'label'                 => esc_html__( 'Border Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[button_radius]', array(
	'default'               => $defaults['button_radius'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[button_radius]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Radius', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['button_radius'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 60,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[button_shadow]', array(
	'default'               => $defaults['button_shadow'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[button_shadow]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['button_shadow'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 30,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[button_shadow_opacity]', array(
	'default'               => $defaults['button_shadow_opacity'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[button_shadow_opacity]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow Opacity', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => '%',
	'default'               => $defaults['button_shadow_opacity'],
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 1,
		),
	)
) );


/**
 * Button Text.
 */
$wp_customize->add_setting( 'login_designer[button_text_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[button_text_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Text', '@@textdomain' ),
	'description'           => esc_html__( 'Change the button font, color and size.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[button_font]', array(
	'default'               => $defaults['button_font'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'wp_filter_nohtml_kses',
) );

$wp_customize->add_control( 'login_designer[button_font]', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Font', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'choices'           => $this->get_fonts(),
) );

$wp_customize->add_setting( 'login_designer[button_font_size]', array(
	'default'               => $defaults['button_font_size'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
) );

$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer[button_font_size]', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Size', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => $defaults['button_font_size'],
	'input_attrs'           => array(
		'min'               => 13,
		'max'               => 40,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer[button_color]', array(
	'default'               => $defaults['button_color'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer[button_color]', array(
	'label'                 => esc_html__( 'Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );








