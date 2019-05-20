<?php
/**
 * Migrations.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Migrate the button height to the new padding top and padding bottom options.
 *
 * @since 1.1.5
 */
function login_designer_button_padding() {

	// Set up options.
	$options = array();

	// Current site options.
	$current_options = get_option( 'login_designer', array() );

	// Check if options exist. If not, return.
	if ( ! $current_options ) {
		return;
	}

	// Check if the button_height option exists. If not, return.
	if ( ! isset( $current_options['button_height'] ) ) {
		return;
	}

	// Let's set the padding options to half of the button_height.
	$options['button_padding_top']    = $current_options['button_height'] / 2;
	$options['button_padding_bottom'] = $current_options['button_height'] / 2;

	// Merge options.
	$merged_options = array_merge( $current_options, $options );
	$new_options    = $merged_options;

	// Remove the old button height option.
	unset( $new_options['button_height'] );

	// Update the options.
	update_option( 'login_designer', $new_options );
}
add_action( 'after_setup_theme', 'login_designer_button_padding' );
