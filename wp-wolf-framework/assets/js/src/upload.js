/**
 *  Upluad using the media library
 */
var WolfAdminParams =  WolfAdminParams || {};

;( function( $ ) {

	'use strict';

	$( document ).on( 'click', '.inkpro-options-set-img, .inkpro-options-set-bg', function( e ) {
		e.preventDefault();
		var $el = $( this ).parent();
		var uploader = wp.media({
			title : WolfAdminParams.chooseImage,
			library : { type : 'image'},
			multiple : false
		} )
		.on( 'select', function(){
			var selection = uploader.state().get('selection');
			var attachment = selection.first().toJSON();
			$('input', $el).val(attachment.id);
			$('img', $el).attr('src', attachment.url).show();
		} )
		.open();
	} );


	$( document ).on( 'click', '.inkpro-options-set-file', function(e){
		e.preventDefault();
		var $el = $( this ).parent();
		var uploader = wp.media({
			title : WolfAdminParams.chooseFile,
			multiple : false
		} )
		.on( 'select', function(){
			var selection = uploader.state().get('selection');
			var attachment = selection.first().toJSON();
			$('input', $el).val(attachment.url);
			$('span', $el).html(attachment.url).show();
		} )
		.open();
	} );

	$( document ).on( 'click', '.inkpro-options-set-video-file', function(e){
		e.preventDefault();
		var $el = $( this ).parent();
		var uploader = wp.media({
			title : WolfAdminParams.chooseFile,
			library : { type : 'video'},
			multiple : false

		} )
		.on( 'select', function(){
			var selection = uploader.state().get('selection');
			var attachment = selection.first().toJSON();
			$('input', $el).val(attachment.url);
			$('span', $el).html(attachment.url).show();
		} )
		.open();
	} );


/*-----------------------------------------------------------------------------------*/
/*	Reset Image preview
/*-----------------------------------------------------------------------------------*/

	$( document ).on( 'click', '.inkpro-options-reset-img, .inkpro-options-reset-bg', function(){

		$( this ).parent().find('input').val('');
		$( this ).parent().find('.inkpro-options-img-preview').hide();
		return false;

	} );

	$( document ).on( 'click', '.inkpro-options-reset-file', function(){

		$( this ).parent().find('input').val('');
		$( this ).parent().find('span').empty();
		return false;

	} );

	/* Tipsy */
	$( '.hastip' ).tipsy( { fade: true, gravity: 's' } );

} )( jQuery );
