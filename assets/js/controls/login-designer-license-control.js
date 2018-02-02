/* global jQuery, login_designer_custom_controls, ajaxurl, wp */

( function ( $ ) {

	$( document ).ready( function ( $ ) {

		var
		activation_button 	= $( '#login-designer-activate-license' ),
		deactivation_button 	= $( '#login-designer-deactivate-license' ),
		valid 			= ( 'is-valid' ),
		not_valid 		= ( 'is-not-valid' );

		// Removes the error class from the license input field, if necessary.
		$( '#license-key' ).blur( function( ) {
			val = $( this ).val();
			if ( val == '') {
				$( this ).removeClass( not_valid );
			}
		});

		activation_button.on( 'click', function ( e ) {

			// Prevent the button from refreshing.
			e.preventDefault();

			// Show the spinner.
			$( '#license-form .spinner' ).addClass( 'visible' );

			// Disable the button so that the request won't be duplicated accidently.
			$( this ).attr( 'disabled', true );

			// Ensure the key is not already invalid.
			$( '#license-key' ).removeClass( not_valid );

			// License activation data.
			var activation_data = {
				type: 'post',
				action: 'activate_login_designer_license',
				nonce: login_designer_custom_controls.nonce.activate,
				wp_customize: 'on',
				key: $( '#license-key' ).val(),
			};

			// License activation AJAX request.
			$.post( login_designer_custom_controls.ajaxurl, activation_data, function ( r ) {

				console.log( r.error );

				// If the request has been performed.
				if ( typeof r.done !== 'undefined' ) {

					// Save the current customizer settings.
					wp.customize.state( 'saved' ).set( true );

					$( '#license-form .spinner' ).removeClass( 'visible' );

					// Remove the disabled attribute.
					activation_button.attr( 'disabled', false );

					// Check for validity.
					if ( 'valid' === r.status ) {
						// Swap the buttons and remove the disabled attribute from the deactivate button.
						deactivation_button.addClass( valid ).removeClass( not_valid );
						activation_button.addClass( valid ).attr( 'disabled', false );

						// Show the license info, as the license is now activated.
						$( '#license-info' ).addClass( valid ).removeClass( not_valid );
					} else {
						$( '#license-key' ).addClass( not_valid );
						$( '#license-key' ).focus();
					}

					// Append license info.
					$( '#license-status' ).html( r.status );
					$( '#license-expiration' ).html( r.expiration );
					$( '#license-site_count' ).html( r.site_count );
					$( '#license-activations_left' ).html( r.activations_left );

					// Log the data, for debugging purposes.
					// console.log( activation_data );
				}

			});

		});

		deactivation_button.on( 'click', function (e) {

			// Prevent the button from refreshing.
			e.preventDefault();

			// Show the spinner.
			$( '#license-form .spinner' ).addClass( 'visible' );

			// Disable the button so that the request won't be duplicated accidently.
			$( this ).attr( 'disabled', true );

			// License deactivation data.
			var deactivation_data = {
				type: 'post',
				action: 'deactivate_login_designer_license',
				nonce: login_designer_custom_controls.nonce.deactivate,
				wp_customize: 'on',
			};

			// License deactivation AJAX request.
			$.post( login_designer_custom_controls.ajaxurl, deactivation_data, function ( r ) {

				console.log( r.error );

				// If the request has been performed.
				if ( typeof r.done !== 'undefined' ) {

					// Save the current customizer settings.
					wp.customize.state( 'saved' ).set( true );

					// Remove the spinner.
					$( '#license-form .spinner' ).removeClass( 'visible' );

					// Swap the buttons and remove the disabled attribute from the deactivate button.
					activation_button.removeClass( valid );
					deactivation_button.removeClass( valid ).addClass( not_valid ).attr( 'disabled', false );

					// Hide the license info, as the license is now deactivated.
					$( '#license-info' ).removeClass( valid ).addClass( not_valid );

					// Empty the license key input field.
					wp.customize.control( 'login_designer_license[key]' ).setting.set( '' );

					// Log the data, for debugging purposes.
					// console.log( deactivation_data );
				}

			});

		});

	});

} ) ( jQuery );
