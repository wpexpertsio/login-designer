/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. This javascript will grab settings from customizer controls, and
 * then make any necessary changes to the page using jQuery.
 */

( function( $ ) {

	// Switch to the /login-designer/ page, where we can live-preview Customizer options.
	wp.customize.bind( 'preview-ready', function() {

		wp.customize.preview.bind( 'login-designer-url-switcher', function( data ) {

			// When the section is expanded, open the login designer page.
			if ( true === data.expanded ) {
				wp.customize.preview.send( 'url', login_designer_script.login_designer_page );
			}
		});

		wp.customize.preview.bind( 'login-designer-back-to-home', function( data ) {
			console.log( 'sent back to home' );
			wp.customize.preview.send( 'url', data.home_url );
		});
	});

	// Check whether a custom logo image is available.
	function hasLogo() {
		var image = wp.customize( 'login_designer[logo]' )();
		return '' !== image;
	}

	// Return the form's shadow size value.
	function formBoxShadowSize() {
		return wp.customize( 'login_designer[form_shadow]' )();
	}

	// Return the form's shadow opacity value.
	function formBoxShadowOpacity() {
		return wp.customize( 'login_designer[form_shadow_opacity]' )() * .01;
	}

	// Output live font-family changes and link to the relevant Google Fonts stylesheet, if applicable.
	function live_font_family( control, style_element ) {

		wp.customize( control, function( value ) {

			value.bind( function( to ) {

				var
				el,
				style,
				old_stylesheet;

				// Default is the WordPress admin's default.
				if ( 'default' === to ) {
					to == '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;'
				}

				style = '<style class=" ' + control + ' "> ' + style_element + ' { font-family: ' + to + '; } </style>';

				el =  $( '.' + control );

				if ( el.length ) {
					el.replaceWith( style ); // style element already exists, so replace it
				} else {
					$( 'head' ).append( style ); // style element doesn't exist so add it
				}

				// Don't link to fonts that don't have Google Fonts.
				if ( 'default' != to && 'Times New Roman' != to && 'Helvetica' != to && 'Georgia' != to ) {

					// Convert the value into the correct url args.
					font_family = '?family=' + to;

					// Generate and link the new stylesheet.
					stylesheet = $( '<link rel="stylesheet" id="login-designer-' + control + '" href=" ' + login_designer_script.font_url + font_family + login_designer_script.font_subset +' " type="text/css" media="all" >' ).appendTo( 'head' );

					// Look for the old font stylesheet so we may replace it on the fly.
					old_stylesheet =  $( '#login-designer-' + control );

					if ( old_stylesheet.length ) {
						// Style element already exists, so replace it
						old_stylesheet.replaceWith( stylesheet );
					} else {
						// Style element doesn't exist so add it
						$( 'head' ).append( stylesheet );
					}

				}

			} );
		} );
	}

	live_font_family( 'login_designer[label_font]', '#loginform label:not([for=rememberme])' );
	live_font_family( 'login_designer[field_font]', '#loginform .input' );

	// Label font size.
	wp.customize( 'login_designer[label_font_size]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_label_font_size"> #loginform label:not([for=rememberme]) { font-size: ' + to + 'px; } </style>';

			el =  $( '.login_designer_label_font_size' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Label color.
	wp.customize( 'login_designer[label_color]', function( value ) {
		value.bind( function( to ) {
			$( '#loginform label:not([for=rememberme])' ).css( 'color', to );
		} );
	} );

	// Add a body class based on the current template.
	wp.customize( 'login_designer[template]', function( value ) {
		value.bind( function( to ) {

			$( 'body.login' ).attr( 'class', 'login login-action-login wp-core-ui locale-en-us has-template-applied' );
			$( 'body.login' ).addClass( 'login-designer-template-' + to );

			// If we have a custom background color, let's remove it so the templates can shine.
			$( 'body.login' ).css( 'background-color', '' );
		} );
	} );

	// Login page background color.
	wp.customize( 'login_designer[bg_color]', function( value ) {
		value.bind( function( to ) {

			$( 'body.login' ).removeClass( 'class', 'has-template-applied' );

			$( 'body.login' ).css( 'background-color', to );
		} );
	} );

	// Return a background image, if there is available.
	function customBackground() {
		return wp.customize( 'login_designer[bg_image]' )();
	}

	// Login page background image url.
	wp.customize( 'login_designer[bg_image]', function( value ) {
		value.bind( function( to ) {

			$( 'body.login' ).css( 'background-image', 'none' );

			$( '#login-designer-background' ).addClass( 'transitioning' );

			setTimeout( function() {
				$( '#login-designer-background' ).css( 'background-image', 'url( ' + to + ')' );
			}, 500);

			setTimeout( function() {
				$( '#login-designer-background' ).removeClass( 'transitioning' );
			}, 550 );
		} );
	} );

	// Login page background image url.
	wp.customize( 'login_designer[bg_image_gallery]', function( value ) {
		value.bind( function( to ) {

			var url;
			var values = [];

			if ( login_designer_script.extension_backgrounds ) {
				values = Object.values( login_designer_script.extension_backgrounds );
			}

			if ( values.includes( to ) ) {

				if ( to.indexOf( 'seasonal' ) >= 0 ) {

					url = login_designer_script.seasonal_plugin_url;

				} else {
					// Remove hyphen from value.
					bg_collection = to.replace(/-|\s/g,"");

					// Remove numbers from value.
					bg_collection = bg_collection.replace(/[0-9]/g, '');

					// Generate the dynamic URL based on the value of the option selected.
					url = login_designer_script.plugins_url + '/login-designer-' + bg_collection + '-backgrounds/assets/images/' ;
				}

			} else {
				// Or use a core background that's included in Login Designer core.
				url = login_designer_script.plugin_url;
			}

			if ( 'none' === to ) {

				$( '#login-designer-background' ).addClass( 'transitioning' );

				setTimeout( function() {
					$( '#login-designer-background' ).css( 'background-image', 'url( ' + customBackground() + ')' );
				}, 500);

				setTimeout( function() {
					$( '#login-designer-background' ).removeClass( 'transitioning' );
				}, 550 );

				console.log( customBackground() );

			} else {

				$( 'body.login' ).css( 'background-image', 'none' );

				$( '#login-designer-background' ).addClass( 'transitioning' );

				setTimeout( function() {
					$( '#login-designer-background' ).css( 'background-image', 'url( ' + url + to + '.jpg' + ')' );
				}, 500);

				setTimeout( function() {
					$( '#login-designer-background' ).removeClass( 'transitioning' );
				}, 550 );
			}
		} );
	} );

	// Login page background image repeat.
	wp.customize( 'login_designer[bg_repeat]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_bg_repeat"> #login-designer-background { background-repeat: ' + to + '; } </style>';

			el =  $( '.login_designer_bg_repeat' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login page background image size.
	wp.customize( 'login_designer[bg_size]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_bg_size"> #login-designer-background { background-size: ' + to + '; } </style>';

			el =  $( '.login_designer_bg_size' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login page background image position.
	wp.customize( 'login_designer[bg_position]', function( value ) {
		value.bind( function( to ) {
			var style, el;

			var to = to;
			var to = to.replace(/-/g, ' ');

			style = '<style class="login_designer_bg_position"> #login-designer-background { background-position: ' + to + '; } </style>';

			el =  $( '.login_designer_bg_position' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login page background attachment position.
	wp.customize( 'login_designer[bg_attach]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_bg_attach"> #login-designer-background { background-attachment: ' + to + '; } </style>';

			el =  $( '.login_designer_bg_attach' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Form Box Shadow.
	wp.customize( 'login_designer[form_shadow]', function( value ) {
		value.bind( function( to ) {
			var style, shadow_opacity, el;
			style = '<style class="login_designer_form_shadow"> #loginform { box-shadow: 0 0 ' + to + 'px rgba(0, 0, 0, ' + formBoxShadowOpacity() + '); } </style>';

			el =  $( '.login_designer_form_shadow' );
			// shadow_opacity =  $( '.login_designer[form_shadow_opacity]' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Form Box Shadow.
	wp.customize( 'login_designer[form_shadow_opacity]', function( value ) {
		value.bind( function( to ) {
			var style, el, shadow_size, opacity;

			opacity = to * .01;

			style = '<style class="login_designer_form_shadow"> #loginform { box-shadow: 0 0 ' + formBoxShadowSize() + 'px rgba(0, 0, 0, ' + opacity + '); } </style>';

			el =  $( '.login_designer_form_shadow' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	wp.customize( 'login_designer[username_label]', function( value ) {
		value.bind( function( newval ) {
			$( '#login-designer--username-label span' ).html( newval );
		} );
	} );

	wp.customize( 'login_designer[password_label]', function( value ) {
		value.bind( function( newval ) {
			$( '#login-designer--password-label span' ).html( newval );
		} );
	} );

	// Custom logo.
	wp.customize( 'login_designer[logo]', function( value ) {

		value.bind( function( to ) {

			var style, element;

			// Output the style changes (for background sizes).
			element =  $( '.login_designer_logo' );

			// If we have a custom logo uploaded.
			if ( hasLogo() ) {

				// Set the background image of the logo.
				$( '#login-designer-logo' ).css( 'background-image', 'url( ' + to + ')' );

				// Grab the height & width attributes, so we can resize the logo appropriately.
				var img = new Image();

				img.src = to;

				var style;

				img.onload = function(){

					// We're dividing by 2, in order to make the logo's look nice on retina devices.
					var width 	= img.width / 2,
					    height 	= img.height / 2;

		           		$( '#login-designer-logo' ).css({
		           			width: width,
						height: height,
					});

					// Setting the background size of the custom logo.
					style = '<style class="login_designer_logo"> #login-designer-logo, body.login #login h1 a { background-size:'+width+'px '+height+'px; } h1#login-designer-logo-h1 { width: '+width+'px !important; height: '+height+'px !important; } </style>';

					if ( element.length ) {
						element.replaceWith( style );
					} else {
						$( 'head' ).append( style );
					}
				}

			} else {
				// If a logo is removed, fallback to the default WordPress logo + sizes.
				style = '<style class="login_designer_logo"> body.login #login h1 a, body.login h1#login-designer-logo-h1 { margin-bottom: 0px !important; } h1#login-designer-logo-h1 { width: 84px !important; height: 84px !important; } #login-designer-logo { height: 84px !important; width: 84px !important; background-size: 84px !important; background-image: none, url(" ' + login_designer_script.admin_url + '/images/wordpress-logo.svg ") !important; } </style>';

				if ( element.length ) {
					element.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			}
		} );
	} );

	// Custom logo margin bottom.
	wp.customize( 'login_designer[logo_margin_bottom]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_logo_margin_bottom"> body.login #login h1 a, h1#login-designer-logo-h1 { margin-bottom: ' + to + 'px !important; } </style>';

			el =  $( '.login_designer_logo_margin_bottom' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login form background color.
	wp.customize( 'login_designer[form_bg]', function( value ) {
		value.bind( function( to ) {
			$( 'body.login #loginform' ).css( 'background-color', to );
		} );
	} );

	// Login form border radius.
	wp.customize( 'login_designer[form_radius]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_form_radius"> body.login #loginform { border-radius: ' + to + 'px; } </style>';

			el =  $( '.login_designer_form_radius' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login form width.
	wp.customize( 'login_designer[form_width]', function( value ) {
		value.bind( function( to ) {
			$( 'body.login #login' ).css({
				width: to,
			});
		} );
	} );

	// Form padding: left/right.
	wp.customize( 'login_designer[form_side_padding]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_form_side_padding"> body.login #loginform { padding-left: ' + to + 'px; padding-right: ' + to + 'px; } </style>';

			el =  $( '.login_designer_form_side_padding' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Form padding: top/bottom.
	wp.customize( 'login_designer[form_vertical_padding]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_form_vertical_padding"> body.login #loginform { padding-top: ' + to + 'px; padding-bottom: ' + to + 'px; } </style>';

			el =  $( '.login_designer_form_vertical_padding' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	wp.customize( 'login_designer_admin[logo_url]', function( value ) {
		value.bind( function( to ) {
			$( '#login-designer-logo' ).attr( 'href', to );
		} );
	} );

	// Field border radius.
	wp.customize( 'login_designer[field_radius]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_field_radius"> body.login #loginform .input { border-radius: ' + to + 'px; } </style>';

			el =  $( '.login_designer_field_radius' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );


} )( jQuery );
