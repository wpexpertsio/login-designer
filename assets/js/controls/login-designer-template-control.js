( function ( $ ) {

	$( document ).ready( function ( $ ) {

		$( '#layout-switcher' ).on( 'click', function (e) {

			e.preventDefault();

			$('.login-designer-templates-wrapper').toggleClass( 'open' );

			if ( $( this ).text() === login_designer_custom_controls.btn_default ) {
				$( this ).text( login_designer_custom_controls.btn_close );
			} else {
				$( this ).text( login_designer_custom_controls.btn_default );
			}

		} );

	} );

} ) ( jQuery );
