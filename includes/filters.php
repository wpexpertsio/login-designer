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
	$page = Login_Designer()->get_login_designer_page();
	$url = get_permalink( $page );

	return $url;

}, 10, 3 );
