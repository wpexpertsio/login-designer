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
		$classes[] = 'is-loginly';
	}

	return $classes;
}
add_filter( 'body_class', 'loginly_add_body_classes' );

/**
 * Redirect user after successful login.
 *
 * @param string $redirect_to URL to redirect to.
 * @param string $request URL the user is coming from.
 * @param object $user Logged user's data.
 * @return string
 */
function loginly_login_redirect( $redirect_to, $request, $user ) {
	// Is there a user to check?
	if ( isset( $user->roles ) && is_array( $user->roles ) ) {
		// Check for admins.
		if ( in_array( 'administrator', $user->roles ) ) {
			// Redirect them to the default place.
			return $redirect_to;
		} else {
			return home_url();
		}
	} else {
		return get_page_link( get_theme_mod( 'loginly__login-redirect', '' ) );
	}
}

add_filter( 'login_redirect', 'loginly_login_redirect', 10, 3 );











