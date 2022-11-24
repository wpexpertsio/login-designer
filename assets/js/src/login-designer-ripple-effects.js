(function( $, $d, $w, variable ){
    $( '#rememberme' ).on( 'click', function( e ){
        e.preventDefault();
    } );
    $( '#login-designer--username-label' ).hover( function(){
        $( '#login-designer-username-hover' ).css( 'opacity', '100%' );
    }, function(){
        $( '#login-designer-username-hover' ).css( 'opacity', '0' );
    } );
    $( '#login-designer--password-label' ).hover( function(){
        $('#login-designer-password-hover').css( 'opacity', '100%' );
    }, function(){
        $('#login-designer-password-hover').css( 'opacity', '0' );
    } );
    $( '.login-designer--form-footer' ).hover( function(){
        $( '#login-designer-remember-hover' ).css( 'opacity', '100%' );
        $( '#login-designer-remember-label-hover' ).css( 'opacity', '100%' );
    }, function(){
        $( '#login-designer-remember-hover' ).css( 'opacity', '0' );
        $( '#login-designer-remember-label-hover' ).css( 'opacity', '0' );
    } );
    $( '#login-designer--button' ).hover( function(){
        $( '#login-designer-submit-hover' ).css( 'opacity', '100%' );
    }, function(){
        $( '#login-designer-submit-hover' ).css( 'opacity', '0' );
    } );
    $( '#login-designer--username' ).hover( function(){
        $( '#login-designer-username-field-hover' ).css( 'opacity', '100%' );
    }, function(){
        $( '#login-designer-username-field-hover' ).css( 'opacity', '0' );
    } );
    $( '#login-designer--password' ).hover( function(){
        $( '#login-designer-password-field-hover' ).css( 'opacity', '100%' );
    }, function(){
        $( '#login-designer-password-field-hover' ).css( 'opacity', '0' );
    } );
    $( '#login-designer--below-form' ).hover( function(){
        $( '#login-designer-bellow-form-field-hover' ).css( 'opacity', '100%' );
    }, function(){
        $( '#login-designer-bellow-form-field-hover' ).css( 'opacity', '0' );
    } );
    $( '#login-designer-logo-h1' ).hover( function(){
        $( '#login-designer--ripple-effect-logo' ).css( 'opacity', '100%' );
    }, function(){
        $( '#login-designer--ripple-effect-logo' ).css( 'opacity', '0' );
    } );
    $( '#user_login, #user_pass' ).on( 'click', function( e ){
        e.preventDefault();
    } );
    $( '#login-designer-username-hover' ).on( 'click', function(){
        $( this ).parent().next()[0].click();
    } );
    $( '#login-designer-password-hover' ).on( 'click', function(){
        $( this ).parent().next()[0].click();
    } );
    $( '#login-designer-username-field-hover' ).on( 'click', function(){
        $( this ).next().next()[0].click();
    } );
    $( '#login-designer-password-field-hover' ).on( 'click', function(){
        $( this ).next().next().next()[0].click();
    } );
    $( '#login-designer-remember-hover' ).on( 'click', function(){
        $( this ).next().next().next()[0].click();
    } );
    $( '#login-designer-submit-hover' ).on( 'click', function(){
        $( this ).next().next()[0].click();
    } );
    $( '#login-designer-bellow-form-field-hover' ).on( 'click', function(){
        $( this ).next().next().next()[0].click();
    } );
    $( '#login-designer-remember-label-hover' ).on( 'click', function(){
        $( this ).parent().next()[0].click();
    } );
    $( '#login-designer--ripple-effect-logo' ).on( 'click', function(){
        $( this ).next()[0].click();
    } );
    $( '#language-switcher' ).on( 'submit', function( e ){
        e.preventDefault();
    } );
}( jQuery, document, window ));