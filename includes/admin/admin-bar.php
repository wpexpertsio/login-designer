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
 * @param	string|string $wp_admin_bar The admin bar.
 */
function login_designer_admin_bar_link( $wp_admin_bar ) {

	if ( ! is_page_template( 'template-login-designer.php' ) ) {
		return;
	}

	$args = array(
		'id' => 'login-designer',
		'title' => esc_html__( 'Login Designer', '@@textdomain' ),
		'href' => admin_url( '/customize.php?autofocus[panel]=login_designer&url='.home_url( '/login-designer' ) ),
		'meta' => array(
			'target' => '_self',
			'class' => 'login-designer-link',
			'title' => esc_html__( 'Login Designer', '@@textdomain' ),
		),
	);

	$wp_admin_bar->add_node( $args );

}
add_action( 'admin_bar_menu', 'login_designer_admin_bar_link', 999 );
