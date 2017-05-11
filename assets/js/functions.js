/*!
 * Main Theme methods
 *
 * InkPro 2.0.3
 */
/* jshint -W062 */
/* global DocumentTouch,
InkproParams,
WolfFrameworkJSParams */

var InkproUi = function( $ ) {

	'use strict';

	return {
		initFlag : false,
		doParallax : true,
		body : $( 'body' ),
		loader : $( '#loading-overlay' ),
		clock : 0,
		timer : null,
		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
		isApple : ( navigator.userAgent.match( /(Safari)|(iPad)|(iPhone)|(iPod)/i ) && navigator.userAgent.indexOf( 'Chrome' ) === -1 && navigator.userAgent.indexOf( 'Android' ) === -1 ) ? true : false,
		supportSVG : !! document.createElementNS && !! document.createElementNS( 'https://www.w3.org/2000/svg', 'svg').createSVGRect,
		isTouch : 'ontouchstart' in window || window.DocumentTouch && document instanceof DocumentTouch,
		videoBgOptions : {
			loop: true,
			features: [],
			enableKeyboard: false,
			pauseOtherPlayers: false
		},

		init : function () {

			if ( this.initFlag ) {
				return;
			}

			var _this = this;

			this.loadingAnimation();

			this.setClasses();
			this.breakPoint();

			this.logoMenuPadding();
			this.mainContainerMinHeight();

			this.postPaddingTop();

			this.fullWindowElement();

			/* Video functions */
			this.fluidVideos();
			this.youtubeWmode();
			this.setVimeoOptions();
			this.videoBackground();

			this.parallax();

			this.flexSlider();
			this.owlCarousel();

			this.lightbox();

			this.animateAnchorLinks();

			this.commentForm();

			/* Menu functions */
			this.stickyMenu();
			this.toggleMenu();
			this.mobileMenuScroll();
			this.megaMenuBg();
			this.megaMenuTagline();

			this.postBg();

			this.shareLinkPopup();
			this.singlePostNavBg();

			this.additionalFixes();

			this.WolfPluginShortcodeAnimation();

			this.searchFormToggle();
			this.updateWooCommerceCart();
			this.WooCommerceLiveSearch();
			this.views();
			this.likes();

			this.bigText404();

			this.videoShortcode();

			this.lazyLoad();

			/**
			 * Resize event
			 */
			$( window ).resize( function() {
				_this.fullWindowElement();
				_this.videoBackground();
				_this.breakPoint();
				_this.mainContainerMinHeight();
				_this.postPaddingTop();
				_this.doZoom();
				_this.mobileMenuScroll();
				_this.videoShortcode();
			} ).resize();

			/**
			 * Scroll event
			 */
			$( window ).scroll( function() {
				var scrollTop = $( window ).scrollTop();
				_this.stickyMenu( scrollTop );
				_this.transitionParallax( scrollTop );
				_this.animatePageTitle( scrollTop );
				_this.mobileMenuScroll( scrollTop );
				_this.topLinkAnimation( scrollTop );
			} );

			$( window ).trigger( 'resize' ); // trigger resize event to force all window size related calculation
			$( window ).trigger( 'scroll' ); // trigger scroll event to force all window scroll related calculation

			_this.body.addClass( 'loaded' );
			_this.initFlag = true;
		},

		/**
		 * Set HTML tag classes that mayb be usefull
		 */
		setClasses : function () {

			if ( this.supportSVG ) {
				$( 'html' ).addClass( 'svg' );
			}

			if ( this.isTouch ) {
				$( 'html' ).addClass( 'touch' );
			} else {
				$( 'html' ).addClass( 'no-touch' );
			}

			if ( this.isMobile ) {
				this.body.addClass( 'is-mobile' );
			}

			if ( this.isApple ) {
				this.body.addClass( 'is-apple' );
			}
		},

		/**
		 * Loader
		 */
		loadingAnimation : function () {

			var _this = this;

			// timer to display the loader if loading last more than 1 sec
			_this.timer = setInterval( function() {

				_this.clock++;

				/**
				 * If the loading time last more than n sec, we hide the overlay anyway
				 * An iframe such as a video or a google map probably takes too much time to load
				 * So let's show the page
				 */
				if ( _this.clock === 4 ) {
					_this.hideLoader();
				}

			}, 1000 );
		},

		/**
		 * Adjust left and right menu padding depending on logo width
		 */
		logoMenuPadding : function () {
			if ( $( '.logo a img' ).length && 'centered' === InkproParams.menuLayout ) {

				var logoWidth = 250;

				if ( $( '.logo-light' ).length && $( '.logo-light' ).is( ':visible' ) ) {
					logoWidth = $( '.logo-light' ).width() + 40;
				} else if ( $( '.logo-dark' ).length && $( '#logo-dark' ).is( ':visible' ) ) {
					logoWidth = $( '.logo-dark' ).width() + 40;
				}

				$( '#navbar-left' ).css( { 'padding-right' : logoWidth / 2 } );
				$( '#navbar-right, #menu-product-search-form-container' ).css( { 'padding-left' : logoWidth / 2 } );
			}
		},

		/**
		 * Update menu offset global variable for scrolling anchor
		 */
		updateMenuOffset : function () {
			var winWidth = $( window ).width();

			if ( 800 < winWidth ) {

				WolfFrameworkJSParams.menuOffset = 80;

			} else {
				WolfFrameworkJSParams.menuOffset = 50;
			}
		},

		/**
		 * Set a minimum height to the #main container to avoid a gap below the footer
		 */
		mainContainerMinHeight : function () {
			var minHeight,
				footerHeight = ( $( '#colophon' ).is( ':visible' ) ) ? $( '#colophon' ).outerHeight() : 0,
				headerHeight = ( $( '#masthead' ).length ) ? $( '#masthead' ).outerHeight() : 0;

			minHeight = $( window ).height() - footerHeight - headerHeight;

			$( '#main' ).css( { 'min-height' : minHeight } );
		},

		/**
		 * Full Window function
		 */
		fullWindowElement : function () {

			var _this = this;

			$( '.full-height, .page-header-full .page-header-container' ).each( function() {
				$( this ).css( { 'height' : $( window ).height() - _this.getToolBarOffset() } );
			} );
		},

		/**
		 * Video Background
		 */
		videoBackground : function () {

			var videoContainer = $( '.video-bg-container' );

			$( '.site-header' ).find( 'video' ).attr( 'id', 'header-video' );

			videoContainer.each( function() {
				var videoContainer = $( this ),
					containerWidth = videoContainer.width(),
					containerHeight = videoContainer.height(),
					ratioWidth = 640,
					ratioHeight = 360,
					$video = $( this ).find( '.video-bg' ),
					//video = document.getElementById( $video.attr( 'id' ) ),
					newHeight,
					newWidth,
					newMarginLeft,
					newMarginTop,
					newCss;

				if ( videoContainer.hasClass( 'youtube-video-bg-container' ) ) {
					$video = videoContainer.find( 'iframe' );
					ratioWidth = 560;
					ratioHeight = 315;

				} else {
					// fallback
					if ( this.isTouch && 800 > $( window ).width() ) {
						// console.log( this.isTouch );
						videoContainer.find( '.video-bg-fallback' ).css( { 'z-index' : 1 } );
						$video.remove();
						return;
					}
				}

				if ( ( containerWidth / containerHeight ) >= 1.8 ) {
					newWidth = containerWidth;

					newHeight = Math.ceil( ( containerWidth/ratioWidth ) * ratioHeight ) + 2;
					newMarginTop =  - ( Math.ceil( ( newHeight - containerHeight  ) ) / 2 );
					newMarginLeft =  - ( Math.ceil( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginTop :  newMarginTop,
						marginLeft : newMarginLeft
					};

					$video.css( newCss );

				} else {
					newHeight = containerHeight;
					newWidth = Math.ceil( ( containerHeight/ratioHeight ) * ratioWidth );
					newMarginLeft =  - ( Math.ceil( ( newWidth - containerWidth  ) ) / 2 );

					newCss = {
						width : newWidth,
						height : newHeight,
						marginLeft :  newMarginLeft,
						marginTop : 0
					};

					$video.css( newCss );
				}
			} );
		},

		/**
		 * Blog top padding
		 */
		postPaddingTop : function () {

			// don't fo this if the the layout is boxed
			if ( this.body.hasClass( 'site-layout-boxed' ) && this.body.hasClass( 'desktop' ) ) {
				//return;
			}

			if ( this.body.hasClass( 'single-post-layout-small-width' ) || this.body.hasClass( 'single-post-layout-full-width' ) ) {

				var winWidth = $( '.content-wrapper' ).width(),
					$post = $( 'article.type-post' );

				if ( $post.hasClass( 'format-image' ) || $post.hasClass( 'format-gallery' ) || $post.hasClass( 'format-standard' ) || $post.hasClass( 'format-video' ) || $post.hasClass( 'format-audio' ) ) {

					if ( $post.find( '.entry-header-inner' ).width() < winWidth ) {

						$post.removeClass( 'post-no-padding-top' );

					} else {

						$post.addClass( 'post-no-padding-top' );
					}
				}
			}
		},

		/**
		 * Home Header Animation
		 */
		transitionParallax : function ( scrollTop ) {

			if ( this.doParallax ) {

				var _this = this,
					$el = $( '.parallax-inner' );

				$el.each( function() {
					$el.css( {
						'transform': 'translate3d(0,-' + Math.floor( scrollTop/_this.parallaxSpeed ) + 'px,0)',
						'-webkit-transform': 'translate3d(0,-' + Math.floor( scrollTop/_this.parallaxSpeed ) + 'px,0)'
					} );
				} );
			}
		},

		/**
		 * Animate page title while scrolling
		 */
		animatePageTitle : function ( scrollTop ) {

			if ( this.doParallax ) {

				var ratio = 0.5;

				$( '#hero, .intro' ).css( {
					'opacity': 1 - scrollTop/400
				} );

				$( '#hero' ).css( {
					'transform': 'translate3d(0,' + Math.floor( scrollTop * ratio ) + 'px,0)',
					'-webkit-transform': 'translate3d(0,' + Math.floor( scrollTop * ratio ) + 'px,0)'
				} );
			}
		},

		/**
		 * Allow scrolling if right side menu iheight is too high
		 */
		mobileMenuScroll : function ( scrollTop ) {

			scrollTop = scrollTop || 0;

			var _this = this,
				adminbar = 0,
				menuTopPos = 0,
				offset = 0,
				winHeight = $( window ).height(),
				winWidth = $( window ).width(),
				panel = $( '#navbar-mobile-container' ),
				panelheight = panel.outerHeight();

			if ( _this.body.hasClass( 'admin-bar' ) ) {
				if ( 782 > winWidth ) {
					adminbar = 46;
				} else {
					adminbar = 32;
				}
			}

			if ( winHeight < panelheight ) {

				menuTopPos = adminbar - scrollTop;
				offset = panelheight - winHeight;

				if ( menuTopPos > - offset ) {
					panel.css( {
						'top' : menuTopPos
					} );
				}
			}
		},

		/**
		 * Check if the window dimension allow zoom effect
		 */
		doZoom : function () {

			$( '.zoom-bg' ).each( function() {

				var $this = $( this ),
					img = $this.find( 'img' ),
					imgHeight = img.height(),
					containerHeight = $( this ).parents( '.post-header-container' ).height();

				if ( containerHeight < imgHeight ) {

					$this.addClass( 'do-zoom' );

				} else {

					$this.removeClass( 'do-zoom' );
				}
			} );
		},

		getMenuType : function () {

			var i,
			bodyClasses = $( 'body' ).attr( 'class' ).split( ' ' ),
			matches, fxclass;

			for ( i = 0; i < bodyClasses.length; i++) {
				matches = /^menu-type\-(.+)/.exec( bodyClasses[i] );
				if ( matches != null ) {
					fxclass = matches[1];
				}
			}

			if ( 'undefined' !== typeof  fxclass ) {
				return fxclass.replace( 'menu-type', fxclass );
			}
		},

		stickyMenu : function ( scrollTop ) {

			if ( ! InkproParams.isStickyMenu ) {
				return;
			}

			var scrollPoint;

			scrollTop = scrollTop || 0;

			scrollPoint = parseInt( InkproParams.stickyMenuScrollPoint, 10 );

			if ( scrollPoint < scrollTop ) {
				this.body.addClass( 'sticking' );
				this.logoMenuPadding();
			} else {
				this.body.removeClass( 'sticking' );
				this.logoMenuPadding();
			}
		},

		/**
		 *  Add a breakpoint class
		 */
		breakPoint : function () {

			var winWidth = $( window ).width(),
				breakpoint = InkproParams.breakPoint;

			if ( breakpoint > winWidth ) {

				this.body.addClass( 'breakpoint' );
				this.body.removeClass( 'desktop' );

			} else {
				this.logoMenuPadding();

				this.body.removeClass( 'breakpoint' );
				this.body.addClass( 'desktop' );

				if ( this.body.hasClass( 'menu-toggle' ) ) {
					this.body.removeClass( 'menu-toggle' );
					$( '#navbar-mobile-container' ).removeAttr( 'style' );
				}

				if ( this.body.hasClass( 'search-toggle-woocommerce' ) ) {
					this.body.removeClass( 'search-toggle-woocommerce' );
				}
			}

			if ( 800 > winWidth ) {
				this.body.addClass( 'mobile' );
			} else {
				this.body.removeClass( 'mobile' );
			}
		},

		/**
		 * Fluid Video wrapper
		 */
		fluidVideos : function ( container ) {

			container = container || $( '#page' );

			var videoSelectors = [
				'iframe[src*="player.vimeo.com"]',
				'iframe[src*="youtube.com"]',
				'iframe[src*="youtube-nocookie.com"]',
				'iframe[src*="youtu.be"]',
				'iframe[src*="kickstarter.com"][src*="video.html"]',
				'iframe[src*="screenr.com"]',
				'iframe[src*="blip.tv"]',
				'iframe[src*="dailymotion.com"]',
				'iframe[src*="viddler.com"]',
				'iframe[src*="qik.com"]',
				'iframe[src*="revision3.com"]',
				'iframe[src*="hulu.com"]',
				'iframe[src*="funnyordie.com"]',
				'iframe[src*="flickr.com"]',
				'embed[src*="v.wordpress.com"]'
			];

			container.find( videoSelectors.join( ',' ) ).wrap( '<span class="fluid-video" />' );
			$( '.rev_slider_wrapper' ).find( videoSelectors.join( ',' ) ).unwrap(); // disabled for revslider videos
			$( '.fluid-video' ).parent().addClass( 'fluid-video-container' );
		},

		/**
		 * Fix z-index bug with youtube videos
		 */
		youtubeWmode : function() {

			var iframes, $iframes,
				youtubeSelector = [
					'iframe[src*="youtube.com"]',
					'iframe[src*="youtu.be"]',
					'iframe[src*="youtube-nocookie.com"]'
				];

			iframes = youtubeSelector.join( ',' );
			$iframes = $( iframes );

			if ( $iframes.length ) {

				$iframes.each(function(){

					var url = $( this ).attr( 'src' );

					if ( url ) {

						if ( url.indexOf( '?' ) !== -1) {

							// if attribute is not already there
							if ( ! url.match( '/wmode=transparent/' ) ) {
								$( this ).attr( 'src', url + '&wmode=transparent' );
							}

						} else {

							$( this ).attr( 'src', url + '?wmode=transparent' );
						}
					}
				} );
			}
		},

		/**
		 * Remove title from vimeo videos
		 * Set default color
		 */
		setVimeoOptions : function() {

			var iframes, $iframes,
				accentColor,
				vimeoSelector = [
					'iframe[src*="player.vimeo.com"]'
				];

			if ( InkproParams.accentColor ) {
				accentColor = InkproParams.accentColor.replace( '#', '' );
			} else {
				accentColor = '007acc';
			}

			iframes = vimeoSelector.join( ',' );
			$iframes = $( iframes );

			if ( $iframes.length ) {

				$iframes.each( function(){

					var url = $( this ).attr( 'src' );

					if ( url ) {

						if ( url.indexOf( '?' ) !== -1) {

							$( this ).attr( 'src', url + '&title=0&byline=0&portrait=0&badge=0&color=' + accentColor );

						} else {

							$( this ).attr( 'src', url + '?title=0&byline=0&portrait=0&badge=0&color=' + accentColor );
						}
					}
				} );
			}
		},

		/**
		 * Header parallax
		 */
		parallax : function () {
			if ( this.doParallax ) {
				$( '.parallax-window' ).each( function () {
					var $this = $( this ),
						backgroundImageUrl = $this.data( 'background-url' );

					$this.parallax( {
						imageSrc: backgroundImageUrl,
						mainContainer :'#page'
					} );
				} );
			}
		},

		/**
		 * FlexSlider
		 */
		flexSlider : function() {

			if ( $.isFunction( $.flexslider ) ) {

				/* Post slider */
				$( '.post-gallery-slider:not(.post-gallery-slider-slideshow)' ).flexslider( {
					animation: 'slide',
					slideshow : true,
					smoothHeight : true
				} );

				$( '.post-gallery-slider-slideshow' ).flexslider( {
					animation: 'fade',
					slideshow : true,
					smoothHeight : true,
					pauseOnHover : false,
					pauseOnAction : false,
					slideshowSpeed : 3000
				} );

				/* Product slider */
				$( '.woocommerce-single-product-images-slider' ).flexslider( {
					animation: 'slide',
					slideshow : true,
					smoothHeight : true,
					controlNav : false
				} );
			}
		},

		/**
		 * owlCarousel
		 */
		owlCarousel : function () {

			if ( this.body.hasClass( 'albums-display-vertical' ) ) {

				$( '.albums' ).addClass( 'vertical-carousel' );
				$( '#albums-filter-container' ).remove();

				/* Portrait Carousel */
				$( '.vertical-carousel' ).owlCarousel( {
					loop : true,
					margin : 0,
					dots : false,
					nav : false,
					autoplay : false,
					autoplayTimeout : 4000,
					autoplayHoverPause : true,
					responsive : {
						0 : {
							items : 1
						},
						600 : {
							items : 3
						},
						1000 : {
							items : 5
						}
					}
				} );
			}
		},

		/**
		 * Set lightbox depending on user's theme options
		 */
		lightbox : function() {

			var $body = this.body,
				_this = this,
				videoItem = $( '.video-item-container' ),
				postId,
				data;

			$( '.gallery .lightbox' ).each( function() { $( this ).attr( 'rel', 'gallery' ); } );

			if ( InkproParams.doWoocommerceLightbox ) {

				$( 'a[data-rel^="prettyPhoto"]' ).each( function() {
					$( this ).attr( 'rel', $( this ).data( 'rel' ) ).addClass( 'lightbox' );
				} );
			}

			if ( $body.hasClass( 'lightbox-swipebox' ) ) {


				$( '.lightbox, .wolf-show-flyer, .wolf-show-flyer-single, .last-photos-thumbnails' ).swipebox();


			} else if ( $body.hasClass( 'lightbox-fancybox' ) ) {

				$( '.lightbox, .wolf-show-flyer, .wolf-show-flyer-single, .last-photos-thumbnails' ).fancybox();
			}

			if ( InkproParams.doVideoLightbox ) {

				if ( 'swipebox' === InkproParams.lightbox ) {

					$( '.video-item .entry-link, .lightbox-video' ).swipebox( {
						hideBarsDelay : 0,
						vimeoColor : InkproParams.accentColor,
						afterOpen : function () {
							_this.setVimeoOptions();
						}
					} );

				} else if ( 'fancybox' === InkproParams.lightbox ) {

					$( '.video-item .entry-link, .lightbox-video' ).fancybox( {
						padding : 0,
						nextEffect : 'none',
						prevEffect : 'none',
						openEffect  : 'none',
						closeEffect : 'none',
						helpers : {
							media : {},
							title : {
								type : 'outside'
							},
							overlay : {
								opacity: 0.9
							}
						}
					} );
				}

				/**
				 * Replace entry link by video link
				 */
				if ( videoItem.length ) {

					videoItem.each( function() {

						var _this = $( this );

						postId = _this.attr( 'id' ).replace( 'post-', '' );

						data = {
							action: 'inkpro_ajax_get_video_url_from_post_id',
							id : postId
						};

						$.post( InkproParams.ajaxUrl , data, function(response){

							if ( response ) {
								_this.find( '.entry-link' ).attr( 'href', response );
							}

						} );
					} );

					$( '.video-item-container .entry-link' ).each( function(){ $( this ).attr( 'rel','video-gallery' ); } );
				}
			} // end if video lightbox
		},

		/**
		 * Get the height of the top admin bar and/or menu
		 */
		getToolBarOffset : function () {

			var offset = 0;

			if ( this.body.is( '.admin-bar' ) ) {

				if ( 782 < $( window ).width() ) {
					offset = 32;
				} else {
					offset = 46;
				}
			}

			if ( $( '#wolf-message-bar' ).length && $( '#wolf-message-bar' ).is( ':visible' ) ) {
				offset = offset + $( '#wolf-message-bar-container' ).outerHeight();
			}

			return parseInt( offset, 10 );
		},

		/**
		 * Get menu offset from Theme if available
		 */
		getMenuOffsetFromTheme : function () {

			var menuOffset = 0;

			if ( ! $.isEmptyObject( WolfFrameworkJSParams ) ) {

				// if mobile
				if ( WolfFrameworkJSParams.menuOffsetMobile && $( 'body' ).hasClass( 'mobile' ) ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetMobile;

				// if tablet
				} else if ( WolfFrameworkJSParams.menuOffsetBreakpoint && ! $( 'body' ).hasClass( 'desktop' ) ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetBreakpoint;

				// if desktop
				} else if ( WolfFrameworkJSParams.menuOffsetDesktop ) {

					menuOffset = WolfFrameworkJSParams.menuOffsetDesktop;

				// if default
				} else if ( WolfFrameworkJSParams.menuOffset ) {

					menuOffset = WolfFrameworkJSParams.menuOffset;
				}
			}

			// console.log( menuOffset );

			return parseInt( menuOffset, 10 );
		},

		/**
		 * Commentform placeholder
		 */
		commentForm : function () {

			$( '#comment' ).attr( 'placeholder', InkproParams.l10n.replyTitle );

			$( '#comment' ).on( 'focus', function() {
				$( this ).attr( 'placeholder', '' );
			} );

			$( '#respond' ).on( 'focusout', function() {
				$( '#comment' ).attr( 'placeholder', InkproParams.l10n.replyTitle );
			} );
		},

		/**
		 * Smooth scroll
		 */
		animateAnchorLinks : function () {
			var _this = this;
			// console.log( scrollOffset );
			// console.log( this.getMenuOffsetFromTheme() );

			$( '.scroll, .woocommerce-review-link' ).on( 'click', function( event ) {

				event.preventDefault();
				event.stopPropagation();

				_this.smoothScroll( $( this ).attr( 'href' ) );
			} );
		},

		/**
		 * Smmoth scroll to an anchor
		 */
		smoothScroll : function( href ) {
			var scrollOffset = this.getToolBarOffset() + this.getMenuOffsetFromTheme() - 5,
				hash;

			if ( -1 !== href.indexOf( '#' ) ) {

				hash = href.substring( href.indexOf( '#' ) + 1 );

				if ( $( '#' + hash ).length ) {

					$( 'html, body' ).stop().animate( {

						scrollTop: $( '#' + hash ).offset().top - scrollOffset

					}, 1E3, 'swing', function() {

						if ( '' !== hash ) {
							// push hash
							history.pushState( null, null, '#' + hash );
							//window.location.hash = hash;
						}
					} );

				} else {
					window.location.replace( href ); // redirect to link if anchor doesn't exist on the page
				}
			}
		},

		/**
		 * Mobile Menu
		 */
		toggleMenu : function () {

			var $body = this.body,
				$menuItem,
				toggleClass = 'menu-toggle',
				dropDown = '.dropdown li.menu-item-has-children > a, .dropdown li.page_item_has_children > a';

			/**
			 * Close the menu panel when clicking a menu link
			 */
			$( '.nav-menu-mobile li a:not(.search-toggle)' ).on( 'click', function() {

				$menuItem = $( this ).parents( 'li' );

				// console.log( $menuItem.attr( 'class' ) );

				if ( ! $menuItem.hasClass( 'menu-item-has-children' ) ) {

					if ( $body.hasClass( toggleClass ) ) {
						//$mobileMenu.removeAttr( 'style' );
						$body.removeClass( toggleClass );
					}
				}
			} );

			$( document ).on( 'click', '.mobile-menu-toggle-button', function() {

				if ( $body.hasClass( toggleClass ) ) {
					$body.removeClass( toggleClass );
				} else {
					$body.addClass( toggleClass );
				}
			} );

			$( document ).on( 'click', dropDown, function( event ) {
				var $link = $( this ),
					$linkSubmenu = $( this ).parent().find( 'ul:first' );

				event.preventDefault();
				// event.stopPropagation();

				if ( $linkSubmenu.length ) {

					// close if open
					if ( $linkSubmenu.hasClass( 'menu-item-open' ) ) {
						$linkSubmenu.slideUp();
						$linkSubmenu.removeClass( 'menu-item-open' );

					// proceed
					} else {
						// close other submenu
						$link.parent().parent().find( 'ul.sub-menu.menu-item-open' ).slideUp().removeClass( 'menu-item-open' );

						$linkSubmenu.slideDown();
						$linkSubmenu.addClass( 'menu-item-open' );
					}
				}

				return false;
			} );
		},

		/**
		 * Set mega menu background
		 */
		megaMenuBg : function () {

			$( '.mega-menu' ).each( function() {
				var $this = $( this ),
					$submenu = $this.find( '.sub-menu' ),
					bg = $this.data( 'mega-menu-bg' );

				if ( bg ) {
					$submenu.css( {
						'background-image' : 'url('+ bg +')'
					} );
				}
			} );
		},

		/**
		 * Set mega menu tagline
		 */
		megaMenuTagline : function () {

			$( '#site-navigation-primary-desktop .mega-menu' ).each( function() {
				var $this = $( this ),
					$submenu = $this.find( '.sub-menu' ).first(),
					tagline = $this.data( 'mega-menu-tagline' ),
					$tagline;

				if ( tagline ) {
					$tagline = $( '<span class="mega-menu-tagline">' + tagline + '</span>' );
					$tagline.insertBefore( $submenu );
				}
			} );
		},

		/**
		 * Special post background for quote, link, and status post format
		 */
		postBg : function () {
			$( '[data-bg]' ).each( function() {
				var style,
					$this = $( this ),
					imgUrl = $this.data( 'bg' );

				if ( '' !== imgUrl ) {
					if ( $this.hasClass( 'format-quote' ) || $this.hasClass( 'format-link' ) || $this.hasClass( 'format-aside' ) || $this.hasClass( 'format-status' ) ) {
						style = 'background-color:transparent;background-image:url(' + imgUrl + ');background-repeat:no-repeat;background-position:center center;background-size:100%;background-size:cover;-webkit-background-size:100%;-webkit-background-size:cover;';
						$this.find( '.entry-content, .entry-frame' )
							.attr( 'style', style )
							.addClass( 'has-bg' );
					}
				}
			} );
		},

		/**
		 * Share Links Popup
		 */
		shareLinkPopup : function () {

			var _this = this;

			$( '.share-link, .share-link-video, .bit-fb-share, .bit-twitter-share' ).on( 'click', function() {

				if ( $( this ).data( 'popup' ) === true && ! _this.isMobile ){

					var $link = $( this ),
						url = $link.attr( 'href' ),
						height = $link.data( 'height' ) || 250,
						width = $link.data( 'width' ) || 500,
						popup = window.open( url,'null', 'height=' + height + ',width=' + width + ', top=150, left=150' );

					if ( window.focus ) {
						popup.focus();
					}

					return false;
				}
			} );
		},

		/**
		 * Views feature
		 */
		views : function () {

			var $item = $( '.single-work .work, .single .post, .single-video .video, .single-gallery .gallery, .single-release .release, .single-event .event' ),
				itemId = $item.data( 'post-id' ),
				data = {
					action: 'inkpro_ajax_view',
					postId : itemId
				};

			if ( $( 'body' ).hasClass( 'single' ) && itemId ) {
				$.post( InkproParams.ajaxUrl , data, function() {} );
			}
		},

		/**
		 * Likes feature
		 */
		likes : function () {

			var item = '.post, .attachment, .photo-actions, .video, .plugin, .theme, .work, .gallery, .page, .theme_documentation, .plugin_documentation',
				$item = $( item ),
				postId, loader, $container, $nbContainer, data, $this;

			$item.each( function () {
				if ( Cookies.get( InkproParams.themeSlug + '-likes-' +  $( this ).data( 'post-id' ) ) ) {
					$( this ).find( '.likes-meta' ).addClass( 'liked' );
				}
			} );

			$item.on( 'click', '.likes-meta', function() {

				$container = $( this ).parents( '[data-post-id]' );
				postId = $container.data( 'post-id' );

				$this = $( this );

				//console.log( postId );

				if ( $this.hasClass( 'liked' ) || Cookies.get( InkproParams.themeSlug + '-likes-' + postId ) ) {

					return; // post already liked by visitor

				} else {

					$this.addClass( 'liked' );

					loader = '';
					$nbContainer = $container.find( '.likes-meta-count' );
					data = {
						action: 'inkpro_ajax_like',
						postId: postId
					};

					$.post( InkproParams.ajaxUrl, data, function( response ) {

						if ( $nbContainer.length ) {
							$nbContainer.empty().html( response );
						}

						Cookies.set( InkproParams.themeSlug + '-likes-' + postId, 'liked', { path: '/', expires: 5 } );
					} );
				}

				return false;
			} );
		},

		/**
		 * Add featured image backgrounds to post navigation
		 */
		singlePostNavBg : function () {

			if ( this.body.hasClass( 'blog-navigation-standard' ) ) {

				$( '.nav-single' ).find( '[data-bg]' ).each( function() {

					var style, $this = $( this ),
						imgUrl = $this.attr( 'data-bg' );

					if ( '' !== imgUrl ) {
						style = 'background-color:transparent;background-image:url(' + imgUrl + ');background-repeat:no-repeat;background-position:center center;background-size:100%;background-size:cover;-webkit-background-size:100%;-webkit-background-size:cover;';
						$this.addClass( 'nav-has-bg' )
							.prepend( '<span class="nav-bg-overlay" />' );

						$this.find( '.nav-bg-overlay' ).attr( 'style', style );
					}
				} );
			}
		},

		/**
		 * Additional fix for WP
		 */
		additionalFixes : function () {
			// $( '.wp-embedded-content' ).parent( 'p' ).addClass( 'no-margin' );

			if ( ! this.initFlag ) {
				$( '.menu-item.button-style' ).each( function() {
					$( this ).next().addClass( 'no-menu-item-separator' );
				} );
			}

			var $firstWpbSetion = $( '.wpb-section' ).first();

			if ( $firstWpbSetion.length ) {

				$firstWpbSetion.addClass( 'wpb-first-section' );

				// if ( $firstWpbSetion.find( '.wpb-advanced-slider-container' ).hasClass( 'wpb-fullscreen-slider' ) ) {
				//	$( 'body' ).addClass( 'no-padding-top' );

				// }

				// if ( $firstWpbSetion.hasClass( 'wpb-section-full-height' ) ) {
				//	$( 'body' ).addClass( 'no-padding-top' );
				// }

				// if ( $firstWpbSetion.find( '.wpb-last-posts-big-slider' ) ) {
				//	$( 'body' ).addClass( 'no-padding-top' );

				// }
			}
		},

		/**
		 * Hide loading overlay
		 */
		hideLoader : function () {

			var _this = this;

			// animate loader overlay if any
			if ( ! this.body.hasClass( 'no-loading-overlay' ) ) {
				_this.loader.fadeOut( 'slow', function() {
					clearInterval( _this.timer );
					_this.body.removeClass( 'loading' );
					_this.body.addClass( 'loaded' );
				} );
			} else {
				clearInterval( _this.timer );
				_this.body.removeClass( 'loading' );
				_this.body.addClass( 'loaded' );
			}
		},

		/**
		 * Back to the top link animation
		 */
		topLinkAnimation : function( scrollTop ){

			if ( InkproParams.doBackToTopAnimation ) {
				if ( scrollTop >= 550 ) {
					$( 'a#back-to-top' ).show();
				} else {
					$( 'a#back-to-top' ).hide();
				}
			}
		},

		/**
		 * Top Search form toggle
		 */
		searchFormToggle : function () {

			var body = this.body,
				searchBar = $( '#top-search-form-container' );

			// Overlay
			$( '.search-toggle-overlay' ).on( 'click', function( event ) {
				event.preventDefault();

				if ( ! body.hasClass( 'search-toggle-overlay-on' ) ) {
					body.addClass( 'search-toggle-overlay-on' );
					setTimeout( function() {
						searchBar.find( 'input' ).focus();
					}, 100 );
				}
			} );

			$( '#close-search' ).on( 'click', function() {

				if ( body.hasClass( 'search-toggle-overlay-on' ) ) {
					body.removeClass( 'search-toggle-overlay-on' );
				}
			} );

			// WooCommerce search
			$( '.search-toggle-woocommerce' ).on( 'click', function( event ) {
				event.preventDefault();

				if ( ! body.hasClass( 'search-toggle-woocommerce-on' ) ) {
					body.addClass( 'search-toggle-woocommerce-on' );
					setTimeout( function() {
						$( '#menu-product-search-form-container' ).find( 'input' ).focus();
					}, 100 );
				}

			} );

			$( '.close-product-search-form' ).on( 'click', function() {
				if ( body.hasClass( 'search-toggle-woocommerce-on' ) ) {
					body.removeClass( 'search-toggle-woocommerce-on' );
				}
			} );
		},

		/**
		 * Add animation to Wolf Plugin shortcodes
		 */
		WolfPluginShortcodeAnimation : function() {

			$( '.shortcode-video-grid, .shortcode-gallery-grid, .shortcode-release-grid' ).each( function() {

				var $container = $( this ),
					anim = $container.data( 'animation-parent' ),
					animDelay = 0;

				if ( anim ) {
					$container.find( 'article' ).each( function() {
						animDelay = animDelay + 200;
						$( this ).addClass( 'wow ' + anim ).css( {
							'animation-delay' : animDelay / 1000 + 's',
							'-webkit-animation-delay' : animDelay / 1000 + 's'
						} );
					} );
				}

			} );
		},

		/**
		 * Update WooCommerce menu cart on page load to avoid issue with cache plugins
		 */
		updateWooCommerceCart : function () {

			if ( $( '.cart-menu-item' ).length ) {

				var cartPanel = $( '.cart-menu-item' ),
					bubble = cartPanel.find( '.product-count' ),
					panelCount = cartPanel.find( '.panel-product-count' ),
					amount = cartPanel.find( '.amount' );

				if ( Cookies.get( InkproParams.themeSlug + '_woocommerce_items_in_cart' ) ) {
					bubble.html( Cookies.get( InkproParams.themeSlug + '_woocommerce_items_in_cart' ) );
					panelCount.html( Cookies.get( InkproParams.themeSlug + '_woocommerce_items_in_cart' ) );
				}

				if ( Cookies.get( InkproParams.themeSlug + '_woocommerce_cart_total' ) ) {
					amount.html( Cookies.get( InkproParams.themeSlug + '_woocommerce_cart_total' ) );
				}
			}
		},

		/**
		 * bigText
		 */
		bigText404 : function () {
			if ( $( 'body' ).hasClass( 'error404' ) && InkproParams.hasWPB ) {
				$( '#error-404-bigtext' ).bigtext();
			}
		},

		/**
		 * Make WP video shortcode responsive
		 */
		videoShortcode : function () {

			$( '.wp-video' ).each( function() {
				var $this = $( this ),
					width = $this.parent().width(),
					height = Math.floor( ( width/16 ) * 9 );

				$this.css( {
					'width' : width,
					'height' : height
				} );
			} );
		},

		/**
		 * Live Search
		 */
		WooCommerceLiveSearch : function() {

			var searchInput = $( '#menu-product-search-form-container' ).find( 'input[type="search"]' ),
				$loader = $( '#product-search-form-loader' ),
				timer = null,
				$resultContainer,
				result;

			$( '<div id="woocommerce-live-search-results"><ul></u></div>' ).insertAfter( searchInput );

			$resultContainer = $( '#woocommerce-live-search-results' ),
			result = $resultContainer.find( 'ul' );

			searchInput.on( 'keyup', function( event ) {

				// clear the previous timer
				clearTimeout( timer );

				var $this = $( this ),
					term = $this.val();

				if ( 8 === event.keyCode || 46 === event.keyCode ) {
					//console.log( 'back' );
					$resultContainer.fadeOut();
					$loader.fadeOut();

				} else if ( '' !== term ) {

					// 600ms delay so we dont exectute excessively
					timer = setTimeout( function() {

						$loader.fadeIn();

						var data = {

							action : 'inkpro_ajax_woocommerce_live_search',
							s : term
						};

						$.post( InkproParams.ajaxUrl , data, function( response ) {

							//console.log( response );

							if ( '' !== response ) {

								result.empty().html( response );
								$resultContainer.fadeIn();
								$loader.fadeOut();

								//result.find( 'li' ).on( 'click', function() {
								//	var text = $( this ).find( '.term-text' ).text();
								//	//console.log( text );
								//	searchInput.val( text );
								// } );

							} else {
								$resultContainer.fadeOut();
								$loader.fadeOut();
							}
						} );
					}, 600 ); // timer

				} else {
					$resultContainer.fadeOut();
					$loader.fadeOut();
				}
			} );
		},

		/**
		 * Lazy load gallery image
		 */
		lazyLoad : function () {
			$( 'img.lazy-hidden' ).lazyLoadXT();
		},

		/**
		 * Page Load
		 */
		pageLoad : function() {
			this.hideLoader();
			$( window ).trigger( 'resize' ); // trigger resize event to force all window size related calculation
			$( window ).trigger( 'scroll' ); // trigger scroll event to force all window scroll related calculation
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		InkproUi.init();
	} );

	$( window ).load( function() {
		InkproUi.pageLoad();
	} );

} )( jQuery );
