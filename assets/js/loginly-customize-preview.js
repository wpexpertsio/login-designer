/**
 * This file adds some LIVE to the Theme Customizer live preview. To leverage
 * this, set your custom settings to 'postMessage' and then add your handling
 * here. This javascript will grab settings from customizer controls, and 
 * then make any necessary changes to the page using jQuery.
 */
 
( function( $ ) {

	function loginly_css_property( setting, target, property ) {
		wp.customize( setting, function( value ) {
			value.bind( function( loginPressVal ) {
				if ( loginPressVal == '' ) {
					$( '#customize-preview iframe' ).contents().find( target ).css( property, '' );
				} else {
					$( '#customize-preview iframe' ).contents().find( target ).css( property, loginPressVal );
				}
			} );
		} );
	}

	loginly_css_property('loginly__custom-logo-maxwidth', '#login h1 a', 'width' );

	$(window).on('load', function() {
	    $("<style type='text/css' id='loginly-customize'></style>").appendTo( $('#customize-preview iframe').contents().find('head') );
	});

} )( jQuery );





(function ( api ) {
	
    api.panel( 'loginly__panel', function( section ) {
        var previousUrl, clearPreviousUrl, previewUrlValue;
        previewUrlValue = api.previewer.previewUrl;
        clearPreviousUrl = function() {
            previousUrl = null;
        };
 
        section.expanded.bind( function( isExpanded ) {
            var url;
            if ( isExpanded ) {
                url = api.settings.url.home;
                previousUrl = previewUrlValue.get();
                previewUrlValue.set( url );
                previewUrlValue.bind( clearPreviousUrl );
            } else {
                previewUrlValue.unbind( clearPreviousUrl );
                if ( previousUrl ) {
                    previewUrlValue.set( previousUrl );
                }
            }
        } );
    } );
} ( wp.customize ) );