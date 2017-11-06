( function ( $ ) {

	$( document ).ready( function ( $ ) {

		$( '#gallery-button' ).on( 'click', function (e) {

			e.preventDefault();

			$( '#login-designer-gallery' ).toggleClass( 'open' );
			$( '#customize-control-login_designer[bg_image]' ).toggleClass( 'gallery-is-open' );
			$( '#customize-control-login_designer[bg_image_gallery]' ).toggleClass( 'gallery-is-open' );

			if ( $( this ).text() === 'Open Gallery' ) {
				$( this ).text( 'Close' );
			}

			else {
				$(this).text( 'Open Gallery' );
			}

		});

	});

} ) ( jQuery );
