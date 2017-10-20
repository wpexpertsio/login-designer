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

		$extensions_link = esc_url( add_query_arg( array(
				'utm_source'   => 'plugins-page',
				'utm_medium'   => 'plugin-action-link',
				'utm_campaign' => 'admin',
				'utm_content' => 'get-extensions',
			), 'https://logindesigner.com/extensions/' )
		);

		$pro_link = sprintf( esc_html__( '%1$s %3$s Get Extensions %4$s %2$s', '@@textdomain' ),  '<a href="' . esc_url( $extensions_link ) . '" target="_blank">', '</a>', '<span style="color: #006505;">', '</span>' );

		array_push( $links, $pro_link );
	}

	return $links;
}
add_action( 'plugin_action_links', 'logindesigner_action_links' , 10, 2 );

/**
 * Plugin row meta links
 *
 * @param array|array   $input already defined meta links.
 * @param string|string $file plugin file path and name being processed.
 * @return array $input
 */
function logindesigner_plugin_row_meta( $input, $file ) {

	if ( 'login-designer/login-designer.php' !== $file ) {
		return $input;
	}

	$extensions_link = esc_url( add_query_arg( array(
			'utm_source'   => 'plugins-page',
			'utm_medium'   => 'plugin-row',
			'utm_campaign' => 'admin',
			'utm_content'  => 'extensions',
		), 'https://logindesigner.com/extensions/' )
	);

	$links = array(
		'<a href="' . esc_url( $extensions_link ) . '">' . esc_html__( 'Extensions', '@@textdomain' ) . '</a>',
	);

	$input = array_merge( $input, $links );

	return $input;
}
add_filter( 'plugin_row_meta', 'logindesigner_plugin_row_meta', 10, 2 );
