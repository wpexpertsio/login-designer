/**
 * Customizer Events Communicator.
 */
( function ( exports, $ ) {
	"use strict";

	var api = wp.customize, OldPreviewer;

	// Custom Customizer Previewer class (attached to the Customize API)
	api.myCustomizerPreviewer = {

		init: function () {

			// Store a reference to "this" in case callback functions need to reference it.
			var self = this;

			// Logo
			this.preview.bind( 'loginly-edit-logo', function() {

				// Focus on this option.
				wp.customize.control( 'loginly_custom_logo' ).focus();

				// Activate these associated options.
				wp.customize.control( 'loginly_title_logo' ).activate();
				wp.customize.control( 'loginly_custom_logo' ).activate();
				wp.customize.control( 'loginly_custom_logo_margin_bottom' ).activate();

				// Deactivate all other options in the Style Editor.
				wp.customize.control( 'loginly_title_form' ).deactivate();
				wp.customize.control( 'loginly_form_width' ).deactivate();
				wp.customize.control( 'loginly_form_border_radius' ).deactivate();
				wp.customize.control( 'loginly_form_background_color' ).deactivate();
				wp.customize.control( 'loginly_form_padding_top_bottom' ).deactivate();
				wp.customize.control( 'loginly_form_padding_left_right' ).deactivate();

				// Fields
				wp.customize.control( 'loginly_title_form_fields' ).deactivate();
				wp.customize.control( 'loginly_form_field_background' ).deactivate();

			} );

			this.preview.bind( 'loginly-edit-loginform', function() {

				// Focus on this option.
				wp.customize.control( 'loginly_form_background_color' ).focus();

				// Activate these associated options.
				wp.customize.control( 'loginly_title_form' ).activate();
				wp.customize.control( 'loginly_form_width' ).activate();
				wp.customize.control( 'loginly_form_border_radius' ).activate();
				wp.customize.control( 'loginly_form_background_color' ).activate();
				wp.customize.control( 'loginly_form_padding_top_bottom' ).activate();
				wp.customize.control( 'loginly_form_padding_left_right' ).activate();

				// Deactivate all other options in the Style Editor.
				wp.customize.control( 'loginly_title_logo' ).deactivate();
				wp.customize.control( 'loginly_custom_logo' ).deactivate();
				wp.customize.control( 'loginly_custom_logo_margin_bottom' ).deactivate();

				// Fields
				wp.customize.control( 'loginly_title_form_fields' ).deactivate();
				wp.customize.control( 'loginly_form_field_background' ).deactivate();

			} );

			this.preview.bind( 'loginly-edit-loginform-fields', function() {

				wp.customize.control( 'loginly_title_form_fields' ).focus();

				// Focus on this option.
				wp.customize.control( 'loginly_title_form_fields' ).activate();
				wp.customize.control( 'loginly_form_field_background' ).activate();

				// Activate these associated options.
				wp.customize.control( 'loginly_title_form' ).deactivate();
				wp.customize.control( 'loginly_form_width' ).deactivate();
				wp.customize.control( 'loginly_form_border_radius' ).deactivate();
				wp.customize.control( 'loginly_form_background_color' ).deactivate();
				wp.customize.control( 'loginly_form_padding_top_bottom' ).deactivate();
				wp.customize.control( 'loginly_form_padding_left_right' ).deactivate();

				// Deactivate all other options in the Style Editor.
				wp.customize.control( 'loginly_title_logo' ).deactivate();
				wp.customize.control( 'loginly_custom_logo' ).deactivate();
				wp.customize.control( 'loginly_custom_logo_margin_bottom' ).deactivate();

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
