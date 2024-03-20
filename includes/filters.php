<?php
/**
 * Filters to exclude the Login Designer page from external plugins.
 *
 * @package Login Designer
 */

add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', 'login_designer_wpseo_exclude_page_id' );
if ( ! function_exists( 'login_designer_wpseo_exclude_page_id' ) ) {
	/**
	 * Excluding Login designer page ID form WPSEO
	 *
	 * @param array $posts_to_exclude Post|Page Ids.
	 *
	 * @return array
	 */
	function login_designer_wpseo_exclude_page_id( $posts_to_exclude ) {
		// Pull the Login Designer page from options.
		$page     = Login_Designer()->get_login_designer_page();
		$page_ids = login_designer_pages( $page->ID );
		return array_merge( $posts_to_exclude, $page_ids );
	}
}

add_filter( 'rank_math/sitemap/posts_to_exclude', 'login_designer_sitemap_exclude_page_id' );
if ( ! function_exists( 'login_designer_sitemap_exclude_page_id' ) ) {
	/**
	 * Excluding Login designer page ID form Sitemap
	 *
	 * @param int $posts_to_exclude Post IDs which sre excluding.
	 *
	 * @return array
	 */
	function login_designer_sitemap_exclude_page_id( $posts_to_exclude ) {
		// Pull the Login Designer page from options.
		$page     = Login_Designer()->get_login_designer_page();
		$page_ids = login_designer_pages( $page->ID );
		return array_merge( $posts_to_exclude, $page_ids );
	}
}
