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
	wp_delete_post( get_page_by_title( 'Login Designer' ) );
}

// Remove all plugin settings.
delete_option( 'login_designer' );
delete_option( 'login_designer_settings' );
