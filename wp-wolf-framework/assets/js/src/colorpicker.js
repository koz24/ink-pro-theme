/**
 *  Colorpicker
 */
var WolfThemeAdminParams =  WolfThemeAdminParams || {};

;( function( $ ) {

	'use strict';

	var colorpickerOptions = {

		palettes: WolfThemeAdminParams.defaultPalette
	};

	if ( {} !== WolfThemeAdminParams && WolfThemeAdminParams.defaultPalette ) {
		$( '.inkpro-options-colorpicker' ).wpColorPicker( colorpickerOptions );
	} else {
		$( '.inkpro-options-colorpicker' ).wpColorPicker();
	}

} )( jQuery );