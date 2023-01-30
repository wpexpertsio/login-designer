/**
 * Customizer Live Events.
 */
( function ( wp, $ ) {
	"use strict";

	$( '#login-designer--username, #login-designer--password').hover(function() {
		$( '#login form').toggleClass( 'input-hover' );
	});

	$( '#login-designer--username-label, #login-designer--password-label').hover(function() {
		$( '#login form').toggleClass( 'label-hover' );
	});

	// Bail if the Customizer isn't initialized
	if ( ! wp || ! wp.customize ) {
		return;
	}

	var api = wp.customize, LoginDesignerOldPreview;

	// Custom Customizer Preview class (attached to the Customize API)
	api.LoginDesignerCustomizerPreview = {
		// Init
		init: function () {
			var self = this;

			// When the previewer is active, the "active" event has been triggered (on load)
			this.preview.bind( 'active', function() {

				var
					$body 		= $( 'body'),
					$body_bg 	= $( '#login'),
					$document 	= $( document ),
					$logo	 	= $( '#login-designer-logo-h1'),
					$loginform	= $( '#login form'),
					$loginform_text	= $( '#login-designer--username'),
					$loginform_pass	= $( '#login-designer--password'),
					$username_label	= $( '#login-designer--username-label'),
					$password_label	= $( '#login-designer--password-label'),
					$button		= $( '#login-designer--button'),
					$remember_me	= $( '.forgetmenot'),
					$remember_me_cb	= $( '.forgetmenot label'),
					$below_form	= $( '#login-designer--below-form'),
					$branding	= $( '.login-designer-badge__inner'),
					$language_switcher = $( '.login-designer--translation-switcher' );

				$logo.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-logo"></button>' );

				$loginform.append( '<span class="customize-partial--loginform customize-partial-edit-shortcut"><button class="login-designer-event-button customize-partial-edit-shortcut-button" data-login-designer-customizer-event="login-designer-edit-loginform"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M13.89 3.39l2.71 2.72c.46.46.42 1.24.03 1.64l-8.01 8.02-5.56 1.16 1.16-5.58s7.6-7.63 7.99-8.03c.39-.39 1.22-.39 1.68.07zm-2.73 2.79l-5.59 5.61 1.11 1.11 5.54-5.65zm-2.97 8.23l5.58-5.6-1.07-1.08-5.59 5.6z"></path></svg></button></span>' );

				$loginform_text.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-loginform-fields"></button>' );
				$loginform_pass.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-loginform-fields"></button>' );

				$username_label.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-loginform-labels-username"></button>' );
				$password_label.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-loginform-labels-password"></button>' );

				$body_bg.append( '<span class="customize-partial--login-designer-background customize-partial-edit-shortcut"><button class="login-designer-event-button customize-partial-edit-shortcut-button" data-login-designer-customizer-event="login-designer-edit-background"></button></span>' );

				$button.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-button"></button>' );

				// Settings
				$body_bg.append( '<span class="customize-partial--login-designer-settings customize-partial-edit-shortcut"><button class="login-designer-event-button customize-partial-edit-shortcut-button" data-login-designer-customizer-event="login-designer-edit-settings"></button></span>' );

				// Templates
				$body_bg.append( '<span class="customize-partial--login-designer-template customize-partial-edit-shortcut"><button class="login-designer-event-button customize-partial-edit-shortcut-button" data-login-designer-customizer-event="login-designer-edit-template"></button></span>' );

				if ( login_designer_customize_live.label_hidden ) {
					$body.append( '<span style="top: 90px;left: 40px;font-size: 10px" class=" customize-partial-edit-shortcut"><button style="font-size: 10px" class="login-designer-event-button customize-partial-edit-shortcut-button" data-login-designer-customizer-event="login-designer-edit-remember-me">label</button></span>' );
				}

				// Remember Me
				$remember_me.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-remember-me"></button>' );

				// Checkbox
				$remember_me_cb.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-remember-me-checkbox"></button>' );

				// Below Form
				$below_form.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-below"></button>' );

				// Below Form
				$branding.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-branding"></button>' );
				$language_switcher.append( '<button class="login-designer-event-button customizer-event-overlay" data-login-designer-customizer-event="login-designer-edit-language"></button>' );

				// Listen for events on the new previewer buttons
				$document.on( 'touch click', '.login-designer-event-button', function( e ) {
					var $this = $( this );

					// Send the event that we've specified on the HTML5 data attribute ('data-login-designer-customizer-event') to the Customizer
					self.preview.send( $this.attr( 'data-login-designer-customizer-event' ) );
				} );

			} );
		}
	};

	/**
	 * Capture the instance of the Preview since it is private (this has changed in WordPress 4.0)
	 */
	LoginDesignerOldPreview = api.Preview;
	api.Preview = LoginDesignerOldPreview.extend( {
		initialize: function( params, options ) {
			// Store a reference to the Preview
			api.LoginDesignerCustomizerPreview.preview = this;

			// Call the old Preview's initialize function
			LoginDesignerOldPreview.prototype.initialize.call( this, params, options );
		}
	} );

	$( function () {
		// Initialize our Preview
		api.LoginDesignerCustomizerPreview.init();
	} );

} )( window.wp, jQuery );
