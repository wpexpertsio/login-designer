<?php
/**
 * Login Designer Localize Google Fonts
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$wp_customize->add_setting(
	'login_designer[localize_fonts]',
	array(
		'type'              => 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'sanitize_text_field',
	)
);
$wp_customize->add_control(
	new Login_Designer_Localize_Google_Fonts(
		$wp_customize,
		'login_designer[localize_fonts]',
		array(
			'type'    => 'login-designer-localize-google-fonts',
			'label'   => esc_attr__( 'Import Google Fonts', 'login-designer' ),
			'section' => 'login_designer__section--file-import-export',
		)
	)
);

