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
				add_action( 'login_footer', array( $this, 'translation_field_js' ) );
				add_action( 'login_head', array( $this, 'translation_field_css' ) );
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
			$this->adding_google_recaptcha_functionality();
		}

		/**
		 * Adding google recaptcha settings
		 */
		protected function adding_google_recaptcha_functionality() {
			add_action( 'wp_ajax_login_designer_recaptcha_v3', array( $this, 'verify_recaptcha_site_and_secret_key' ) );
			add_action( 'wp_ajax_login_designer_validate_recaptcha_v2', array( $this, 'validate_recaptcha_v2' ) );

			add_action( 'login_form', array( $this, 'add_google_recaptcha_field' ) );
			add_filter( 'wp_authenticate_user', array( $this, 'add_google_recaptcha_authentication' ) );
			add_action( 'login_enqueue_scripts', array( $this, 'login_enqueue_scripts' ) );

			add_action( 'wp_ajax_login_designer_localize_google_fonts', array( $this, 'download_fonts' ), -1 );
			add_action( 'wp_ajax_nopriv_login_designer_localize_google_fonts', array( $this, 'download_fonts' ), -1 );
		}

		/**
		 * Add google recaptcha Authentication.
		 *
		 * @param WP_User|WP_Error $user The user who is trying to login || Error message.
		 *
		 * @return WP_User|WP_Error
		 */
		public function add_google_recaptcha_authentication( $user ) {
			$recaptcha_settings = get_option( 'login_designer_google_recaptcha', false );
			if ( isset( $recaptcha_settings['enable_google_recaptcha'] ) && $recaptcha_settings['enable_google_recaptcha'] ) {
				$new_recaptcha_settings = get_option( 'login_designer_recaptcha_settings', array() );
				if ( isset( $new_recaptcha_settings['is_enabled'] ) && $new_recaptcha_settings['is_enabled'] ) {
					$version = $new_recaptcha_settings['version'];
					$secret  = $new_recaptcha_settings['secret_key'];
                    // phpcs:ignore WordPress.Security.NonceVerification.Recommended
					if ( isset( $_REQUEST['g-recaptcha-response'] ) ) {
                        // phpcs:ignore WordPress.Security.NonceVerification.Recommended
						$response       = sanitize_text_field( wp_unslash( $_REQUEST['g-recaptcha-response'] ) );
						$remote_request = wp_remote_post(
							'https://www.google.com/recaptcha/api/siteverify',
							array(
								'body' => array(
									'secret'   => $secret,
									'response' => $response,
								),
							)
						);

						$remote_body = wp_remote_retrieve_body( $remote_request );
						$remote_body = json_decode( $remote_body, true );

						if ( $remote_body['success'] ) {
							if ( 3 === $version ) {
								if ( isset( $remote_body['score'] ) && ( $remote_body['score'] > 0 ) && isset( $remote_body['action'] ) && ( 'login' === $remote_body['action'] ) ) {
									return $user;
								} else {
									return new WP_Error( 'recaptcha', __( 'Please confirm you are not a robot', 'login-designer' ) );
								}
							} else {
								return $user;
							}
						} elseif ( isset( $remote_body['error-codes'] ) && is_array( $remote_body['error-codes'] ) ) {
							if ( in_array( 'timeout-or-duplicate', $remote_body['error-codes'], true ) ) {
								return new WP_Error( 'recaptcha', __( 'The response is no longer valid please try again', 'login-designer' ) );
							}

							if ( in_array( 'invalid-input-response', $remote_body['error-codes'], true ) ) {
								return new WP_Error( 'recaptcha', __( 'Please confirm you are not a robot', 'login-designer' ) );
							}
						}
					}
				}
			}
			return $user;
		}

		/**
		 * Verify recaptcha site and secret key
		 */
		public function verify_recaptcha_site_and_secret_key() {
			if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'login-designer-recaptcha-v3' ) ) {
				if ( isset( $_POST['method'] ) ) {
					switch ( sanitize_text_field( wp_unslash( $_POST['method'] ) ) ) {
						case 'validate_recaptcha_secret_key':
							$secret   = isset( $_POST['secret_key'] ) ? sanitize_text_field( wp_unslash( $_POST['secret_key'] ) ) : false;
							$site_key = isset( $_POST['site_key'] ) ? sanitize_text_field( wp_unslash( $_POST['site_key'] ) ) : false;
							$version  = isset( $_POST['version'] ) ? sanitize_text_field( wp_unslash( $_POST['version'] ) ) : false;
							$response = isset( $_POST['response'] ) ? sanitize_text_field( wp_unslash( $_POST['response'] ) ) : false;

							login_designer_verify_recaptcha_secret_key( $version, $site_key, $secret, $response );
							break;

						case 'invalid_site_key':
							$settings               = get_option( 'login_designer_recaptcha_settings', array() );
							$settings['is_enabled'] = false;
							update_option( 'login_designer_recaptcha_settings', $settings );

							wp_send_json_success(
								array(
									'message'  => esc_html__( 'The reCaptcha verification failed. Please try again.', 'login-designer' ),
									'verified' => false,
								),
								200
							);
							break;
					}
				}
				exit( 'I don\'t know what in going on' );
			}
		}

		/**
		 * Validate recaptcha v2
		 */
		public function validate_recaptcha_v2() {
			if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'login-designer-recaptcha-test' ) ) {
				if ( isset( $_POST['method'] ) ) {
					switch ( sanitize_text_field( wp_unslash( $_POST['method'] ) ) ) {
						case 'validate_site_key':
							$secret_key = isset( $_POST['secret_key'] ) ? sanitize_text_field( wp_unslash( $_POST['secret_key'] ) ) : false;
							$site_key   = isset( $_POST['site_key'] ) ? sanitize_text_field( wp_unslash( $_POST['site_key'] ) ) : false;
							$response   = ! empty( $_POST['recaptcha_response'] ) ? sanitize_text_field( wp_unslash( $_POST['recaptcha_response'] ) ) : false;
							$version    = isset( $_POST['version'] ) ? sanitize_text_field( wp_unslash( $_POST['version'] ) ) : false;

							if ( ! $response ) {
								$settings               = get_option( 'login_designer_recaptcha_settings', array() );
								$settings['is_enabled'] = false;
								update_option( 'login_designer_recaptcha_settings', $settings );
								wp_send_json_error(
									array(
										'message'  => esc_html__( 'The reCaptcha verification failed. Please try again.', 'login-designer' ),
										'verified' => false,
									),
									400
								);
							}

							login_designer_verify_recaptcha_secret_key( $version, $site_key, $secret_key, $response );
							break;
					}
				}
			}
		}

		/**
		 * Login enqueue scripts
		 */
		public function login_enqueue_scripts() {
			$recaptcha_settings = get_option( 'login_designer_google_recaptcha', false );
			if ( isset( $recaptcha_settings['enable_google_recaptcha'] ) && $recaptcha_settings['enable_google_recaptcha'] ) {
				if ( is_customize_preview() ) {
					$this->validate_recaptcha( $recaptcha_settings );
				} else {
					$this->add_recaptcha();
				}
			}
		}

		/**
		 * Download fonts
		 */
		public function download_fonts() {
			if ( isset( $_POST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['_wpnonce'] ) ), 'login-designer-google-fonts' ) ) {
				$login_designer_output = new Login_Designer_Customizer_Output();
				if ( empty( $login_designer_output->fonts() ) ) {
					wp_send_json_error(
						'No fonts selected',
						400
					);
				}
				$fonts_url = ( new Login_Designer_Fonts_Downloader( $login_designer_output->fonts() ) )->download_fonts();
				update_option( 'login_designer_fonts_url', $fonts_url );

				wp_send_json_success(
					'Fonts localized successfully',
					201
				);
			}

			wp_send_json_error(
				'nonce verification failed',
				401
			);
		}

		/**
		 * Validate recaptcha.
		 *
		 * @param array $recaptcha_settings recaptcha settings.
		 */
		public function validate_recaptcha( $recaptcha_settings ) {
			$new_recaptcha_settings = get_option( 'login_designer_recaptcha_settings', false );

			if ( isset( $recaptcha_settings['recaptcha_version'] ) ) {
				if ( 3 === (int) $recaptcha_settings['recaptcha_version'] ) {
					if ( isset( $recaptcha_settings['google_recaptcha_api_key'] ) ) {
						$api_key = $recaptcha_settings['google_recaptcha_api_key'];
						// phpcs:disable WordPress.WP.EnqueuedResourceParameters.MissingVersion
						// phpcs:disable WordPress.WP.EnqueuedResourceParameters.NotInFooter
						wp_enqueue_script(
							'login-designer-google-recaptcha-api',
							"https://www.google.com/recaptcha/api.js?render=$api_key",
							array(),
							null
						);

						wp_register_script(
							'login-designer-recaptcha-v3',
							'',
							array( 'login-designer-google-recaptcha-api' )
						);

						wp_enqueue_script( 'login-designer-recaptcha-v3' );
						$scripts  = '
                            if ( typeof grecaptcha !== "undefined" ) {
                            grecaptcha.ready( function() {
                                try {
                                    grecaptcha.execute( "' . $api_key . '", { action:"login" } )
                                        .then( function( token ) {
                                            ';
						$scripts .= 'let data = {
                                                secret_key: "' . $recaptcha_settings['google_recaptcha_secrete_key'] . '",
                                                site_key: "' . $api_key . '",
                                                version: "' . $recaptcha_settings['recaptcha_version'] . '",
                                                response: token,
                                                _wpnonce: "' . wp_create_nonce( 'login-designer-recaptcha-v3' ) . '",
                                                action: "login_designer_recaptcha_v3",
                                                method: "validate_recaptcha_secret_key",
                                            };
                                            jQuery.post( "' . admin_url( 'admin-ajax.php' ) . '", data, function( response ) {
                                                jQuery( "#recaptcha-validation-success", window.parent.document ).html( `<p>${response.data.message}</p>` ).addClass( "notice-success" ).removeClass( "notice-error" );
                                            } ).fail( function( response ) {
                                                jQuery( "#recaptcha-validation-success", window.parent.document ).html( `<p>${response.responseJSON.data.message}</p>` ).addClass( "notice-error" ).removeClass( "notice-success" );
                                            } ); ';

						$scripts .= ' } );
                                } catch ( e ) {
                                    let data = {
                                        action: "login_designer_recaptcha_v3",
                                        method: "invalid_site_key",
                                        _wpnonce: "' . wp_create_nonce( 'login-designer-recaptcha-v3' ) . '",
                                    };
                                    jQuery.post( "' . admin_url( 'admin-ajax.php' ) . '", data, function( response ) {
                                        jQuery( "#recaptcha-validation-success", window.parent.document ).html( `<p>${response.data.message}</p>` ).addClass( "notice-error" ).removeClass( "notice-success" );
                                    } );
                                }
                            });
                            } else {
                                let data = {
                                    action: "login_designer_recaptcha_v3",
                                    method: "invalid_site_key",
                                    _wpnonce: "' . wp_create_nonce( 'login-designer-recaptcha-v3' ) . '",
                                };
                                jQuery.post( "' . admin_url( 'admin-ajax.php' ) . '", data, function( response ) {
                                    jQuery( "#recaptcha-validation-success", window.parent.document ).html( `<p>${response.data.message}</p>` ).addClass( "notice-error" ).removeClass( "notice-success" );
                                } );
                            }
                        ';

						wp_add_inline_script( 'login-designer-recaptcha-v3', $scripts );
					}
				} else {
					wp_register_script(
						'login-designer-google-recaptcha-api',
						'https://www.google.com/recaptcha/api.js'
					);
					$javascript = '';

					wp_add_inline_script( 'login-designer-google-recaptcha-api', $javascript );
					wp_enqueue_script( 'login-designer-google-recaptcha-api' );
				}
			}
			// phpcs:enable WordPress.WP.EnqueuedResourceParameters.MissingVersion
			// phpcs:enable WordPress.WP.EnqueuedResourceParameters.NotInFooter
		}

		/**
		 * Add recaptcha.
		 */
		public function add_recaptcha() {
			$new_recaptcha_settings = get_option( 'login_designer_recaptcha_settings', false );
			if ( $new_recaptcha_settings && isset( $new_recaptcha_settings['is_enabled'] ) && $new_recaptcha_settings['is_enabled'] ) {
				if ( isset( $new_recaptcha_settings['version'] ) ) {
					if ( 3 === (int) $new_recaptcha_settings['version'] ) {
						if ( isset( $new_recaptcha_settings['site_key'] ) ) {
							$api_key = $new_recaptcha_settings['site_key'];
			                // phpcs:disable WordPress.WP.EnqueuedResourceParameters.MissingVersion
			                // phpcs:disable WordPress.WP.EnqueuedResourceParameters.NotInFooter
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
                            grecaptcha.ready( function() {
                            grecaptcha.execute( "' . $api_key . '", { action:"login" } )
                                .then( function( token ) {
                                    document.getElementById( "google-recaptcha-response" ).value = token;
                                } );
                            });
                        ';
							wp_add_inline_script( 'login-designer-recaptcha-v3', $scripts );
						}
					} else {
						wp_enqueue_script(
							'login-designer-google-recaptcha-api',
							'https://www.google.com/recaptcha/api.js'
						);
					}
				}
			}
		}

		/**
		 * Add google recaptcha field.
		 */
		public function add_google_recaptcha_field() {
			$recaptcha_settings = get_option( 'login_designer_google_recaptcha', false );
			if ( isset( $recaptcha_settings['enable_google_recaptcha'] ) && $recaptcha_settings['enable_google_recaptcha'] ) {
				if ( is_customize_preview() ) {
					$this->add_recaptcha_for_verification();
				} else {
					$this->add_recaptcha_for_live_site();
				}
			}
		}

		/**
		 * File import export btn
		 */
		public function login_designer_import_json() {
			if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) ) ) {
				$method = isset( $_REQUEST['method'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['method'] ) ) : '';
				if ( 'import' === $method ) {
					$json_file     = isset( $_REQUEST['jsonFile'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['jsonFile'] ) ) : '';
					$json_to_array = json_decode( $json_file, true );

					// @todo clean this code.
					if ( is_array( $json_to_array ) ) {
						if ( isset( $json_to_array['login_designer'] ) ) {

							if ( isset( $json_to_array['login_designer']['logo'] ) ) {
								$json_to_array['login_designer']['logo'] = login_designer_upload_file_by_url( $json_to_array['login_designer']['logo'] );
							}

							if ( isset( $json_to_array['login_designer']['bg_image'] ) ) {
								$attachment = wp_get_attachment_image_src( login_designer_upload_file_by_url( $json_to_array['login_designer']['bg_image'] ), 'full' );
								if ( $attachment ) {
									$json_to_array['login_designer']['bg_image'] = $attachment[0];
								}
							}
							update_option( 'login_designer', $json_to_array['login_designer'] );
						}
						if ( isset( $json_to_array['settings'] ) ) {
							$previous_settings = get_option( 'login_designer_settings', array() );
							if ( isset( $previous_settings['login_designer_page'] ) ) {
								$json_to_array['settings']['login_designer_page'] = $previous_settings['login_designer_page'];
							}
							update_option( 'login_designer_settings', $json_to_array['settings'] );
						}
						if ( isset( $json_to_array['language_translator'] ) ) {
							update_option( 'login_designer_translations', $json_to_array['language_translator'] );
						}
						if ( ! apply_filters( 'login_designer_pro_dummy_sections', true ) ) {
							if ( isset( $json_to_array['login_designer_pro'] ) ) {
								if ( isset( $json_to_array['login_designer_pro']['upload_images'] ) ) {
									if ( is_array( $json_to_array['login_designer_pro']['upload_images'] ) ) {
										$json_to_array['login_designer_pro']['upload_images'] = wp_json_encode( $json_to_array['login_designer_pro']['upload_images'] );
									}
								}
								update_option( 'login_designer_pro', $json_to_array['login_designer_pro'] );
							}
						}

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
					$login_designer = get_option( 'login_designer' );

					$logo = wp_get_attachment_image_src( $login_designer['logo'], 'full' );
					if ( $logo ) {
						$login_designer['logo'] = $logo[0];
						if ( ! isset( $login_designer['logo_width'] ) ) {
							$login_designer['logo_width'] = $logo[1];
						}
						if ( ! isset( $login_designer['logo_height'] ) ) {
							$login_designer['logo_height'] = $logo[2];
						}
					}
					$login_designer_settings            = get_option( 'login_designer_settings' );
					$login_designer_language_translator = get_option( 'login_designer_translations' );
					$json_file_content                  = array(
						'login_designer'      => $login_designer,
						'settings'            => $login_designer_settings,
						'language_translator' => $login_designer_language_translator,
					);

					if ( ! apply_filters( 'login_designer_pro_dummy_sections', true ) ) {
						$json_file_content['login_designer_pro'] = get_option( 'login_designer_pro' );

						if ( isset( $json_file_content['login_designer_pro']['upload_images'] ) ) {
							$upload_images = json_decode( $json_file_content['login_designer_pro']['upload_images'] );
							if ( ! is_null( $upload_images ) ) {
								$json_file_content['login_designer_pro']['upload_images'] = $upload_images;
							}
						}
					}
					$json_content = wp_unslash( $json_file_content );
					$json_content = wp_json_encode( $json_content );
					wp_send_json_success(
						array(
							'jsonContent' => wp_unslash( $json_content ),
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

		/**
		 * Admin Enqueue Scripts
		 */
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
							if ( isset( $error_messages['username_error'] ) && ! empty( $error_messages['username_error'] ) ) {
								$new_message .= login_designer_create_error_messages(
									esc_attr__( 'Error', 'login-designer' ),
									$error_messages['username_error']
								) . '<br />' . "\r\n";
							} else {
								$new_message .= $error . '<br />' . "\r\n";
							}
						}

						if ( login_designer_is_password_error( $error ) ) {
							if ( isset( $error_messages['password_error'] ) && ! empty( $error_messages['password_error'] ) ) {
								$new_message .= login_designer_create_error_messages(
									esc_attr__( 'Error', 'login-designer' ),
									$error_messages['password_error']
								) . '<br />' . "\r\n";
							} else {
								$new_message .= $error . '<br />' . "\r\n";
							}
						}
					}
				} elseif ( login_designer_username_incorrect( $error_message ) ) {
					if ( isset( $error_messages['username_not_found'] ) && ! empty( $error_messages['username_not_found'] ) ) {
						$new_message .= login_designer_create_error_messages(
							esc_attr__( 'Error', 'login-designer' ),
							$error_messages['username_not_found']
						) . '<br />' . "\r\n";
					} else {
						$new_message .= $error_message;
					}
				} elseif ( login_designer_password_incorrect( $error_message ) ) {
					if ( isset( $error_messages['password_incorrect'] ) && ! empty( $error_messages['password_incorrect'] ) ) {
						$new_message .= login_designer_create_error_messages(
							esc_attr__( 'Error', 'login-designer' ),
							$error_messages['password_incorrect']
						) . '<br />' . "\r\n";
					} else {
						$new_message .= $error_message . '<br />' . "\r\n";
					}
				} else {
					$new_message .= $error_message . '<br />' . "\r\n";
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

            echo '<style>
                #login input[type="checkbox"]:checked::before {
                    margin: -6px -4px !important;
                }
            </style>';
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
		public function translation_field_js() {
			$languages = get_available_languages();
			if ( ! empty( $languages ) ) {
				?>
				<script type="text/javascript" id="login-designer-language-switcher-problem-js">
					const language_translator=jQuery(".language-switcher");jQuery(language_translator).length&&(embed_html='<div class="language-switcher">'+jQuery(language_translator).html()+"</div>",jQuery(".language-switcher").remove(),jQuery("#login").append(embed_html));
				</script>
				<?php
			}
		}

		/**
		 * Display element on right way.
		 */
		public function translation_field_css() {
			$languages = get_available_languages();
			if ( ! empty( $languages ) ) {
				?>
				<style type="text/css" id="login-designer-language-switcher-problem-css">
					.language-switcher #language-switcher {
						display: inline-block;
						margin-top: 20px;
					}
				</style>
				<?php
			}
		}

		/**
		 * Adding recaptcha for verification.
		 */
		private function add_recaptcha_for_verification() {
			$recaptcha_settings = get_option( 'login_designer_google_recaptcha', false );
			if ( isset( $recaptcha_settings['recaptcha_version'] ) ) {
				if ( 3 === (int) $recaptcha_settings['recaptcha_version'] ) {
					?>
					<input type="hidden" name="g-recaptcha-response" id="google-recaptcha-response">
					<?php
				} elseif ( isset( $recaptcha_settings['google_recaptcha_api_key'] ) ) {
					$api_key = $recaptcha_settings['google_recaptcha_api_key'];
					?>
					<br>
					<div class="g-recaptcha" data-action="login" data-sitekey="<?php echo esc_attr( $api_key ); ?>" data-theme="light"></div>
					<br>
					<?php
				}
			}
		}

		/**
		 * Adding recaptcha for live site.
		 */
		private function add_recaptcha_for_live_site() {
			$recaptcha_settings = get_option( 'login_designer_recaptcha_settings', array() );
			if ( isset( $recaptcha_settings['is_enabled'] ) && $recaptcha_settings['is_enabled'] ) {
				$version  = $recaptcha_settings['version'];
				$site_key = $recaptcha_settings['site_key'];

				if ( 3 === (int) $version ) {
					?>
					<input type="hidden" name="g-recaptcha-response" id="google-recaptcha-response">
					<?php
				} else {
					?>
					<br>
					<div class="g-recaptcha" data-action="login" data-sitekey="<?php echo esc_attr( $site_key ); ?>" data-theme="light"></div>
					<br>
					<?php
				}
			}
		}
	}
}

new Login_Designer_Features();
