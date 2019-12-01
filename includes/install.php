<?php
/**
 * Install Functionality
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Install
 *
 * Runs on plugin install by setting up the Login Designer template.
 * After successful install, the user is redirected to the Customizer.
 *
 * @global $wpdb
 * @global $login_designer_options
 * @param  bool|bool $network_wide If the plugin is being network-activated.
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
 * Create a page and store the ID in an option.
 *
 * @param mixed  $slug Slug for the new page.
 * @param string $option Option name to store the page's ID.
 * @param string $page_title (default: '') Title for the new page.
 * @param string $page_content (default: '') Content for the new page.
 * @return int   page ID
 */
function login_designer_create_page( $slug, $option = '', $page_title = '', $page_content = '' ) {
	global $wpdb;

	// Set up options.
	$options = array();

	// Pull options from WP.
	$admin_options = get_option( 'login_designer_settings', array() );
	$option_value  = array_key_exists( 'login_designer_page', $admin_options ) ? $admin_options['login_designer_page'] : false;
	$page_object   = get_post( $option_value );

	if ( $option_value > 0 && $page_object ) {
		if ( 'page' === $page_object->post_type && ! in_array( $page_object->post_status, array( 'pending', 'trash', 'future', 'auto-draft' ), true ) ) {
			// Valid page is already in place.
			return $page_object->ID;
		}
	}

	// Search for an existing page with the specified page slug.
	$valid_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status NOT IN ( 'pending', 'trash', 'future', 'auto-draft' )  AND post_name = %s LIMIT 1;", $slug ) );

	$valid_page_found = apply_filters( 'login_designer_create_page_id', $valid_page_found, $slug, $page_content );

	if ( $valid_page_found ) {
		if ( $option ) {
			$options['login_designer_page'] = $valid_page_found;
			$valid_page_found               = isset( $page_id ) ? $valid_page_found : $option_value;
			$merged_options                 = array_merge( $admin_options, $options );
			$admin_options                  = $merged_options;

			update_option( 'login_designer_settings', $admin_options );
		}
		return $valid_page_found;
	}

	// Search for an existing page with the specified page slug.
	$trashed_page_found = $wpdb->get_var( $wpdb->prepare( "SELECT ID FROM $wpdb->posts WHERE post_type='page' AND post_status = 'trash' AND post_name = %s LIMIT 1;", $slug ) );

	if ( $trashed_page_found ) {
		$page_id   = $trashed_page_found;
		$page_data = array(
			'ID'          => $page_id,
			'post_status' => 'publish',
		);

		wp_update_post( $page_data );
	} else {
		$page_data = array(
			'post_status'    => 'publish',
			'post_type'      => 'page',
			'post_author'    => 1,
			'post_name'      => $slug,
			'post_title'     => $page_title,
			'post_content'   => $page_content,
			'comment_status' => 'closed',
		);

		$page_id = wp_insert_post( $page_data );
	}

	if ( $option ) {
		$options['login_designer_page'] = $page_id;
		$page_id                        = isset( $page_id ) ? $page_id : $option_value;
		$merged_options                 = array_merge( $admin_options, $options );
		$admin_options                  = $merged_options;

		update_option( 'login_designer_settings', $admin_options );
	}

	// Assign the Login Designer template.
	login_designer_attach_template_to_page( $page_id, 'template-login-designer.php' );

	return $page_id;
}

/**
 * Run the Login Designer install process
 *
 * @return void
 */
function login_designer_run_install() {

	/* translators: 1: Name of this plugin */
	$post_content = sprintf( __( '<p>This page is used by %1$s to preview the login form in the Customizer.</p>', 'login-designer' ), 'Login Designer' );

	$pages = apply_filters(
		'login_designer_create_pages',
		array(
			'login_designer' => array(
				'name'    => _x( 'login-designer', 'Page slug', 'login-designer' ),
				'title'   => _x( 'Login Designer', 'Page title', 'login-designer' ),
				'content' => $post_content,
			),
		)
	);

	foreach ( $pages as $key => $page ) {
		login_designer_create_page( esc_sql( $page['name'] ), 'login_designer_page', $page['title'], $page['content'] );
	}
}

/**
 * When a new Blog is created in multisite, see if Login Designer is network activated, and run the installer
 *
 * @param int|int     $blog_id The Blog ID created.
 * @param int|int     $user_id The User ID set as the admin.
 * @param string      $domain The URL.
 * @param string      $path Site Path.
 * @param int|int     $site_id The Site ID.
 * @param array|array $meta Blog Meta.
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
 * @param int|int $page The id of the page to attach the template.
 * @param int|int $template The template's filename (assumes .php' is specified).
 *
 * @returns -1 if the page does not exist; otherwise, the ID of the page.
 */
function login_designer_attach_template_to_page( $page, $template ) {

	// Only attach the template if the page exists.
	if ( -1 !== $page ) {
		update_post_meta( $page, '_wp_page_template', $template );
	}

	return $page;
}
