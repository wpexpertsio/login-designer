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

$wp_customize->add_setting( 'login_designer[settings_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[settings_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'General Settings', '@@textdomain' ),
	'description'           => __( 'Integer posuere erat a ante venenatis dapibus posuere velit aliquet llam quis.', '@@textdomain' ),
	'section'               => 'login_designer__section--settings',
	'priority' 		=> 1,
) ) );
