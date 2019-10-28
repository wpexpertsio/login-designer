<?php
/**
 * License handler.
 *
 * @package Login Designer
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Login_Designer_License_Handler' ) ) :

	/**
	 * Enqueues JS & CSS assets
	 */
	class Login_Designer_License_Handler {

		/**
		 * The class constructor.
		 */
		public function __construct() {
			add_action( 'wp_ajax_activate_login_designer_license', array( $this, 'ajax_activate_license' ) );
			add_action( 'wp_ajax_deactivate_login_designer_license', array( $this, 'ajax_deactivate_license' ) );
		}

		/**
		 * Get the shop.
		 *
		 * @access public
		 */
		public function shop_url() {
			return 'https://logindesigner.com';
		}

		/**
		 * Get the shop.
		 *
		 * @access public
		 */
		public function author() {
			return 'ThatPluginCompany';
		}

		/**
		 * Get the license key.
		 *
		 * @access public
		 */
		public function key() {

			$options = get_option( 'login_designer_license', array() );
			$key     = array_key_exists( 'key', $options ) ? sanitize_text_field( $options['key'] ) : false;

			return $key;
		}

		/**
		 * Get the license status.
		 *
		 * @access public
		 */
		public function status() {

			$options = get_option( 'login_designer_license', array() );
			$status  = array_key_exists( 'status', $options ) ? sanitize_text_field( $options['status'] ) : false;

			return $status;
		}

		/**
		 * Get the license's expiration date.
		 *
		 * @access public
		 */
		public function expiration() {

			$options    = get_option( 'login_designer_license', array() );
			$expiration = array_key_exists( 'expiration', $options ) ? sanitize_text_field( $options['expiration'] ) : false;

			return $expiration;
		}

		/**
		 * Get status.
		 *
		 * @access public
		 */
		public function site_count() {

			$options    = get_option( 'login_designer_license', array() );
			$site_count = array_key_exists( 'site_count', $options ) ? sanitize_text_field( $options['site_count'] ) : false;

			return $site_count;
		}

		/**
		 * Get status.
		 *
		 * @access public
		 */
		public function activations_left() {

			$options          = get_option( 'login_designer_license', array() );
			$activations_left = array_key_exists( 'activations_left', $options ) ? sanitize_text_field( $options['activations_left'] ) : false;

			return $activations_left;
		}

		/**
		 * Get the license status.
		 *
		 * @access public
		 */
		public function is_valid_license() {

			// Get the status of the license.
			$status = $this->status();

			if ( 'valid' === $status ) {
				return true;
			} else {
				return false;
			}
		}

		/**
		 * Makes a call to the API.
		 *
		 * @param array $api_params to be used for wp_remote_get.
		 * @return array $response decoded JSON response.
		 */
		function get_api_response( $api_params ) {

			// Call the custom API.
			$response = wp_remote_post(
				'https://logindesigner.com/', array(
					'timeout'   => 15,
					'sslverify' => false,
					'body'      => $api_params,
				)
			);

			// Make sure the response came back okay.
			if ( is_wp_error( $response ) ) {
				return false;
			}

			$response = json_decode( wp_remote_retrieve_body( $response ) );

			return $response;
		}

		/**
		 * License Activation AJAX.
		 */
		public function ajax_activate_license() {

			if ( ! check_ajax_referer( 'login-designer-activate-license', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			$this->activate_license();
		}

		/**
		 * License Deactivation AJAX.
		 */
		public function ajax_deactivate_license() {

			if ( ! check_ajax_referer( 'login-designer-deactivate-license', 'nonce', false ) ) {
				wp_send_json_error( 'invalid_nonce' );
			}

			$this->deactivate_license();
		}

		/**
		 * Check the license and activate it.
		 *
		 * Development test license: d2d430edb42c02297e999c604b29019e (All Access for Login Designer Pro)
		 * https://logindesigner.com/?edd_action=check_license&item_id=30&license=d2d430edb42c02297e999c604b29019e
		 */
		public function activate_license() {

			// Veritfy and validate the request.
			if ( isset( $_POST['key'], $_POST['login-designer-activate-license'] ) && wp_verify_nonce( sanitize_key( $_POST['login-designer-activate-license'] ), 'nonce' ) ) {  // Input var okay.
				return;
			}

			// Get the option from AJAX and save it to our options array.
			$key = sanitize_text_field( wp_unslash( $_POST['key'] ) );  // Input var okay.

			// Data to send in our API request.
			$api_params = array(
				'edd_action' => 'activate_license',
				'license'    => urlencode( $key ),
				'item_id'    => '30',
			);

			// Get the response.
			$response = $this->get_api_response( $api_params );

			// Make sure the response came back okay.
			if ( ! isset( $response->license ) ) {
				$message = esc_html__( 'An error occurred, please try again.', 'login-designer' );
			} else {
				// If the license response is not successful.
				if ( false === $response->success ) {

					switch ( $response->error ) {

						case 'expired':
							$message = sprintf(
								esc_html__( 'Your license key expired on %s.', 'login-designer' ),
								date_i18n( get_option( 'date_format' ), strtotime( $response->expires, current_time( 'timestamp' ) ) )
							);
							break;

						case 'revoked':
							$message = esc_html__( 'Your license key has been disabled.', 'login-designer' );
							break;

						case 'missing':
							$message = esc_html__( 'Invalid license.', 'login-designer' );
							break;

						case 'invalid':
						case 'site_inactive':
							$message = esc_html__( 'Your license is not active for this URL.', 'login-designer' );
							break;

						case 'item_name_mismatch':
							$message = esc_html__( 'This appears to be an invalid license key.', 'login-designer' );
							break;

						case 'no_activations_left':
							$message = esc_html__( 'Your license key has reached its activation limit.', 'login-designer' );
							break;

						default:
							$message = esc_html__( 'An error occurred, please try again.', 'login-designer' );
							break;
					}
				}
			}

			// We need to update the license at the same time the message is updated.
			if ( $response && isset( $response->license ) ) {

				// Set up options.
				$options = array();

				// Pull options from WP.
				$license_options = get_option( 'login_designer_license', array() );

				// Get the license key (from the AJAX $_POST call up above).
				$options['key'] = $key;

				// Get the license status.
				$response_status   = $response->license;
				$options['status'] = $response_status;

				// Get the license expiration date.
				$response_expiration   = date_i18n( get_option( 'date_format' ), strtotime( $response->expires ) );
				$options['expiration'] = $response_expiration;

				// Get the number of activations left.
				$response_site_count   = $response->site_count;
				$options['site_count'] = $response_site_count;

				// Get the number of activations left.
				$response_activations_left   = $response->activations_left;
				$options['activations_left'] = $response_activations_left;

				// Merge options.
				$merged_options  = array_merge( $license_options, $options );
				$license_options = $merged_options;

				update_option( 'login_designer_license', $license_options );

				wp_send_json(
					array(
						'done'             => 1,
						'error'            => $message,
						'expiration'       => $response_expiration,
						'status'           => $response_status,
						'site_count'       => $response_site_count,
						'activations_left' => $response_activations_left,
					)
				);
			}
		}

		/**
		 * Deactivates the license key.
		 */
		public function deactivate_license() {

			// Veritfy and validate the request.
			if ( isset( $_POST['login-designer-deactivate-license'] ) && wp_verify_nonce( sanitize_key( $_POST['login-designer-deactivate-license'] ), 'nonce' ) ) {  // Input var okay.
				return;
			}

			// Get the license key that we want to deactivate.
			$key = $this->key();

			// Data to send in our API request.
			$api_params = array(
				'edd_action' => 'deactivate_license',
				'license'    => urlencode( $key ),
				'item_id'    => '105665',
			);

			$response = $this->get_api_response( $api_params );

			// $response->license will be either "deactivated" or "failed".
			if ( $response && ( 'deactivated' === $response->license ) ) {

				// Remove the license option entirely.
				delete_option( 'login_designer_license' );

				// Let the Customizer know we're done here.
				wp_send_json(
					array(
						'done' => 1,
					)
				);
			}
		}
	}

endif;

new Login_Designer_License_Handler();
