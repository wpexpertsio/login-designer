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

if ( ! class_exists( 'Loginly_Frontend_Settings' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Loginly_Frontend_Settings {

		/**
		 * The class constructor.
		 * Adds actions to enqueue our assets.
		 */
		public function __construct() {
			add_action( 'login_headertitle', array( $this, 'login_headertitle' ) );
			add_action( 'login_headerurl', array( $this, 'login_headerurl' ) );
			add_filter( 'login_message', array( $this, 'login_message' ) );
			add_filter( 'login_redirect', array( $this, 'login_redirect' ) , 10, 3 );
			add_filter( 'logout_redirect', array( $this, 'logout_redirect' ) );
		}

		/**
		 * Filters the title attribute of the header logo above login form.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_headertitle/
		 *
		 * @access public
		 */
		public function login_headertitle() {
			return sprintf( esc_html__( 'Login to %s', '@@textdomain' ), get_bloginfo( 'name' ) );
		}

		/**
		 * Filters link URL of the header logo above login form.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_headerurl/
		 *
		 * @access public
		 * @since 1.0.0
		 * @return string
		 */
		public function login_headerurl() {
			return get_page_link( get_theme_mod( 'loginly__logo-url', home_url() ) );
		}

		/**
		 * Used to filter the message displayed above the login form.
		 * This filter can return HTML markup.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_message/
		 *
		 * @access public
		 * @param string $message Login message text.
		 * @since 1.0.0
		 * @return string
		 */
		public function login_message( $message ) {
			if ( empty( $message ) ) {
				if ( get_theme_mod( 'loginly__login-message' ) ) {
					return sprintf( '<p>%s</p>', esc_textarea( get_theme_mod( 'loginly__login-message' ) ) );
				}
			} else {
				return $message;
			}
		}

		/**
		 * Redirect user after successful login.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_redirect/
		 *
		 * @access public
		 * @param string $redirect_to URL to redirect to.
		 * @param string $requested_redirect_to URL the user is coming from.
		 * @param object $user Logged user's data.
		 * @return string
		 */
		public function login_redirect( $redirect_to, $requested_redirect_to, $user ) {
			// Is there a user to check?
			if ( isset( $user->roles ) && is_array( $user->roles ) ) {
				// Check for admins.
				if ( in_array( 'administrator', $user->roles ) ) {
					// Redirect them to the default place.
					return $redirect_to;
				} else {
					return home_url();
				}
			} else {
				return get_page_link( get_theme_mod( 'loginly__login-redirect', home_url() ) );
			}
		}

		/**
		 * Redirect user after successful login.
		 *
		 * @see https://developer.wordpress.org/reference/hooks/login_redirect/
		 *
		 * @access public
		 * @param string $redirect_to URL to redirect to.
		 * @param string $requested_redirect_to URL the user is coming from.
		 * @param object $user Logged user's data.
		 * @return string
		 */
		public function logout_redirect( $redirect_to, $requested_redirect_to, $user ) {
			// Is there a user to check?
			if ( isset( $user->roles ) && is_array( $user->roles ) ) {
				// Check for admins.
				if ( in_array( 'administrator', $user->roles ) ) {
					// Redirect them to the default place.
					return $redirect_to;
				} else {
					return home_url();
				}
			} else {
				return get_page_link( get_theme_mod( 'loginly__logout-redirect', home_url() ) );
			}
		}
	}

endif;

new Loginly_Frontend_Settings();
