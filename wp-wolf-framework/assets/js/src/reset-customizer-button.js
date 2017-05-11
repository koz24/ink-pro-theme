/**
 *  Reset theme mods button
 */
;( function( $ ) {

	'use strict';

	var $container = $( '#customize-header-actions' );

	var $button = $( '<button id="wolf-mods-reset" class="button-secondary button">' )
		.text( WolfAdminParams.resetModsText )
		.css( {
		'float': 'right',
		'margin-right': '10px',
		'margin-top': '9px'
	} );

	$button.on( 'click', function ( event ) {

		event.preventDefault();

		var data = {
			wp_customize: 'on',
			action: 'wolf_ajax_customizer_reset',
			nonce: WolfAdminParams.nonce.reset
		};

		var r = confirm( WolfAdminParams.confirm );

		if ( ! r ) {
			return;
		}

		$button.attr( 'disabled', 'disabled' );

		$.post( ajaxurl, data, function ( response ) {

			if ( 'OK' === response ) {
				wp.customize.state( 'saved' ).set( true );
				location.reload();
			}
		} );
	} );

	$button.insertAfter( $container.find( '.button-primary.save' ) );
} )( jQuery );