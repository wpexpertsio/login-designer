/**
 * Scripts within the customizer controls window.
 *
 * Contextually shows the color hue control and informs the preview
 * when users open or close the front page sections section.
 */

(function() {
	wp.customize.bind( 'ready', function() {

		// Detect when the front page sections section is expanded (or closed) so we can adjust the preview accordingly.
		wp.customize.panel( 'login_designer', function( section ) {
			section.expanded.bind( function( isExpanding ) {

				// Value of isExpanding will = true if you're entering the section, false if you're leaving it.
				wp.customize.previewer.send( 'login-designer-url-switcher', { expanded: isExpanding });

			} );
		} );

		// Add a body class based on the current template.
		wp.customize( 'login_designer__template-selector', function( value ) {
			value.bind( function( to ) {

				if ( '01' === to ) {
					color = '#00F';
				} else if ( to === '02' ) {
					color = '#F00';
				} else {
					color = '#f1f1f1';
				}

				// If we have a custom background color, let's put it back to default.
				// @todo In the future, maybe we'll make this color change based on the template's default background color.
				wp.customize( 'login_designer_body_bg_color' ).set( color );
			} );
		} );
	});
})( jQuery );
