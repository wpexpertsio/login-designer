/**
 *
 */

( function( wp, $ ){
    if ( ! wp || ! wp.customize ) {
        return;
    }

    var
        api = wp.customize, passwordProtectedOldPreview;
    api.PasswordProtectedCustomizerPreview = {
        init() {
            var self = this;

            this.preview.bind( 'active', function(){
                var
                    $document                  = $( document ),
                    $logo                      = $( '#password-protected-logo' ),
                    $password_label            = $( '#password-protected--password-label' ),
                    $password_field            = $( '#password_protected_field_customizer' ),
                    $submit_btn                = $( '#password-protected-submit-btn' ),
                    $remember_me               = $( '#password-protected-forgetmenot' ),
                    $remember_me_cb            = $( '#password-protected-forgetmenot label' ),
                    $text_above_password_field = $( '.password-protected-text-above' ),
                    $text_below_password_field = $( '.password-protected-text-below' );

                $logo.append( `<button class="password-protected-event-button customizer-event-overlay" data-password-protected-customizer-event="password-protected-edit-logo"></button>` );
                $password_label.append( `<button class="password-protected-event-button customizer-event-overlay" data-password-protected-customizer-event="password-protected-edit-label"></button>` );
                $password_field.append( `<button class="password-protected-event-button customizer-event-overlay" data-password-protected-customizer-event="password-protected-edit-field"></button>` );
                $submit_btn.append( `<button class="password-protected-event-button customizer-event-overlay" data-password-protected-customizer-event="password-protected-edit-button"></button>` );
                $remember_me_cb.append( `<button class="password-protected-event-button customizer-event-overlay" data-password-protected-customizer-event="password-protected-edit-rememberme-checkbox"></button>` );
                $remember_me.append( `<button class="password-protected-event-button customizer-event-overlay" data-password-protected-customizer-event="password-protected-edit-rememberme-label"></button>` );
                $text_above_password_field.append( `<button class="password-protected-event-button customizer-event-overlay" data-password-protected-customizer-event="password-protected-edit-text-above"></button>` );
                $text_below_password_field.append( `<button class="password-protected-event-button customizer-event-overlay" data-password-protected-customizer-event="password-protected-edit-text-below"></button>` );

                $document.on( 'touch, click', '.password-protected-event-button', function( e ){
                    var $this = $( this );
                    self.preview.send( $this.attr( 'data-password-protected-customizer-event' ) );
                } );
            } );
        }
    };

    passwordProtectedOldPreview = api.Preview;
    api.Preview = passwordProtectedOldPreview.extend( {
        initialize( params, options ) {
            api.PasswordProtectedCustomizerPreview.preview = this;
            passwordProtectedOldPreview.prototype.initialize.call( this, params, options );
        }
    } );

    $( function(){
        api.PasswordProtectedCustomizerPreview.init();
    } );
} )( window.wp, jQuery );