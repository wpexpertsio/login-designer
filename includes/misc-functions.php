<?php
/**
 * Enqueue the scripts that are required by the customizer.
 * Any additional scripts that are required by individual controls
 * are enqueued in the control classes themselves.
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Determines if we're currently on a login page
 *
 * @since 1.0.0
 * @return bool True if on the login page, false otherwise
 */
function loginly_is_login() {

	global $wp_query;

	$is_object_set    = isset( $wp_query->queried_object );
	$is_object_id_set = isset( $wp_query->queried_object_id );
	$is_login    	  = is_page( get_theme_mod( 'loginly__login-page', 'login' ) );

	if ( ! $is_object_set ) {
		unset( $wp_query->queried_object );
	}

	if ( ! $is_object_id_set ) {
		unset( $wp_query->queried_object_id );
	}

	return apply_filters( 'loginly_is_login', $is_login );
}

/**
 * Adds body classes for Loginly login pages
 *
 * @since 1.0.0
 * @param array $class current classes.
 * @return array Modified array of classes
 */
function loginly_add_body_classes( $class ) {

	if ( loginly_is_login() ) {
		$classes[] = 'loginly-page';
	}

	return $classes;
}
add_filter( 'body_class', 'loginly_add_body_classes' );










/**
 * Locate template.
 *
 * Locate the called template.
 * Search Order:
 * 1. /themes/theme/templates/$template_name
 * 2. /themes/theme/$template_name
 * 3. /plugins/plugin/templates/$template_name.
*
* @since 1.0.0
*
* @param   string  $template_name          Template to load.
* @param   string  $string $template_path  Path to templates.
* @param   string  $default_path           Default path to template files.
* @return  string                          Path to the template file.
*/
function PLUGIN_locate_template( $template_name, $template_path = '', $default_path = '' ) {

if ( ! is_page( get_theme_mod( 'loginly__login-page', 'login' ) ) ) {
	return; 
}


// Set variable to search in the templates folder of theme.
	if ( ! $template_path ) :
		$template_path = 'templates/';
	endif;

// Set default plugin templates path.
	if ( ! $default_path ) :
		$default_path = plugin_dir_path( __DIR__ ) . 'templates/'; // Path to the template folder
	endif;

// Search template file in theme folder.
	$template = locate_template( array(
	$template_path . $template_name,
	$template_name
	) );

// Get plugins template file.
if ( ! $template ) :
	$template = $default_path . $template_name;
endif;


return apply_filters( 'PLUGIN_locate_template', $template, $template_name, $template_path, $default_path );

}

/**
* Get template.
*
* Search for the template and include the file.
*
* @since 1.0.0
*
* @see PLUGIN_locate_template()
*
* @param string  $template_name          Template to load.
* @param array   $args                   Args passed for the template file.
* @param string  $string $template_path  Path to templates.
* @param string  $default_path           Default path to template files.
*/
function PLUGIN_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {

	if ( is_array( $args ) && isset( $args ) ) :
		extract( $args );
	endif;

	$template_file = contests_locate_template( $template_name, $tempate_path, $default_path );

	if ( ! file_exists( $template_file ) ) :
		_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
	return;
	endif;

	include $template_file;

}

/**
* Template loader.
*
* The template loader will check if WP is loading a template
* for a specific Post Type and will try to load the template
* from out 'templates' directory.
*
* @since 1.0.0
*
* @param string  $template Template file that is being loaded.
* @return  string          Template file that should be loaded.
*/
function PLUGIN_template_loader( $template ) {

	$find = array();
	$file = '';

	if ( loginly_is_login() ) :
		$file = 'loginly.php';
	endif;

	if ( file_exists( PLUGIN_locate_template( $file ) ) ) :
		$template = PLUGIN_locate_template( $file );
	endif;

	return $template;

}
add_filter( 'template_include', 'PLUGIN_template_loader' );