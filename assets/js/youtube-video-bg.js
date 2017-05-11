/*!
 * Youtube Video Background
 *
 * InkPro 2.0.3
 */
/* jshint -W062 */
/* global YT */

var InkproYTVideoBg = function( $ ) {

	'use strict';

	return {

		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,

		/**
		 * @link http://gambit.ph/how-to-use-the-javascript-youtube-api-across-multiple-plugins/
		 */
		init : function ( $container ) {

			var _this = this;

			$container = $container || $( '#page' );

			if ( ! $container.find( '.youtube-video-bg-container' ).length || this.isMobile ) {
				return;
			}

			if ( 'undefined' === typeof( YT ) || 'undefined' === typeof( YT.Player ) ) {
				$.getScript( '//www.youtube.com/player_api' );
			}

			setTimeout( function() {

				if ( typeof window.onYouTubePlayerAPIReady !== 'undefined' ) {
					if ( typeof window.InkproOtherYTAPIReady === 'undefined' ) {
						window.InkproOtherYTAPIReady = [];
					}
					window.InkproOtherYTAPIReady.push( window.onYouTubePlayerAPIReady );
				}

				window.onYouTubePlayerAPIReady = function() {

					// Initialize YT.Player and do stuff here
					_this.playVideo( $container );

					if ( typeof window.InkproOtherYTAPIReady !== 'undefined' ) {
						if ( window.InkproOtherYTAPIReady.length ) {
							window.InkproOtherYTAPIReady.pop()();
						}
					}
				}
			}, 2 );
		},

		/**
		 * Loop through video container and load player
		 */
		playVideo : function( $container ) {

			var _this = this;

			$container.find( '.youtube-video-bg-container' ).each( function() {
				var $this = $( this ), containerId, videoId;

				containerId = $this.find( '.youtube-player' ).attr( 'id' );
				videoId = $this.data( 'youtube-video-id' );

				_this.loadPlayer( containerId, videoId );
			} );
		},

		/**
		 * Load YT player
		 */
		loadPlayer: function( containerId, videoId ) {

			new YT.Player( containerId, {
				width: '100%',
				height: '100%',
				videoId: videoId,
				playerVars: {
					playlist: videoId,
					iv_load_policy: 3, // hide annotations
					enablejsapi: 1,
					disablekb: 1,
					autoplay: 1,
					controls: 0,
					showinfo: 0,
					rel: 0,
					loop: 1,
					wmode: 'transparent'
				},
				events: {
					onReady: function ( event ) {
						event.target.mute().setLoop( true );
						var el = document.getElementById( containerId );
						el.className = el.className + ' youtube-player-is-loaded';
					}
				}
			} );

			$( window ).trigger( 'resize' ); // trigger window calculation for video background
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		InkproYTVideoBg.init();
	} );

} )( jQuery );