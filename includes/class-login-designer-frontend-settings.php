<?php
/**
 * Functions that modify the frontend functionality of the login pages.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_Frontend_Settings' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_Frontend_Settings {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'login_headertext', array( $this, 'logo_title' ) );
			add_action( 'login_headerurl', array( $this, 'logo_url' ) );
			add_filter( 'login_message', array( $this, 'login_message' ) );
		}

		/**
		 * Filters the logo image title attribute.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_headertext/
		 *
		 * @access public
		 */
		public function logo_title() {
			/* translators: 1: Name of this site */
			return sprintf( esc_html__( 'Log in to %s', 'login-designer' ), get_bloginfo( 'name' ) );
		}

		/**
		 * Filters link URL of the header logo above login form.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_headerurl/
		 *
		 * @access public
		 */
		public function logo_url() {

			// Check for the admin option.
			$options = new Login_Designer_Customizer_Output();
			$option  = $options->admin_option_wrapper( 'logo_url' );

			if ( $option ) {
				return get_page_link( $option );
			} else {
				return esc_url( home_url( '/' ) );
			}
		}

		/**
		 * Used to filter the message displayed above the login form.
		 * This filter can return HTML markup.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_message/
		 *
		 * @access public
		 * @param string|string $message Login message text.
		 */
		public function login_message( $message ) {

			// Check for the admin option.
			$options = new Login_Designer_Customizer_Output();
			$option  = $options->admin_option_wrapper( 'login_message' );

			if ( ! empty( $option ) ) {
				return sprintf( '<p>%s</p>', esc_textarea( $option ) );
			} else {
				return $message;
			}
		}
	}

endif;

new Login_Designer_Frontend_Settings();
