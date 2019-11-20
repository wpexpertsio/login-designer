<?php
/**
 * Filters to exclude the Login Designer page from external plugins.
 *
 * @package Login Designer
 */

add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', function () {

	// Pull the Login Designer page from options.
	$page = Login_Designer()->get_login_designer_page();

	return array( $page->ID );

} );

add_filter( 'rank_math/sitemap/entry', function( $url, $type, $object ) {

	// Pull the Login Designer page from options.
	$login_designer_page = Login_Designer()->get_login_designer_page();

	$login_designer_url = get_permalink( $login_designer_page );

	$type = $login_designer_page->post_type;

	if ( ( $key = array_search( $login_designer_url, $url ) ) !== false ) {

		return false;

	}

	return $url;

}, 10, 3 );
