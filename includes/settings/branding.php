<?php
/**
 * Branding Customizer Section.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Settings.
 */
$wp_customize->add_setting( 'login_designer_settings[branding_title]', array(
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer_settings[branding_title]', array(
	'type'        => 'login-designer-title',
	'label'       => esc_html__( 'Branding', '@@textdomain' ),
	'description' => esc_html__( 'Show some love and add a "Powered by Login Designer" mark to your login page.', '@@textdomain' ),
	'section'     => 'login_designer__section--settings',
) ) );

$wp_customize->add_setting( 'login_designer_settings[branding]', array(
	'default'           => $admin_defaults['branding'],
	'type'              => 'option',
	'transport'         => 'postMessage',
	'sanitize_callback' => array( $this, 'sanitize_checkbox' ),
) );

$wp_customize->add_control( new Login_Designer_Toggle_Control( $wp_customize, 'login_designer_settings[branding]', array(
	'label'    => esc_html__( 'Powered By Link', '@@textdomain' ),
	'type'     => 'toggle',
	'settings' => 'login_designer_settings[branding]',
	'section'  => 'login_designer__section--settings',
) ) );

$wp_customize->add_setting( 'login_designer_settings[branding_color]', array(
	'default'           => $admin_defaults['branding_color'],
	'type'              => 'option',
	'transport'         => 'postMessage',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_settings[branding_color]', array(
	'label'   => esc_html__( 'Text Color', '@@textdomain' ),
	'section' => 'login_designer__section--settings',
) ) );

$wp_customize->add_setting( 'login_designer_settings[branding_icon_color]', array(
	'default'           => $admin_defaults['branding_icon_color'],
	'type'              => 'option',
	'transport'         => 'postMessage',
	'sanitize_callback' => 'sanitize_hex_color',
) );

$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'login_designer_settings[branding_icon_color]', array(
	'label'   => esc_html__( 'Logo Color', '@@textdomain' ),
	'section' => 'login_designer__section--settings',
) ) );
