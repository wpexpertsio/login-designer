/**
 * Customizer Events Communicator.
 */
( function ( exports, $ ) {
	"use strict";

	var api = wp.customize, OldPreviewer;

	var all_controls = {
		'logo' : [
			'login_designer_title_logo',
			'login_designer_custom_logo',
			'login_designer_custom_logo_margin_bottom'
		],
		'form' : [
			'login_designer_title_form',
			'login_designer_form_width',
			'login_designer_form_border_radius',,
			'login_designer_form_background_color',
			'login_designer_form_padding_top_bottom',
			'login_designer_form_padding_side',
			'login_designer_form_box_shadow',
			'login_designer_form_box_shadow_opacity',
		],
		'fields' : [
			'login_designer_title_form_fields',
			'login_designer_form_field_background',
			'login_designer_form_field_border_size',
			'login_designer_form_field_border_color',
			'login_designer_form_field_side_padding',
			'login_designer_form_field_box_shadow',
			'login_designer_form_field_box_shadow_opacity',
			'login_designer_form_field_box_shadow_inset',
			'login_designer_title_form_field_text',
			'login_designer_form_field_font',
			'login_designer_form_field_text_size',
			'login_designer_form_field_text_color',
		],
		'labels' : [
			'login_designer_title_form_labels',
			'login_designer_form_label_font',
			'login_designer_form_label_size',
			'login_designer_form_label_color',
			'login_designer_form_label_username_text',
			'login_designer_form_label_password_text',
		],
		'button' : [
			'login_designer_title_button',
		],
		'background' : [
			'login_designer_title_bg',
			'login_designer_bg_image',
			'login_designer_bg_color',
			'login_designer_bg_image_repeat',
			'login_designer_bg_image_size',
			'login_designer_bg_image_attach',
			'login_designer_bg_image_position',
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

		control_visibility( section, 'activate' );
	}

	function control_visibility( controls, action ) {

		controls.forEach( function( item, index, array ) {

			if ( action == 'activate' ) {

				// For this particular control, let's check to see if corresponding options are visible.
				// We only want to show relevant options based on the user's contextual design decisions.
				if ( item === 'login_designer_custom_logo_margin_bottom' ) {

					wp.customize( 'login_designer_custom_logo', function( setting ) {
						wp.customize.control( 'login_designer_custom_logo_margin_bottom', function( control ) {
							var visibility = function() {

								if ( setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				// BG
				} else if ( item === 'login_designer_bg_image_repeat' ) {

					wp.customize( 'login_designer_bg_image', function( setting ) {
						wp.customize.control( 'login_designer_bg_image_repeat', function( control ) {
							var visibility = function() {

								if ( setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer_bg_image_size' ) {

					wp.customize( 'login_designer_bg_image', function( setting ) {
						wp.customize.control( 'login_designer_bg_image_size', function( control ) {
							var visibility = function() {

								if ( setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer_bg_image_attach' ) {

					wp.customize( 'login_designer_bg_image', function( setting ) {
						wp.customize.control( 'login_designer_bg_image_size', function( control ) {
							var visibility = function() {

								if ( setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer_bg_image_position' ) {

					wp.customize( 'login_designer_bg_image', function( setting ) {
						wp.customize.control( 'login_designer_bg_image_position', function( control ) {
							var visibility = function() {

								if ( setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer_form_box_shadow_opacity' ) {

					wp.customize( 'login_designer_form_box_shadow', function( setting ) {
						wp.customize.control( 'login_designer_form_box_shadow_opacity', function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer_form_field_box_shadow_opacity' ) {

					wp.customize( 'login_designer_form_field_box_shadow', function( setting ) {
						wp.customize.control( 'login_designer_form_field_box_shadow_opacity', function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else if ( item === 'login_designer_form_field_box_shadow_inset' ) {

					wp.customize( 'login_designer_form_field_box_shadow', function( setting ) {
						wp.customize.control( 'login_designer_form_field_box_shadow_inset', function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
									console.log( 'has a shadow' );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
									console.log( 'no shadow' );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				}

				else if ( item === 'login_designer_form_field_border_color' ) {

					wp.customize( 'login_designer_form_field_border_size', function( setting ) {
						wp.customize.control( 'login_designer_form_field_border_color', function( control ) {
							var visibility = function() {

								if ( '0' < setting.get() ) {
									// If there is a custom logo uploaded, let's show the bottom positioning option.
									wp.customize.control( item ).activate();
									console.log( 'border' );
								} else {
									// If not, let's quickly hide it.
									control.container.slideUp( 0 );
									console.log( 'no border' );
								}
							};

							visibility();
							setting.bind( visibility );
						});
					});

				} else {
					// Activate all others.
					wp.customize.control( item ).activate();
				}

			} else {
				wp.customize.control( item ).deactivate();
			}

			if ( controls[0] ) {
				wp.customize.control( item ).container.addClass( 'is-active' );
			}
		});
	}

	//  Customizer Previewer
	api.myCustomizerPreviewer = {

		init: function () {

			// Store a reference to "this" in case callback functions need to reference it.
			var self = this;

			// Logo
			this.preview.bind( 'login-designer-edit-logo', function() {

				// Visibility.
				active_control( all_controls.logo );

				// Focus.
				wp.customize.control( 'login_designer_custom_logo' ).focus();

			} );

			this.preview.bind( 'login-designer-edit-loginform', function() {

				// Visibility.
				active_control( all_controls.form );

				// Focus.
				wp.customize.control( 'login_designer_form_background_color' ).focus();
			} );

			this.preview.bind( 'login-designer-edit-loginform-fields', function() {

				// Visibility.
				active_control( all_controls.fields );

				wp.customize.control( 'login_designer_title_form_fields' ).focus();
			} );

			this.preview.bind( 'login-designer-edit-loginform-labels-username', function() {

				// Visibility.
				active_control( all_controls.labels );

				wp.customize.control( 'login_designer_form_label_username_text' ).focus();
			} );

			this.preview.bind( 'login-designer-edit-loginform-labels-password', function() {

				// Visibility.
				active_control( all_controls.labels );

				wp.customize.control( 'login_designer_form_label_password_text' ).focus();
			} );

			this.preview.bind( 'login-designer-edit-button', function() {

				// Visibility.
				active_control( all_controls.button );

				wp.customize.control( 'login_designer_title_button' ).focus();
			} );

			this.preview.bind( 'login-designer-edit-background', function() {

				// Visibility.
				active_control( all_controls.background );

				wp.customize.control( 'login_designer_title_bg' ).focus();
			} );
		}
	};

	/**
	 * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0)
	 */
	OldPreviewer = api.Previewer;
	api.Previewer = OldPreviewer.extend( {
		initialize: function( params, options ) {
			// Store a reference to the Previewer
			api.myCustomizerPreviewer.preview = this;

			// Call the old Previewer's initialize function
			OldPreviewer.prototype.initialize.call( this, params, options );
		}
	} );

	$( function() {
		// Initialize our Previewer
		api.myCustomizerPreviewer.init();
	} );

} )( wp, jQuery );
