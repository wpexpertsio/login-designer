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
		} );

		wp.customize.preview.bind( 'login-designer-back-to-home', function( data ) {
			wp.customize.preview.send( 'url', data.home_url );
		} );

		wp.customize.preview.bind( 'login-designer-templates', function( data ) {
			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'login-designer-template-section-opened' );
			} else {
				$( 'body' ).removeClass( 'login-designer-template-section-opened' );
			}
		} );

		wp.customize.preview.bind( 'login-designer-settings', function( data ) {
			if ( true === data.expanded ) {
				$( 'body' ).addClass( 'login-designer-settings-opened' );
			} else {
				$( 'body' ).removeClass( 'login-designer-settings-opened' );
			}
		} );
	} );

	// Branding.
	wp.customize( 'login_designer_settings[branding]', function( value ) {
		value.bind( function( to ) {

			if ( false === to ) {
				$( '.login-designer-badge' ).addClass( 'is-hidden' );
			} else {
				$( '.login-designer-badge' ).removeClass( 'is-hidden' );
			}
		} );
	} );

	// Branding position.
	wp.customize( 'login_designer_settings[branding_position]', function( value ) {
		value.bind( function( to ) {
			$( '.login-designer-badge' ).attr( 'class', 'login-designer-badge' );
			$( '.login-designer-badge' ).addClass( to );
		} );
	} );

	// Branding text color.
	wp.customize( 'login_designer_settings[branding_color]', function( value ) {
		value.bind( function( to ) {
			$( '.login-designer-badge__text' ).css( 'color', to );
		} );
	} );

	// Branding icon fill color.
	wp.customize( 'login_designer_settings[branding_icon_color]', function( value ) {
		value.bind( function( to ) {
			$( '.login-designer-badge .icon' ).css( 'color', to );
		} );
	} );

	// Below form color.
	wp.customize( 'login_designer[below_color]', function( value ) {
		value.bind( function( to ) {
			$( '#login #nav, #login #nav a, #login #backtoblog a' ).css( 'color', to );
		} );
	} );

	// Below form font size.
	wp.customize( 'login_designer[below_font_size]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_below_font_size"> .login #login #nav, .login #login #nav a, .login #login #backtoblog a { font-size: ' + to + 'px; } </style>';

			el =  $( '.login_designer_below_font_size' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Below form position.
	wp.customize( 'login_designer[below_position]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_below_position">#login-designer--below-form { margin-top: ' + to + 'px !important; } </style>';

			el =  $( '.login_designer_below_position' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Checkbox size.
	wp.customize( 'login_designer[checkbox_size]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_checkbox_size">#login form input[type=checkbox] { height: ' + to + 'px; width: ' + to + 'px; } </style>';

			el =  $( '.login_designer_checkbox_size' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Checkbox background.
	wp.customize( 'login_designer[checkbox_bg]', function( value ) {
		value.bind( function( to ) {
			$( '#login form input[type=checkbox]' ).css( 'background-color', to );
		} );
	} );

	// Checkbox border.
	wp.customize( 'login_designer[checkbox_border]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_checkbox_border">#login form input[type=checkbox] { border-style: solid; border-width: ' + to + 'px; } </style>';

			el =  $( '.login_designer_checkbox_border' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Checkbox border color.
	wp.customize( 'login_designer[checkbox_border_color]', function( value ) {
		value.bind( function( to ) {
			$( '#login form input[type=checkbox]' ).css( 'border-color', to );
		} );
	} );

	// Checkbox border radius.
	wp.customize( 'login_designer[checkbox_radius]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_checkbox_radius"> #login form input[type=checkbox] { border-radius: ' + to + 'px !important; } </style>';

			el =  $( '.login_designer_checkbox_radius' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Remeber color
	wp.customize( 'login_designer[remember_color]', function( value ) {
		value.bind( function( to ) {
			$( '#login .forgetmenot label' ).css( 'color', to );
		} );
	} );

	// Remeber font size.
	wp.customize( 'login_designer[remember_font_size]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_remember_font_size">#login .forgetmenot label { font-size: ' + to + 'px; } </style>';

			el =  $( '.login_designer_remember_font_size' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Remember position.
	wp.customize( 'login_designer[remember_position]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_remember_position">#login .forgetmenot { margin-top: ' + to + 'px !important; } </style>';

			el =  $( '.login_designer_remember_position' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	wp.customize( 'login_designer[remember_hide]', function( value ) {
		value.bind( function( to ) {
			let style, el, display;
			if ( to ) {
				display = 'hidden';
			} else {
				display = 'visible';
			}
			style = `<style class="login-designer-hide-rememberme">
				.forgetmenot {
					visibility: ${display} !important;
				}
			</style>`;

			el = $( '.login-designer-hide-rememberme' );

			if ( el.length ) {
				el.replaceWith( style );
			} else {
				$( 'head' ).append( style );
			}
		} );
	} );

	// Back to label — @todo Make this an option.
	wp.customize( 'login_designer[back_to_label]', function( value ) {
		value.bind( function( newval ) {
			$( '#backtoblog a' ).html( newval );
		} );
	} );

	// On/Off for the lost password text.
	wp.customize( 'login_designer[lost_password]', function( value ) {
		value.bind( function( to ) {
			var style, el;

			if ( false === to ) {
				style = '<style class="login_designer_lost_password"> #login #nav { opacity: 0; } </style>';
			} else {
				style = '<style class="login_designer_lost_password"> #login #nav { display: block; opacity: 1;  } </style>';
			}

			el =  $( '.login_designer_lost_password' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// On/Off for the lost back to blog text.
	wp.customize( 'login_designer[back_to]', function( value ) {
		value.bind( function( to ) {
			var style, el;

			if ( false === to ) {
				style = '<style class="login_designer_back_to"> #login #backtoblog { opacity: 0; } </style>';
			} else {
				style = '<style class="login_designer_back_to"> #login #backtoblog { display: block; opacity: 1;  } </style>';
			}

			el =  $( '.login_designer_back_to' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Button background color.
	wp.customize( 'login_designer[button_bg]', function( value ) {
		value.bind( function( to ) {
			$( '#login .submit .button' ).css( 'background-color', to );
		} );
	} );

	// Button top padding.
	wp.customize( 'login_designer[button_padding_top]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_button_padding_top"> #login form .submit .button { padding-top: ' + to + 'px; } </style>';

			el =  $( '.login_designer_button_padding_top' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Button bottom padding.
	wp.customize( 'login_designer[button_padding_bottom]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_button_padding_bottom"> #login form .submit .button { padding-bottom: ' + to + 'px; } </style>';

			el =  $( '.login_designer_button_padding_bottom' );

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
			style = '<style class="login_designer_button_side_padding"> #login form .submit .button { padding-left: ' + to + 'px; padding-right: ' + to + 'px; } </style>';

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
			style = '<style class="login_designer_button_border"> #login form .submit .button { border-style: solid; border-width: ' + to + 'px; } </style>';

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
			$( '#login form .submit .button' ).css( 'border-color', to );
		} );
	} );

	// Button border radius.
	wp.customize( 'login_designer[button_radius]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_button_radius"> #login form .submit .login-designer-event-button, #login form .submit .button { border-radius: ' + to + 'px !important; } </style>';

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
			style = '<style class="login_designer_button_shadow"> #login form .submit .button { box-shadow: 0 0 ' + to + 'px rgba(0, 0, 0, ' + buttonBoxShadowOpacity() + '); } </style>';

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

			style = '<style class="login_designer_button_shadow"> #login form .submit .button { box-shadow: 0 0 ' + buttonBoxShadowSize() + 'px rgba(0, 0, 0, ' + opacity + '); } </style>';

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
			style = '<style class="login_designer_button_font_size"> #login form .submit .button { font-size: ' + to + 'px; } </style>';

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
			$( '#login form .submit .button' ).css( 'color', to );
		} );
	} );

	// Field top padding.
	wp.customize( 'login_designer[field_padding_top]', function( value ) {
		value.bind( function( to ) {
			var style, el;

			style = '<style class="login_designer_field_padding_top"> #login form .input { padding-top: ' + to + 'px; }</style>';

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

			style = '<style class="login_designer_field_padding_bottom"> #login form .input { padding-bottom: ' + to + 'px; }</style>';

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
			style = '<style class="login_designer_field_side_padding"> #login form .input { padding-left: ' + to + 'px; } </style>';

			el =  $( '.login_designer_field_side_padding' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field margin-bottom.
	wp.customize( 'login_designer[field_margin_bottom]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_field_margin_bottom"> #login-designer--username, #login-designer--password { margin-bottom: ' + to + 'px; } </style>';

			el =  $( '.login_designer_field_margin_bottom' );

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
			style = '<style class="login_designer_field_border"> #login form .input { border-style: solid; border-width: ' + to + 'px; } </style>';

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
			$( '#login form .input' ).css( 'border-color', to );
		} );
	} );

	// Field border radius.
	wp.customize( 'login_designer[field_radius]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_field_radius"> #login form div .login-designer-event-button, #login form .input { border-radius: ' + to + 'px !important; } </style>';

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

	// Return the field's background color value.
	function fieldBackgroundColor() {
		return wp.customize( 'login_designer[field_bg]' )();
	}

	// Field background color.
	wp.customize( 'login_designer[field_bg]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_field_shadow"> #login form .input { background-color: ' + to + '; box-shadow: ' + fieldBoxShadowInset() + ' 0 0 ' + fieldBoxShadowSize() + 'px rgba(0, 0, 0, ' + fieldBoxShadowOpacity() + '), inset 0 0 0 9999px '+ to +'; } </style>';

			el =  $( '.login_designer_field_shadow' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Field Box Shadow.
	wp.customize( 'login_designer[field_shadow]', function( value ) {
		value.bind( function( to ) {
			var style, shadow_opacity, el;
			style = '<style class="login_designer_field_shadow"> #login form .input { background-color: ' + fieldBackgroundColor() + '; box-shadow: ' + fieldBoxShadowInset() + ' 0 0 ' + to + 'px rgba(0, 0, 0, ' + fieldBoxShadowOpacity() + '), inset 0 0 0 9999px '+ fieldBackgroundColor() +'; } </style>';

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

			style = '<style class="login_designer_field_shadow"> #login form .input { background-color: ' + fieldBackgroundColor() + '; box-shadow: ' + fieldBoxShadowInset() + ' 0 0 ' + fieldBoxShadowSize() + 'px rgba(0, 0, 0, ' + opacity + '), inset 0 0 0 9999px '+ fieldBackgroundColor() +'; } </style>';

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

			style = '<style class="login_designer_field_shadow"> #login form .input { background-color: ' + fieldBackgroundColor() + '; box-shadow: ' + inset + ' 0 0 ' + fieldBoxShadowSize() + 'px rgba(0, 0, 0, ' + fieldBoxShadowOpacity() + '), inset 0 0 0 9999px '+ fieldBackgroundColor() +'; } </style>';

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
			style = '<style class="login_designer_field_font_size"> #login form .input { font-size: ' + to + 'px; } </style>';

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
			$( '#login form .input' ).css( 'color', to );
			$( '#login form .button.wp-hide-pw' ).css( 'color', to );
		} );
	} );

	// Check whether a custom logo image is available.
	function hasLogo() {
		var image = wp.customize( 'login_designer[logo]' )();
		return '' !== image;
	}

	// Return the logo dimensions.
	function LogoWidth() {
		return wp.customize( 'login_designer[logo_width]' )();
	}

	function LogoHeight() {
		return wp.customize( 'login_designer[logo_height]' )();
	}

	// Customize the logo width.
	wp.customize( 'login_designer[logo_width]', function( value ) {

		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_logo">@media screen and (min-width: 600px) { body.login #login-designer-logo, body.login #login h1 a { background-size:' + to + 'px ' + LogoHeight() + 'px !important; } #login-designer-logo, #login-designer-logo-h1, body.login #login h1 a { width: ' + to + 'px !important; height: ' + LogoHeight() + 'px !important; } } } </style>';

			el =  $( '.login_designer_logo' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Customize the logo height.
	wp.customize( 'login_designer[logo_height]', function( value ) {

		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_logo">@media screen and (min-width: 600px) { body.login #login-designer-logo, body.login #login h1 a { background-size:' + LogoWidth() + 'px ' + to + 'px !important; } #login-designer-logo, #login-designer-logo-h1, body.login #login h1 a { width: ' + LogoWidth() + 'px !important; height: ' + to + 'px !important; } } } </style>';

			el =  $( '.login_designer_logo' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Custom logo.
	wp.customize( 'login_designer[logo]', function( value ) {
		value.bind( function( to ) {

			if ( to ) {

				var data = { action: 'get_logo_info', method: 'login_form', };

				$.post( login_designer_script.ajax_url, data, function( response ) {

					// Conduct the relative actions when a logo is uploaded.
					hasLogoAction( response.url, response.width, response.height );

					// Communicate with the logo height and width controls to output the right sizes.
					wp.customize.preview.send( 'logo-sizes', { height: response.height, width: response.width } );

					// console.log( 'Preview response:' + response.height + response.width + response.url );
				});

			} else {
				hasLogoAction( to, null, null );
			}

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
				style = '<style class="login_designer_logo_disable_logo"> #login-designer-logo { display: none !important; } body #login-designer-logo-h1, body #login-designer-logo-h1 #login-designer-logo { height: 0 !important; width: 0 !important; } </style>';
			} else {
				style = '<style class="login_designer_logo_disable_logo"> #login-designer-logo { display: block !important; } #login-designer-logo-h1 { height: ' + LogoHeight() + 'px } </style>';
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
				$( '#login-designer-logo-h1 .login-designer-event-button' ).unwrap();
				$( '#login-designer-logo-h1 .login-designer-event-button' ).addClass( 'customizer-event-overlay' );
			}

		});
	});

	wp.customize( 'login_designer_translations[translation]', function( value ){
		value.bind( function( to ){
			let style, el, template, text;
			text = $( '#login-designer-template' ).text();
			template = ( 'default' === text ) ? 'default' : 'template';
			/**
			 * Custom LoginDesigner Translation Logics
			 * */
			let translator = $( '.language-switcher' ),
				translator_length = translator.length;

			for ( var i = 0; i < translator_length; i++) {
				if ( template === $( translator[ i ] ).attr( 'data-logindesigner-template' ) ) {
					// console.log( $( translator[ i ] ).attr( 'data-logindesigner-template' ) )
					el = $( '.login-designer-disable-translation' );
					if ( to ) {
						style = '<style class="login-designer-disable-translation">.language-switcher { display: none !important; } .language-switcher[data-logindesigner-template="' +$(translator[i]).attr('data-logindesigner-template') + '"] { display: block !important; }</style>';
						$( 'body' ).removeClass( 'login-designer-no-language' );
						$( translator[ i ] ).attr( 'style', 'position:relative;' )
					} else {
						style = '<style class="login-designer-disable-translation">.language-switcher { display: none !important; } .language-switcher[data-logindesigner-template="' +$(translator[i]).attr('data-logindesigner-template') + '"] { display: none !important; }</style>'
						$( 'body' ).addClass( 'login-designer-no-language' );
						$( translator[ i ] ).attr( 'style', 'display:none;position:relative;' )
					}
				}
			}
			if ( el.length ) {
				el.replaceWith( style );
			} else {
				$( 'head' ).append( style );
			}
		} );
	} );

	function hasLogoAction( to, width, height ) {

		var style, element;

		// Output the style changes (for background sizes).
		element =  $( '.login_designer_logo' );

		// If we have a custom logo uploaded.
		if ( hasLogo() ) {

			var
				width  = width / 2,
				height = height / 2;

			// Set the background image of the logo.
			$( '#login-designer-logo' ).css( 'background-image', 'url( ' + to + ')' );

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

		} else {

			// If a logo is removed, fallback to the default WordPress logo + sizes.
			style = '<style class="login_designer_logo">body.login #login h1 a#login-designer-logo { display: block; }  #login-designer-logo-h1, body.login #login h1 a#login-designer-logo { width: 84px !important; height: 84px !important; } #login-designer-logo { height: 84px !important; width: 84px !important; background-size: 84px !important; background-image: none, url(" ' + login_designer_script.admin_url + '/images/wordpress-logo.svg ") !important; } </style>';

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

	live_font_family( 'login_designer[label_font]', '#login form label:not([for=rememberme]), #login .message' );
	live_font_family( 'login_designer[field_font]', '#login form .input' );
	live_font_family( 'login_designer[button_font]', '#login form .submit .button' );
	live_font_family( 'login_designer[remember_font]', '#login .forgetmenot label' );
	live_font_family( 'login_designer[below_font]', '#login #nav, #login #nav a, #login #backtoblog a' );

	// Label font size.
	wp.customize( 'login_designer[label_font_size]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_label_font_size"> #login form label:not([for=rememberme]), #login .message { font-size: ' + to + 'px; } </style>';

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
			$( '#login form label:not([for=rememberme]), #login .message' ).css( 'color', to );
		} );
	} );

	// Label position.
	wp.customize( 'login_designer[label_position]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_label_position">#login form .input { margin-top: ' + to + 'px; } #login form div .login-designer-event-button { top: ' + to + 'px; } </style>';

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
			$( '#login-designer-template' ).text( to );

// if ( ! $( '.login-designer-disable-translation' ).length ) {
			if ('default' === to) {
				$('.login-designer--translation-switcher[data-logindesigner-template=template]').attr('style', 'display: none !important;position:relative;');
				$('.login-designer--translation-switcher[data-logindesigner-template=default]').attr('style', 'display: block !important;position:relative;');
			}
			if ('default' !== to) {
				$('.login-designer--translation-switcher[data-logindesigner-template=default]').attr('style', 'display: none !important;position:relative;');
				$('.login-designer--translation-switcher[data-logindesigner-template=template]').attr('style', 'display: block !important;position:relative;');
			}
// }

			if ( $( 'body' ).hasClass( 'login-designer-no-language' ) ) {
				$( '.language-switcher' ).attr( 'style', 'display:none;' );
			}

			let bodyClass = $( 'body' ).hasClass( 'login-designer-no-language' ) ? 'login-designer-no-language' : '';
			$( 'body.login' ).attr( 'class', 'login login-action-login wp-core-ui locale-en-us login-designer has-template-applied login-designer-template-section-opened customize-partial-edit-shortcuts-shown' );
			$( 'body.login' ).addClass( 'login-designer-template-' + to );
			$( 'body.login' ).addClass( bodyClass );


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
			style = '<style class="login_designer_bg_repeat">body.login, #login-designer-background { background-repeat: ' + to + '; } </style>';

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
			style = '<style class="login_designer_bg_size">body.login, #login-designer-background { background-size: ' + to + '; } </style>';

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

			style = '<style class="login_designer_bg_position">body.login, #login-designer-background { background-position: ' + to + '; } </style>';

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
			style = '<style class="login_designer_bg_attach">body.login, #login-designer-background { background-attachment: ' + to + '; } </style>';

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
			style = '<style class="login_designer_form_shadow"> #login form { box-shadow: 0 0 ' + to + 'px rgba(0, 0, 0, ' + formBoxShadowOpacity() + '); } </style>';

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

			style = '<style class="login_designer_form_shadow"> #login form { box-shadow: 0 0 ' + formBoxShadowSize() + 'px rgba(0, 0, 0, ' + opacity + '); } </style>';

			el =  $( '.login_designer_form_shadow' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	wp.customize( 'login_designer[username_label]', function( value ) {
		value.bind( function( to ) {

			$( '#login-designer--username-label #login-designer--username-label-text' ).html( to );

			if ( to ) {
				$( '#loginform' ).removeClass( 'no-label' );
			} else {
				$( '#loginform' ).addClass( 'no-label' );
			}

		} );
	} );

	wp.customize( 'login_designer[password_label]', function( value ) {
		value.bind( function( to ) {
			$( '#login-designer--password-label #login-designer--password-label-text' ).html( to );
		} );
	} );

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
			style = '<style class="login_designer_form_bg"> body.login #login form, body.login-designer-template-01 #login, body.login-designer-template-04 #login { background-color: ' + to + ' !important; } </style>';

			el =  $( '.login_designer_form_bg' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}

			$( 'body.login #login form, body.login-designer-template-01 #login, body.login-designer-template-04 #login' ).css( 'background-color', to );
		} );
	} );

	// Return the form background color.
	function formBackgroundColor() {
		return wp.customize( 'login_designer[form_bg]' )();
	}

	function formBackgroundTransparency() {
		return wp.customize( 'login_designer[form_bg_transparency]' )();
	}

	// Login form background transparency.
	wp.customize( 'login_designer[form_bg_transparency]', function( value ) {
		value.bind( function( to ) {

			var style, el;

			el =  $( '.login_designer_form_bg' );

			if ( true === to ) {
				style = '<style class="login_designer_form_bg">body.login #login form, body.login-designer-template-01 #login, body.login-designer-template-04 #login { background: none !important; } </style>';
			} else {
				style = '<style class="login_designer_form_bg">#login form, .login-designer-template-01 #login, .login-designer-template-04 #login { background-color: ' + formBackgroundColor() + ' ; } </style>';
			}

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Login form border radius.
	wp.customize( 'login_designer[form_radius]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_form_radius"> body.login #login form { border-radius: ' + to + 'px; } </style>';

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
			var style, el;
			style = '<style class="login_designer_form_width"> body.login #login { max-width: ' + to + 'px; } </style>';

			el =  $( '.login_designer_form_width' );

			if ( el.length ) {
				el.replaceWith( style ); // style element already exists, so replace it
			} else {
				$( 'head' ).append( style ); // style element doesn't exist so add it
			}
		} );
	} );

	// Form padding: left/right.
	wp.customize( 'login_designer[form_side_padding]', function( value ) {
		value.bind( function( to ) {
			var style, el;
			style = '<style class="login_designer_form_side_padding"> body.login #login form { padding-left: ' + to + 'px; padding-right: ' + to + 'px; } </style>';

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
			style = '<style class="login_designer_form_vertical_padding"> body.login #login form { padding-top: ' + to + 'px; padding-bottom: ' + to + 'px; } </style>';

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

	wp.customize( 'login_designer_google_recaptcha[recaptcha_version]', function( value ) {
		value.bind( function( to ) {
			jQuery( '#test-recaptcha', window.parent.document ).removeAttr( 'disabled' ).show();
			jQuery( '#validate-recaptcha', window.parent.document ).remove();

			if ( 2 === parseInt( to ) ) {
				jQuery( '#recaptcha-validation-success', window.parent.document ).html( '<p>Please complete the reCaptcha on the right screen and press validate and save.</p>' );
				jQuery( '#test-recaptcha', window.parent.document ).text( 'Render Recaptcha' );
			} else {
				jQuery( '#recaptcha-validation-success', window.parent.document ).empty();
				jQuery( '#test-recaptcha', window.parent.document ).text( 'Validate and Save' );
			}
		} );
	} );

	wp.customize( 'login_designer_google_recaptcha[google_recaptcha_api_key]', function( value ) {
		value.bind( function( to ) {
			jQuery( '#test-recaptcha', window.parent.document ).removeAttr( 'disabled' ).show();
			jQuery( '#validate-recaptcha', window.parent.document ).remove();
		} );
	} );

	wp.customize( 'login_designer_google_recaptcha[google_recaptcha_secrete_key]', function( value ) {
		value.bind( function( to ) {
			jQuery( '#test-recaptcha', window.parent.document ).removeAttr( 'disabled' ).show();
			jQuery( '#validate-recaptcha', window.parent.document ).remove();
		} );
	} );

	$.each( [
		'login_designer[username_label]',
		'login_designer[field_font]',
		'login_designer[remember_font]',
		'login_designer[button_font]',
		'login_designer[below_font]',
	], function( _index_, _control_ ) {
		wp.customize( _control_, function( _value_ ) {
			_value_.bind( function( _to_ ) {
				if ( 'default' === _to_ ) {
					return;
				}

				$( '#login-designer-localize-google-fonts', window.parent.document ).removeAttr( 'disabled' );
			} );
		} );
	} );

} )( jQuery );
