/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function() {
	wp.customize.bind( 'ready', function() {

		/**
		 * Function to hide/show Customizer options, based on another control.
		 *
		 * Parent option, Affected Control, Value which affects the control.
		 */
		function customizer_image_option_display( parent_setting, affected_control ) {
			wp.customize( parent_setting, function( setting ) {
				wp.customize.control( affected_control, function( control ) {
					var visibility = function() {
						if ( setting.get() ) {
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
		customizer_image_option_display( 'login_designer_custom_logo', 'login_designer_custom_logo_margin_bottom' );

		// Only show the border color style option, if the border is greater than zero.
		customizer_range_option_display( 'login_designer_form_field_border_size', 'login_designer_form_field_border_color', '0' );

		// Only show the shadow opacity style option, if the shadow is greater than zero.
		customizer_range_option_display( 'login_designer_form_box_shadow', 'login_designer_form_box_shadow_opacity', '0' );

		// Only show the shadow opacity and inset style options, if the shadow is greater than zero.
		customizer_range_option_display( 'login_designer_form_field_box_shadow', 'login_designer_form_field_box_shadow_opacity', '0' );
		customizer_range_option_display( 'login_designer_form_field_box_shadow', 'login_designer_form_field_box_shadow_inset', '0' );

		// Only show the background optios, if there is a background image uploaded.
		customizer_image_option_display( 'login_designer_bg_image', 'login_designer_bg_image_repeat' );
		customizer_image_option_display( 'login_designer_bg_image', 'login_designer_bg_image_size' );
		customizer_image_option_display( 'login_designer_bg_image', 'login_designer_bg_image_attach' );
		customizer_image_option_display( 'login_designer_bg_image', 'login_designer_bg_image_position' );

		// Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.panel( 'login_designer', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'login-designer-url-switcher', { expanded: isExpanding });

			} );
		} );

		// Add a body class based on the current template.
		wp.customize( 'login_designer__template-selector', function( value ) {
			value.bind( function( to ) {

				if ( '01' === to ) {
					color = '#00F';
				} else if ( to === '02' ) {
					color = '#F00';
				} else {
					color = '#f1f1f1';
				}

				// If we have a custom background color, let's put it back to default.
				// @todo In the future, maybe we'll make this color change based on the template's default background color.
				wp.customize( 'login_designer_bg_color' ).set( color );
			} );
		} );

		wp.customize( 'login_designer_bg_image_gallery', function( value ) {
			value.bind( function( to ) {
				if ( 'none' === to ) {
					wp.customize( 'login_designer_bg_image' ).set( ' ' );
				} else {
					wp.customize( 'login_designer_bg_image' ).set( login_designer_script.plugin_url + '/' + to + '.jpg' );
				}
			} );
		} );

		// wp.customize( 'login_designer_bg_image', function( value ) {
		// 	value.bind( function( to ) {
		// 		if ( to ) {
		// 			wp.customize( 'login_designer_bg_image_gallery' ).set( '' );
		// 		}
		// 	} );
		// } );
	});
})( jQuery );
