( function ( $ ) {

	$( document ).ready( function ( $ ) {

		$( '#layout-switcher' ).on( 'click', function (e) {

			e.preventDefault();

			$('.layout-switcher__wrapper').toggleClass( 'open' );

			if ( $( this ).text() === login_designer_script.btn_default ) {
				$( this ).text( login_designer_script.btn_close );
			} else {
				$( this ).text( login_designer_script.btn_default );
			}

		} );

	} );

} ) ( jQuery );
