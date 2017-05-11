/*!
 * AJAX navigation methods
 *
 * InkPro 2.0.3
 */
/* jshint -W062 */
/* global InkproParams,
InkproUi,
InkproYTVideoBg,
InkproMasonry,
InkproCategoryFilter,
InkproInfiniteScroll,
InkproPhotos,
WPB,
WPBCountdown,
WPM,
FB,
WolfGram,
WolfPortfolio,
WolfAlbums,
WolfVideos,
WolfPlugins,
WolfWooCommerceWishlist,
woocommerce_price_slider_params,
_gaq, ga,
console */

var InkproAjaxNav = function( $ ) {

	'use strict';

	return {

		body : $( 'body' ),
		contentDiv : '.site-content',
		$dom : null,
		currentUrl : window.location.href,

		init : function () {

			if ( InkproParams.is404 ) {
				return;
			}

			// Insert progress bar if not already here
			if ( ! $( '#ajax-progress-bar' ).length ) {
				$( '.site-container' ).prepend( '<div id="ajax-progress-bar"></div>' );
			}

			// Wrap content in a specific div
			if ( ! $( '#ajax-content' ).length ) {
				$( this.contentDiv ).wrapInner( '<div id="ajax-content" />' );
				this.playVideos(); // play video backgrounds (fix for ...)
			}

			this.setAjaxLinkClass(); // add ajax-link class to links
			this.clickEvent(); // main click event
			this.browserNavigation();
			this.updateCurrentUrl();
		},

		/**
		 * Fix video backgrounds stopping when wrapping the content in the ajax-content div
		 */
		playVideos : function () {
			$( '.video-bg, .wpb-video-bg' ).each( function() {
				$( this ).get( 0 ).play();
			} );
		},

		/**
		 * Remov slash
		 */
		untrailingSlashit : function ( str ) {

			str = str || '';

			if ( '/' === str.charAt( str.length - 1 ) ) {
				str = str.substr( 0, str.length - 1 );
			}

			return str;
		},

		/**
		 * Add class to link that will be ajaxify
		 *
		 * Then remove it for the ones we don't want
		 */
		setAjaxLinkClass : function () {

			var siteURL = InkproParams.siteUrl,
				$internalLinks,
				regEx = '';

			$.each( InkproParams.allowedMimeTypes, function( index, value ) {
				regEx += '|' + value;
			} );

			regEx = $.trim( regEx ).substring(1);

			siteURL = InkproParams.siteUrl;

			$internalLinks = $( 'a[href^="' + siteURL + '"], a[href^="/"], a[href^="./"], a[href^="../"]' );

			// exclude downloadable files
			$internalLinks = $internalLinks.not( function() {
				return $( this ).attr( 'href' ).match( '.(' + regEx + ')$' );
			} );

			$internalLinks.addClass( 'ajax-link' );

			if ( InkproParams.isWooCommerce ) {

				/*
				When WC pages aren't set the WC pages variables will return the siteURL
				Be sure it is not the same !!
				 */
				if ( this.untrailingSlashit( siteURL ) !== this.untrailingSlashit( InkproParams.WooCommerceCartUrl ) ) {
					$( 'a[href^="' + InkproParams.WooCommerceCartUrl + '"]' ).removeClass( 'ajax-link' );
				}

				if ( this.untrailingSlashit( siteURL ) !== this.untrailingSlashit( InkproParams.WooCommerceAccountUrl ) ) {
					$( 'a[href^="' + InkproParams.WooCommerceAccountUrl + '"]' ).removeClass( 'ajax-link' );
				}

				if ( this.untrailingSlashit( siteURL ) !== this.untrailingSlashit( InkproParams.WooCommerceCheckoutUrl ) ) {
					$( 'a[href^="' + InkproParams.WooCommerceCheckoutUrl + '"]' ).removeClass( 'ajax-link' );
				}

				$( '.woocommerce-MyAccount-navigation a, .add_to_cart_button, .woocommerce-main-image, .product .images a, .product-remove a, .wc-proceed-to-checkout a, .wc-forward' ).removeClass( 'ajax-link' );
			}

			$( '.wpml-ls-item, .wpml-ls-item a' ).removeClass( 'ajax-link' );
			$( '[class*="wp-image-"]' ).parent().removeClass('ajax-link');
			$( '.no-ajax' ).removeClass( 'ajax-link' );
			$( '#wpadminbar a' ).removeClass( 'ajax-link' );
			$( '.lightbox, .wpb-lightbox, .video-item .entry-link, .last-photos-thumbnails, .scroll, .wpb-nav-scroll' ).removeClass( 'ajax-link' );
			$( '.widget_meta a, a.logo-link, a.comment-reply-link, a#cancel-comment-reply-link, a.post-edit-link, a.comment-edit-link, a.share-link, .single .comments-link a' ).removeClass( 'ajax-link' );
			$( '#blog-filter a, #albums-filter a, #work-filter a, #videos-filter a, #plugin-filter a, .logged-in-as a, #trigger a' ).removeClass( 'ajax-link' );
			$( '.is-infinitescroll .nav-links a, .envato-item-presentation a' ).removeClass( 'ajax-link' );
			$( '.dropdown li.menu-item-has-children > a, .dropdown li.page_item_has_children > a' ).removeClass( 'ajax-link' );
		},

		/**
		 * Browser navigation
		 */
		browserNavigation : function () {
			// http://hawkee.com/snippet/9940/
			// http://stackoverflow.com/questions/25682671/how-to-call-an-event-when-browser-back-button-is-clicked
			var _this = this,
				href;

			window.userInteractionTimeout = null;
			window.userInteractionInHTMLArea = false;
			window.onBrowserHistoryButtonClicked = null; // This will be your event handler for browser navigation buttons clicked

			$( document ).mousedown(function () {
				clearTimeout( window.userInteractionTimeout );
				window.userInteractionInHTMLArea = true;
				window.userInteractionTimeout = setTimeout( function () {
					window.userInteractionInHTMLArea = false;
				}, 500 );
			} );

			$( document ).keydown(function () {
				clearTimeout( window.userInteractionTimeout );
				window.userInteractionInHTMLArea = true;
				window.userInteractionTimeout = setTimeout( function () {
					window.userInteractionInHTMLArea = false;
				}, 500 );
			} );

			if ( window.history && window.history.pushState ) {

				$( window ).on( 'popstate', function() {

					if ( ! window.userInteractionInHTMLArea) {

						//window.onBrowserHistoryButtonClicked = true;

						href = location.href;

						// if anchor navigate within the page
						if ( _this.removeHash( _this.currentUrl ) === _this.removeHash( href ) ) { // smae page but hash

							//_this.goToAnchor( href );
							//window.location.replace( href );

						} else {
							// navigate with AJAX
							_this.navigate( href, 'no' );
						}

						$( window ).trigger( 'wolf_on_browser_navigation' ); // hook
					}
				} );
			}
		},

		/**
		 * Scroll to an anchor (no smooth effect)
		 * not used ATM
		 */
		goToAnchor : function ( href ) {

			var hash,
				scrollPoint = 0,
				scrollOffset = InkproUi.getToolBarOffset() + InkproUi.getMenuOffsetFromTheme() - 5;

			if ( -1 !== href.indexOf( '#' ) ) {

				hash = href.substring( href.indexOf( '#' ) + 1 );

				if ( $( '#' + hash ).length ) {

					scrollPoint = $( '#' + hash ).offset().top - scrollOffset;

					if ( 0 > scrollPoint ) {
						scrollPoint = 1;
					}

					//console.log( scrollPoint );

					//window.scrollTo( 0, scrollPoint );
				}
			}
		},

		/**
		 * Update current URL
		 */
		updateCurrentUrl : function () {

			var _this = this, hash;

			$( window ).on( 'hashchange', function() {

				hash = window.location.hash;

				_this.currentUrl = window.location.href;
				//console.log( _this.currentUrl );
			} );
		},

		/**
		 * Get URL without hash
		 */
		removeHash : function ( url ) {

			// there is hash
			if ( -1 !== url.indexOf( '#' ) ) {
				var hash = url.substring( url.indexOf( '#' ) );

				if ( '' !== hash ) {
					url = url.replace( hash, '' );
				}
			}

			return url;
		},

		/**
		 * Load content
		 */
		navigate : function ( href, clicked ) {

			clicked = clicked || 'yes';

			var _this = this,
				newHref,
				$body = $( 'body' ),
				toggleClass = 'menu-toggle',
				xhr,
				percentComplete,
				nonce,
				currentUrl,
				randStart;

			currentUrl = window.location.href;
			newHref = href.replace( href, InkproParams.siteUrl );

			//console.log( clicked );

			if ( currentUrl === href ) {
				//return;
			}

			// start the progress animation at a random point
			randStart = parseInt( Math.random() * ( 88 - 8 ) + 8, 10 );

			$( '#ajax-progress-bar' ).show().animate( { 'width' : randStart + '%' } );
			$( 'html' ).addClass( 'ajax-loading' );

			// reset mobile menu
			$body.removeClass( toggleClass );
			$( 'ul.sub-menu.menu-item-open' ).slideUp().removeClass( 'menu-item-open' );

			// AJAX request
			$.ajax( {

				type : 'POST',
				dataType : 'html',
				url: InkproParams.ajaxUrl,
				data : {
					url : href,
					action : 'inkpro_ajax_get_page_markup',
					nonce: nonce
				},

				xhr : function () {
					xhr = new window.XMLHttpRequest();

					xhr.addEventListener( 'progress', function ( event ) {

						if ( event.lengthComputable ) {

							// console.log( event.loaded);

							percentComplete = Math.round( ( event.loaded / event.total ) * 100 );

							if ( randStart < percentComplete ) {
								$( '#ajax-progress-bar' ).css( {
									'width' : percentComplete + '%'
								} );
							}

						} else {
							console.log( 'Progress no reported' );
						}
					}, false);

					return xhr;
				},

				error : function () {
					console.log( 'unkown error' );
					_this.currentUrl = href;
					window.location.replace( href );
				},

				beforeSend : function () {},

				complete : function () {},

				success: function( response ) {
					// console.log( response );

					// redirect to target URL if error
					if ( 'error' === response ) {

						_this.currentUrl = href;
						window.location.replace( href );

					} else {
						_this.$dom = $( document.createElement( 'html' ) ); // Create HTML content
						_this.$dom[0].innerHTML = response; // Set AJAX response as HTML dom
						_this.process( href ); // process content

						//console.log( href );

						if ( 'yes' === clicked && currentUrl !== href ) {
							window.history.pushState( null, null, href ); // update URL
						}

						_this.trackPageView( href ); // track page view
						_this.currentUrl = href;
						$( window ).trigger( 'wolf_after_ajax_load' ); // hook
					}
				}
			} );
		},

		/**
		 * Function that handles the click event
		 */
		clickEvent : function() {

			var _this = this,
				$link,
				href,
				currentUrl;

			$( document ).on( 'click', '.ajax-link', function( event ) {

				event.preventDefault();
				event.stopPropagation();

				$link = $( this ),
				currentUrl = window.location.href;
				href = $link.attr( 'href' );

				if ( currentUrl === href ) {
					return; // stop if URL links to the current page
				}

				if ( $link.hasClass( 'menu-link' ) ) {

					$( '.menu-item' ).removeClass( 'menu-link-active current_page_item current-menu-parent current-menu-item' );

					// item has parent
					if ( $link.parents( '.menu-parent-item' ).length ) {

						$link.parents( '.menu-parent-item' ).addClass( 'menu-link-active' );

					} else {
						$link.parent( 'li' ).addClass( 'menu-link-active' );
					}
				}

				_this.navigate( href );
			} );
		},

		/**
		 * Track page view if Google analytics is found
		 */
		trackPageView : function ( url ) {
			var title = this.$dom.find( 'title' ).html();

			if ( 'undefined' !== typeof _gaq ) {
				_gaq.push( [ '_trackPageview', url ] );
			}
			else if ( 'undefined' !== typeof ga ) {
				ga( 'send', 'pageview', { 'page' : url, 'title' : title } );
			}
		},

		/**
		 * Update title
		 */
		loadTitle : function() {
			var $title = this.$dom.find( 'title' );
			$( 'title' ).html( $title.html() ); // replace head tag content
		},

		/**
		 * Load inline custom post CSS style
		 */
		loadCustomPostStyle : function() {
			var $postStyle = this.$dom.find( 'style#inkpro-single-post-style-inline-css' );
			$( 'style#inkpro-single-post-style-inline-css' ).html( $postStyle.html() ); // replace single post style inline CSS
		},

		/**
		 * Main animation and process
		 */
		process : function ( href ) {

			var content = this.$dom.find( this.contentDiv ).html(),
				$body = this.$dom.find( 'body' ),
				bodyClasses = $body.attr( 'class' ),
				hash,
				scrollOffset = 0,
				scrollPoint = 0;

			$( window ).scrollTop( 0 ); // scroll at the top before inserting new content (for page scroll animation)

			/* Destroy countdown WPM element to avoid bug */
			if ( typeof WPBCountdown !== 'undefined') {
				WPBCountdown.destroy();
			}

			// Update content
			$( '#ajax-content' ).empty().html( content );

			this.setBodyClasses( bodyClasses );

			this.loadCustomPostStyle();

			this.loadTitle();

			this.removeParallaxMirrors();

			// replace admin bar
			this.updateAdminbar();

			// replace WPML links
			this.updateWPMLInMenu();

			/**
			 * Big callback
			 */
			this.callBack();

			if ( -1 !== href.indexOf( '#' ) ) {

				hash = href.substring( href.indexOf( '#' ) + 1 );

				if ( '' !== hash ) {
					scrollOffset = InkproUi.getToolBarOffset() + InkproUi.getMenuOffsetFromTheme() - 5,
					scrollPoint = $( '#' + hash ).offset().top - scrollOffset;
				}
			}

			// scroll to anchor if any
			$( window ).scrollTop( scrollPoint );

			$( '#ajax-progress-bar' ).css( { 'width' : '100%' } );

			setTimeout( function() {
				$( window ).trigger( 'resize' );
				$( 'html' ).removeClass( 'ajax-loading' );
				$( '#ajax-progress-bar' ).hide().css( { 'width' : '0%' } );
			}, 500 );
		},

		/**
		 * Remove parallax mirrors
		 */
		removeParallaxMirrors : function () {
			$( '.parallax-mirror' ).remove();
		},

		/**
		 * Reset body classes
		 */
		setBodyClasses : function( bodyClasses ) {

			bodyClasses = bodyClasses.replace( 'loading', '' ); // remove laoding class

			bodyClasses += ' loaded';

			if ( InkproParams.isUserLoggedIn ) {
				bodyClasses += ' logged-in admin-bar loaded';
			}

			$( 'body' ).attr( 'class', '' ).addClass( bodyClasses );
		},

		/**
		 * Replace admin bar markup
		 */
		updateAdminbar : function () {
			var $admin = this.$dom.find( '#wpadminbar' );
			$( '#wpadminbar' ).html( $admin.html() ); // replace head tag content
		},

		/**
		 * Update WPML
		 */
		updateWPMLInMenu : function () {

			var wpmlMenuItem = [],
				$wpml;

			if ( this.$dom.find( '#navbar-container .custom-wpml-iso-codes' ) ) {

				$wpml = this.$dom.find( '#navbar-container .custom-wpml-iso-codes' );

				$( '#navbar-container .custom-wpml-iso-codes' ).html( $wpml.html() );
			}


			// Get the new WPML link content
			if ( this.$dom.find( '#navbar-container .wpml-ls-menu-item' ).length ) {
				this.$dom.find( '#navbar-container .wpml-ls-menu-item' ).each( function() {
					wpmlMenuItem.push( $( this ).html() );
				} );
			}

			// Insert the content in the actual items in the main menu
			$( '#site-navigation-primary-desktop .wpml-ls-menu-item' ).each( function( index ) {
				if ( 'undefined' !== typeof wpmlMenuItem[ index ] ) { // avoid error
					$( this ).html( wpmlMenuItem[ index ] );
				}
			} );

			// Insert the content in the actual items in the mobile main menu
			$( '#site-navigation-primary-mobile .wpml-ls-menu-item' ).each( function( index ) {
				if ( 'undefined' !== typeof wpmlMenuItem[ index ] ) { // avoid error
					$( this ).html( wpmlMenuItem[ index ] );
				}
			} );

			// Insert the content in the actual items in the bottom menu
			$( '#site-navigation-tertiary .wpml-ls-menu-item' ).each( function( index ) {
				if ( 'undefined' !== typeof wpmlMenuItem[ index ] ) { // avoid error
					$( this ).html( wpmlMenuItem[ index ] );
				}
			} );
		},

		/**
		 * Reinit all JS theme function that need it
		 */
		callBack : function() {

			this.themeCallback();
			this.WooCommerceCallback();
			this.WPBCallback();
			this.wolfPluginsCallback();
			this.thirdPartyCallback();
			this.setAjaxLinkClass();
		},

		/**
		 * Theme callback
		 */
		themeCallback : function () {

			if ( 'undefined' !== typeof InkproUi ) {
				InkproUi.init();
				InkproUi.postBg();
				InkproUi.singlePostNavBg();
				InkproUi.fluidVideos();
				InkproUi.youtubeWmode();
				InkproUi.setVimeoOptions();
				InkproUi.likes();
				InkproUi.lightbox();
				InkproUi.flexSlider();
				InkproUi.owlCarousel();
				InkproUi.parallax();
				InkproUi.postPaddingTop();
				InkproUi.animateAnchorLinks();
				InkproUi.shareLinkPopup();
				InkproUi.lazyLoad();
				InkproUi.additionalFixes();
			}

			/* YT background */
			if ( 'undefined' !== typeof InkproYTVideoBg ) {
				InkproYTVideoBg.init();
			}

			if ( 'undefined' !== typeof InkproMasonry ) {
				InkproMasonry.init();
			}

			if ( 'undefined' !== typeof InkproCategoryFilter ) {
				InkproCategoryFilter.init();
			}

			if ( 'undefined' !== typeof InkproInfiniteScroll ) {
				InkproInfiniteScroll.init();
			}

			if ( 'undefined' !== typeof InkproPhotos ) {
				InkproPhotos.init();
			}

			// load Twitter script
			if ( $( '#ajax-content' ).find( '.twitter-tweet' ).length ) {
				$.getScript( 'https://platform.twitter.com/widgets.js' );
			}

			if ( $( '#ajax-content' ).find( '.instagram-media' ).length ) {

				$.getScript( 'https://platform.instagram.com/en_US/embeds.js' );

				if ( 'undefined' !== typeof window.instgrm  ) {
					window.instgrm.Embeds.process();
				}
			}

			// load Facebook script
			if ( $( '#ajax-content' ).find( '.fb-page' ).length ) {
				FB.XFBML.parse();
			}

			// WP audio and video shortcode
			if ( $( '#ajax-content' ).find( 'audio.wp-audio-shortcode, video.wp-video-shortcode' ).length ) {
				$( '#ajax-content' ).find( 'audio.wp-audio-shortcode, video.wp-video-shortcode' ).mediaelementplayer();
			}

			// to do WP playlist fallback
		},

		/**
		 * WooCommerce callback
		 */
		WooCommerceCallback : function () {

			// Tabs and rating
			if ( $( 'body' ).hasClass( 'single-product' ) ) {
				$( '.wc-tabs-wrapper, .woocommerce-tabs, #rating' ).trigger( 'init' );
			}

			// Sorting
			if ( $( '.woocommerce-ordering' ).length ) {

				// Orderby
				$( '.woocommerce-ordering' ).on( 'change', 'select.orderby', function() {
					$( this ).closest( 'form' ).submit();
				} );
			}

			// Quantity input
			if ( $( 'input.qty' ).length ) {
				// Target quantity inputs on product pages
				$( 'input.qty:not(.product-quantity input.qty)' ).each( function() {
					var min = parseFloat( $( this ).attr( 'min' ) );

					if ( min >= 0 && parseFloat( $( this ).val() ) < min ) {
						$( this ).val( min );
					}
				} );
			}

			this.WooCommercePriceFilter();
		},

		/**
		 * Code snippet from WooCommerce
		 *
		 * @see woocommerce/assets/js/price-filter.js
		 */
		WooCommercePriceFilter : function () {

			// woocommerce_price_slider_params is required to continue, ensure the object exists
			if ( 'undefined' === typeof woocommerce_price_slider_params ||  1 > $( '.price_slider' ).length ) {
				return false;
			}

			// Get markup ready for slider
			$( 'input#min_price, input#max_price' ).hide();
			$( '.price_slider, .price_label' ).show();

			// Price slider uses jquery ui
			var min_price = $( '.price_slider_amount #min_price' ).data( 'min' ),
				max_price = $( '.price_slider_amount #max_price' ).data( 'max' ),
				current_min_price = parseInt( min_price, 10 ),
				current_max_price = parseInt( max_price, 10 );

			if ( woocommerce_price_slider_params.min_price ) {
				current_min_price = parseInt( woocommerce_price_slider_params.min_price, 10 );
			}
			if ( woocommerce_price_slider_params.max_price ) {
				current_max_price = parseInt( woocommerce_price_slider_params.max_price, 10 );
			}

			$( document.body ).bind( 'price_slider_create price_slider_slide', function( event, min, max ) {
				if ( woocommerce_price_slider_params.currency_pos === 'left' ) {

					$( '.price_slider_amount span.from' ).html( woocommerce_price_slider_params.currency_symbol + min );
					$( '.price_slider_amount span.to' ).html( woocommerce_price_slider_params.currency_symbol + max );

				} else if ( woocommerce_price_slider_params.currency_pos === 'left_space' ) {

					$( '.price_slider_amount span.from' ).html( woocommerce_price_slider_params.currency_symbol + ' ' + min );
					$( '.price_slider_amount span.to' ).html( woocommerce_price_slider_params.currency_symbol + ' ' + max );

				} else if ( woocommerce_price_slider_params.currency_pos === 'right' ) {

					$( '.price_slider_amount span.from' ).html( min + woocommerce_price_slider_params.currency_symbol );
					$( '.price_slider_amount span.to' ).html( max + woocommerce_price_slider_params.currency_symbol );

				} else if ( woocommerce_price_slider_params.currency_pos === 'right_space' ) {

					$( '.price_slider_amount span.from' ).html( min + ' ' + woocommerce_price_slider_params.currency_symbol );
					$( '.price_slider_amount span.to' ).html( max + ' ' + woocommerce_price_slider_params.currency_symbol );

				}

				$( document.body ).trigger( 'price_slider_updated', [ min, max ] );
			});

			$( '.price_slider' ).slider( {
				range: true,
				animate: true,
				min: min_price,
				max: max_price,
				values: [ current_min_price, current_max_price ],
				create: function() {

					$( '.price_slider_amount #min_price' ).val( current_min_price );
					$( '.price_slider_amount #max_price' ).val( current_max_price );

					$( document.body ).trigger( 'price_slider_create', [ current_min_price, current_max_price ] );
				},
				slide: function( event, ui ) {

					$( 'input#min_price' ).val( ui.values[0] );
					$( 'input#max_price' ).val( ui.values[1] );

					$( document.body ).trigger( 'price_slider_slide', [ ui.values[0], ui.values[1] ] );
				},
				change: function( event, ui ) {

					$( document.body ).trigger( 'price_slider_change', [ ui.values[0], ui.values[1] ] );
				}
			} );
		},

		/**
		 * Other plugins callback
		 */
		wolfPluginsCallback : function () {

			/* Wolf Playilst */
			if ( 'undefined' !== typeof WPM ) {
				WPM.init();
			}

			/* Wolf Portfolio */
			if ( 'undefined' !== typeof WolfPortfolio ) {
				WolfPortfolio.init();
			}

			/* Wolf Albums */
			if ( 'undefined' !== typeof WolfAlbums ) {
				WolfAlbums.init();
			}

			/* Wolf Videos */
			if ( 'undefined' !== typeof WolfVideos ) {
				WolfVideos.init();
			}

			/* Wolf Gram */
			if ( 'undefined' !== typeof WolfGram ) {
				WolfGram.init();
			}

			/* Wolf Plugins */
			if ( 'undefined' !== typeof WolfPlugins ) {
				WolfPlugins.init();
			}

			/* Wolf WooCommerce Wishlist */
			if ( 'undefined' !== typeof WolfWooCommerceWishlist ) {
				WolfWooCommerceWishlist.init();
			}
		},

		/**
		 * Wolf Page Builder callback
		 */
		WPBCallback : function() {
			if ( 'undefined' !== typeof WPB ) {
				WPB.ajaxCallback();
			}
		},

		/**
		 * 3rd party plugins callback
		 */
		thirdPartyCallback : function () {

			// Contactform7
			if ( $.isFunction( $.wpcf7InitForm ) ) {
				$( 'div.wpcf7 > form' ).wpcf7InitForm();
			}
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		InkproAjaxNav.init();
	} );

} )( jQuery );