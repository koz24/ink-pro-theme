/*!
 * Masonry
 *
 * InkPro 2.0.3
 */
/* jshint -W062 */
var InkproMasonry = function( $ ) {

	'use strict';

	return {

		init : function() {

			if ( ! $( 'body' ).hasClass( 'is-masonry' ) ) {
				return;
			}

			var _this = this;

			this.metroItemDimension();
			this.masonry();

			if ( $( 'body' ).hasClass( 'blog-display-masonry' ) || $( 'body' ).hasClass( 'blog-display-masonry2' ) || $( 'body' ).hasClass( 'portfolio-display-masonry' ) ) {
				this.resizeTimer();
			}

			// Resize event
			$( window ).resize( function() {

				_this.metroItemDimension();

			} ).resize();
		},

		metroItemDimension : function () {

			if ( $( 'body' ).hasClass( 'blog-display-metro' ) || $( 'body' ).hasClass( 'portfolio-display-metro' ) ) {

				if ( ! $( '.metro-item' ).length ) {
					return;
				}

				var winWidth = $( window ).width(),
					baseDimension,
					$item;

				if ( $( '#content' ).find( '.metro-item-standard-width' ).first().length ) {

					baseDimension = $( '#content' ).find( '.metro-item-standard-width' ).first().width();

				} else if ( $( '#content' ).find( '.metro-item' ).first().hasClass( 'metro-item-width2' ) ) {

					baseDimension = $( '#content' ).find( '.metro-item' ).first().width() / 2;
				}

				$( '.metro-item' ).each( function() {
					$item = $( this );

					if ( $( 'body' ).hasClass( 'blog-grid-padding-yes' ) || $( 'body' ).hasClass( 'portfolio-grid-padding-yes' ) ) {
					}

					$item.css( { height : baseDimension } );

					//console.log( baseDimension );

					if ( 500 < winWidth ) {

						if ( $item.hasClass( 'metro-item-height2' ) ) {
							$item.css( { height : baseDimension * 2 } );
						}
					}
				} );
			}
		},

		/**
		 * Masonry
		 */
		masonry : function () {

			var $container = $( '#content' );

			if ( $( 'body' ).hasClass( 'blog-display-masonry' ) || $( 'body' ).hasClass( 'blog-display-masonry2' ) || $( 'body' ).hasClass( 'portfolio-display-masonry' ) ) {

				if ( ! $( '.masonry-item' ).length ) {
					return;
				}

				$container.isotope( {
					itemSelector : '.masonry-item',
					animationEngine : 'best-available',
					layoutMode : 'masonry'
				} );

			} else if ( $( 'body' ).hasClass( 'blog-display-metro' ) || $( 'body' ).hasClass( 'portfolio-display-metro' ) ) {

				if ( ! $( '.metro-item' ).length ) {
					return;
				}

				$container.imagesLoaded( function() {
					$container.isotope( {
						itemSelector : '.metro-item',
						animationEngine : 'none',
						layoutMode : 'packery'
					} );
				} );
			}
		},

		/**
		 * Trigger isotope layout on load for elements fired after the whole page
		 */
		resizeTimer : function () {

			var _this = this,
				$container = $( '#content' );

			_this.resizeTime = setInterval( function() {
				_this.resizeClock++;

				if ( $( 'body' ).hasClass( 'is-masonry' ) ) {
					$container.isotope( 'layout' );
				}

				if ( _this.resizeClock === 3 ) {
					_this.clearResizeTime();
				}
				//console.log( _this.resizeClock );
			}, 2000 );
		},

		/**
		 * Clear resize time
		 */
		clearResizeTime : function () {
			clearInterval( this.resizeTime );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		InkproMasonry.init();
	} );

} )( jQuery );