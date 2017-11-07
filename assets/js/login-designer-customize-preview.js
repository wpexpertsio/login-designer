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
			wp.customize.preview.send( 'url', data.home_url );
		});

		wp.customize.preview.bind( 'login-designer-template-switcher', function( data ) {
			// When the section is expanded, open the login designer page.
			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'customize-templates template-section-option' );
			} else {
				$( 'body' ).removeClass( 'customize-templates template-section-option' );
			}
		});

		wp.customize.preview.bind( 'login-designer-settings', function( data ) {
			// When the section is expanded, open the login designer page.
			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'customize-settings' );
			} else {
				$( 'body' ).removeClass( 'customize-settings' );
			}
		});
	});

	// Button background color.
	wp.customize( 'login_designer[button_bg]', function( value ) {
		value.bind( function( to ) {
			$( '#loginform .submit .button' ).css( 'background-color', to );
		} );
	} );

	// Button side padding.
	wp.customize( 'login_designer[button_height]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_button_height"> #loginform .submit .button { padding-top: ' + to + 'px; padding-bottom: ' + to + 'px; } </style>';

			el =  $( '.login_designer_button_height' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Button side padding.
	wp.customize( 'login_designer[button_side_padding]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_button_side_padding"> #loginform .submit .button { padding-left: ' + to + 'px; padding-right: ' + to + 'px; } </style>';

			el =  $( '.login_designer_button_side_padding' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Button border.
	wp.customize( 'login_designer[button_border]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_button_border"> #loginform .submit .button { border-style: solid; border-width: ' + to + 'px; } </style>';

			el =  $( '.login_designer_button_border' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Button border color.
	wp.customize( 'login_designer[button_border_color]', function( value ) {
		value.bind( function( to ) {
			$( '#loginform .submit .button' ).css( 'border-color', to );
		} );
	} );

	// Button border radius.
	wp.customize( 'login_designer[button_radius]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_button_radius"> #loginform .submit .login-designer-event-button, #loginform .submit .button { border-radius: ' + to + 'px !important; } </style>';

			el =  $( '.login_designer_button_radius' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Return the field's shadow size value.
	function buttonBoxShadowSize() {
		return wp.customize( 'login_designer[button_shadow]' )();
	}

	// Return the field's shadow opacity value.
	function buttonBoxShadowOpacity() {
		return wp.customize( 'login_designer[button_shadow_opacity]' )() * .01;
	}

	// Field Box Shadow.
	wp.customize( 'login_designer[button_shadow]', function( value ) {
		value.bind( function( to ) {
			var style, shadow_opacity, el;
			style = '<style class="login_designer_button_shadow"> #loginform .submit .button { box-shadow: 0 0 ' + to + 'px rgba(0, 0, 0, ' + buttonBoxShadowOpacity() + '); } </style>';

			el =  $( '.login_designer_button_shadow' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field Box Shadow.
	wp.customize( 'login_designer[button_shadow_opacity]', function( value ) {
		value.bind( function( to ) {
			var style, el, shadow_size, opacity;

			opacity = to * .01;

			style = '<style class="login_designer_button_shadow"> #loginform .submit .button { box-shadow: 0 0 ' + buttonBoxShadowSize() + 'px rgba(0, 0, 0, ' + opacity + '); } </style>';

			el =  $( '.login_designer_button_shadow' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Button font size.
	wp.customize( 'login_designer[button_font_size]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_button_font_size"> #loginform .submit .button { font-size: ' + to + 'px; } </style>';

			el =  $( '.login_designer_button_font_size' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Button color.
	wp.customize( 'login_designer[button_color]', function( value ) {
		value.bind( function( to ) {
			$( '#loginform .submit .button' ).css( 'color', to );
		} );
	} );

	// Field background color.
	wp.customize( 'login_designer[field_bg]', function( value ) {
		value.bind( function( to ) {
			$( '#loginform .input' ).css( 'background-color', to );
		} );
	} );

	// Field top padding.
	wp.customize( 'login_designer[field_padding_top]', function( value ) {
		value.bind( function( to ) {
			var style, el;

			style = '<style class="login_designer_field_padding_top"> #loginform .input { padding-top: ' + to + 'px; }</style>';

			el =  $( '.login_designer_field_padding_top' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field bottom padding.
	wp.customize( 'login_designer[field_padding_bottom]', function( value ) {
		value.bind( function( to ) {
			var style, el;

			style = '<style class="login_designer_field_padding_bottom"> #loginform .input { padding-bottom: ' + to + 'px; }</style>';

			el =  $( '.login_designer_field_padding_bottom' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field padding-left.
	wp.customize( 'login_designer[field_side_padding]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_field_side_padding"> #loginform .input { padding-left: ' + to + 'px; } </style>';

			el =  $( '.login_designer_field_side_padding' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field border.
	wp.customize( 'login_designer[field_border]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_field_border"> #loginform .input { border-style: solid; border-width: ' + to + 'px; } </style>';

			el =  $( '.login_designer_field_border' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field border color.
	wp.customize( 'login_designer[field_border_color]', function( value ) {
		value.bind( function( to ) {
			$( '#loginform .input' ).css( 'border-color', to );
		} );
	} );

	// Field border radius.
	wp.customize( 'login_designer[field_radius]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_field_radius"> #loginform div .login-designer-event-button, #loginform .input { border-radius: ' + to + 'px !important; } </style>';

			el =  $( '.login_designer_field_radius' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Return the field's shadow size value.
	function fieldBoxShadowSize() {
		return wp.customize( 'login_designer[field_shadow]' )();
	}

	// Return the field's shadow opacity value.
	function fieldBoxShadowOpacity() {
		return wp.customize( 'login_designer[field_shadow_opacity]' )() * .01;
	}

	// Return the field's shadow inset value.
	function fieldBoxShadowInset() {
		if ( true === wp.customize( 'login_designer[field_shadow_inset]' )() ) {
			return 'inset';
		} else {
			return '';
		}
	}

	// Field Box Shadow.
	wp.customize( 'login_designer[field_shadow]', function( value ) {
		value.bind( function( to ) {
			var style, shadow_opacity, el;
			style = '<style class="login_designer_field_shadow"> #loginform .input { box-shadow: ' + fieldBoxShadowInset() + ' 0 0 ' + to + 'px rgba(0, 0, 0, ' + fieldBoxShadowOpacity() + '); } </style>';

			el =  $( '.login_designer_field_shadow' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field Box Shadow.
	wp.customize( 'login_designer[field_shadow_opacity]', function( value ) {
		value.bind( function( to ) {
			var style, el, shadow_size, opacity;

			opacity = to * .01;

			style = '<style class="login_designer_field_shadow"> #loginform .input { box-shadow: ' + fieldBoxShadowInset() + ' 0 0 ' + fieldBoxShadowSize() + 'px rgba(0, 0, 0, ' + opacity + '); } </style>';

			el =  $( '.login_designer_field_shadow' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field Box Shadow.
	wp.customize( 'login_designer[field_shadow_inset]', function( value ) {
		value.bind( function( to ) {
			var style, el, shadow_size, inset;

			if ( true === to ) {
				inset = 'inset';
			} else {
				inset = '';
			}

			style = '<style class="login_designer_field_shadow"> #loginform .input { box-shadow: ' + inset + ' 0 0 ' + fieldBoxShadowSize() + 'px rgba(0, 0, 0, ' + fieldBoxShadowOpacity() + '); } </style>';

			el =  $( '.login_designer_field_shadow' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field font size.
	wp.customize( 'login_designer[field_font_size]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_field_font_size"> #loginform .input { font-size: ' + to + 'px; } </style>';

			el =  $( '.login_designer_field_font_size' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field color.
	wp.customize( 'login_designer[field_color]', function( value ) {
		value.bind( function( to ) {
			$( '#loginform .input' ).css( 'color', to );
		} );
	} );

















	// Check whether a custom logo image is available.
	function hasLogo() {
		var image = wp.customize( 'login_designer[logo]' )();
		return '' !== image;
	}

	function hasLogoAction( to ) {

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
				style = '<style class="login_designer_logo">body.login #login h1 a { display: block; } #login-designer-logo, body.login #login h1 a { background-size:'+width+'px '+height+'px; } #login-designer-logo-h1 { width: '+width+'px !important; height: '+height+'px !important; } </style>';

				if ( element.length ) {
					element.replaceWith( style );
				} else {
					$( 'head' ).append( style );
				}
			}

		} else {

			// If a logo is removed, fallback to the default WordPress logo + sizes.
			style = '<style class="login_designer_logo">body.login #login h1 a { display: block; } body.login #login h1 a, body.login #login-designer-logo-h1 { margin-bottom: 0px !important; } #login-designer-logo-h1 { width: 84px !important; height: 84px !important; } #login-designer-logo { height: 84px !important; width: 84px !important; background-size: 84px !important; background-image: none, url(" ' + login_designer_script.admin_url + '/images/wordpress-logo.svg ") !important; } </style>';

			if ( element.length ) {
				element.replaceWith( style );
			} else {
				$( 'head' ).append( style );
			}
		}
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
					to = '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;'
				}

				// Remove the [] from the control, so we can use the control as a class.
				control = control.replace( '[', '_' );
				control = control.replace( ']', '' );

				style = '<style class="' + control + '"> ' + style_element + ' { font-family: ' + to + '; } </style>';

				el =  $( '.' + control );

				if ( el.length ) {
					el.replaceWith( style ); // style element already exists, so replace it
				} else {
					$( 'head' ).append( style ); // style element doesn't exist so add it
				}

				// Don't link to fonts that don't have Google Fonts.
				if ( '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", sans-serif;' !== to && 'Times New Roman' !== to && 'Helvetica' !== to && 'Georgia' != to ) {

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
	live_font_family( 'login_designer[button_font]', '#loginform .submit .button' );

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

	// Label position.
	wp.customize( 'login_designer[label_position]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_label_position">#loginform .input { margin-top: ' + to + 'px; } #loginform div .login-designer-event-button { top: ' + to + 'px; } </style>';

			el =  $( '.login_designer_label_position' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Add a body class based on the current template.
	wp.customize( 'login_designer[template]', function( value ) {
		value.bind( function( to ) {

			$( 'body.login' ).attr( 'class', 'login login-action-login wp-core-ui locale-en-us has-template-applied template-section-option customize-partial-edit-shortcuts-shown' );
			$( 'body.login' ).addClass( 'login-designer-template-' + to );

			// If we have a custom background color, let's remove it so the templates can shine.
			$( 'body.login' ).css( 'background-color', '' );

			if ( to !== '01' ) {
				$( '#login' ).css( 'background-color', '' );
			}
		} );
	} );

	// Login page background color.
	wp.customize( 'login_designer[bg_color]', function( value ) {

		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_bg_color">body.login { background-color: ' + to + '; } </style>';

			el =  $( '.login_designer_bg_color' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
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

				if ( customBackground() ) {
					setTimeout( function() {
					$( '#login-designer-background' ).css( 'background-image', 'url( ' + customBackground() + ')' );
					}, 300);

					setTimeout( function() {
						$( '#login-designer-background' ).removeClass( 'transitioning' );
					}, 350 );
				} else {
					$( 'body.login, #login-designer-background' ).css( 'background-image', 'none' );
				}


			} else if ( '' === to ) {
				$( 'body.login, #login-designer-background' ).css( 'background-image', 'none' );
				console.log( 'No background' );

			}  else {

				$( 'body.login, #login-designer-background' ).css( 'background-image', 'none' );

				$( '#login-designer-background' ).addClass( 'transitioning' );

				setTimeout( function() {
					$( '#login-designer-background' ).css( 'background-image', 'url( ' + url + to + '.jpg' + ')' );
				}, 300);

				setTimeout( function() {
					$( '#login-designer-background' ).removeClass( 'transitioning' );
				}, 350 );
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
			hasLogoAction( to );
		} );
	} );

	// Check whether a custom logo image is available.
	function logoVisibility() {

		var logo_display;

		var logo_display = wp.customize( 'login_designer[disable_logo]' )();

		if ( logo_display === true ) {

			setTimeout( function() {
				$( '#login-designer-logo-h1 .login-designer-event-button' ).wrap( '<span class="customize-partial--login-designer-add-logo customize-partial-edit-shortcut"></span>' );
				$( '#login-designer-logo-h1 .login-designer-event-button' ).removeClass( 'customizer-event-overlay' );
			}, 70);

			return false;
		} else {
			return true;
		}
	}

	wp.customize.bind( 'preview-ready', function() {
		logoVisibility();
	});

	// Hide the logo.
	wp.customize( 'login_designer[disable_logo]', function( value ) {
		value.bind( function( to ) {

			var style, el;

			el =  $( '.login_designer_logo_disable_logo' );

			if ( true === to ) {
				style = '<style class="login_designer_logo_disable_logo"> #login-designer-logo { display: none !important; } body #login-designer-logo-h1 { margin-bottom: 0 !important; } body #login-designer-logo-h1, body #login-designer-logo-h1 #login-designer-logo { height: 0 !important; width: 0 !important; } </style>';
			} else {
				style = '<style class="login_designer_logo_disable_logo"> #login-designer-logo { display: block !important; } </style>';
			}

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}

			var nib = '<span class="customize-partial--login-designer-add-logo customize-partial-edit-shortcut"></span>';

			if ( true === to ) {
				// If hidden;
				$( '#login-designer-logo-h1 .login-designer-event-button' ).wrap( nib );
				$( '#login-designer-logo-h1 .login-designer-event-button' ).removeClass( 'customizer-event-overlay' );
			} else {
				$( '#login-designer-logo-h1 .login-designer-event-button' ).unwrap( nib );
				$( '#login-designer-logo-h1 .login-designer-event-button' ).addClass( 'customizer-event-overlay' );
			}

		});
	});

	// Custom logo margin bottom.
	wp.customize( 'login_designer[logo_margin_bottom]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_logo_margin_bottom"> body.login #login h1 a, #login-designer-logo-h1 { margin-bottom: ' + to + 'px !important; } </style>';

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
			var style, el;
			style = '<style class="login_designer_form_bg"> body.login #loginform, body.login-designer-template-01 #login { background-color: ' + to + ' !important; } </style>';

			el =  $( '.login_designer_form_bg' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}


			$( 'body.login #loginform, body.login-designer-template-01 #login' ).css( 'background-color', to );
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

	wp.customize( 'login_designer_settings[logo_url]', function( value ) {
		value.bind( function( to ) {
			$( '#login-designer-logo' ).attr( 'href', to );
		} );
	} );


} )( jQuery );
