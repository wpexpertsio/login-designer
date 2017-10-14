<?php
/**
 * Templates Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

$wp_customize->add_setting( 'login_designer__template-selector', array(
	'default'               => 'login_designer__template--01',
	'transport'             => 'postMessage',
) );

$wp_customize->add_control( new LoginDesigner_Template_Control( $wp_customize, 'login_designer__template-selector', array(
	'type'                  => 'login-designer-template-selector',
	'description'           => esc_html__( 'You can switch templates at any time. Previewing a template allows you to make style changes without changing the live template visitors see.', '@@textdomain' ),
	'section'               => 'login_designer__section--templates',
	'choices'               => $this->get_choices( $this->get_templates() ),
) ) );
