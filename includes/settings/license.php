<?php
/**
 * License Customizer Section.
 *
 * @package Login Designer
 */

// Return early, if there is no pro version yet.
if ( ! Login_Designer()->has_pro() ) {
	return;
}

$login_designer_store_url = Login_Designer()->get_store_url(
	'pricing',
	array(
		'utm_medium'   => 'login-designer-lite',
		'utm_source'   => 'customizer',
		'utm_campaign' => 'license-control',
		'utm_content'  => 'license-key',
	)
);

$wp_customize->add_setting(
	'login_designer_license[key]',
	array(
		'default'           => '',
		'transport'         => 'postMessage',
		'type'              => 'option',
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_License_Control(
		$wp_customize,
		'login_designer_license[key]',
		array(
			'type'        => 'login-designer-title',
			'label'       => esc_html__( 'License', 'login-designer' ),
			/* translators: 1: Opening link, 2: Closing link */
			'description' => sprintf( esc_html__( 'Enter a %1$slicense key%2$s to enable remote updates, unlock premium templates and activate professional extensions.', 'login-designer' ), '<a href="' . esc_url( $login_designer_store_url ) . '" target="_blank">', '</a>' ),
			'section'     => 'login_designer__section--settings',
			'priority'    => 1,
		)
	)
);
