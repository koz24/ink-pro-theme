/**
 *  Admin notices
 */
;( function( $ ) {

	'use strict';

	$( '.wolf-dismiss-admin-notice' ).click( function( event ) {

		event.preventDefault();
		
		var message = $( this ),
			cookieID = message.attr( 'id' );

		if ( cookieID ) {
			$.cookie( cookieID,  "false", { path: '/', expires: 7 } );
			$( this ).parent().parent().slideUp();
		}
	} );
} )( jQuery );