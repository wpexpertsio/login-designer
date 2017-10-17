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
 * Add the background color selector.
 */
$wp_customize->add_setting( 'login_designer_title_bg', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_bg', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer_bg_image', array(
	// 'transport'             => 'postMessage',
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'login_designer_bg_image', array(
	'label'                => esc_html__( 'Upload Image', '@@textdomain' ),
	'section'              => 'login_designer__section--styles',
	'settings'             => 'login_designer_bg_image',
) ) );


// Set background choices from the Customize class.
$background_choices = $this->get_background_choices();

$wp_customize->add_setting( 'login_designer_bg_image_repeat', array(
	'default'               => 'no-repeat',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( 'login_designer_bg_image_repeat', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Repeat', '@@textdomain' ),
	'section'           => 'login_designer__section--styles',
	'choices'           => $background_choices['repeat'],
) );

$wp_customize->add_setting( 'login_designer_bg_image_size', array(
	'default'               => 'cover',
	// 'transport'             => 'postMessage',
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
	// 'transport'             => 'postMessage',
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
	// 'transport'             => 'postMessage',
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
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_bg_color', array(
	'label'                 => esc_html__( 'Background Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );













// $wp_customize->add_setting( 'login_designer__gallery', array(
// 	'default'               => null,
// 	// 'transport'             => 'postMessage',
// ) );

// $wp_customize->add_control( new Login_Designer_Background_Gallery_Control( $wp_customize, 'login_designer__gallery', array(
// 	'label'			=> esc_html__( 'Background Gallery', '@@textdomain' ),
// 	'description'		=> esc_html__( 'Or choose an image from our human-curated collection of beautiful backgrounds.', '@@textdomain' ),
// 	'type'                  => 'login-designer-gallery',
// 	'section'               => 'login_designer__section--styles',
// 	'choices'               => $this->get_choices( $this->get_background_images() ),
// ) ) );




















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



$wp_customize->add_setting( 'login_designer_form_background_color', array(
	'default'               => null,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_background_color', array(
	'label'                 => esc_html__( 'Background', '@@textdomain' ),
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










/**
 * Form Fields.
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


$wp_customize->add_setting( 'login_designer_form_field_side_padding', array(
	'default'               => '3',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_side_padding', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Side Padding', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '3',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 40,
		'step'              => 1,
		),
	)
) );


$wp_customize->add_setting( 'login_designer_form_field_border_size', array(
	'default'               => '1',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_border_size', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Border', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '1',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 10,
		'step'              => 1,
		),
	)
) );


$wp_customize->add_setting( 'login_designer_form_field_border_color', array(
	'default'               => '#dddddd',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_field_border_color', array(
	'label'                 => esc_html__( 'Border Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );


$wp_customize->add_setting( 'login_designer_form_field_box_shadow', array(
	'default'               => '2',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_box_shadow', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '2',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 30,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_box_shadow_opacity', array(
	'default'               => '7',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_box_shadow_opacity', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Shadow Opacity', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => '%',
	'default'               => '7',
	'input_attrs'           => array(
		'min'               => 0,
		'max'               => 100,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_box_shadow_inset', array(
	'default'               => true,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );

$wp_customize->add_control( 'login_designer_form_field_box_shadow_inset', array(
	'type'                  => 'checkbox',
	'label'                 => esc_html__( 'Shadow Inset', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) );






/**
 * Form Fields.
 */
$wp_customize->add_setting( 'login_designer_title_form_field_text', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_form_field_text', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Fields Text', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );


$wp_customize->add_setting( 'login_designer_form_field_font', array(
	'default'               => 'default',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );

$wp_customize->add_control( 'login_designer_form_field_font', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Font', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'choices'           => $this->get_fonts(),
) );


$wp_customize->add_setting( 'login_designer_form_field_text_size', array(
	'default'               => '24',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_field_text_size', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Font Size', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '24',
	'input_attrs'           => array(
		'min'               => 13,
		'max'               => 40,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_field_text_color', array(
	'default'               => null,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_field_text_color', array(
	'label'                 => esc_html__( 'Font Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );



















/**
 * Labels.
 */
$wp_customize->add_setting( 'login_designer_title_form_labels', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_form_labels', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Form Labels', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );


$wp_customize->add_setting( 'login_designer_form_label_username_text', array(
	'default'           	=> esc_html__( 'Username or Email Address', '@@textdomain' ),
	'sanitize_callback' 	=> 'esc_html',
	// 'transport'         	=> '',
) );

$wp_customize->add_control( 'login_designer_form_label_username_text', array(
	'label'          => esc_html__( 'Username', '@@textdomain' ),
	'section'        => 'login_designer__section--styles',
	'type'           => 'text',
) );

$wp_customize->add_setting( 'login_designer_form_label_password_text', array(
	'default'           	=> esc_html__( 'Password', '@@textdomain' ),
	'sanitize_callback' 	=> 'esc_html',
	// 'transport'         	=> '',
) );

$wp_customize->add_control( 'login_designer_form_label_password_text', array(
	'label'          => esc_html__( 'Password', '@@textdomain' ),
	'section'        => 'login_designer__section--styles',
	'type'           => 'text',
) );

$wp_customize->add_setting( 'login_designer_form_label_font', array(
	'default'               => 'default',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );

$wp_customize->add_control( 'login_designer_form_label_font', array(
	'type'              => 'select',
	'label'             => esc_html__( 'Font', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'choices'           => $this->get_fonts(),
) );

$wp_customize->add_setting( 'login_designer_form_label_size', array(
	'default'               => '14',
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => '',
) );
$wp_customize->add_control( new Login_Designer_Range_Control( $wp_customize, 'login_designer_form_label_size', array(
	'type'                  => 'login-designer-range',
	'label'                 => esc_html__( 'Size', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
	'description'           => 'px',
	'default'               => '14',
	'input_attrs'           => array(
		'min'               => 13,
		'max'               => 40,
		'step'              => 1,
		),
	)
) );

$wp_customize->add_setting( 'login_designer_form_label_color', array(
	'default'               => null,
	// 'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );
$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_label_color', array(
	'label'                 => esc_html__( 'Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );





/**
 * Button.
 */
$wp_customize->add_setting( 'login_designer_title_button', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );
$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_button', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Submit Button', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );





























