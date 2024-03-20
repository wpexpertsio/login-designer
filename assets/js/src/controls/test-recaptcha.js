( function( $, api ) {
    api.controlConstructor['login-designer-test-recaptcha'] = api.Control.extend( {
        ready() {
            let control = this;

            control.container.on( 'click', '#test-recaptcha', function( e ) {
                $( this ).attr( 'disabled', 'disabled' );
                e.preventDefault();
                let site_key, secret_key, version;
                secret_key = wp.customize( 'login_designer_google_recaptcha[google_recaptcha_secrete_key]' ).get();
                site_key   = wp.customize( 'login_designer_google_recaptcha[google_recaptcha_api_key]' ).get();
                version    = wp.customize( 'login_designer_google_recaptcha[recaptcha_version]' ).get();
                version    = parseInt( version );
                if ( ! site_key.trim().length || ! secret_key.trim().length ) {
                    alert( 'Both fields are required' );
                    return;
                }

                if ( 2 === version ) {
                    $( this ).hide();
                    control.container.append( '<button class="button button-secondary" id="validate-recaptcha">Validate and Save Re-Captcha</button>' );
                }

                control.setting.set( { version: version, site_key: site_key, secret_key: secret_key, verified: false } );
            } );

            $( document ).on( 'click', '#validate-recaptcha', function( e ) {
                e.preventDefault();
                let site_key, secret_key, version;

                secret_key   = wp.customize( 'login_designer_google_recaptcha[google_recaptcha_secrete_key]' ).get();
                site_key = wp.customize( 'login_designer_google_recaptcha[google_recaptcha_api_key]' ).get();
                version    = wp.customize( 'login_designer_google_recaptcha[recaptcha_version]' ).get();
                version    = parseInt( version );
                let recaptcha_response;
                recaptcha_response = $( '#g-recaptcha-response', $( 'iframe' ).contents() ).val();
                let data = {
                    recaptcha_response : recaptcha_response,
                    secret_key         : secret_key,
                    _wpnonce           : login_designer_recaptcha_object._wpnonce,
                    site_key           : site_key,
                    version            : version,
                    method             : 'validate_site_key',
                    action             : 'login_designer_validate_recaptcha_v2',
                };
                let element = this;
                jQuery.post( ajaxurl, data, function( response ) {
                    $( element ).remove();
                    jQuery( '#recaptcha-validation-success' ).html( `<p>${response.data.message}</p>` ).addClass( 'notice-success' ).removeClass( 'notice-error' );
                } )
                    .fail( function( response ) {
                        $( element ).remove();
                        $( '#test-recaptcha' ).show();
                        jQuery( '#recaptcha-validation-success' ).html( `<p>${response.responseJSON.data.message}</p>` ).addClass( 'notice-error' ).removeClass( 'notice-success' );
                    } );
            } );
        }
    } );
} )( jQuery, wp.customize );