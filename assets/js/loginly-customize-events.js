/**
 * Customizer Communicator.
 */
( function ( exports, $ ) {
	"use strict";

	var api = wp.customize, OldPreviewer;

	// Custom Customizer Previewer class (attached to the Customize API).
	api.LoginlyCustomizerPreviewer = {

		init: function () {
			// Store a reference to "this" in case callback functions need to reference it.
			var self = this; 

			// Open the "Style Editor" panel.
			this.preview.bind( 'loginly__open-styles-section', function() {
				var loginly__styles = wp.customize.section( 'loginly__section--styles' );
				if ( ! loginly__styles.expanded() ) {
					loginly__styles.expand();
				}
			} );
		}
	};

	/**
	 * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0).
	 *
	 * @see https://github.com/WordPress/WordPress/blob/5cab03ab29e6172a8473eb601203c9d3d8802f17/wp-admin/js/customize-controls.js#L1013
	 */
	OldPreviewer = api.Previewer;
	api.Previewer = OldPreviewer.extend( {
		initialize: function( params, options ) {
			// Store a reference to the Previewer.
			api.LoginlyCustomizerPreviewer.preview = this;
			// Call the old Previewer's initialize function.
			OldPreviewer.prototype.initialize.call( this, params, options );
		}
	} );

	$( function() {
		// Initialize our Previewer.
		api.LoginlyCustomizerPreviewer.init();
	} );
} )( wp, jQuery );