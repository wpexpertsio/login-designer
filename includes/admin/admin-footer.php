<?php
/**
 * The main template file for the team post type.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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
 * Add rating links to the admin dashboard
 *
 * @since	1.0.0
 * @global	string $typenow
 * @param       string $footer_text The existing footer text.
 * @return      string
 */
function loginly_admin_rate_us( $footer_text ) {
	global $typenow;

	if ( 'download' == $typenow ) {
		// @todo - What page should this be on? If any?
		$rate_text = sprintf( __( 'Thank you for using <a href="%1$s" target="_blank">Loginly</a>! Please <a href="%2$s" target="_blank">rate us</a> on <a href="%2$s" target="_blank">WordPress.org</a>', '@@textdomain' ),
			'https://loginlywp.com',
			'https://wordpress.org/support/view/plugin-reviews/loginly?filter=5#postform'
		);

		return str_replace( '</span>', '', $footer_text ) . ' | ' . $rate_text . '</span>';
	} else {
		return $footer_text;
	}
}
add_filter( 'admin_footer_text', 'loginly_admin_rate_us' );
