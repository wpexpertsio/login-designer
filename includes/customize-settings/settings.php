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

$extensions_url = esc_url( add_query_arg( array(
	'utm_source'   => 'plugins-page',
	'utm_medium'   => 'plugin-admin-bail-notice',
	'utm_campaign' => 'admin',
	'utm_content' => 'login-designer-redirection',
	),
'https://logindesigner.com/' ) );

$wp_customize->add_setting( 'login_designer[settings_title]', array(
	'sanitize_callback'     => 'sanitize_text_field',
) );

$wp_customize->add_control( new Login_Designer_Title_Control( $wp_customize, 'login_designer[settings_title]', array(
	'type'                  => 'login-designer-title',
	'label'                 => esc_html__( 'Settings', '@@textdomain' ),
	'description'           => esc_html__( 'Additional plugin settings and added functionality to extend Login Designer.', '@@textdomain' ),
	'section'               => 'login_designer__section--settings',
	'priority' 		=> 1,
) ) );
