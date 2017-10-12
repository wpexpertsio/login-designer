( function ( $ ) {

	$( document ).ready( function ( $ ) {

		$( '.layout-switcher' ).on( 'click', function (e) {

			e.preventDefault();

			$('.layout-switcher__wrapper').toggleClass( 'open' );

			if ( $( this ).text() === 'Switch Template' ) {
				$( this ).text( 'Close' );
			}

			else {
				$(this).text( 'Install New Template' );
			}

		});

	});

} ) ( jQuery );
