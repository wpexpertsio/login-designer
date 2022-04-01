<?php
/**
 * Import Export Settings
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;

$login_designer          = get_option( 'login_designer' );
$login_designer_settings = get_option( 'login_designer_settings' );
$value                   = array(
	'login_designer' => $login_designer,
	'settings'       => $login_designer_settings,
);
$value                   = wp_json_encode( $value );
$value                   = wp_unslash( $value );

$wp_customize->add_setting(
	'login_designer_import_export[file_title]',
	array(
		'sanitize_callback' => 'sanitize_text_field',
	)
);

$wp_customize->add_control(
	new Login_Designer_Title_Control(
		$wp_customize,
		'login_designer_import_export[file_title]',
		array(
			'type'    => 'login-designer-title',
			'label'   => esc_html__( 'File Import Export Settings', 'login-designer' ),
			'section' => 'login_designer__section--file-import-export',
		)
	)
);

$wp_customize->add_setting(
	'login_designer_import_export[file_import]',
	array(
		'type'      => 'option',
		'default'   => $value,
		'transport' => 'postMessage',
	)
);

$wp_customize->add_control(
	new Login_Designer_File_Import_Button_Control(
		$wp_customize,
		'login_designer_import_export[file_import]',
		array(
			'label'   => 'File Import',
			'section' => 'login_designer__section--file-import-export',
		)
	)
);
