<?php
/**
 * Customizer functionality
 *
 * @package   @@pkg.name
 * @copyright @@pkg.copyright
 * @author    @@pkg.author
 * @license   @@pkg.license
 */

/**
 * Output Customizer styles.
 *
 * The login_enqueue_scripts hook is used when enqueuing items that are meant to appear
 * on the login page. Despite the name, it is used for enqueuing both scripts and styles.
 */
function loginly_customize_css() {

	$logo_maxwidth = get_theme_mod( 'loginly__custom-logo-maxwidth', '100' );

	$custom_css = ' #login h1 a { width: '. esc_attr( $logo_maxwidth ).'px; } ';

	wp_add_inline_style( 'login', wp_strip_all_tags( $custom_css ) );

}
add_action( 'login_enqueue_scripts', 'loginly_customize_css' );




