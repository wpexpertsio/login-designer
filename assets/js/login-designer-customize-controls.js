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
						} else if ( 'none' === setting.get() ) {
							control.container.slideUp( 180 );
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
		 * Function to hide/show Customizer options, based on another control.
		 *
		 * Parent option, Affected Control, Value which affects the control.
		 */
		function customizer_gallery_option_display( parent_setting, affected_control ) {
			wp.customize( parent_setting, function( setting ) {
				wp.customize.control( affected_control, function( control ) {
					var visibility = function() {

						console.log( setting.get() );

						if (// setting.get() ||
							'none' === setting.get() ||
							login_designer_script.plugin_url + '01.jpg' === setting.get() ||
							login_designer_script.plugin_url + '02.jpg' === setting.get() ||
							login_designer_script.plugin_url + '03.jpg' === setting.get() ||
							login_designer_script.plugin_url + '04.jpg' === setting.get() ||
							login_designer_script.plugin_url + '05.jpg' === setting.get() ||
							login_designer_script.plugin_url + '06.jpg' === setting.get() ||
							login_designer_script.plugin_url + '07.jpg' === setting.get() ||
							login_designer_script.plugin_url + '08.jpg' === setting.get() ||
							login_designer_script.plugin_url + '09.jpg' === setting.get() ||
							login_designer_script.plugin_url + '10.jpg' === setting.get() ||
							login_designer_script.plugin_url + '11.jpg' === setting.get() ||
							login_designer_script.plugin_url + '12.jpg' === setting.get() ||
							login_designer_script.plugin_url + '13.jpg' === setting.get() ||
							login_designer_script.plugin_url + '14.jpg' === setting.get() ||
							login_designer_script.plugin_url + '15.jpg' === setting.get() ) {
						} else {
							control.container.slideUp( 180 );
							// control.container.slideDown( 180 );
						}


						// console.log( wp.customize( 'login_designer_bg_image' ).get() );
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

		customizer_no_image_option_display( 'login_designer_bg_image', 'login_designer_bg_image_gallery' );

		// Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.panel( 'login_designer', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'login-designer-url-switcher', { expanded: isExpanding });

			} );
		} );

		// Add a body class based on the current template.
		// wp.customize( 'login_designer__template-selector', function( value ) {
		// 	value.bind( function( to ) {

		// 		if ( '01' === to ) {
		// 			color = '#00F';
		// 		} else if ( to === '02' ) {
		// 			color = '#F00';
		// 		} else {
		// 			color = '#f1f1f1';
		// 		}

		// 		// If we have a custom background color, let's put it back to default.
		// 		// @todo In the future, maybe we'll make this color change based on the template's default background color.
		// 		wp.customize( 'login_designer_bg_color' ).set( color );
		// 	} );
		// } );


		// Only show the color hue control when there's a custom color scheme.
		// wp.customize( 'login_designer_bg_image', function( setting ) {
		// 	wp.customize.control( 'login_designer_bg_image_gallery', function( control ) {
		// 		var visibility = function() {
		// 			if ( 'none' === setting.get() ) {
		// 				control.container.slideDown( 180 );
		// 				console.log( 'sliding down' );
		// 			}
		// 		};

		// 		visibility();
		// 		setting.bind( visibility );
		// 	});
		// });


		// wp.customize( 'login_designer_bg_image', function( setting ) {
		// 	wp.customize.control( 'login_designer_bg_image_gallery', function( control ) {
		// 		var visibility = function() {

		// 			if (// setting.get() ||
		// 				'none' === setting.get() ||
		// 				login_designer_script.plugin_url + '01.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '02.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '03.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '04.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '05.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '06.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '07.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '08.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '09.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '10.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '11.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '12.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '13.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '14.jpg' === setting.get() ||
		// 				login_designer_script.plugin_url + '15.jpg' === setting.get() ) {
		// 			} else {
		// 				wp.customize( 'login_designer_bg_image_gallery' ).set('');
		// 				console.log( 'has a gallery image but we removed it' );
		// 			}


		// 		};

		// 		visibility();
		// 		setting.bind( visibility );
		// 	});
		// });

		// wp.customize( 'login_designer_bg_image_gallery', function( value ) {
		// 	value.bind( function( to ) {

		// 		if ( 'none' === to ) {
		// 			wp.customize( 'login_designer_bg_image' ).set( 'none' );
		// 		} else {
		// 			wp.customize( 'login_designer_bg_image' ).set( login_designer_script.plugin_url + to + '.jpg' );
		// 		}

		// 		console.log( wp.customize( 'login_designer_bg_image' ).get() );
		// 	} );
		// } );
	});
})( jQuery );
