<?php
/**
 * Templates Customizer Section.
 *
 * @package Login Designer
 */

// Return early if the class is missing.
if ( ! class_exists( 'Login_Designer_Templates' ) ) {
	return;
}

// Set template choices.
$login_designer_template = new Login_Designer_Templates();

$wp_customize->add_setting(
	'login_designer[template]',
	array(
		'default'   => 'default',
		'type'      => 'option',
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new Login_Designer_Template_Control(
		$wp_customize,
		'login_designer[template]',
		array(
			'type'    => 'login-designer-templates',
			'section' => 'login_designer__section--templates',
			'choices' => $this->get_choices( $login_designer_template->get_templates() ),
		)
	)
);
