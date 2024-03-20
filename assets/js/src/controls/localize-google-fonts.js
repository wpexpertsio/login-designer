( function( $, api ) {
    api.controlConstructor['login-designer-localize-google-fonts'] = api.Control.extend( {
        ready() {
            var control = this;

            control.container.on( 'click', '#login-designer-localize-google-fonts', function( e ) {
                e.preventDefault();
                var button_control = this;

                $( button_control ).attr( 'disabled', 'disabled' );
                $( '#login-designer-google-fonts-spinner' ).addClass( 'is-active' )

                $.post( ajaxurl, {
                    action: 'login_designer_localize_google_fonts',
                    _wpnonce: login_designer_google_fonts._wpnonce,
                }, function( response ) {
                    $( button_control ).removeAttr( 'disabled' );
                    $( '#login-designer-google-fonts-spinner' ).removeClass( 'is-active' );

                    $( '#login-designer-google-fonts-response' ).empty().append( $( '<div class="notice notice-success"><p>Fonts imported successfully</p></div>' ) )
                } ).fail( function( response ) {
                    $( button_control ).removeAttr( 'disabled' );
                    $( '#login-designer-google-fonts-spinner' ).removeClass( 'is-active' );
                    $( '#login-designer-google-fonts-response' ).empty().append( $( '<div class="notice notice-error"><p>Got an error while importing fonts</p></div>' ) )
                } );
            } );
        }
    } );
} )( jQuery, wp.customize );