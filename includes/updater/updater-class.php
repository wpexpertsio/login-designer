<?php
/**
 * EDD SL Theme Updater Class
 *
 * @package @@pkg.name
 * @version @@pkg.version
 * @author  @@pkg.author
 * @license @@pkg.license
 */

if ( ! class_exists( 'EDD_Theme_Updater' ) ) :
	/**
	 * Automatic update notification and download class.
	 *
	 * Creates a way to download theme updates from a remote server.
	 *
	 * @package @@pkg.name
	 */
	class EDD_Theme_Updater {
		/**
		 * The API URL of the site we're sending the update request to.
		 *
		 * @var string $remote_api_url
		 */
		private $remote_api_url;

		/**
		 * The API URL of the site we're sending the update request to.
		 *
		 * @var string $request_data
		 */
		private $request_data;

		/**
		 * The response key.
		 *
		 * @var string $response_key
		 */
		private $response_key;

		/**
		 * The theme slug.
		 *
		 * @var string $theme_slug
		 */
		private $theme_slug;

		/**
		 * The customer's license key.
		 *
		 * @var string $license_key
		 */
		private $license_key;

		/**
		 * The theme version.
		 *
		 * @var string $version
		 */
		private $version;

		/**
		 * The author of the download.
		 *
		 * @var string $author
		 */
		private $author;

		/**
		 * The text string array.
		 *
		 * @var array $strings
		 */
		protected $strings = null;

		/**
		 * Add an update transient.
		 *
		 * @param array $args Download args.
		 * @param array $strings Text for the different elements.
		 */
		function __construct( $args = array(), $strings = array() ) {

			$args = wp_parse_args( $args, array(
				'remote_api_url' => 'http://themebeans.com',
				'request_data' => array(),
				'theme_slug' => get_template(),
				'item_name' => '',
				'license' => '',
				'version' => '',
				'author' => '',
			) );
			extract( $args );

			$this->license = $license;
			$this->item_name = $item_name;
			$this->version = $version;
			$this->theme_slug = sanitize_key( $theme_slug );
			$this->author = $author;
			$this->remote_api_url = $remote_api_url;
			$this->response_key = $this->theme_slug . '-update-response';
			$this->strings = $strings;

			add_filter( 'site_transient_update_themes', array( &$this, 'theme_update_transient' ) );
			add_filter( 'delete_site_transient_update_themes', array( &$this, 'delete_theme_update_transient' ) );
			add_action( 'load-update-core.php', array( &$this, 'delete_theme_update_transient' ) );
			add_action( 'load-themes.php', array( &$this, 'delete_theme_update_transient' ) );
			add_action( 'load-themes.php', array( &$this, 'load_themes_screen' ) );
		}

		/**
		 * Loads the theme update.
		 */
		function load_themes_screen() {
			add_thickbox();
			add_action( 'admin_notices', array( &$this, 'update_nag' ) );
		}

		/**
		 * Add an update nag.
		 */
		function update_nag() {

			if ( current_user_can( 'manage_options' ) ) {

				$strings = $this->strings;

				$theme = wp_get_theme( $this->theme_slug );

				$api_response = get_transient( $this->response_key );

				if ( false === $api_response ) {
					return;
				}

				$update_url = wp_nonce_url( 'update.php?action=upgrade-theme&amp;theme=' . urlencode( $this->theme_slug ), 'upgrade-theme_' . $this->theme_slug );
				$update_onclick = ' onclick="if ( confirm(\'' . esc_js( $strings['update-notice'] ) . '\') ) {return true;}return false;"';

				if ( version_compare( $this->version, $api_response->new_version, '<' ) ) {

					echo '<div id="update-nag">';
						printf(
							$strings['update-available'],
							esc_html( $theme->get( 'Name' ) ),
							esc_html( $api_response->new_version ),
							'http://demo.themebeans.com/wp-content/themes/' . esc_attr( $this->theme_slug ) . '/changelog.txt',
							esc_html( $theme->get( 'Name' ) ),
							esc_url( $update_url ),
							esc_attr( $update_onclick )
						);
					echo '</div>';
					echo '<div id="' . esc_attr( $this->theme_slug ) . '_changelog" style="display:none;">';
						echo wpautop( $api_response->sections['changelog'] );
					echo '</div>';
				}
			}
		}

		/**
		 * Add an update transient.
		 *
		 * @param string $value Transient.
		 */
		function theme_update_transient( $value ) {
			$update_data = $this->check_for_update();
			if ( $update_data ) {
				$value->response[ $this->theme_slug ] = $update_data;
			}
			return $value;
		}

		/**
		 * Delete the transient.
		 */
		function delete_theme_update_transient() {
			delete_transient( $this->response_key );
		}

		/**
		 * Check for an update.
		 */
		function check_for_update() {

			$update_data = get_transient( $this->response_key );

			if ( false === $update_data ) {
				$failed = false;

				$api_params = array(
					'edd_action'    => 'get_version',
					'license'   => $this->license,
					'name'      => $this->item_name,
					'slug'      => $this->theme_slug,
					'author'    => $this->author,
				);

				$response = wp_remote_post( $this->remote_api_url, array( 'timeout' => 15, 'body' => $api_params ) );

				// Make sure the response was successful.
				if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
					$failed = true;
				}

				$update_data = json_decode( wp_remote_retrieve_body( $response ) );

				if ( ! is_object( $update_data ) ) {
					$failed = true;
				}

				// If the response failed, try again in 30 minutes.
				if ( $failed ) {
					$data = new stdClass;
					$data->new_version = $this->version;
					set_transient( $this->response_key, $data, strtotime( '+30 minutes' ) );
					return false;
				}

				// If the status is 'ok', return the update arguments.
				if ( ! $failed ) {
					$update_data->sections = maybe_unserialize( $update_data->sections );
					set_transient( $this->response_key, $update_data, strtotime( '+12 hours' ) );
				}
			}

			if ( version_compare( $this->version, $update_data->new_version, '>=' ) ) {
				return false;
			}

			return (array) $update_data;
		}
	}
endif;