<?php
/**
 * Labels Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Settings.
 */
$wp_customize->add_setting( 'login_designer_title_form_labels', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_title_form_labels', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Field Labels', '@@textdomain' ),
	'description'           => esc_html__( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer_form_label_username_text', array(
	'default'           	=> esc_html__( 'Username or Email Address', '@@textdomain' ),
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'esc_html',
) );

$wp_customize->add_control( 'login_designer_form_label_username_text', array(
	'label'          	=> esc_html__( 'Username', '@@textdomain' ),
	'section'        	=> 'login_designer__section--styles',
	'type'           	=> 'text',
) );

$wp_customize->add_setting( 'login_designer_form_label_password_text', array(
	'default'           	=> esc_html__( 'Password', '@@textdomain' ),
	'transport'             => 'postMessage',
	'sanitize_callback' 	=> 'esc_html',
) );

$wp_customize->add_control( 'login_designer_form_label_password_text', array(
	'label'         	=> esc_html__( 'Password', '@@textdomain' ),
	'section'       	=> 'login_designer__section--styles',
	'type'           	=> 'text',
) );

$wp_customize->add_setting( 'login_designer_form_label_font', array(
	'default'               => 'default',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'wp_filter_nohtml_kses',
) );

$wp_customize->add_control( 'login_designer_form_label_font', array(
	'type'              	=> 'select',
	'label'             	=> esc_html__( 'Font', '@@textdomain' ),
	'section'          	=> 'login_designer__section--styles',
	'choices'           	=> $this->get_fonts(),
) );

$wp_customize->add_setting( 'login_designer_form_label_size', array(
	'default'               => '14',
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'absint',
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
	'transport'             => 'postMessage',
	'sanitize_callback'     => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_form_label_color', array(
	'label'                 => esc_html__( 'Color', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );
