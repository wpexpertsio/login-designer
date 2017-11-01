<?php
/**
 * Theme Updater Admin Functions.
 *
 * @package @@pkg.name
 * @version @@pkg.version
 * @author  @@pkg.author
 * @license @@pkg.license
 */

if ( ! class_exists( 'EDD_Theme_Updater_Admin' ) ) :
	/**
	 * Automatic update notification and download class.
	 *
	 * Creates a way to download theme updates from a remote server.
	 *
	 * @package @@pkg.name
	 */
	class EDD_Theme_Updater_Admin {
		/**
		 * The API URL of the site we're sending the update request to.
		 *
		 * @var string $remote_api_url
		 */
		protected $remote_api_url = null;

		/**
		 * The theme slug.
		 *
		 * @var string $theme_slug
		 */
		protected $theme_slug = null;

		/**
		 * The theme slug.
		 *
		 * @var string $status
		 */
		protected $status = null;

		/**
		 * The version number of this theme.
		 *
		 * @var string $version
		 */
		protected $version = null;

		/**
		 * The author of the theme.
		 *
		 * @var string $author
		 */
		protected $author = null;

		/**
		 * The download ID of the theme on the remote site.
		 *
		 * @var string $download_id
		 */
		protected $download_id = null;

		/**
		 * The renewal URL the download on the remote site.
		 *
		 * @var string $renew_url
		 */
		protected $renew_url = null;

		/**
		 * The text string array.
		 *
		 * @var array $strings
		 */
		protected $strings = null;

		/**
		 * Initialize the class.
		 *
		 * @param array $config The remote request args.
		 * @param array $strings The string texts defined in updater.php.
		 */
		function __construct( $config = array(), $strings = array() ) {

			$config = wp_parse_args( $config, array(
				'remote_api_url' => '@@pkg.author_uri',
				'theme_slug' => get_template(),
				'item_name' => '',
				'license' => '',
				'version' => '',
				'author' => '',
				'download_id' => '',
				'renew_url' => '',
				'status' => '',
			) );

			// Set config arguments.
			$this->remote_api_url = $config['remote_api_url'];
			$this->item_name = $config['item_name'];
			$this->theme_slug = sanitize_key( $config['theme_slug'] );
			$this->version = $config['version'];
			$this->author = $config['author'];
			$this->download_id = $config['download_id'];
			$this->renew_url = $config['renew_url'];
			$this->status = sanitize_key( $this->theme_slug . '_license_key_status' );
			$this->license = trim( get_option( $this->theme_slug . '_license_key' ) );

			// Populate version fallback.
			if ( '' === $config['version'] ) {
				$theme = wp_get_theme( $this->theme_slug );
				$this->version = $theme->get( 'Version' );
			}

			// Strings passed in from the updater config.
			$this->strings = $strings;

			add_action( 'admin_init', array( $this, 'updater' ) );
			add_action( 'admin_notices', array( $this, 'notices' ) );
		}

		/**
		 * Creates the updater class.
		 */
		function updater() {

			/* If there is no valid license key status, don't allow updates. */
			if ( get_option( $this->theme_slug . '_license_key_status', false ) !== 'valid' ) {
				return;
			}

			if ( ! class_exists( 'EDD_Theme_Updater' ) ) {
				include get_parent_theme_file_path() . '/updater/updater-class.php';
			}

			new EDD_Theme_Updater(
				array(
					'remote_api_url'    => $this->remote_api_url,
					'version'           => $this->version,
					'license'           => trim( get_option( $this->theme_slug . '_license_key' ) ),
					'item_name'         => $this->item_name,
					'author'            => $this->author,
				),
				$this->strings
			);
		}

		/**
		 * Check if license key is valid once per week
		 */
		public function weekly_license_check() {

			if ( empty( $this->license ) ) {
				return;
			}

			$license = trim( get_option( $this->theme_slug . '_license_key' ) );

			// Data to send in our API request.
			$api_params = array(
				'edd_action' => 'check_license',
				'license'    => $license,
				'item_name'  => urlencode( $this->item_name ),
			);

			// Call the API.
			$license_data = $this->get_api_response( $api_params );
			$expires_on = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) );
			update_option( $this->theme_slug . '_license_expiration', $expires_on );
		}

		/**
		 * Admin notices for errors
		 */
		public function notices() {

			static $showed_invalid_message;

			$license = trim( get_option( $this->theme_slug . '_license_key' ) );

			if ( empty( $license ) ) {
				return;
			}

			$messages = array();

			$expired_on = get_option( $this->theme_slug . '_license_expiration' );
			$status = get_option( $this->theme_slug . '_license_key_status', false );

			$allowed_html_array = array(
				'a' => array(
					'href' => array(),
					'title' => array(),
					'target' => array(),
				),
			);

			if ( 'expired' === $status && empty( $showed_invalid_message ) ) {

				if ( empty( $_GET['tab'] ) ) {

					$messages[] = sprintf(
						wp_kses( __( 'Your license key for %1$s expired on %2$s. Please <a href="%3$s" target="blank" title="Renew your license key">renew your license key now</a> to correct this issue.', '@@textdomain' ), $allowed_html_array ),
						esc_html( $this->item_name ),
						esc_html( $expired_on ),
						esc_url( $this->get_renewal_link() )
					);

					$showed_invalid_message = true;
				}
			}

			if ( ! empty( $messages ) ) {

				foreach ( $messages as $message ) {

					echo '<div class="error">';
						echo '<p>' . esc_html( $message ) . '</p>';
					echo '</div>';

				}
			}
		}

		/**
		 * Constructs a renewal link
		 *
		 * @since 1.0.0
		 */
		function get_renewal_link() {

			// If a renewal link was passed in the config, use that.
			if ( '' !== $this->renew_url ) {
				return $this->renew_url;
			}

			// If download_id was passed in the config, a renewal link can be constructed.
			$license_key = trim( get_option( $this->theme_slug . '_license_key', false ) );
			if ( '' !== $this->download_id && $license_key ) {
				$url = esc_url( $this->remote_api_url );
				$url .= '/checkout/?edd_license_key=' . $license_key . '&download_id=' . $this->download_id;
				return $url;
			}

			// Otherwise return the remote_api_url.
			return $this->remote_api_url;
		}

		/**
		 * Checks if license is valid and gets expire date.
		 *
		 * @since 1.0.0
		 *
		 * @return string $message License status message.
		 */
		function check_license() {

			$license = trim( get_option( $this->theme_slug . '_license_key' ) );
			$strings = $this->strings;

			$api_params = array(
				'edd_action' => 'check_license',
				'license'    => $license,
				'item_name'  => urlencode( $this->item_name ),
				'url'        => esc_url( home_url( '/' ) ),
			);

			$license_data = $this->get_api_response( $api_params );

			// If response doesn't include license data, return.
			if ( ! isset( $license_data->license ) ) {
				$message = $strings['license-unknown'];
				return $message;
			}

			// We need to update the license status at the same time the message is updated.
			if ( $license_data && isset( $license_data->license ) ) {
				update_option( $this->theme_slug . '_license_key_status', $license_data->license );
			}

			// Get expire date.
			$expires = false;
			if ( isset( $license_data->expires ) ) {
				$expires = date_i18n( get_option( 'date_format' ), strtotime( $license_data->expires ) );
				$renew_link = '<a href="' . esc_url( $this->get_renewal_link() ) . '" target="_blank">' . $strings['renew'] . '</a> ';
			}

			// Get license key name.
			$name = $this->item_name;

			// Get site counts.
			$site_count = $license_data->site_count;
			$license_limit = $license_data->license_limit;

			// If unlimited.
			if ( 0 === $license_limit ) {
				$license_limit = $strings['unlimited'];
			}

			if ( 'valid' === $license_data->license ) {
				$message = sprintf( $strings['license-key-is-active%s'], $name ) . ' ';
				if ( $expires ) {
					$message .= sprintf( $strings['expires%s'], $expires ) . ' ';
				}
				if ( $site_count && $license_limit ) {
					$message .= sprintf( $strings['%1$s/%2$-sites'], $site_count, $license_limit );
				}
			} else if ( 'expired' === $license_data->license ) {
				if ( $expires ) {
					$message = sprintf( $strings['license-key-expired-%s'], $expires );
				} else {
					$message = $strings['license-key-expired'];
				}
				if ( $renew_link ) {
					$message .= ' ' . $renew_link . '' .$strings['renew-after'];
				}
			} else if ( 'invalid' === $license_data->license ) {
				$message = $strings['license-keys-do-not-match'];
			} else if ( 'inactive' === $license_data->license ) {
				$message = $strings['license-is-inactive'];
			} else if ( 'disabled' === $license_data->license  ) {
				$message = $strings['license-key-is-disabled'];
			} else if ( 'site_inactive' === $license_data->license ) {
				// Site is inactive.
				$message = $strings['enter-key'];
			} else {
				$message = $strings['license-status-unknown'];
			}

			return $message;
		}
	}

endif;
