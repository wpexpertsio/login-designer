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
$wp_customize->add_setting( 'login_designer[remember_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[remember_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Remember Me', '@@textdomain' ),
	'description'           => esc_html__( 'Easily customize the "Remember Me" element on the login form.', '@@textdomain' ),
	'section'               => 'login_designer__section--styles',
) ) );
