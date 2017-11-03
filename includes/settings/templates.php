<?php
/**
 * Templates Customizer Section.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 * @version   @@pkg.version
 */

$wp_customize->add_setting( 'login_designer[template]', array(
	'default'               => $defaults['template'],
	'type' 			=> 'option',
	'transport'             => 'postMessage',
) );

$wp_customize->add_control( new Login_Designer_Template_Control( $wp_customize, 'login_designer[template]', array(
	'type'                  => 'login-designer-template-selector',
	'description'           => esc_html__( 'You can switch templates at any time. Previewing a template allows you to make style changes without changing the live template visitors see.', '@@textdomain' ),
	'section'               => 'login_designer__section--templates',
	'choices'               => $this->get_choices( $this->get_templates() ),
) ) );
