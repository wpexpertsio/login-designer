( function ( $ ) {

	$( document ).ready( function ( $ ) {

		$( 'input[data-input-type]' ).on('input change', function () {
			var val = $( this ).val();
			$( this ).prev( '.value' ).find('span' ).html( val );
			$( this ).val( val );
		});

		$( '.range-reset' ).on( 'click', function () {
			var
			input = $( this ).prev( $( 'input[data-input-type]' ) ),
			defaultvalue = input.data('default-value');

			input.val( defaultvalue );

			var val = input.val();
			input.prev('.value').find( 'span' ).html( val );
			input.val( val );
			input.change();
		});

	});

} ) ( jQuery );
