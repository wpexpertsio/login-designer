<?php
/**
 * Install Functionality
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
 * Adds the Typekit enabled fonts added to the Customizer.
 *
 * @param  array $fonts Default fonts from the ava_get_fonts function.
 * @return array of default fonts, plus the new typekit additions.
 */
function login_designer_seasonal_background_images( $backgrounds ) {

	$image_dir  = LOGIN_DESIGNER_PLUGIN_URL . 'assets/images/backgrounds/';

	$seasonal_backgrounds = array(
		'christmas-01' => array(
			'title' => esc_html__( 'Christmas 01', '@@textdomain' ),
			'image' => esc_url( $image_dir ) . 'christmas-01-sml.jpg',
		),
		'christmas-02' => array(
			'title' => esc_html__( 'Christmas 02', '@@textdomain' ),
			'image' => esc_url( $image_dir ) . 'christmas-02-sml.jpg',
		),
		'christmas-03' => array(
			'title' => esc_html__( 'Christmas 03', '@@textdomain' ),
			'image' => esc_url( $image_dir ) . 'christmas-03-sml.jpg',
		),
		'christmas-04' => array(
			'title' => esc_html__( 'Christmas 04', '@@textdomain' ),
			'image' => esc_url( $image_dir ) . 'christmas-04-sml.jpg',
		),
		'christmas-05' => array(
			'title' => esc_html__( 'Christmas 05', '@@textdomain' ),
			'image' => esc_url( $image_dir ) . 'christmas-05-sml.jpg',
		),
	);

	// Combine the two arrays.
	$backgrounds = array_merge( $backgrounds, $seasonal_backgrounds );

	return $backgrounds;
}

add_filter( 'login_designer_backgrounds', 'login_designer_seasonal_background_images' );
