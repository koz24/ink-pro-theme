/**
 * Includes all the logic to manage the page builder backend
 *
 */
var InkproAdmin = InkproAdmin || {},
	InkproParams = InkproParams || {},
	InkproAdminParams = InkproAdminParams || {},
	console = console || {},
	WPBAdminParams = WPBAdminParams || {};

/* jshint -W062 */
InkproAdmin = function ( $ ) {

	'use strict';

	return {

		init : function () {
			this.subHeadingfield();
		},

		subHeadingfield : function()  {
			$( 'input#_post_subheading' ).parents( 'tr' )
				.hide()
				.find( 'input' )
				.attr( { 'tabindex': 1, 'placeholder' : InkproAdminParams.subHeadingPlaceholder } )
				.css( {
					'width' : '100%'
				} )
				.insertAfter( $( '#title' ) );
		},

		/**
		 * Colorpicker
		 */
		colorPicker : function () {

			if ( typeof $.wp !== 'undefined' && typeof $.wp.wpColorPicker !== 'undefined') {
				$.wp.wpColorPicker.prototype.options = {
					// add your custom colors here
					// WPBAdminParams.defaultPalette
					palettes: [
						'#000000', // black
						'#FFFFFF', // white
						'#ecad81', // orange
						'#79bc90', // green
						'#63a69f',
						'#7e8aa2',
						'#c84564',
						'#49535a',
						'#C74735',
						'#e6ae48',
						'#046380'
					]
				};
			}
		}
	};

}( jQuery );

;( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		InkproAdmin.init();
	} );

} )( jQuery );