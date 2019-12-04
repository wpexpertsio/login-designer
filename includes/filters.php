<?php
/**
 * Filters to exclude the Login Designer page from external plugins.
 *
 * @package Login Designer
 */

add_filter(
	'wpseo_exclude_from_sitemap_by_post_ids',
	function() {
		// Pull the Login Designer page from options.
		$page = Login_Designer()->get_login_designer_page();

		return array( $page->ID );
	}
);

add_filter(
	'rank_math/sitemap/posts_to_exclude',
	function( $posts_to_exclude ) {
		// Pull the Login Designer page from options.
		$page = Login_Designer()->get_login_designer_page()->ID;

		$posts_ids = array( $page );

		return array_merge( $posts_to_exclude, $posts_ids );
	}
);
