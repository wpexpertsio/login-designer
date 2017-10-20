<?php
/**
 * Install Functionality
 *
 * @package	 @@pkg.name
 * @copyright @@pkg.copyright
 * @author	@@pkg.author
 * @license	 @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Install
 *
 * Runs on plugin install by setting up the post types, custom taxonomies,
 * flushing rewrite rules to initiate the new 'downloads' slug and also
 * creates the plugin and populates the settings fields for those plugin
 * pages. After successful install, the user is redirected to the EDD Welcome
 * screen.
 *
 * @global $wpdb
 * @global $login_designer_options
 * @param	bool|bool $network_wide If the plugin is being network-activated.
 * @return void
 */
function login_designer_install( $network_wide = false ) {
	global $wpdb;

	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	if ( is_multisite() && $network_wide ) {

		foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs LIMIT 100" ) as $blog_id ) {
			switch_to_blog( $blog_id );
			login_designer_run_install();
			restore_current_blog();
		}

	} else {

		login_designer_run_install();

	}

}
register_activation_hook( LOGIN_DESIGNER_PLUGIN_FILE, 'login_designer_install' );

/**
 * Run the EDD Install process
 *
 * @return void
 */
function login_designer_run_install() {

	set_transient( '_welcome_screen_activation_redirect', true, 30 );

	$allowed_html_array = array(
		'a' => array(
			'href' => array(),
			'target' => array(),
		),
	);

	$post_content = sprintf( wp_kses( __( '<p>This page is used by <a href="%1$s">%2$s</a> to preview the login forms in the Customizer. Please don\'t delete this page. Thanks!</p>', '@@textdomain' ), $allowed_html_array ), 'https://logindesigner.com', 'Login Designer' );

	// Customizable Login Designer page.
	$page = array(
		'post_title'	 => 'Login Designer',
		'post_content'	 => $post_content,
		'post_status'	 => 'draft',
		'post_author'	 => 1,
		'post_type'	 => 'page',
		'comment_status' => 'closed',
	);

	if ( ! get_page_by_title( 'Login Designer' ) ) {
		wp_insert_post( $page );
	}

	login_designer_attach_template_to_page( 'Login Designer', 'template-login-designer.php' );
}

/**
 * Redirect to the Customizer upon plugin activation.
 */
function welcome_screen_do_activation_redirect() {

	// Bail if no activation redirect.
	if ( ! get_transient( '_welcome_screen_activation_redirect' ) ) {
		return;
	}

	// Delete the redirect transient.
	delete_transient( '_welcome_screen_activation_redirect' );

	// Bail if activating from network, or bulk.
	if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
		return;
	}

	// Get the login designer templated page we just created.
	$page = get_page_by_title( 'Login Designer' );

	wp_safe_redirect( admin_url( '/customize.php?autofocus[panel]=login_designer&url='.get_permalink( $page ) ) );

}
add_action( 'admin_init', 'welcome_screen_do_activation_redirect' );


/**
 * When a new Blog is created in multisite, see if EDD is network activated, and run the installer
 *
 * @param	int|int		 $blog_id The Blog ID created.
 * @param	int|int		 $user_id The User ID set as the admin.
 * @param	string|string $domain	The URL.
 * @param	string|string $path	Site Path.
 * @param	int|int	 	 $site_id The Site ID.
 * @param	array|array	 $meta	Blog Meta.
 * @return void
 */
function login_designer_new_blog_created( $blog_id, $user_id, $domain, $path, $site_id, $meta ) {

	if ( is_plugin_active_for_network( plugin_basename( LOGIN_DESIGNER_PLUGIN_FILE ) ) ) {

		switch_to_blog( $blog_id );
		login_designer_install();
		restore_current_blog();

	}

}
add_action( 'wpmu_new_blog', 'login_designer_new_blog_created', 10, 6 );

/**
 * Attaches the specified template to the page identified by the specified name.
 *
 * @params $page_name		The name of the page to attach the template.
 * @params $template_path	The template's filename (assumes .php' is specified)
 *
 * @returns	 -1 if the page does not exist; otherwise, the ID of the page.
 */
function login_designer_attach_template_to_page( $page_name, $template_file_name ) {

	// Look for the page by the specified title. Set the ID to -1 if it doesn't exist.
	// Otherwise, set it to the page's ID.
	$page = get_page_by_title( $page_name, OBJECT, 'page' );
	$page_id = null === $page ? -1 : $page->ID;

	// Only attach the template if the page exists.
	if ( -1 !== $page_id ) {
		update_post_meta( $page_id, '_wp_page_template', $template_file_name );
	}

	return $page_id;
}






