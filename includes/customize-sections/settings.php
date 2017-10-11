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
 * Settings Section.
 */
$wp_customize->add_setting( 'loginly__logo-url', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'loginly__logo-url', array(
	'label'          => esc_html__( 'Logo URL', '@@textdomain' ),
	'section'        => 'loginly__section--settings',
	'type'           => 'dropdown-pages',
	'allow_addition' => true,
) );

$wp_customize->add_setting( 'loginly__login-redirect', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'loginly__login-redirect', array(
	'label'          => esc_html__( 'Login Redirect', '@@textdomain' ),
	'section'        => 'loginly__section--settings',
	'type'           => 'dropdown-pages',
	'allow_addition' => true,
) );

$wp_customize->add_setting( 'loginly__logout-redirect', array(
	'default'           => '',
	'sanitize_callback' => 'absint',
	'transport'         => 'postMessage',
) );

$wp_customize->add_control( 'loginly__logout-redirect', array(
	'label'          => esc_html__( 'Logout Redirect', '@@textdomain' ),
	'section'        => 'loginly__section--settings',
	'type'           => 'dropdown-pages',
	'allow_addition' => true,
) );

$wp_customize->add_setting( 'loginly__login-message', array(
	'default'           => '',
	'sanitize_callback' => 'esc_textarea',
	'transport'         => '',
) );

$wp_customize->add_control( 'loginly__login-message', array(
	'label'          => esc_html__( 'Login Message', '@@textdomain' ),
	'section'        => 'loginly__section--settings',
	'type'           => 'textarea',
) );