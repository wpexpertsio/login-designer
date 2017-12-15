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

		// wp.customize( 'login_designer[template]', function( setting ) {

		// 	// Hide the form width option if "2" is selected.
		// 	wp.customize.control( 'login_designer[form_width]', function( control ) {
		// 		if ( '01' === setting.get() ) {
		// 			wp.customize.control( 'login_designer[form_width]' ).deactivate( { duration: 0 } );
		// 		} else {
		// 			wp.customize.control( 'login_designer[form_width]' ).activate( { duration: 0 } );
		// 		}
		// 	});

		// 	// Hide the form background color option if "2" or "3" is selected.
		// 	wp.customize.control( 'login_designer[form_bg]', function( control ) {
		// 		if ( '02' === setting.get() || '03' === setting.get()  ) {
		// 			wp.customize.control( 'login_designer[form_width]' ).deactivate( { duration: 0 } );
		// 		} else {
		// 			wp.customize.control( 'login_designer[form_width]' ).activate( { duration: 0 } );
		// 		}
		// 	});
		// });

		function template_reset_to_defaults() {

			// console.log( 'Defaults Reset' );

			// $( '#customize-control-login_designer-bg_image .remove-button' ).click();
			// $( '#customize-control-login_designer-logo .remove-button' ).click();

			for ( var key in login_designer_controls.template_defaults ) {

				var control 	= key;
				var value	= login_designer_controls.template_defaults[key];

				wp.customize( 'login_designer[' + control + ']' ).set( value );

			}
		}

		function template_set_defaults( template_defaults ) {

			// Now apply the template's custom style.
			for ( var key in template_defaults ) {

				var control 	= key;
				var value	= template_defaults[key];

				wp.customize( 'login_designer[' + control + ']' ).set( value );

			}
		}

		// Modify the background color based on the gallery image selected.
		wp.customize( 'login_designer[template]', function( value ) {

			value.bind( function( to ) {

				template_reset_to_defaults();

				if ( to === 'default' ) {
					template_set_defaults( login_designer_controls.template_defaults );
				} else if ( to === '01' ) {
					template_set_defaults( login_designer_controls.template_defaults_01 );
				} else if ( to === '02' ) {
					template_set_defaults( login_designer_controls.template_defaults_02 );
				} else if ( to === '03' ) {
					template_set_defaults( login_designer_controls.template_defaults_03 );
				} else if ( to === '04' ) {
					template_set_defaults( login_designer_controls.template_defaults_04 );
				} else if ( to === '05' ) {
					template_set_defaults( login_designer_controls.template_defaults_05 );
				} else if ( to === '06' ) {
					template_set_defaults( login_designer_controls.template_defaults_06 );
				} else if ( to === '07' ) {
					template_set_defaults( login_designer_controls.template_defaults_07 );
				} else if ( to === '08' ) {
					template_set_defaults( login_designer_controls.template_defaults_08 );
				} else if ( to === '09' ) {
					template_set_defaults( login_designer_controls.template_defaults_09 );
				} else if ( to === '10' ) {
					template_set_defaults( login_designer_controls.template_defaults_10 );
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
					color = '#ed4844';
				} else if ( to === 'bg_10' ) {
					color = '#e3ebee';
				} else {
					color = '#f1f1f1';
				}

				// If we have a custom background color, let's put it back to default.
				wp.customize( 'login_designer[bg_color]' ).set( color );
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
	} );
} )( jQuery );
