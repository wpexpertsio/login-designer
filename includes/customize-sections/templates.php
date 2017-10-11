<?php
/**
 * Templates Customizer Section.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

$wp_customize->add_setting( 'loginly__template-selector', array(
	'default'               => 'loginly__template--01',
	'transport'             => 'postMessage',
) );

$wp_customize->add_control( new Loginly_Template_Control( $wp_customize, 'loginly__template-selector', array(
	'type'                  => 'loginly-template-selector',
	'description'           => esc_html__( 'You can switch templates at any time. Previewing a template allows you to make style changes without changing the live template visitors see.', '@@textdomain' ),
	'section'               => 'loginly__section--templates',
	'choices'               => $this->get_choices( $this->get_templates() ),
) ) );
