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
					wp.customize.previewer.send( 'login-designer-templates', { expanded: isExpanding } );
				} else {
					wp.customize.previewer.send( 'login-designer-templates', { expanded: false } );
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

		function template_reset_to_defaults() {

			// console.log( 'Defaults Reset' );

			for ( var key in login_designer_controls.template_defaults ) {

				if ( key === 'logo' || key === 'logo_height' || key === 'logo_width' ) continue;

				var control 	= key;
				var value	= login_designer_controls.template_defaults[key];

				wp.customize( 'login_designer[' + control + ']' ).set( value );
			}
		}

		function template_set_defaults( template_defaults ) {

			// Now apply the template's custom style.
			for ( var key in template_defaults ) {

				if ( key === 'logo' || key === 'logo_height' || key === 'logo_width' ) continue;

				var control 	= key;
				var value	= template_defaults[key];

				wp.customize( 'login_designer[' + control + ']' ).set( value );

			}
		}

		function template_set_branding_defaults( template_defaults ) {

			// Now apply the template's custom style.
			for ( var key in template_defaults ) {

				if ( key === 'branding' ) continue;

				var control 	= key;
				var value	= template_defaults[key];

				wp.customize( 'login_designer_settings[' + control + ']' ).set( value );

			}
		}

		// Modify the background color based on the gallery image selected.
		wp.customize( 'login_designer[template]', function( value ) {

			value.bind( function( to ) {

				template_reset_to_defaults();

				if ( to === 'default' ) {
					template_set_defaults( login_designer_controls.template_defaults );
					template_set_branding_defaults( login_designer_controls.template_branding_defaults );
				} else if ( to === '01' ) {
					template_set_defaults( login_designer_controls.template_defaults_01 );
					template_set_branding_defaults( login_designer_controls.template_branding_defaults_01 );
				} else if ( to === '02' ) {
					template_set_defaults( login_designer_controls.template_defaults_02 );
					template_set_branding_defaults( login_designer_controls.template_branding_defaults_02 );
				} else if ( to === '03' ) {
					template_set_defaults( login_designer_controls.template_defaults_03 );
					template_set_branding_defaults( login_designer_controls.template_branding_defaults_03 );
				}
			} );
		} );

		// Modify the background color based on the gallery image selected.
		// @todo — Find a way where gallery extensions can filter this and add live previewing based on their colors (or use their own).
		wp.customize( 'login_designer[bg_image_gallery]', function( value ) {

			value.bind( function( to ) {

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
					color = '#ffffff';
				} else {
					color = '#f1f1f1';
				}

				// If we have a custom background color, let's put it back to default.
				wp.customize( 'login_designer[bg_color]' ).set( color );
			} );
		} );

		// Modify the branding text and icon colors, based on the gallery image selected.
		// @todo — Find a way where gallery extensions can filter this and add live previewing based on their colors (or use their own).
		wp.customize( 'login_designer[bg_image_gallery]', function( value ) {

			value.bind( function( to ) {

				if ( to === 'bg_01' ) {
					text = '#e98b62';
					icon = '#dd462c';
				} else if ( to === 'bg_02' ) {
					text = '#008c93';
					icon = '#008c93';
				} else if ( to === 'bg_03' ) {
					text = '#878787';
					icon = '#afafaf';
				} else if ( to === 'bg_04' ) {
					text = '#456099';
					icon = '#2c4081';
				} else if ( to === 'bg_05' ) {
					text = '#a38259';
					icon = '#ddba90';
				} else if ( to === 'bg_06' ) {
					text = '#ffffff';
					icon = '#ffffff';
				} else if ( to === 'bg_07' ) {
					text = '#c3d0dd';
					icon = '#c3d0dd';
				} else if ( to === 'bg_08' ) {
					text = '#3b2a3d';
					icon = '#3b2a3d';
				} else if ( to === 'bg_09' ) {
					text = '#1d3973';
					icon = '#1d3973';
				} else {
					text = '';
					icon = '';
				}

				// If we have a custom background color, let's put it back to default.
				wp.customize( 'login_designer_settings[branding_color]' ).set( text );
				wp.customize( 'login_designer_settings[branding_icon_color]' ).set( icon );
			} );
		} );

		wp.customize( 'login_designer[form_bg]', function( value ) {

			value.bind( function( to ) {
				// If we have a custom background color, let's turn off transparency.
				wp.customize( 'login_designer[form_bg_transparency]' ).set( false );
			} );
		} );

		wp.customize( 'login_designer[form_bg_transparency]', function( value ) {

			value.bind( function( to ) {
				// If we have a custom background color, let's turn off transparency.
				wp.customize( 'login_designer[form_shadow]' ).set( '0' );
			} );
		} );

		// Grab the logo sizes from the logo uploader event from the Customizer.
		wp.customize.previewer.bind( 'logo-sizes', function( data ) {

			var
			width,
			height;

			if ( data.height ) {
				height = parseInt( data.height / 2 );
				wp.customize( 'login_designer[logo_height]' ).set( height );
			}

			if ( data.width ) {
				width = parseInt( data.width / 2 );
				wp.customize( 'login_designer[logo_width]' ).set( width );
			}
		} );

		// Grab the logo sizes from the logo uploader event from the Customizer.
		wp.customize.previewer.bind( 'logo-sizes-fallback', function( data ) {

			var
			width,
			height;

			if ( data.height ) {
				height = data.height;
				wp.customize( 'login_designer[logo_height]' ).set( height );
			}

			if ( data.width ) {
				width = data.width;
				wp.customize( 'login_designer[logo_width]' ).set( width );
			}
		} );

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

		customizer_checkbox_option_display( 'login_designer_settings[branding]', 'login_designer_settings[branding_position]', true );
		customizer_checkbox_option_display( 'login_designer_settings[branding]', 'login_designer_settings[branding_color]', true );
		customizer_checkbox_option_display( 'login_designer_settings[branding]', 'login_designer_settings[branding_icon_color]', true );
		customizer_checkbox_option_display( 'login_designer[form_bg_transparency]', 'login_designer[form_bg]', false );

		customizer_checkbox_option_display( 'login_designer_google_recaptcha[enable_google_recaptcha]', 'login_designer_google_recaptcha[google_recaptcha_api_key]', true );
		customizer_checkbox_option_display( 'login_designer_google_recaptcha[enable_google_recaptcha]', 'login_designer_google_recaptcha[google_recaptcha_secrete_key]', true );
		customizer_checkbox_option_display( 'login_designer_google_recaptcha[enable_google_recaptcha]', 'login_designer_google_recaptcha[recaptcha_version]', true );

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

		customizer_select_option_display( 'login_designer[bg_size]', 'login_designer[bg_position]', 'cover' );

		wp.customize( 'login_designer[bg_repeat]', function( value ) {

			value.bind( function( to ) {

				if ( to !== 'no-repeat' ) {
					// If repeat is set to "Tile", set the background size to auto.
					wp.customize( 'login_designer[bg_size]' ).set( 'auto' );
				}
			} );
		} );

	} );
} )( jQuery );
