/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

( function( $ ) {
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
					var current_url = current_url.includes( login_designer_script.login_designer_page );

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

		// Detect when the Style Editor is expanded (or closed) so we can show the Reset button accordingly.
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

		// Only show the Twitter profile option, if social sharing is enabled.
		customizer_image_option_display( 'login_designer[logo]', 'login_designer[logo_margin_bottom]' );

		// Only show the border color style option, if the border is greater than zero.
		customizer_range_option_display( 'login_designer[field_border]', 'login_designer[field_border_color]', '0' );

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

		// Modify the background color based on the gallery image selected.
		wp.customize( 'login_designer[bg_image_gallery]', function( value ) {

			value.bind( function( to ) {

				if ( '01' === to ) {
					color = '#616264';
				} else if ( to === '02' ) {
					color = '#d0f1ec';
				} else if ( to === '03' ) {
					color = '#cccfd4';
				} else if ( to === '04' ) {
					color = '#d5aabb';
				} else if ( to === '05' ) {
					color = '#141611';
				} else if ( to === '06' ) {
					color = '#151515';
				} else if ( to === '07' ) {
					color = '#d0e4ec';
				} else if ( to === '08' ) {
					color = '#4b2d3f';
				} else if ( to === '09' ) {
					color = '#ed4844';
				} else if ( to === 'christmas-01' ) {
					color = '#dfe0e2'; // Seasonal #1
				} else if ( to === 'christmas-02' ) {
					color = '#131522'; // Seasonal #2
				} else if ( to === 'christmas-03' ) {
					color = '#000c1a'; // Seasonal #3
				} else if ( to === 'christmas-04' ) {
					color = '#1f2214'; // Seasonal #4
				} else if ( to === 'christmas-05' ) {
					color = '#dadad8'; // Seasonal #5
				} else {
					color = '#f1f1f1';
				}

				// If we have a custom background color, let's put it back to default.
				wp.customize( 'login_designer[bg_color]' ).set( color );
			} );
		} );
	} );
} )( jQuery );
