/**
 *
 *
 *
 *
 */

( function( $ ){
    wp.customize.bind( 'ready', function(){

        wp.customize.panel( 'password_protected', function( section ){
            section.expanded.bind( function( isExpanding ){
                if ( isExpanding ) {
                    let current_url = wp.customize.previewer.previewUrl();
                    current_url = current_url.includes( password_protected_controls.password_protected_page );

                    if ( ! current_url ) {
                        wp.customize.previewer.send( 'password-protected-url-switcher', { expanded: isExpanding } );
                    }
                } else {
                    wp.customize.previewer.send( 'password-protected-back-to-home', { home_url: wp.customize.settings.url.home } );
                    url = wp.customize.settings.url.home;
                }
            } );
        } );

        wp.customize.section( 'password_protected__section--styles', function( section ){
            section.expanded.bind( function( isExpanding ){
                if ( isExpanding ) {
                    $( '#customize-header-actions' ).addClass( 'style-editor-open' );
                } else {
                    $( '#customize-header-actions' ).removeClass( 'style-editor-open' );
                }
            } );
        } );

        wp.customize.previewer.bind( 'pp-logo-sizes', function( data ){
            let
                width,
                height;

            if ( data.height ) {
                height = parseInt( data.height/2 );
                wp.customize( 'password_protected[logo_height]' ).set( height );
            }

            if ( data.width ) {
                width = parseInt( data.width/2 );
                wp.customize( 'password_protected[logo_width]' ).set( width );
            }
        } );

        wp.customize.previewer.bind( 'logo-sizes-fallback', function( data ){
            var
                width,
                height;

            if ( data.height ) {
                height = data.height;
                wp.customize( 'password_protected[logo_height]' ).set( height );
            }

            if ( data.width ) {
                width = data.width;
                wp.customize( 'password_protected[logo_width]' ).set( width );
            }
        } );
    } );
} )( jQuery );