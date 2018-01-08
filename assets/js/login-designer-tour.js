/**
 * Customizer Live Events.
 */
( function ( $ ) {
	"use strict";

introJs().addHints();

// introJs().setOptions({
//     hints: [
//         { hint: 'First hint', element: '#login-designer--username-label' },
//         { hint: 'Second hint', element: '#login-designer--password', hintAnimation: false }
//     ]
// });


	// introJs().addHints();

	// $( '#hints' ).on( 'click', function( e ) {
	// 	e.preventDefault();

	// 	if ( $(this).hasClass( 'hints--active' ) ) {
	// 		$(this).removeClass( 'hints--active' );
	// 		introJs().removeHints();
	// 	} else {
	// 		$(this).addClass( 'hints--active' );
	// 		introJs().addHints();
	// 	}
	// });

} )( jQuery );
