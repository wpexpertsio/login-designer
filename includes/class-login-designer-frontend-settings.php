<?php
/**
 * Functions that modify the frontend functionality of the login pages.
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
			add_action( 'login_headertitle', array( $this, 'logo_title' ) );
			add_action( 'login_headerurl', array( $this, 'logo_url' ) );
			add_filter( 'login_message', array( $this, 'login_message' ) );
			add_filter( 'login_redirect', array( $this, 'login_redirect' ) , 10, 3 );
			add_filter( 'logout_redirect', array( $this, 'logout_redirect' ) , 10, 3 );
		}

		/**
		 * Filters the logo image title attribute.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_headertitle/
		 *
		 * @access public
		 */
		public function logo_title() {

			return sprintf( esc_html__( 'Log in to %s', '@@textdomain' ), get_bloginfo( 'name' ) );
		}

		/**
		 * Filters link URL of the header logo above login form.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_headerurl/
		 *
		 * @access public
		 */
		public function logo_url() {

			// Check for the option.
			$options   = new Login_Designer_Customizer_Output();
			$option    = $options->option_wrapper( 'logo_url' );

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

			// Check for the option.
			$options   = new Login_Designer_Customizer_Output();
			$option    = $options->option_wrapper( 'login_message' );

			if ( ! empty( $option ) ) {
				return sprintf( '<p>%s</p>', esc_textarea( $option ) );
			} else {
				return $message;
			}
		}

		/**
		 * Redirect after successful login.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_redirect/
		 *
		 * @access public
		 * @param string|string $redirect_to URL to redirect to.
		 * @param string|string $requested_redirect_to URL the user is coming from.
		 * @param object|object $user Logged user's data.
		 * @return string|string
		 */
		public function login_redirect( $redirect_to, $requested_redirect_to, $user ) {

			// Check for the option.
			$options   = new Login_Designer_Customizer_Output();
			$option    = $options->option_wrapper( 'login_redirect' );

			if ( $option ) {
				return get_page_link( $option );
			}
		}

		/**
		 * Redirect after successful login.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/logout_redirect/
		 *
		 * @access public
		 * @param string|string $redirect_to URL to redirect to.
		 * @param string|string $requested_redirect_to URL the user is coming from.
		 * @param object|object $user Logged user's data.
		 * @return string|string
		 */
		public function logout_redirect( $redirect_to, $requested_redirect_to, $user ) {

			// Check for the option.
			$options   = new Login_Designer_Customizer_Output();
			$option    = $options->option_wrapper( 'logout_redirect' );

			if ( $option ) {
				return get_page_link( $option );
			}
		}
	}

endif;

new Login_Designer_Frontend_Settings();
