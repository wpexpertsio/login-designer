<?php
/**
 * Uninstall Login Designer.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

// Load the Login Designer file.
require_once 'login-designer.php';

// Pull the Login Designer page from options.
$login_designer_page = Login_Designer()->get_login_designer_page();
$login_designer_page = $login_designer_page->ID;

wp_trash_post( $login_designer_page );

// Remove all plugin settings.
delete_option( 'login_designer' );
delete_option( 'login_designer_settings' );
delete_option( 'login_designer_license' );

// Clear any cached data that has been removed.
wp_cache_flush();
