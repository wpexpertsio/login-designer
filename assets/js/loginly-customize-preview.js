/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. This javascript will grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

( function( $ ) {

	wp.customize.bind( 'preview-ready', function() {

		wp.customize.preview.bind( 'loginly-url-switcher', function( data ) {

			// When the section is expanded, open the fake login page.
			if ( true === data.expanded ) {

				url = '/loginly/';

				wp.customize.preview.send( 'url', url );

			}
		});
	});

	wp.customize( 'loginly__custom-background-color', function( value ) {
		value.bind( function( to ) {
			$( 'body.login' ).css( 'background-color', to );
		} );
	} );

	wp.customize( 'loginly__custom-logo', function( value ) {
		value.bind( function( to ) {

			if ( to.length ) {
				$( '#loginly-logo-h1' ).css({
					clip: 'auto',
					position: 'relative'
				});
			} else {
				$( '#loginly-logo-h1' ).css({
					clip: 'rect(1px, 1px, 1px, 1px)',
					position: 'absolute'
				});
			}
		} );
	} );

	wp.customize( 'loginly__custom-logo-maxwidth', function( value ) {
		value.bind( function( to ) {
			$( '#login h1 a' ).css( 'width', to );
		} );
	} );

	wp.customize( 'loginly__template-selector', function( value ) {
		value.bind( function( to ) {
			$( 'body.login' ).attr( 'class', 'login login-action-login wp-core-ui locale-en-us' );
			$( 'body.login' ).addClass( to );
		} );
	} );

	wp.customize( 'loginly__logo-url', function( value ) {
		value.bind( function( to ) {
			$( '#loginly-logo' ).attr( 'href', to );
		} );
	} );

} )( jQuery );
