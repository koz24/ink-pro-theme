/*!
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Things like site title, description, and background color changes.
 *
 * InkPro 2.0.3 
 */

 var console = console || {};

;( function( $ ) {

	'use strict';

	/**
	 * Background
	 */
	var style = $( '#inkpro-color-scheme-css' ),
		api = wp.customize,
		backgrounds = {
		'light_background' : '.wpb-font-dark',
		'dark_background' : ' .wpb-font-light',
		'footer_bg' : '.sidebar-footer',
		'bottom_bar_bg' : '.site-infos',
		'music_network_bg' : '.music-social-icons-container'
	},

	options = [ 'repeat', 'position', 'attachment' ];

	if ( ! style.length ) {
		style = $( 'head' ).append( '<style type="text/css" id="inkpro-color-scheme-css" />' )
			.find( '#inkpro-color-scheme-css' );
	}

	$.each( backgrounds, function( key, bg ) {

		$.each( options, function( k, o ) {

			wp.customize( key + '_' + o, function( value ) {

				value.bind( function( to ) {

					var prop = 'background-' + o;
					$( bg ).css( prop , to );
				} );
			} );
		} );

		/* Size
		---------------*/
		wp.customize( key + '_size', function( value ) {

			value.bind( function( to ) {

				if ( to === 'resize' ) {

					$( bg ).css( {
						'background-size' : '100% auto',
						'-webkit-background-size' : '100% auto',
						'-moz-background-size' : '100% auto',
						'-o-background-size' : '100% auto'
					} );

				} else {

					$( bg ).css( {
						'background-size' : to,
						'-webkit-background-size' : to,
						'-moz-background-size' : to,
						'-o-background-size' : to
					} );
				}
			} );
		} );
	} ); // end for each background

	// Color Scheme CSS.
	api.bind( 'preview-ready', function() {
		api.preview.bind( 'update-color-scheme-css', function( css ) {
			style.html( css );
		} );
	} );

	// Add has-header-image body class when background image is added.
	api( 'header_image', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).toggleClass( 'has-default-header', '' !== to );
		} );
	} );

	// Main skin
	api( 'color_scheme', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)skin-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'skin-' + to );
			$( window ).trigger( 'resize' );
		} );
	} );

	// Site layout
	api( 'site_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)site-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'site-layout-' + to );
			$( window ).trigger( 'resize' );
		} );
	} );

	/* Button
	-------------------------------------------*/
	api( 'button_style', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)button-style-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'button-style-' + to );
		} );
	} );

	/* Menu
	-------------------------------------------*/
	api( 'menu_width', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-width-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-width-' + to );
		} );
	} );

	api( 'menu_centered_alignment', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-centered-alignment-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-centered-alignment-' + to );
		} );
	} );

	api( 'menu_bottom_style', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-bottom-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-bottom-' + to );
		} );
	} );

	api( 'menu_hover_style', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)menu-hover-style-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'menu-hover-style-' + to );
		} );
	} );

	api( 'submenu_width', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)submenu-width-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'submenu-width-' + to );
		} );
	} );

	/* Blog
	-------------------------------------------*/

	// Blog layout
	api( 'blog_layout', function( value ) {
		value.bind( function( to ) {
			
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)blog-layout-\S+/g) || [] ).join(' ');
			} );

			$( 'body' ).addClass( 'blog-layout-' + to );
			if ( $( 'body' ).hasClass( 'blog-layout-masonry' ) ) {
				$( '#content' ).isotope( 'reloadItems' ).isotope();
			}
			$( window ).trigger( 'resize' );
		} );
	} );

	// Blog grid padding
	api( 'blog_grid_padding', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)blog-grid-padding-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'blog-grid-padding-' + to );
		} );
	} );

	/* Portfolio
	-------------------------------------------*/

	// Portfolio layout
	api( 'portfolio_layout', function( value ) {
		value.bind( function( to ) {
			
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)portfolio-layout-\S+/g) || [] ).join(' ');
			} );

			$( 'body' ).addClass( 'portfolio-layout-' + to );
			
			if ( $( 'body' ).hasClass( 'portfolio-display-grid' ) ) {
				$( '.works' ).isotope( 'reloadItems' ).isotope();
			}
			
			$( window ).trigger( 'resize' );
		} );
	} );

	// Portfolio grid padding
	api( 'portfolio_grid_padding', function( value ) {
		value.bind( function( to ) {
			
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)portfolio-grid-padding-\S+/g) || [] ).join(' ');
			} );
			
			$( 'body' ).addClass( 'portfolio-grid-padding-' + to );
			
			if ( $( 'body' ).hasClass( 'portfolio-display-grid' ) ) {
				$( '.works' ).isotope( 'reloadItems' ).isotope();
			}
			
			$( window ).trigger( 'resize' );
		} );
	} );

	/* Discography
	-------------------------------------------*/

	// Discography layout
	api( 'discography_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)discography-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'discography-layout-' + to );
		} );
	} );

	// Discography display
	api( 'discography_display', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)discography-display-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'discography-display-' + to );
		} );
	} );

	// Discography columns
	api( 'discography_columns', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)discography-columns-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'discography-columns-' + to );
		} );
	} );

	// Discography padding
	api( 'discography_padding', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)discography-padding-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'discography-padding-' + to );
		} );
	} );

	/* Videos
	-------------------------------------------*/

	// Videos layout
	api( 'videos_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)videos-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'videos-layout-' + to );
			$( '.videos' ).isotope( 'reloadItems' ).isotope();
		} );
	} );

	// Videos columns
	api( 'videos_columns', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)videos-columns-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'videos-columns-' + to );
			$( '.videos' ).isotope( 'reloadItems' ).isotope();
		} );
	} );

	// Videos padding
	api( 'videos_padding', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)videos-padding-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'videos-padding-' + to );
			$( '.videos' ).isotope( 'reloadItems' ).isotope();
		} );
	} );

	/* Albums
	-------------------------------------------*/

	// Albums layout
	api( 'albums_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)albums-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'albums-layout-' + to );
			$( '.albums' ).isotope( 'reloadItems' ).isotope();
		} );
	} );

	// Albums display
	api( 'albums_display', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)albums-display-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'albums-display-' + to );
			$( '.albums' ).isotope( 'reloadItems' ).isotope();
		} );
	} );

	// Albums columns
	api( 'albums_columns', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)albums-columns-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'albums-columns-' + to );
			$( '.albums' ).isotope( 'reloadItems' ).isotope();
		} );
	} );

	// Albums padding
	api( 'albums_padding', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)albums-padding-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'albums-padding-' + to );
			$( '.albums' ).isotope( 'reloadItems' ).isotope();
		} );
	} );

	/* Events
	-------------------------------------------*/

	// Events layout
	api( 'events_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)events-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'events-layout-' + to );
		} );
	} );

	// Events columns
	api( 'events_columns', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)events-columns-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'events-columns-' + to );
		} );
	} );

	// Events padding
	api( 'events_padding', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)events-padding-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'events-padding-' + to );
		} );
	} );

	/* Shop
	-------------------------------------------*/

	// Shop layout

	if ( $( 'body' ).hasClass( 'single-product' ) ) {

		api( 'shop_single_layout', function( value ) {
			value.bind( function( to ) {
				$( 'body' ).removeClass( function ( index, css ) {
					return ( css.match ( /(^|\s)shop-layout-\S+/g) || [] ).join(' ');
				} );
				$( 'body' ).addClass( 'shop-layout-' + to );
			} );
		} );

	} else {
		api( 'shop_layout', function( value ) {
			value.bind( function( to ) {
				$( 'body' ).removeClass( function ( index, css ) {
					return ( css.match ( /(^|\s)shop-layout-\S+/g) || [] ).join(' ');
				} );
				$( 'body' ).addClass( 'shop-layout-' + to );
			} );
		} );
	}
	
	// Shop columns
	api( 'shop_columns', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)shop-columns-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'shop-columns-' + to );
		} );
	} );

	// Shop padding
	api( 'shop_padding', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)shop-padding-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'shop-padding-' + to );
		} );
	} );

	/* Bottom bar
	-------------------------------------------*/
	api( 'bottom_bar_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)bottom-bar-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'bottom-bar-layout-' + to );
		} );
	} );


	/* Footer
	-------------------------------------------*/

	api( 'footer_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)footer-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'footer-layout-' + to );
		} );
	} );

	api( 'footer_widgets_layout', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)footer-widgets-layout-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'footer-widgets-layout-' + to );
		} );
	} );

	api( 'scroll_to_top_arrow_style', function( value ) {
		value.bind( function( to ) {
			$( 'body' ).removeClass( function ( index, css ) {
				return ( css.match ( /(^|\s)scroll-to-top-arrow-style-\S+/g) || [] ).join(' ');
			} );
			$( 'body' ).addClass( 'scroll-to-top-arrow-style-' + to );
		} );
	} );

} )( jQuery );