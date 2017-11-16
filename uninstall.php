<?php
/**
 * Uninstall Login Designer.
 *
 * @package   @@pkg.name
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Load the Login Designer file.
include_once( 'login-designer.php' );


// Pull the Login Designer page from options.
$page = Login_Designer()->get_login_designer_page();

// Remove the Login Designer template.
if ( $page ) {

	// Set to true to force delete. There's no need to keep it around.
	wp_delete_post( $page, true );
}

// Remove all plugin settings.
delete_option( 'login_designer' );
delete_option( 'login_designer_settings' );
delete_option( 'login_designer_license' );
