<?php
/**
 * The main template file for the team post type.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author	@@pkg.author
 * @license   @@pkg.license
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add rating links to the admin dashboard.
 *
 * @since	1.0.0
 * @param	string|string $wp_admin_bar The existing footer text.
 */
function loginly_admin_bar_link( $wp_admin_bar ) {

	if ( ! is_page_template( 'template-loginly.php' ) ) {
		return;
	}

	$args = array(
		'id' => 'loginly',
		'title' => __( 'Open Loginly', '@@textdomain' ),
		'href' => admin_url( '/customize.php?autofocus[panel]=loginly__panel&url='.home_url( '/loginly' ) ),
		'meta' => array(
			'target' => '_self',
			'class' => 'loginly-link',
			'title' => __( 'Loginly Login Designer', '@@textdomain' ),
		),
	);

	$wp_admin_bar->add_node( $args );

}
add_action( 'admin_bar_menu', 'loginly_admin_bar_link', 999 );
