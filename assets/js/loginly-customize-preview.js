/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. This javascript will grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

( function( $ ) {

	// Whether a custom logo image is available.
	function hasLogo() {
		var image = wp.customize( 'loginly_custom_logo' )();
		return '' !== image;
	}

	// Switch to the /loginly/ page, where we can live-preview Customizer options.
	wp.customize.bind( 'preview-ready', function() {

		wp.customize.preview.bind( 'loginly-url-switcher', function( data ) {

			// When the section is expanded, open the fake login page.
			if ( true === data.expanded ) {

				url = '/loginly/';

				wp.customize.preview.send( 'url', url );

			}
		});
	});

	// Add a body class based on the current template.
	wp.customize( 'loginly__template-selector', function( value ) {
		value.bind( function( to ) {

			$( 'body.login' ).attr( 'class', 'login login-action-login wp-core-ui locale-en-us has-template-applied' );
			$( 'body.login' ).addClass( 'loginly-template-' + to );

			// If we have a custom background color, let's remove it so the templates can shine.
			$( 'body.login' ).css( 'background-color', '' );
		} );
	} );

	// Login page background color.
	wp.customize( 'loginly__custom-background-color', function( value ) {
		value.bind( function( to ) {

			$( 'body.login' ).removeClass( 'class', 'has-template-applied' );

			$( 'body.login' ).css( 'background-color', to );
		} );
	} );

	// Login page background image url.
	wp.customize( 'loginly__custom-background-image--url', function( value ) {
		value.bind( function( to ) {
			$( 'body.login' ).css( 'background-image', 'url( ' + to + ')' );
		} );
	} );

	// Login page background image repeat.
	wp.customize( 'loginly__custom-background-image--repeat', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="loginly__custom-background-image--repeat"> body.login { background-repeat: ' + to + '; } </style>';

			el =  $( '.loginly__custom-background-image--repeat' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login page background image size.
	wp.customize( 'loginly__custom-background-image--size', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="loginly__custom-background-image--size"> body.login { background-size: ' + to + '; } </style>';

			el =  $( '.loginly__custom-background-image--size' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login page background image position.
	wp.customize( 'loginly__custom-background-image--position', function( value ) {
		value.bind( function( to ) {
			var style, el;

			var to = to;
			var to = to.replace(/-/g, ' ');

			style = '<style class="loginly__custom-background-image--position"> body.login { background-position: ' + to + '; } </style>';

			el =  $( '.loginly__custom-background-image--position' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login page background attachment position.
	wp.customize( 'loginly__custom-background-image--attach', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="loginly__custom-background-image--attach"> body.login { background-attachment: ' + to + '; } </style>';

			el =  $( '.loginly__custom-background-image--attach' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Custom logo.
	wp.customize( 'loginly_custom_logo', function( value ) {

		value.bind( function( to ) {

			var style, element;

			// If we have a custom logo uploaded.
			if ( hasLogo() ) {

				// Set the background image of the logo.
				$( '#loginly-logo' ).css( 'background-image', 'url( ' + to + ')' );

				// Grab the height & width attributes, so we can resize the logo appropriately.
				var img = new Image();

				img.onload = function(){

					// We're dividing by 2, in order to make the logo's look nice on retina devices.
					var width 	= img.width / 2,
					    height 	= img.height / 2;

		           		$( '#loginly-logo' ).css({
		           			width: width,
						height: height,
					});

					// Setting the background size of the custom logo.
					var style = '<style class="loginly_custom_logo"> #loginly-logo { background-size:'+width+'px; } </style>';
				}

				img.src = to;

			} else {
				// If a logo is removed, fallback to the default WordPress logo + sizes.
				style = '<style class="loginly_custom_logo"> #loginly-logo { height: 84px !important; width: 84px !important; background-size: 84px !important; background-image: none, url(" ' + loginly_script.admin_url + '/images/wordpress-logo.svg ") !important; } </style>';
			}

			// alert( style );

			// Outut the style changes (for background sizes).
			element =  $( '.loginly_custom_logo' );

			if ( element.length ) {
				element.replaceWith( style );
			} else {
				$( 'head' ).append( style );
			}
		} );
	} );

	// Custom logo margin bottom.
	wp.customize( 'loginly_custom_logo_margin_bottom', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="loginly_custom_logo_margin_bottom"> body.login #login h1 a { margin-bottom: ' + to + 'px !important; } </style>';

			el =  $( '.loginly_custom_logo_margin_bottom' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login form background color.
	wp.customize( 'loginly_form_background_color', function( value ) {
		value.bind( function( to ) {
			$( 'body.login #loginform' ).css( 'background-color', to );
		} );
	} );

	// Login form border radius.
	wp.customize( 'loginly_form_border_radius', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="loginly_form_border_radius"> body.login #loginform, body.login #loginform:after { border-radius: ' + to + 'px; } </style>';

			el =  $( '.loginly_form_border_radius' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login form width.
	wp.customize( 'loginly_form_width', function( value ) {
		value.bind( function( to ) {
			$( 'body.login #login' ).css({
				width: to,
			});
		} );
	} );

	wp.customize( 'loginly__logo-url', function( value ) {
		value.bind( function( to ) {
			$( '#loginly-logo' ).attr( 'href', to );
		} );
	} );

} )( jQuery );
