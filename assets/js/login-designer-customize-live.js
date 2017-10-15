/**
 * Customizer Live Events.
 */
( function ( wp, $ ) {
	"use strict";

	// $( '#login-designer--username').hover(function() {
	// 	$( '#loginform').toggleClass( 'hide-customize-borders' );
	// });

	// $( '#login-designer--password').hover(function() {
	// 	$( '#loginform').toggleClass( 'hide-customize-borders' );
	// });

	// Bail if the Customizer isn't initialized
	if ( ! wp || ! wp.customize ) {
		return;
	}

	var api = wp.customize, OldPreview;

	// Custom Customizer Preview class (attached to the Customize API)
	api.myCustomizerPreview = {
		// Init
		init: function () {
			var self = this;

			// When the previewer is active, the "active" event has been triggered (on load)
			this.preview.bind( 'active', function() {

				var
				$body 		= $( 'body'),
				$document 	= $( document ),
				$logo	 	= $( '#login-designer-logo-h1'),
				$loginform	= $( '#loginform'),
				$loginform_text	= $( '#login-designer--username'),
				$loginform_pass	= $( '#login-designer--password');

				$logo.append( '<button class="login-designer-event-button customizer-event-overlay" data-customizer-event="login-designer-edit-logo"></button>' );

				// $loginform.append( '<div class="customizer__border customizer__border-btm"></div><div class="customizer__border customizer__border-top"></div><div class="customizer__border customizer__border-left"></div><div class="customizer__border customizer__border-right"></div>' );
				// $loginform.append( '<button class="login-designer-event-button customizer-editlayout-button" data-customizer-event="login-designer-edit-loginform">Edit</button>' );

				$loginform.append( '<span class="customize-partial--loginform customize-partial-edit-shortcut"><button class="login-designer-event-button customize-partial-edit-shortcut-button" data-customizer-event="login-designer-edit-loginform"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"></path></svg></button></span>' );

				$loginform_text.append( '<button class="login-designer-event-button customizer-event-overlay" data-customizer-event="login-designer-edit-loginform-fields"></button>' );
				$loginform_pass.append( '<button class="login-designer-event-button customizer-event-overlay" data-customizer-event="login-designer-edit-loginform-fields"></button>' );

				// Listen for events on the new previewer buttons
				$document.on( 'touch click', '.login-designer-event-button', function( e ) {
					var $this = $( this );

					// Send the event that we've specified on the HTML5 data attribute ('data-customizer-event') to the Customizer
					self.preview.send( $this.attr( 'data-customizer-event' ) );
				} );

			} );
		}
	};

	/**
	 * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0)
	 */
	OldPreview = api.Preview;
	api.Preview = OldPreview.extend( {
		initialize: function( params, options ) {
			// Store a reference to the Preview
			api.myCustomizerPreview.preview = this;

			// Call the old Preview's initialize function
			OldPreview.prototype.initialize.call( this, params, options );
		}
	} );

	$( function () {
		// Initialize our Preview
		api.myCustomizerPreview.init();
	} );

} )( window.wp, jQuery );
