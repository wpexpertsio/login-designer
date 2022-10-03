<?php
/**
 * Class: Login_Designer_Features
 *
 * @package Login Designer
 */

defined( 'ABSPATH' ) || exit;
if ( ! class_exists( 'Login_Designer_Features' ) ) {
	/**
	 * Class Login_Designer_Features
	 */
	class Login_Designer_Features {
		/**
		 * Recaptcha settings
		 *
		 * @var null
		 */
		protected $recaptcha_settings;

		/**
		 * Login_Designer_Features constructor.
		 */
		public function __construct() {
			/**
			 * Translation Field actions.
			 */
			add_action( 'login_head', array( $this, 'add_translation_styles' ) );
			$login_designer = get_option( 'login_designer', array( 'template' => 'default' ) );
			if ( isset( $login_designer['template'] ) && 'default' !== $login_designer['template'] ) {
				add_action( 'login_footer', array( $this, 'translation_field' ) );
			}
			add_action( 'login_footer', array( $this, 'hide_customizer_elements' ) );
			/**
			 * Login Error Messages actions
			 */
			add_filter( 'login_errors', array( $this, 'modify_error_messages' ) );
			/**
			 * Import export settings actions
			 */
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
			add_action( 'wp_ajax_login_designer_import_json', array( $this, 'login_designer_import_json' ) );
			/**
			 * Google recaptcha settings action
			 */
			$this->recaptcha_settings = get_option( 'login_designer_google_recaptcha', false );
			$this->adding_google_recaptcha_functionality();
		}

		/**
		 * Adding google recaptcha settings
		 */
		protected function adding_google_recaptcha_functionality() {
			if ( $this->recaptcha_settings ) {
				$enabled_recaptcha = $this->recaptcha_settings['enable_google_recaptcha'];
				if ( $enabled_recaptcha ) {
					add_action( 'login_form', array( $this, 'add_google_recaptcha_field' ) );
					add_action( 'login_enqueue_scripts', array( $this, 'login_enqueue_scripts' ) );
					add_filter( 'wp_authenticate_user', array( $this, 'add_google_recaptcha_authentication' ) );
				}
			}
		}

		/**
		 * Add google recaptcha Authentication.
		 *
		 * @param WP_User|WP_Error $user The user who is trying to login || Error message.
		 *
		 * @return WP_User|WP_Error
		 */
		public function add_google_recaptcha_authentication( $user ) {
			$secrete_key = $this->recaptcha_settings['google_recaptcha_secrete_key'];
			// phpcs:ignore  WordPress.Security.NonceVerification
			if ( isset( $_REQUEST['g-recaptcha-response'] ) ) {
				// phpcs:ignore  WordPress.Security.NonceVerification
				$google_recaptcha_response = sanitize_text_field( wp_unslash( $_REQUEST['g-recaptcha-response'] ) );
				$response                  = wp_remote_post(
					'https://www.google.com/recaptcha/api/siteverify',
					array(
						'body' => array(
							'secret'   => $secrete_key,
							'response' => $google_recaptcha_response,
						),
					)
				);
				$data                      = wp_remote_retrieve_body( $response );
				$data                      = json_decode( $data );

				if ( isset( $data->success ) ) {
					if ( 3 === (int) $this->recaptcha_settings['recaptcha_version'] ) {
						if ( $data->success && isset( $data->score ) && ( $data->score > 0 ) && isset( $data->action ) && ( 'login' === $data->action ) ) {
							return $user;
						}
					} else {
						if ( $data->success ) {
							return $user;
						}
					}
				}
			}
			return new WP_Error(
				'recaptcha',
				sprintf(
				// Translators: %1$s gettext html element start tag.
				// Translators: %2$s gettext html element end tag.
					__( '%1$s Error %2$s: Please confirm you are not a robot', 'login-designer' ),
					'<strong>',
					'</strong>'
				)
			);
		}
		/**
		 * Login enqueue scripts
		 */
		public function login_enqueue_scripts() {
			// phpcs:disable
			if ( 3 === (int) $this->recaptcha_settings['recaptcha_version'] ) {
				$api_key = $this->recaptcha_settings['google_recaptcha_api_key'];
				wp_enqueue_script(
					'login-designer-google-recaptcha-api',
					"https://www.google.com/recaptcha/api.js?render=$api_key"
				);

				wp_register_script(
					'login-designer-recaptcha-v3',
					'',
					array( 'login-designer-google-recaptcha-api' )
				);

				wp_enqueue_script( 'login-designer-recaptcha-v3' );

				$scripts = '
				grecaptcha.ready(function(){
					grecaptcha.execute("' . $api_key . '", {action:"login"})
						.then(function(token){
						console.log( token );
							document.getElementById( "google-recaptcha-response" ).value = token;
						});
				});
			';

				wp_add_inline_script( 'login-designer-recaptcha-v3', $scripts );
			} else {
				wp_enqueue_script(
					'login-designer-google-recaptcha-api',
					'https://www.google.com/recaptcha/api.js'
				);
			}
			// phpcs:enable
		}

		/**
		 * Add google recaptcha field.
		 */
		public function add_google_recaptcha_field() {
			if ( 3 === (int) $this->recaptcha_settings['recaptcha_version'] ) {
				?>
				<input type="hidden" name="g-recaptcha-response" id="google-recaptcha-response">
				<?php
			} else {
				$api_key = $this->recaptcha_settings['google_recaptcha_api_key'];
				?>
				<br>
				<div class="g-recaptcha" data-action="login" data-sitekey="<?php echo esc_attr( $api_key ); ?>" data-theme="dark"></div>
				<br>
				<?php
			}
		}

		public function login_designer_import_json() {
			if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) ) ) {
				$method = isset( $_REQUEST['method'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['method'] ) ) : '';
				if ( 'import' === $method ) {
					$json_file     = isset( $_REQUEST['jsonFile'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['jsonFile'] ) ) : '';
					$json_to_array = json_decode( $json_file, true );

					if ( isset( $json_to_array['login_designer'] ) && isset( $json_to_array['settings'] ) ) {
						update_option( 'login_designer', $json_to_array['login_designer'] );
						update_option( 'login_designer_settings', $json_to_array['settings'] );

						wp_send_json_success( 'JSON has been saved', 201 );
					} else {
						wp_send_json_error(
							array(
								'error_message' => esc_attr__( 'JSON file does not contain valid json', 'login-designer' ),
							),
							500
						);
					}
				}

				if ( 'get_latest_json' === $method ) {
					$login_designer          = get_option( 'login_designer' );
					$login_designer_settings = get_option( 'login_designer_settings' );
					$json_file_content       = array(
						'login_designer' => $login_designer,
						'settings'       => $login_designer_settings,
					);
					$json_content            = wp_json_encode( $json_file_content );
					$json_content            = sanitize_text_field( wp_unslash( $json_content ) );
					wp_send_json_success(
						array(
							'jsonContent' => $json_content,
						),
						200
					);
				}

				wp_send_json_error(
					array(
						'error_count'   => json_last_error(),
						'error_message' => json_last_error_msg(),
						'error_type'    => esc_attr__( 'Internal Server Error', 'login-designer' ),
					),
					500
				);
			}
		}

		public function admin_enqueue_scripts() {
			wp_enqueue_style(
				'login-designer-import-export-styles',
				LOGIN_DESIGNER_PLUGIN_URL . 'assets/css/src/login-designer-import-export.css',
				array(),
				LOGIN_DESIGNER_VERSION,
				'all'
			);
		}

		/**
		 * Login error messages
		 *
		 * @param string $error_message Error messages.
		 *
		 * @return string
		 */
		public function modify_error_messages( $error_message ) {
			if ( get_option( 'login_designer_error_messages', false ) ) {
				$new_message    = '';
				$error_messages = get_option( 'login_designer_error_messages' );
				if ( login_designer_is_empty_type( $error_message ) ) {
					$error_explode_by_br = explode( '<br />', $error_message );
					$error_explode_by_br = login_designer_remove_if_empty_array( $error_explode_by_br );

					foreach ( $error_explode_by_br as $k => $error ) {

						if ( login_designer_is_username_error( $error ) ) {
							if ( $error_messages['username_error'] ) {
								$new_message .= login_designer_create_error_messages(
									esc_attr__( 'Error', 'login-designer' ),
									$error_messages['username_error']
								);
							} else {
								$new_message .= $error;
							}
						}

						if ( login_designer_is_password_error( $error ) ) {
							if ( isset( $error_messages['password_error'] ) ) {
								$new_message .= login_designer_create_error_messages(
									esc_attr__( 'Error', 'login-designer' ),
									$error_messages['password_error']
								);
							} else {
								$new_message .= $error;
							}
						}
					}
				} elseif ( login_designer_username_incorrect( $error_message ) ) {
					if ( isset( $error_messages['username_not_found'] ) ) {
						$new_message .= login_designer_create_error_messages(
							esc_attr__( 'Error', 'login-designer' ),
							$error_messages['username_not_found']
						);
					} else {
						$new_message .= $error_message;
					}
				} elseif ( login_designer_password_incorrect( $error_message ) ) {
					if ( isset( $error_messages['password_incorrect'] ) ) {
						$new_message .= login_designer_create_error_messages(
							esc_attr__( 'Error', 'login-designer' ),
							$error_messages['password_incorrect']
						);
					} else {
						$new_message .= $error_message;
					}
				} else {
					$new_message .= $error_message;
				}
				return $new_message;
			}
			return $error_message;
		}

		/**
		 * Adding translation styles in login head
		 */
		public function add_translation_styles() {
			echo '<style type="text/css">';
			$translation_parameters = get_option( 'login_designer_translations', false );
			if ( $translation_parameters ) {
				$translation = $translation_parameters['translation'];
				if ( $translation ) {
					echo '.language-switcher { display:block !important; }';
				} else {
					echo '.language-switcher { display: none !important; }';

				}
			}
			echo '</style>';
		}

		/**
		 * Hiding login designer customizer elements.
		 */
		public function hide_customizer_elements() {
			echo '<script type="text/javascript">';
			if ( is_customize_preview() ) {
				$login_designer = get_option( 'login_designer_translations', false );
				if ( $login_designer ) {
					if ( $login_designer['translation'] ) {
						echo "let login_designer_template = jQuery( '#login-designer-template' ).text();
                            if ( 'default' === login_designer_template ) {
                                jQuery( '.login-designer--translation-switcher[data-logindesigner-template=template]' ).attr( 'style', 'display: none !important;position:relative;' );
                                jQuery( '.login-designer--translation-switcher[data-logindesigner-template=default]' ).attr( 'style', 'display: block !important;position:relative;' );
                            }
                            if ( 'default' !== login_designer_template ) {
                                jQuery( '.login-designer--translation-switcher[data-logindesigner-template=default]' ).attr( 'style', 'display: none !important;position:relative;' );
                                jQuery( '.login-designer--translation-switcher[data-logindesigner-template=template]' ).attr( 'style', 'display: block !important;position:relative;' );
                            }";
					} else {
						echo "jQuery( 'body' ).addClass( 'login-designer-no-language' );";
					}
				}
			}
			echo '</script>';
		}

		/**
		 * Display element on right way.
		 */
		public function translation_field() {
			$languages = get_available_languages();
			if ( ! empty( $languages ) ) {
				$js = <<<JS
                const language_translator=jQuery(".language-switcher");jQuery(language_translator).length&&(embed_html='<div class="language-switcher">'+jQuery(language_translator).html()+"</div>",jQuery(".language-switcher").remove(),jQuery("#login").append(embed_html));
JS;
				wp_add_inline_script( 'jquery', trim( $js ) );
				wp_enqueue_script( 'jquery' );
			}
		}
	}
}

new Login_Designer_Features();
