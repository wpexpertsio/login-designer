/**
 * Customizer Events Communicator.
 */
( function ( exports, $ ) {
	"use strict";

	var api = wp.customize, LoginDesignerOldPreviewer;

	var all_controls = {
		'logo' : [
			'login_designer[logo_title]',
			'login_designer[logo]',
			'login_designer[logo_width]',
			'login_designer[logo_height]',
			'login_designer[logo_margin_bottom]',
			'login_designer_settings[logo_url]',
			'login_designer[disable_logo]',
		],
		'form' : [
			'login_designer[form_title]',
			'login_designer[form_width]',
			'login_designer[form_radius]',
			'login_designer[form_bg]',
			'login_designer[form_bg_transparency]',
			'login_designer[form_vertical_padding]',
			'login_designer[form_side_padding]',
			'login_designer[form_shadow]',
			'login_designer[form_shadow_opacity]',
		],
		'fields' : [
			'login_designer[fields_title]',
			'login_designer[field_bg]',
			'login_designer[field_border]',
			'login_designer[field_border_color]',
			'login_designer[field_radius]',
			'login_designer[field_padding_top]',
			'login_designer[field_padding_bottom]',
			'login_designer[field_side_padding]',
			'login_designer[field_margin_bottom]',
			'login_designer[field_shadow]',
			'login_designer[field_shadow_opacity]',
			'login_designer[field_shadow_inset]',
			'login_designer[field_text_title]',
			'login_designer[field_font]',
			'login_designer[field_font_size]',
			'login_designer[field_color]',
		],
		'labels' : [
			'login_designer[labels_title]',
			'login_designer[label_font]',
			'login_designer[label_font_size]',
			'login_designer[label_color]',
			'login_designer[label_position]',
			'login_designer[username_label]',
			'login_designer[password_label]',
		],
		'button' : [
			'login_designer[button_title]',
			'login_designer[button_bg]',
			'login_designer[button_padding_top]',
			'login_designer[button_padding_bottom]',
			'login_designer[button_side_padding]',
			'login_designer[button_border]',
			'login_designer[button_border_color]',
			'login_designer[button_radius]',
			'login_designer[button_shadow]',
			'login_designer[button_shadow_opacity]',
			'login_designer[button_text_title]',
			'login_designer[button_font]',
			'login_designer[button_font_size]',
			'login_designer[button_color]',
		],
		'background' : [
			'login_designer[bg_title]',
			'login_designer[bg_image]',
			'login_designer[bg_color]',
			'login_designer[bg_repeat]',
			'login_designer[bg_size]',
			'login_designer[bg_attach]',
			'login_designer[bg_position]',
			'login_designer[bg_image_gallery]',
		],
		'remember' : [
			'login_designer[remember_title]',
			'login_designer[remember_color]',
			'login_designer[remember_font]',
			'login_designer[remember_font_size]',
			'login_designer[remember_position]',
			'login_designer[remember_hide]',
		],
		'checkbox' : [
			'login_designer[checkbox_title]',
			'login_designer[checkbox_size]',
			'login_designer[checkbox_bg]',
			'login_designer[checkbox_border]',
			'login_designer[checkbox_border_color]',
			'login_designer[checkbox_radius]',
		],
		'below' : [
			'login_designer[below_title]',
			'login_designer[lost_password]',
			'login_designer[back_to]',
			'login_designer[below_color]',
			'login_designer[below_position]',
			'login_designer[below_font]',
			'login_designer[below_font_size]',
		],
	};

	function active_control( section ) {

		all_controls.logo.forEach(function(item, index, array) {
			control_visibility( all_controls.logo, 'deactivate' );
		});

		all_controls.form.forEach(function(item, index, array) {
			control_visibility( all_controls.form, 'deactivate' );
		});

		all_controls.fields.forEach(function(item, index, array) {
			control_visibility( all_controls.fields, 'deactivate' );
		});

		all_controls.labels.forEach(function(item, index, array) {
			control_visibility( all_controls.labels, 'deactivate' );
		});

		all_controls.button.forEach(function(item, index, array) {
			control_visibility( all_controls.button, 'deactivate' );
		});

		all_controls.background.forEach(function(item, index, array) {
			control_visibility( all_controls.background, 'deactivate' );
		});

		all_controls.remember.forEach(function(item, index, array) {
			control_visibility( all_controls.remember, 'deactivate' );
		});

		all_controls.checkbox.forEach(function(item, index, array) {
			control_visibility( all_controls.checkbox, 'deactivate' );
		});

		all_controls.below.forEach(function(item, index, array) {
			control_visibility( all_controls.below, 'deactivate' );
		});

		control_visibility( section, 'activate' );
	}

	/**
	 * Function to hide/show Customizer options, based on another control.
	 *
	 * Parent option, Affected Control, Value which affects the control.
	 */
	function customizer_image_option_display( parent_setting, affected_control, custom_logic ) {
		wp.customize( parent_setting, function( setting ) {
			wp.customize.control( affected_control, function( control ) {
				var visibility = function() {
					if ( setting.get() && 'none' !== setting.get() && '0' !== setting.get() ) {
						control.activate( { duration: 0 } );
						control.container.slideDown( 0 );
					} else {
						control.container.slideUp( 0 );
						control.deactivate( { duration: 0 } );
					}

					if ( custom_logic ) {
						if ( 'cover' === wp.customize( 'login_designer[bg_size]' ).get() ) {
							console.log( 'clicked' )
							control.activate( { duration: 0 } );
							control.container.slideUp( 0 );
						} else {
							control.container.slideDown( 0 );
							control.deactivate( { duration: 0 } );
						}
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	}

	/**
	 * Function to hide/show Customizer options, based on another control.
	 *
	 * Parent option, Affected Control, Value which affects the control.
	 */
	function customizer_no_image_option_display( parent_setting, affected_control ) {
		wp.customize( parent_setting, function( setting ) {
			wp.customize.control( affected_control, function( control ) {
				var visibility = function() {
					if ( setting.get() ) {
						control.container.slideUp( 0 );
						control.deactivate( { duration: 0 } );
					}  else {
						control.container.slideDown( 0 );
						control.activate( { duration: 0 } );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	}

	/**
	 * Function to hide/show Customizer options, based on a range control value.
	 *
	 * Parent option, Affected Control, Value which affects the control.
	 */
	function customizer_range_option_display( parent_setting, affected_control, value ) {
		wp.customize( parent_setting, function( setting ) {
			wp.customize.control( affected_control, function( control ) {
				var visibility = function() {
					if ( setting.get() && '0' !== setting.get() ) {
						control.container.slideDown( 0 );
					} else {
						control.container.slideUp( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	}

	/**
	 * Function to hide/show Customizer options, based on a checkbox value.
	 *
	 * Parent option, Affected Control, Value which affects the control.
	 */
	function customizer_checkbox_option_display( parent_setting, affected_control, value ) {
		wp.customize( parent_setting, function( setting ) {
			wp.customize.control( affected_control, function( control ) {
				var visibility = function() {
					if ( value === setting.get() ) {
						control.container.slideDown( 0 );
					} else {
						control.container.slideUp( 0 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	}

	/**
	 * Function to hide/show Customizer options, based on a select value.
	 *
	 * Parent option, Affected Control, Value which affects the control.
	 */
	function customizer_select_option_display( parent_setting, affected_control, value ) {
		wp.customize( parent_setting, function( setting ) {
			wp.customize.control( affected_control, function( control ) {
				var visibility = function() {
					if ( value !== setting.get() ) {
						control.container.slideDown( 100 );
					} else {
						control.container.slideUp( 100 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});
	}

	function control_visibility( controls, action ) {

		controls.forEach( function( item, index, array ) {

			if ( action === 'activate' ) {

				// For this particular control, let's check to see if corresponding options are visible.
				// We only want to show relevant options based on the user's contextual design decisions.
				if ( item === 'login_designer[logo_margin_bottom]' ) {

					customizer_checkbox_option_display( 'login_designer[disable_logo]', 'login_designer[logo_margin_bottom]', false );

					wp.customize( 'login_designer[disable_logo]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( true === setting.get() ) {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								} else {
									// If there's no custom background image, let's show the gallery.
									wp.customize.control( item ).activate( { duration: 0 } );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[logo_height]' ) {

					// Only show the logo height option, if there is a logo uploaded.
					customizer_image_option_display( 'login_designer[logo]', 'login_designer[logo_height]' );

					wp.customize( 'login_designer[disable_logo]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( true === setting.get() ) {
									// If not, let's quickly hide it.
									wp.customize.control( item ).deactivate( { duration: 0 } );
								} else {
									// Only show the width if there is a logo uploaded.
									if ( wp.customize.control( 'login_designer[logo]' ).setting.get() ) {
										wp.customize.control( item ).activate( { duration: 0 } );
									}
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

					wp.customize( 'login_designer[logo]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( setting.get() ) {
									// If there is a background image or gallery image, but neither are set to "none".
									wp.customize.control( item ).activate( { duration: 0 } );
								} else {
									// If not, let's quickly hide it.
									wp.customize.control( item ).deactivate( { duration: 0 } );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[logo_width]' ) {

					// Only show the logo width option, if there is a logo uploaded.
					customizer_image_option_display( 'login_designer[logo]', 'login_designer[logo_width]' );

					wp.customize( 'login_designer[disable_logo]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( true === setting.get() ) {
									wp.customize.control( item ).deactivate( { duration: 0 } );
								} else {

									// Only show the width if there is a logo uploaded.
									if ( wp.customize.control( 'login_designer[logo]' ).setting.get() ) {
										wp.customize.control( item ).activate( { duration: 0 } );
									}
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

					wp.customize( 'login_designer[logo]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( setting.get() ) {
									// If there is a background image or gallery image, but neither are set to "none".
									wp.customize.control( item ).activate( { duration: 0 } );
								} else {
									// If not, let's quickly hide it.
									wp.customize.control( item ).deactivate( { duration: 0 } );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[logo]' ) {

					customizer_checkbox_option_display( 'login_designer[disable_logo]', 'login_designer[logo]', false );

					wp.customize( 'login_designer[disable_logo]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( true === setting.get() ) {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								} else {
									// If there's no custom background image, let's show the gallery.
									wp.customize.control( item ).activate( { duration: 0 } );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[logo_title]' ) {

					customizer_checkbox_option_display( 'login_designer[disable_logo]', 'login_designer[logo_title]', false );

					wp.customize( 'login_designer[disable_logo]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( true === setting.get() ) {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								} else {
									// If there's no custom background image, let's show the gallery.
									wp.customize.control( item ).activate( { duration: 0 } );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer_settings[logo_url]' ) {

					customizer_checkbox_option_display( 'login_designer[disable_logo]', 'login_designer_settings[logo_url]', false );

					wp.customize( 'login_designer[disable_logo]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( true === setting.get() ) {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								} else {
									// If there's no custom background image, let's show the gallery.
									wp.customize.control( item ).activate( { duration: 0 } );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[form_bg]' ) {

					customizer_checkbox_option_display( 'login_designer[form_bg_transparency]', 'login_designer[form_bg]', false );

					wp.customize( 'login_designer[form_bg_transparency]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( true === setting.get() ) {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								} else {
									// If there's no custom background image, let's show the gallery.
									wp.customize.control( item ).activate( { duration: 0 } );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[bg_image_gallery]' ) {
						customizer_no_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_image_gallery]' );

						wp.customize( 'login_designer[bg_image]', function( setting ) {
							wp.customize.control( item, function( control ) {
								var visibility = function() {

									if ( ! setting.get() ) {
										// If there's no custom background image, let's show the gallery.
										wp.customize.control( item ).activate( { duration: 0 } );
									} else {
										// If not, let's quickly hide it.
										control.container.slideUp( 0 );
									}
								};

								visibility();
								setting.bind( visibility );
							});
						});
				} else if ( item === 'login_designer[bg_repeat]' ) {

					// Only show the background options, if there is a background image uploaded.
					customizer_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_repeat]' );
					customizer_image_option_display( 'login_designer[bg_image_gallery]', 'login_designer[bg_repeat]' );

					$.each( [ 'login_designer[bg_image]', 'login_designer[bg_image_gallery]' ], function( index, settingId ) {
						wp.customize( settingId, function( setting ) {
							wp.customize.control( item, function( control ) {
								var visibility = function() {

									if ( setting.get() && 'none' !== setting.get() ) {
										// If there is a background image or gallery image, but neither are set to "none".
										wp.customize.control( item ).activate( { duration: 0 } );
									} else {
										// If not, let's quickly hide it.
										control.container.slideUp( 0 );
									}
								};

								visibility();
								setting.bind( visibility );
							} );
						} );
					} );

				} else if ( item === 'login_designer[bg_size]' ) {

					customizer_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_size]' );
					customizer_image_option_display( 'login_designer[bg_image_gallery]', 'login_designer[bg_size]' );

					$.each( [ 'login_designer[bg_image]', 'login_designer[bg_image_gallery]' ], function( index, settingId ) {

						wp.customize( settingId, function( setting ) {
							wp.customize.control( item, function( control ) {
								var visibility = function() {

									if ( setting.get() && 'none' !== setting.get() ) {
										// If there is a background image or gallery image, but neither are set to "none".
										wp.customize.control( item ).activate( { duration: 0 } );
									} else {
										// If not, let's quickly hide it.
										control.container.slideUp( 0 );
									}
								};

								visibility();
								setting.bind( visibility );
							} );
						} );
					} );

				} else if ( item === 'login_designer[bg_attach]' ) {

					customizer_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_attach]' );
					customizer_image_option_display( 'login_designer[bg_image_gallery]', 'login_designer[bg_attach]' );

					$.each( [ 'login_designer[bg_image]', 'login_designer[bg_image_gallery]' ], function( index, settingId ) {

						wp.customize( settingId, function( setting ) {
							wp.customize.control( item, function( control ) {
								var visibility = function() {

									if ( setting.get() && 'none' !== setting.get() ) {
										// If there is a background image or gallery image, but neither are set to "none".
										wp.customize.control( item ).activate( { duration: 0 } );
									} else {
										// If not, let's quickly hide it.
										control.container.slideUp( 0 );
									}
								};

								visibility();
								setting.bind( visibility );
							} );
						} );
					} );

				} else if ( item === 'login_designer[bg_position]' ) {

					customizer_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_position]' );
					customizer_image_option_display( 'login_designer[bg_image_gallery]', 'login_designer[bg_position]', true );

					customizer_select_option_display( 'login_designer[bg_size]', 'login_designer[bg_position]', 'cover' );

					$.each( [ 'login_designer[bg_image]', 'login_designer[bg_image_gallery]' ], function( index, settingId ) {

						wp.customize( settingId, function( setting ) {
							wp.customize.control( item, function( control ) {
								var visibility = function() {

									if ( setting.get() && 'none' !== setting.get() ) {
										// If there is a background image or gallery image, but neither are set to "none".
										wp.customize.control( item ).activate( { duration: 0 } );
									} else {
										// If not, let's quickly hide it.
										control.container.slideUp( 0 );
									}
								};

								visibility();
								setting.bind( visibility );
							} );
						} );
					} );

				} else if ( item === 'login_designer[form_shadow_opacity]' ) {

					customizer_range_option_display( 'login_designer[form_shadow]', 'login_designer[form_shadow_opacity]', '0' );

					wp.customize( 'login_designer[form_shadow]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate( { duration: 0 } );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[field_shadow_opacity]' ) {

					customizer_range_option_display( 'login_designer[field_shadow]', 'login_designer[field_shadow_opacity]', '0' );

					wp.customize( 'login_designer[field_shadow]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate( { duration: 0 } );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[field_shadow_inset]' ) {

					customizer_range_option_display( 'login_designer[field_shadow]', 'login_designer[field_shadow_inset]', '0' );

					wp.customize( 'login_designer[field_shadow]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate( { duration: 0 } );
									// console.log( 'has a shadow' );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
									// console.log( 'no shadow' );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				}

				else if ( item === 'login_designer[field_border_color]' ) {

					customizer_range_option_display( 'login_designer[field_border]', 'login_designer[field_border_color]', '0' );

					wp.customize( 'login_designer[field_border]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate( { duration: 0 } );
									// console.log( 'border' );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
									// console.log( 'no border' );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[button_border_color]' ) {

					customizer_range_option_display( 'login_designer[button_border]', 'login_designer[button_border_color]', '0' );

					wp.customize( 'login_designer[button_border]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate( { duration: 0 } );
									// console.log( 'border' );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
									// console.log( 'no border' );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[button_shadow_opacity]' ) {

					customizer_range_option_display( 'login_designer[button_shadow]', 'login_designer[button_shadow_opacity]', '0' );

					wp.customize( 'login_designer[button_shadow]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate( { duration: 0 } );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer[checkbox_border_color]' ) {

					customizer_range_option_display( 'login_designer[checkbox_border]', 'login_designer[checkbox_border_color]', '0' );

					wp.customize( 'login_designer[checkbox_border]', function( setting ) {
						wp.customize.control( item, function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate( { duration: 0 } );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				}  else {
					wp.customize.control( item ).activate( { duration: 0 } );
				}
			} else {
				wp.customize.control( item ).deactivate( { duration: 0 } );
			}
		});
	}

	//  Customizer Previewer
	api.LoginDesignerCustomizerPreviewer = {

		init: function () {

			var
				self = this,
				active_state,
				logo_event  		= 'login-designer-edit-logo',
				form_event  		= 'login-designer-edit-loginform',
				fields_event 		= 'login-designer-edit-loginform-fields',
				username_label_event 	= 'login-designer-edit-loginform-labels-username',
				password_label_event 	= 'login-designer-edit-loginform-labels-password',
				button_event 		= 'login-designer-edit-button',
				background_event 	= 'login-designer-edit-background',
				remember_event 		= 'login-designer-edit-remember-me',
				checkbox_event 		= 'login-designer-edit-remember-me-checkbox',
				below_event 		= 'login-designer-edit-below';

			// Function used for contextually aware Customizer options.
			function bind_control_visibility_event( event, active_controls, focus_control ) {

				api.LoginDesignerCustomizerPreviewer.preview.bind( event, function() {
					// Visibility.
					active_control( active_controls );

					// Focus.
					wp.customize.control( focus_control ).focus();
				} );
			}

			// Function used for contextually aware Customizer options.
			function bind_logo_control_visibility_event( event, active_controls, focus_control ) {

				api.LoginDesignerCustomizerPreviewer.preview.bind( event, function() {

					// Visibility.
					active_control( active_controls );

					// Focus.
					wp.customize.control( focus_control ).focus();

					// Only show the width if there is a logo uploaded.
					if ( true === wp.customize.control( 'login_designer[disable_logo]' ).setting.get() ) {
						wp.customize.control( 'login_designer[logo_height]' ).deactivate( { duration: 0 } );
						wp.customize.control( 'login_designer[logo_width]' ).deactivate( { duration: 0 } );
					}

				} );
			}

			// Only show visible options when necessary.
			bind_logo_control_visibility_event( logo_event, all_controls.logo, 'login_designer[logo]' );
			bind_control_visibility_event( form_event, all_controls.form, 'login_designer[form_title]' );
			bind_control_visibility_event( fields_event, all_controls.fields, 'login_designer[form_title]' );
			bind_control_visibility_event( username_label_event, all_controls.labels, 'login_designer[username_label]' );
			bind_control_visibility_event( password_label_event, all_controls.labels, 'login_designer[password_label]' );
			bind_control_visibility_event( button_event, all_controls.button, 'login_designer[button_title]' );
			bind_control_visibility_event( background_event, all_controls.background, 'login_designer[bg_title]' );
			bind_control_visibility_event( remember_event, all_controls.remember, 'login_designer[remember_title]' );
			bind_control_visibility_event( checkbox_event, all_controls.checkbox, 'login_designer[checkbox_title]' );
			bind_control_visibility_event( below_event, all_controls.below, 'login_designer[below_title]' );

			// Open settings panel when the settings icon is clicked.
			this.preview.bind( 'login-designer-edit-settings', function() {
				var section = wp.customize.section( 'login_designer__section--settings' );
				if ( ! section.expanded() ) {
					section.expand( { duration: 0 } );
				}
			} );

			// Open settings panel when the settings icon is clicked.
			this.preview.bind( 'login-designer-edit-template', function() {
				var section = wp.customize.section( 'login_designer__section--templates' );
				if ( ! section.expanded() ) {
					section.expand( { duration: 0 } );
				}
			} );

			// Open settings panel when the Login Designer badge is clicked.
			this.preview.bind( 'login-designer-edit-branding', function() {
				var section = wp.customize.section( 'login_designer__section--settings' );
				if ( ! section.expanded() ) {
					section.expand( { duration: 0 } );
				}
			} );

			this.preview.bind( 'login-designer-edit-language', function(){
				var section = wp.customize.section( 'login_designer__section--translations' );
				if ( ! section.expanded() ) {
					section.expand( { duration: 0 } );
				}
			} );
		}
	};

	/**
	 * Capture the instance of the Preview since it is private.
	 */
	LoginDesignerOldPreviewer = api.Previewer;
	api.Previewer = LoginDesignerOldPreviewer.extend( {
		initialize: function( params, options ) {

			// Store a reference to the Previewer
			api.LoginDesignerCustomizerPreviewer.preview = this;

			// Call the old Previewer's initialize function
			LoginDesignerOldPreviewer.prototype.initialize.call( this, params, options );
		}
	} );

	$( function() {
		// Initialize our Previewer
		api.LoginDesignerCustomizerPreviewer.init();
	} );

} )( wp, jQuery );
