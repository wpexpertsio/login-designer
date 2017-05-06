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
 * Add links to the settings page to the plugin.
 *
 * @since	    1.8.5
 * @param		string $links The links.
 * @param       string $file The plugin.
 * @return      string
 */
function loginly_action_links( $links, $file ) {

	static $this_plugin;

	if ( empty( $this_plugin ) ) {

		$this_plugin = 'loginly/loginly.php';
	}

	if ( $file == $this_plugin ) {

		$settings_link = sprintf( esc_html__( '%1$s Settings %2$s', '@@textdomain' ), '<a href="' . admin_url( 'admin.php?page=loginly' ) . '">', '</a>' );

		array_unshift( $links, $settings_link );

		$pro_link = sprintf( esc_html__( '%1$s %3$s Go Pro %4$s %2$s', '@@textdomain' ),  '<a href="https://loginly.xyz/?utm_source=loginly-lite&utm_medium=plugin-action-link&utm_campaign=pro" target="_blank">', '</a>', '<span class="loginly-plugin-title__link--green">', '</span>' );

		array_push( $links, $pro_link );
	}

	return $links;
}
add_action( 'plugin_action_links', 'loginly_action_links' , 10, 2 );
