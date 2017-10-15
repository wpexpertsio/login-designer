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

		control_visibility( section, 'activate' );
	}

	function control_visibility( controls, action ) {

		controls.forEach( function( item, index, array ) {

			if ( action == 'activate' ) {
				wp.customize.control( item ).activate();
			} else {
				wp.customize.control( item ).deactivate();
			}

			if ( controls[0] ) {
				wp.customize.control( item ).container.addClass( 'is-active' );
			}

			// console.log(item, index);
		});
	}

	// Customizer Previewer
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
