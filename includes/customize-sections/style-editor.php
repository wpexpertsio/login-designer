<?php
/**
 * Style Editor Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Logo.
 */
$wp_customize->add_setting( 'login_designer_title_logo', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_logo', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Login Logo', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );


$wp_customize->add_setting( 'login_designer_custom_logo', array(
	// 'transport'             => 'postMessage',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'login_designer_custom_logo', array(
	'label'                => esc_html__( 'Upload Image', '@@textdomain' ),
	'section'              => 'login_designer__section--styles',
	'settings'             => 'login_designer_custom_logo',
) ) );


$wp_customize->add_setting( 'login_designer_custom_logo_margin_bottom', array(
	'default'               => '25',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_custom_logo_margin_bottom', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Bottom Spacing', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '25',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 1,
		),
	)
) );



/**
 * Form.
 */
$wp_customize->add_setting( 'login_designer_title_form', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_form', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Form', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );


$wp_customize->add_setting( 'login_designer_form_width', array(
	'default'               => '320',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_width', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Width', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '320',
	'input_attrs'           => array(
		'min'               => 300,
		'max'               => 800,
		'step'              => 2,
		),
	)
) );


$wp_customize->add_setting( 'login_designer_form_padding_side', array(
	'default'               => '24',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_padding_side', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Side Padding', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '24',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 2,
		),
	)
) );


$wp_customize->add_setting( 'login_designer_form_padding_top_bottom', array(
	'default'               => '26',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_padding_top_bottom', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Vertical Padding', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '26',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 2,
		),
	)
) );


$wp_customize->add_setting( 'login_designer_form_border_radius', array(
	'default'               => '0',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_border_radius', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Border Radius', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '0',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 50,
		'step'              => 1,
		),
	)
) );


$wp_customize->add_setting( 'login_designer_form_box_shadow', array(
	'default'               => '3',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_box_shadow', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '3',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 50,
		'step'              => 1,
		),
	)
) );


$wp_customize->add_setting( 'login_designer_form_box_shadow_opacity', array(
	'default'               => '13',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_box_shadow_opacity', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow Opacity', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => '%',
	'default'               => '13',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 1,
		),
	)
) );


$wp_customize->add_setting( 'login_designer_form_background_color', array(
	'default'               => null,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_background_color', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );




/**
 * Form.
 */
$wp_customize->add_setting( 'login_designer_title_form_fields', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_form_fields', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Fields', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );


$wp_customize->add_setting( 'login_designer_form_field_background', array(
	'default'               => null,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_field_background', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );










