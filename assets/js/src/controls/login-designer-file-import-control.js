( function( $ ){
    $( document ).ready( function(){
        let element, textareaVal, copyTextFromTextarea;

        $( '.login-designer-snackbar-close' ).on( 'click', function( e ){
            e.preventDefault();

            $( '.login-designer-snackbar-hide-2000' ).hide();
        } );

        copyTextFromTextarea = ( object ) => {
            object.select();
            document.execCommand( 'copy' );
            return $( object ).val();
        };

        $( '#login-customizer-export-btn' ).on( 'click', function( e ){
            e.preventDefault();

            element = $( this ).attr( 'data-login-designer-export-element' );
            $( element ).show( 'slow' );
            $( '#login-designer-import-container' ).hide( 'slow' );

            $.get( ajaxurl, { method: 'get_latest_json', _wpnonce: login_designer_file_import_object.nonce, action: 'login_designer_import_json' }, function( response ){
                textareaVal = $( '#login-designer-export-textarea' ).val( response.data.jsonContent );
            } );
        } );

        $( '#login-designer-export-btn' ).on( 'click', function( e ){
            e.preventDefault();

            element = $( this ).attr( 'data-login-designer-copy-element' );
            textareaVal = copyTextFromTextarea( $( element ) );

            $( '.login-designer-snackbar-hide-2000' ).show();

            setTimeout( function(){
                $( '.login-designer-snackbar-hide-2000' ).hide(  );
            }, 2000);
        } );

        $( '#login-customizer-import-btn' ).on( 'click', function( e ){
            e.preventDefault();

            element = $( this ).attr( 'data-login-designer-import-element' );
            $( element ).show( 'slow' );
            $( '#login-designer-export-container' ).hide( 'slow' );
        } );

        $( '#login-designer-import-btn' ).on( 'click', function( e ){
            e.preventDefault();

            element = $( this ).attr( 'data-login-designer-import-json-element' );
            textareaVal = $( element ).val();

            $.post( ajaxurl, { method: 'import', _wpnonce: login_designer_file_import_object.nonce, jsonFile: textareaVal, action: 'login_designer_import_json' }, function( response ){
                window.location.href = window.location.href;
            } );
        } );
    } );
}( jQuery ) );