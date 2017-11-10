<?php
/**
 * Remember Me Customizer Section.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 * @version   @@pkg.version
 */

/**
 * Settings.
 */
$wp_customize->add_setting( 'login_designer[below_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[below_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Below Form', '@@textdomain' ),
	'description'           => esc_html__( 'Modify elements below the login form.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );

$wp_customize->add_setting( 'login_designer[lost_password]', array(
	'default'               => $defaults['lost_password'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => array( $this, 'sanitize_checkbox' ),
) );

$wp_customize->add_control( new Login_Designer_Toggle_Control( $wp_customize, 'login_designer[lost_password]', array(
	'label'	      => esc_html__( 'Lost Password', '@@textdomain' ),
	'section'     => 'login_designer__section--styles',
	'type'        => 'toggle',
	'settings'    => 'login_designer[lost_password]',
) ) );

$wp_customize->add_setting( 'login_designer[back_to]', array(
	'default'               => $defaults['back_to'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
	'sanitize_callback'     => array( $this, 'sanitize_checkbox' ),
) );

$wp_customize->add_control( new Login_Designer_Toggle_Control( $wp_customize, 'login_designer[back_to]', array(
	'label'	      => esc_html__( 'Back To', '@@textdomain' ),
	'section'     => 'login_designer__section--styles',
	'type'        => 'toggle',
	'settings'    => 'login_designer[back_to]',
) ) );
