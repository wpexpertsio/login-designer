<?php
/**
 * Plugin action links.
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
 * @since	1.0.0
 * @param	string|string $links The links.
 * @param       string|string $file The plugin.
 * @return      string
 */
function logindesigner_action_links( $links, $file ) {

	static $this_plugin;

	if ( empty( $this_plugin ) ) {

		$this_plugin = 'login-designer/login-designer.php';
	}

	if ( $file === $this_plugin ) {

		$settings_link = sprintf( esc_html__( '%1$s Customize %2$s', '@@textdomain' ), '<a href="' . admin_url( 'themes.php?page=login-designer' ) . '">', '</a>' );

		array_unshift( $links, $settings_link );

		$pro_link = sprintf( esc_html__( '%1$s %3$s Go Pro %4$s %2$s', '@@textdomain' ),  '<a href="https://logindesigner.com/?utm_source=login-designer-lite&utm_medium=plugin-action-link&utm_campaign=pro" target="_blank">', '</a>', '<span style="color: #006505;">', '</span>' );

		array_push( $links, $pro_link );
	}

	return $links;
}
add_action( 'plugin_action_links', 'logindesigner_action_links' , 10, 2 );
