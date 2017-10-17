<?php
/**
 * Settings Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Settings Section.
 */
$wp_customize->add_setting( 'login_designer_logo_url', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'login_designer_logo_url', array(
	'label'          => esc_html__( 'Logo URL', '@@textdomain' ),
	'section'        => 'login_designer__section--settings',
	'type'           => 'dropdown-pages',
	'allow_addition' => true,
) );

$wp_customize->add_setting( 'login_designer_login_redirect', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'login_designer_login_redirect', array(
	'label'          => esc_html__( 'Login Redirect', '@@textdomain' ),
	'section'        => 'login_designer__section--settings',
	'type'           => 'dropdown-pages',
	'allow_addition' => true,
) );

$wp_customize->add_setting( 'login_designer_logout_redirect', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'login_designer_logout_redirect', array(
	'label'          => esc_html__( 'Logout Redirect', '@@textdomain' ),
	'section'        => 'login_designer__section--settings',
	'type'           => 'dropdown-pages',
	'allow_addition' => true,
) );

$wp_customize->add_setting( 'login_designer__login-message', array(
	'default'           => '',
	'sanitize_callback' => 'esc_textarea',
	'transport'         => '',
) );

$wp_customize->add_control( 'login_designer__login-message', array(
	'label'          => esc_html__( 'Login Message', '@@textdomain' ),
	'section'        => 'login_designer__section--settings',
	'type'           => 'textarea',
) );