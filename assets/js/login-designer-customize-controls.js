/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

( function( $ ) {

	// Extends our custom "upgrade" section.
	wp.customize.sectionConstructor['upgrade'] = wp.customize.Section.extend( {

		// No events for this type of section.
		attachEvents: function () {},

		// Always make the section active.
		isContextuallyActive: function () {
			return true;
		}
	} );

	wp.customize.bind( 'ready', function() {

		// We need to modify the Customizer's close link, if the user manually uploaded the plugin.
		$( '#customize-header-actions .customize-controls-close[href*="update.php?action=upload-plugin"]' ).each( function() {

			var old_url = $(this).attr( 'href' );
			var new_url = old_url.substring( 0, old_url.indexOf( 'update.php?action=upload-plugin' ) );

			$(this).attr( 'href', new_url );

		});

		// Detect when the Login Designer panel is expanded (or closed) so we can preview the login form easily.
		wp.customize.panel( 'login_designer', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				if ( isExpanding ) {

					// Only send the previewer to the login designer page, if we're not already on it.
					var current_url = wp.customize.previewer.previewUrl();
					var current_url = current_url.includes( login_designer_controls.login_designer_page );

					if ( ! current_url ) {
						wp.customize.previewer.send( 'login-designer-url-switcher', { expanded: isExpanding } );
					}

				} else {
					// Head back to the home page, if we leave the Login Designer panel.
					wp.customize.previewer.send( 'login-designer-back-to-home', { home_url: wp.customize.settings.url.home } );
					url = wp.customize.settings.url.home;
                			// Debug: console.log( url );
				}
			} );
		} );

		// Detect when the styles section is expanded (or closed) so we can show the Reset button accordingly.
		wp.customize.section( 'login_designer__section--styles', function( section ) {
			section.expanded.bind( function( isExpanding ) {
				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				if ( isExpanding ) {
					$( '#customize-header-actions' ).addClass( 'style-editor-open' );
				} else {
					$( '#customize-header-actions' ).removeClass( 'style-editor-open' );
				}
			} );
		} );

		// Detect when the templates section is expanded (or closed) so we can hide the templates shortcut when it's open.
		wp.customize.section( 'login_designer__section--templates', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				if ( isExpanding ) {
					wp.customize.previewer.send( 'login-designer-template-switcher', { expanded: isExpanding } );
				} else {
					wp.customize.previewer.send( 'login-designer-template-switcher', { expanded: false } );
				}
			} );
		} );

		// Detect when the templates section is expanded (or closed) so we can hide the templates shortcut when it's open.
		wp.customize.section( 'login_designer__section--settings', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				if ( isExpanding ) {
					wp.customize.previewer.send( 'login-designer-settings', { expanded: isExpanding } );
				} else {
					wp.customize.previewer.send( 'login-designer-settings', { expanded: false } );
				}
			} );
		} );

		/**
		 * Function to hide/show Customizer options, based on another control.
		 *
		 * Parent option, Affected Control, Value which affects the control.
		 */
		function customizer_image_option_display( parent_setting, affected_control ) {
			wp.customize( parent_setting, function( setting ) {
				wp.customize.control( affected_control, function( control ) {
					var visibility = function() {
						if ( setting.get() && 'none' !== setting.get() ) {
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
							control.container.slideUp( 180 );
						}  else {
							control.container.slideDown( 180 );
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
						if ( value < setting.get() ) {
							control.container.slideDown( 180 );
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
							control.container.slideDown( 180 );
						} else {
							control.container.slideUp( 180 );
						}
					};

					visibility();
					setting.bind( visibility );
				});
			});
		}

		// Only show the border color style option, if the border is greater than zero.
		customizer_range_option_display( 'login_designer[field_border]', 'login_designer[field_border_color]', '0' );
		customizer_range_option_display( 'login_designer[button_border]', 'login_designer[button_border_color]', '0' );

		// Only show the shadow opacity style option, if the shadow is greater than zero.
		customizer_range_option_display( 'login_designer[form_shadow]', 'login_designer[form_shadow_opacity]', '0' );

		// Only show the shadow opacity and inset style options, if the shadow is greater than zero.
		customizer_range_option_display( 'login_designer[field_shadow]', 'login_designer[field_shadow_opacity]', '0' );
		customizer_range_option_display( 'login_designer[field_shadow]', 'login_designer[field_shadow_inset]', '0' );

		// Only show the background optios, if there is a background image uploaded.
		customizer_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_repeat]' );
		customizer_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_size]' );
		customizer_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_attach]' );
		customizer_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_position]' );

		// Only show the gallery if there is a gallery background image selected and it's not set to "none".
		customizer_image_option_display( 'login_designer[bg_image_gallery]', 'login_designer[bg_repeat]' );
		customizer_image_option_display( 'login_designer[bg_image_gallery]', 'login_designer[bg_size]' );
		customizer_image_option_display( 'login_designer[bg_image_gallery]', 'login_designer[bg_attach]' );
		customizer_image_option_display( 'login_designer[bg_image_gallery]', 'login_designer[bg_position]' );

		// Only show the gallery if there is no custom background image uploaded.
		customizer_no_image_option_display( 'login_designer[bg_image]', 'login_designer[bg_image_gallery]' );

		// Only show the login logo bits, if the login logo is not hidden.
		customizer_checkbox_option_display( 'login_designer[disable_logo]', 'login_designer[logo]', false );
		customizer_checkbox_option_display( 'login_designer[disable_logo]', 'login_designer[logo_title]', false );
		customizer_checkbox_option_display( 'login_designer[disable_logo]', 'login_designer_admin[logo_url]', false );

		// Only show the Twitter profile option, if social sharing is enabled.
		customizer_image_option_display( 'login_designer[logo]', 'login_designer[logo_margin_bottom]' );










		// Hide the form width option if Template 2 is selected.
		wp.customize( 'login_designer[template]', function( setting ) {
			wp.customize.control( 'login_designer[form_width]', function( control ) {
				var visibility = function() {
					if ( '01' === setting.get() ) {
						control.container.slideUp( 180 );
					} else {
						control.container.slideDown( 180 );
					}
				};

				visibility();
				setting.bind( visibility );
			});
		});

		// Modify the background color based on the gallery image selected.
		wp.customize( 'login_designer[template]', function( value ) {

			value.bind( function( to ) {

				if ( to === 'default' ) {

					wp.customize( 'login_designer[bg_color]' ).set( '#f1f1f1' );
					wp.customize( 'login_designer[bg_image_gallery]' ).set( 'none' );

					wp.customize( 'login_designer[form_bg]' ).set( '#fff' );
					wp.customize( 'login_designer[form_width]' ).set( '320' );
					wp.customize( 'login_designer[form_shadow]' ).set( '3' );
					wp.customize( 'login_designer[form_side_padding]' ).set( '24' );
					wp.customize( 'login_designer[form_vertical_padding]' ).set( '26' );

					wp.customize( 'login_designer[field_bg]' ).set( '#ffffff' );
					wp.customize( 'login_designer[field_radius]' ).set( '0' );
					wp.customize( 'login_designer[field_side_padding]' ).set( '12' );
					wp.customize( 'login_designer[field_padding_top]' ).set( '3' );
					wp.customize( 'login_designer[field_padding_bottom]' ).set( '3' );
					wp.customize( 'login_designer[field_border]' ).set( '1' );
					wp.customize( 'login_designer[field_shadow]' ).set( '2' );
					wp.customize( 'login_designer[field_shadow_inset]' ).set( true );
					wp.customize( 'login_designer[field_color]' ).set( '#32373c' );
					wp.customize( 'login_designer[field_font]' ).set( 'default' );
					wp.customize( 'login_designer[field_font_size]' ).set( '24' );

					wp.customize( 'login_designer[disable_logo]' ).set( false );

					wp.customize( 'login_designer[username_label]' ).set( 'Username or Email Address' );
					wp.customize( 'login_designer[label_font]' ).set( 'default' );
					wp.customize( 'login_designer[label_font_size]' ).set( '14' );
					wp.customize( 'login_designer[label_color]' ).set( '#72777c' );
					wp.customize( 'login_designer[label_position]' ).set( '2' );

				} else if ( to === '01' ) {

					wp.customize( 'login_designer[bg_color]' ).set( '#f1f1f1' );
					wp.customize( 'login_designer[bg_image_gallery]' ).set( 'none' );

					wp.customize( 'login_designer[form_bg]' ).set( '#fff' );
					wp.customize( 'login_designer[form_width]' ).set( '' );
					wp.customize( 'login_designer[form_shadow]' ).set( '0' );
					wp.customize( 'login_designer[form_side_padding]' ).set( '42' );
					wp.customize( 'login_designer[form_vertical_padding]' ).set( '26' );

					wp.customize( 'login_designer[field_bg]' ).set( '#ffffff' );
					wp.customize( 'login_designer[field_radius]' ).set( '3' );
					wp.customize( 'login_designer[field_side_padding]' ).set( '12' );
					wp.customize( 'login_designer[field_padding_top]' ).set( '6' );
					wp.customize( 'login_designer[field_padding_bottom]' ).set( '6' );
					wp.customize( 'login_designer[field_border]' ).set( '2' );
					wp.customize( 'login_designer[field_shadow]' ).set( '0' );
					wp.customize( 'login_designer[field_shadow_inset]' ).set( false );
					wp.customize( 'login_designer[field_color]' ).set( '#32373c' );
					wp.customize( 'login_designer[field_font]' ).set( 'default' );
					wp.customize( 'login_designer[field_font_size]' ).set( '24' );

					wp.customize( 'login_designer[disable_logo]' ).set( false );

					wp.customize( 'login_designer[username_label]' ).set( 'Username or Email Address' );
					wp.customize( 'login_designer[label_font]' ).set( 'default' );
					wp.customize( 'login_designer[label_font_size]' ).set( '14' );
					wp.customize( 'login_designer[label_color]' ).set( '#72777c' );
					wp.customize( 'login_designer[label_position]' ).set( '2' );

				} else if ( to === '02' ) {

					wp.customize( 'login_designer[bg_color]' ).set( '#000000' );
					wp.customize( 'login_designer[bg_image_gallery]' ).set( 'none' );

					wp.customize( 'login_designer[form_bg]' ).set( '#000000' );
					wp.customize( 'login_designer[form_width]' ).set( '320' );
					wp.customize( 'login_designer[form_shadow]' ).set( '0' );
					wp.customize( 'login_designer[form_side_padding]' ).set( '10' );
					wp.customize( 'login_designer[form_vertical_padding]' ).set( '0' );

					wp.customize( 'login_designer[field_bg]' ).set( '#191919' );
					wp.customize( 'login_designer[field_radius]' ).set( '5' );
					wp.customize( 'login_designer[field_side_padding]' ).set( '13' );
					wp.customize( 'login_designer[field_padding_top]' ).set( '9' );
					wp.customize( 'login_designer[field_padding_bottom]' ).set( '9' );
					wp.customize( 'login_designer[field_border]' ).set( '0' );
					wp.customize( 'login_designer[field_shadow]' ).set( '0' );
					wp.customize( 'login_designer[field_shadow_inset]' ).set( false );
					wp.customize( 'login_designer[field_color]' ).set( '#606060' );
					wp.customize( 'login_designer[field_font]' ).set( 'Rubik' );
					wp.customize( 'login_designer[field_font_size]' ).set( '18' );

					wp.customize( 'login_designer[disable_logo]' ).set( true );

					wp.customize( 'login_designer[username_label]' ).set( 'Username' );
					wp.customize( 'login_designer[label_font]' ).set( 'Rubik' );
					wp.customize( 'login_designer[label_font_size]' ).set( '14' );
					wp.customize( 'login_designer[label_color]' ).set( '#4f4f4f' );
					wp.customize( 'login_designer[label_position]' ).set( '5' );

				}

			} );
		} );

















		// Modify the background color based on the gallery image selected.
		wp.customize( 'login_designer[bg_image_gallery]', function( value ) {

			value.bind( function( to ) {

				var keys = [];
				var values = [];

				if ( login_designer_script.extension_colors ) {
					keys = Object.keys( login_designer_script.extension_colors );
					values = Object.values( login_designer_script.extension_colors );
				}

				// console.log( 'keys:' + keys );

				if ( keys.includes( to ) ) {

					// If we have a custom background color, let's put it back to default.
					wp.customize( 'login_designer[bg_color]' ).set( color );

					// console.log( 'keys:');

				}


				// 	if ( to.indexOf( 'seasonal' ) >= 0 ) {

				// 		url = login_designer_script.seasonal_plugin_url;

				// 	} else {
				// 		// Remove hyphen from value.
				// 		bg_collection = to.replace(/-|\s/g,"");

				// 		// Remove numbers from value.
				// 		bg_collection = bg_collection.replace(/[0-9]/g, '');

				// 		// Generate the dynamic URL based on the value of the option selected.
				// 		url = login_designer_script.plugins_url + '/login-designer-' + bg_collection + '-backgrounds/assets/images/' ;
				// 	}

				// }

				if ( to === 'bg_01' ) {
					color = '#e3ebee';
				} else if ( to === 'bg_02' ) {
					color = '#d0f1ec';
				} else if ( to === 'bg_03' ) {
					color = '#cccfd4';
				} else if ( to === 'bg_04' ) {
					color = '#d5aabb';
				} else if ( to === 'bg_05' ) {
					color = '#141611';
				} else if ( to === 'bg_06' ) {
					color = '#151515';
				} else if ( to === 'bg_07' ) {
					color = '#d0e4ec';
				} else if ( to === 'bg_08' ) {
					color = '#4b2d3f';
				} else if ( to === 'bg_09' ) {
					color = '#ed4844';
				} else if ( to === 'bg_10' ) {
					color = '#e3ebee';
				} else if ( to === login_designer_controls.seasonal_option_01 ) {
					color = login_designer_controls.seasonal_bg_color_01;
				} else if ( to === login_designer_controls.seasonal_option_02 ) {
					color = login_designer_controls.seasonal_bg_color_02;
				} else if ( to === login_designer_controls.seasonal_option_03 ) {
					color = login_designer_controls.seasonal_bg_color_03;
				} else if ( to === login_designer_controls.seasonal_option_04 ) {
					color = login_designer_controls.seasonal_bg_color_04;
				} else if ( to === login_designer_controls.seasonal_option_05 ) {
					color = login_designer_controls.seasonal_bg_color_05;
				} else {
					color = '#f1f1f1';
				}

				// If we have a custom background color, let's put it back to default.
				wp.customize( 'login_designer[bg_color]' ).set( color );

				// console.log( login_designer_controls.extension_bg_colors );

				// console.log( to );
			} );
		} );

		// Modify the background color based on the gallery image selected.
		wp.customize( 'login_designer[disable_logo]', function( value ) {

			value.bind( function( to ) {

				if ( to === true ) {
					wp.customize( 'login_designer[logo_margin_bottom]' ).set( 25 );
				}
			} );
		} );
	} );
} )( jQuery );
