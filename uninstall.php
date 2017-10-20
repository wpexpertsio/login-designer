<?php
/**
 * Uninstall Login Designer.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Load the Login Designer file.
include_once( 'login-designer.php' );

// Remove the Login Designer template.
if ( get_page_by_title( 'Login Designer' ) ) {

	$login_designer_page = get_page_by_title( 'Login Designer' );

	// Set to true to force delete. There's no need to keep it around.
	wp_delete_post( $login_designer_page->ID, true );
}

// Remove all plugin settings.
delete_option( 'login_designer' );
delete_option( 'login_designer_admin' );
