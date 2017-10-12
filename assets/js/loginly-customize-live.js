/**
 * Customizer Live Events.
 */
( function ( wp, $ ) {
	"use strict";

	$( '#loginly--username').hover(function() {
		$( '#loginform').toggleClass( 'hide-customize-borders' );
	});

	$( '#loginly--password').hover(function() {
		$( '#loginform').toggleClass( 'hide-customize-borders' );
	});

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
				$logo	 	= $( '#loginly-logo-h1'),
				$loginform	= $( '#loginform'),
				$loginform_text	= $( '#loginly--username'),
				$loginform_pass	= $( '#loginly--password');

				$logo.append( '<button class="loginly-event-button customizer-event-overlay" data-customizer-event="loginly-edit-logo"></button>' );

				$loginform.append( '<div class="customizer__border customizer__border-btm"></div><div class="customizer__border customizer__border-top"></div><div class="customizer__border customizer__border-left"></div><div class="customizer__border customizer__border-right"></div>' );
				$loginform.append( '<button class="loginly-event-button customizer-editlayout-button" data-customizer-event="loginly-edit-loginform">Edit</button>' );

				$loginform_text.append( '<button class="loginly-event-button customizer-event-overlay" data-customizer-event="loginly-edit-loginform-fields"></button>' );
				$loginform_pass.append( '<button class="loginly-event-button customizer-event-overlay" data-customizer-event="loginly-edit-loginform-fields"></button>' );

				// Listen for events on the new previewer buttons
				$document.on( 'touch click', '.loginly-event-button', function( e ) {
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
