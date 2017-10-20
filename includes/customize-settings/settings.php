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

$wp_customize->add_setting( 'login_designer[login_redirect]', array(
	'default'               => $defaults['login_redirect'],
	'type' 			=> 'option',
	'transport'         	=> 'postMessage',
	'sanitize_callback' 	=> 'absint',
) );

$wp_customize->add_control( 'login_designer[login_redirect]', array(
	'label'          	=> esc_html__( 'Login Redirect', '@@textdomain' ),
	'section'        	=> 'login_designer__section--settings',
	'type'           	=> 'dropdown-pages',
	'allow_addition'	=> true,
) );

$wp_customize->add_setting( 'login_designer[logout_redirect]', array(
	'default'               => $defaults['logout_redirect'],
	'type' 			=> 'option',
	'transport'         	=> 'postMessage',
	'sanitize_callback' 	=> 'absint',
) );

$wp_customize->add_control( 'login_designer[logout_redirect]', array(
	'label'          	=> esc_html__( 'Logout Redirect', '@@textdomain' ),
	'section'        	=> 'login_designer__section--settings',
	'type'          	=> 'dropdown-pages',
	'allow_addition' 	=> true,
) );

$wp_customize->add_setting( 'login_designer[login_message]', array(
	'default'               => $defaults['login_message'],
	'type' 			=> 'option',
	// 'transport'         	=> 'postMessage',
	'sanitize_callback' 	=> 'esc_textarea',
) );

$wp_customize->add_control( 'login_designer[login_message]', array(
	'label'          	=> esc_html__( 'Login Message', '@@textdomain' ),
	'section'        	=> 'login_designer__section--settings',
	'type'           	=> 'textarea',
) );
