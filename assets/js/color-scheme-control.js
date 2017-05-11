/* global colorScheme, Color */
/**
 * Add a listener to the Color Scheme control to update other color controls to new values/defaults.
 * Also trigger an update of the Color Scheme CSS when a color is changed.
 */

;( function( api, $ ) {

	var cssTemplate = wp.template( 'inkpro-color-scheme' ),

		colorSettings = [
			'body_background_color',
			'page_background_color',
			'accent_color',
			'main_text_color',
			'secondary_text_color',
			'strong_text_color',
			'submenu_background_color',
			'entry_content_background_color',
			'product_tabs_background_color',
			'product_tabs_text_color'
		];

	api.controlConstructor.select = api.Control.extend( {

		ready: function() {

			if ( 'color_scheme' === this.id ) {

				this.setting.bind( 'change', function( value ) {

					var colors = colorScheme[value].colors;

					$.each( colorSettings, function( index, setting ) {
						//console.log( index + ": " + value );
						//console.log( colors[index] );

						if ( 'undefined' !== typeof api( setting ) ) {

							var color = colors[index];
							api( setting ).set( color );
							api.control( setting ).container.find( '.color-picker-hex' )
								.data( 'data-default-color', color )
								.wpColorPicker( 'defaultColor', color );
						} else {
							//console.log( 'nope' );
						}
					} );
				} );
			}
		}
	} );

	// Generate the CSS for the current Color Scheme.
	function updateCSS() {
		
		var scheme = api( 'color_scheme' )(),
			css,
			colors = _.object( colorSettings, colorScheme[ scheme ].colors );

		// Merge in color scheme overrides.
		_.each( colorSettings, function( setting ) {
			if ( 'undefined' !== typeof api( setting ) ) {
				colors[ setting ] = api( setting )();
			}
		} );

		// Add additional color.
		// jscs:disable
		colors.border_color = Color( colors.main_text_color ).toCSS( 'rgba', 0.15 );
		// jscs:enable

		css = cssTemplate( colors );

		api.previewer.send( 'update-color-scheme-css', css );
	}

	// Update the CSS whenever a color setting is changed.
	_.each( colorSettings, function( setting ) {
		api( setting, function( setting ) {
			setting.bind( updateCSS );
		} );
	} );
} )( wp.customize, jQuery );
