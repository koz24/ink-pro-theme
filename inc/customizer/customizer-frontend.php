<?php
/**
 * InkPro Customizer CSS
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueues front-end CSS for color scheme.
 *
 * @see wp_add_inline_style()
 */
function inkpro_color_scheme_css() {
	$color_scheme_option = inkpro_get_color_scheme_option();
	$color_scheme = inkpro_get_color_scheme();

	// Convert needed colors to rgba.
	$color_textcolor_rgb = wolf_hex_to_rgb( $color_scheme[5] );
	$color_bgcolor_rgb = wolf_hex_to_rgb( $color_scheme[0] );

	// If the rgba values are empty return early.
	if ( empty( $color_textcolor_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$colors = array(
		'body_background_color'      => $color_scheme[0],
		'page_background_color' => $color_scheme[1],
		'accent_color'            => $color_scheme[2],
		'main_text_color'       => $color_scheme[3],
		'secondary_text_color'  => $color_scheme[4],
		'strong_text_color'  => $color_scheme[5],
		'submenu_background_color'  => $color_scheme[6],
		'entry_content_background_color'  => $color_scheme[7],
		'shop_tabs_background_color' => $color_scheme[8],
		'shop_tabs_text_color' =>  $color_scheme[9],
		'border_color'          => vsprintf( 'rgba( %s, 0.15)', $color_textcolor_rgb ),
		'search_overlay_background_color' => vsprintf( 'rgba( %s, 0.99)', $color_bgcolor_rgb ),
	);

	$color_scheme_css = inkpro_get_color_scheme_css( $colors );

	if ( ! SCRIPT_DEBUG ) {
		$color_scheme_css = wolf_compact_css( $color_scheme_css );
	}

	wp_add_inline_style( 'inkpro-style', $color_scheme_css );
}
add_action( 'wp_enqueue_scripts', 'inkpro_color_scheme_css' );

/**
 * Enqueues front-end CSS for the body background color.
 *
 * @see wp_add_inline_style()
 */
function inkpro_background_color_css() {
	$color_scheme          = inkpro_get_color_scheme();
	$default_color         = $color_scheme[0];
	$background_color = wolf_get_theme_mod( 'body_background_color', $default_color );

	$css = '
		/* Body Background Color */
		body{
			background-color: %1$s;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $background_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_background_color_css', 11 );

/**
 * Enqueues front-end CSS for the page background color.
 *
 * @see wp_add_inline_style()
 */
function inkpro_page_background_color_css() {
	$color_scheme          = inkpro_get_color_scheme();
	$default_color         = $color_scheme[1];
	$page_background_color = wolf_get_theme_mod( 'page_background_color', $default_color );

	// Convert main text hex color to rgba.
	$page_bg_color_rgb = wolf_hex_to_rgb( $page_background_color );

	// If the rgba values are empty return early.
	if ( empty( $page_bg_color_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$search_overlay_bg_color = vsprintf( 'rgba( %s, 0.99)', $page_bg_color_rgb );

	$css = '
		/* Page Background Color */
		.site-header,
		.post-header-container,
		.content-inner,
		#navbar-container,
		#mobile-bar,
		.loading-overlay,
		#topbar{
			background-color: %1$s;
		}

		#top-search-form-container{
			background: %2$s;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $page_background_color, $search_overlay_bg_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_page_background_color_css', 11 );

/**
 * Enqueues front-end CSS for the accent color.
 *
 * @see wp_add_inline_style()
 */
function inkpro_accent_color_css() {
	$color_scheme = inkpro_get_color_scheme();
	$default_color = $color_scheme[2];
	$accent_color = wolf_get_theme_mod( 'accent_color', $default_color );

	$css = '
		/* Accent Color */
		.accent,
		body.text-link-hover-no a:not(.wpb-button):not(.wpb-bigtext-link):not(.wpb-fittext-link),
		.comment-reply-link,
		.bypostauthor .avatar,
		.wolf-bigtweet-content:before,
		.wolf-more-text,
		#topbar a:hover{
			color:%1$s;
		}

		.button, .wolf-button, input[type=submit],
		.wolf-more-dates,
		.wolf-release-button a,
		.nav-menu li.button-style .menu-item-inner,
		.nav-menu-mobile li.button-style .menu-item-inner,
		body.scroll-to-top-arrow #back-to-top,
		.wolf-show-ticket-button,
		.wolf-event-ticket-button,
		.newsletter-signup .wpb-mailchimp-form-container.wpb-mailchimp-has-bg input[type=submit]:hover{
			border-color: %1$s;
			background: %1$s;
		}

		.has-bg .entry-link:hover,
		.entry-meta a:hover,
		.wpb-entry-meta a:hover,
		.date a:hover,
		.wolf-button-outline,
		.wolf-show-entry-link:hover,
		.wolf-event-entry-link:hover,
		body.scroll-to-top-arrow #back-to-top:hover,
		.wolf-bigtweet-content a,
		.wpb-last-posts .wpb-entry-title a:hover,
		.widget a:hover,
		.site-infos #back-to-top:hover,
		.entry-title a:hover,
		.entry-link:hover,
		.wpb-team-member-social:hover,
		.wolf-show-ticket-button:hover,
		.wolf-event-ticket-button:hover,
		.wolf-upcoming-shows-widget-table .wolf-show-ticket-text,
		.wolf-upcoming-events-widget-table .wolf-event-ticket-text,
		.wpb-last-posts-classic .entry-title a:hover{
			color: %1$s!important;
		}

		.wolf-button.wolf-button-outline:hover {
			color: #fff!important;
			background: %1$s!important;
		}

		.nav-menu li ul.sub-menu li a, .nav-menu li ul.children li a,
		.nav-menu li.mega-menu ul.sub-menu,
		.product-count,
		span.onsale,
		.widget_price_filter .ui-slider .ui-slider-range,
		#infscr-loading,
		#ajax-progress-bar,
		.tagcloud a,
		.sticky-post,
		.scroll-to-top-arrow-style-square #back-to-top:after{
			background: %1$s;
		}

		.button:hover,
		.wolf-button:hover,
		.wolf-release-button a:hover,
		.wolf-more-dates:hover,
		.nav-menu li.button-style .menu-item-inner:hover,
		.nav-menu-mobile li.button-style .menu-item-inner:hover,
		.sticky-menu .nav-menu li.button-style .menu-item-inner:hover,
		input[type=submit]:hover,
		.wolf .sidebar-footer .widget a:hover{
			color:%1$s!important;
		}

		.background-accent,
		.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
		.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{
			background: %1$s!important;
		}

		.trigger,
		span.page-numbers.current,
		a.page-numbers.current,
		.page-links > span:not(.page-links-title)
		{
			background-color: %1$s!important;
			border : solid 1px %1$s;
		}


		.wolf-wpb-button{
			background-color: %1$s!important;
			border : solid 1px %1$s!important;
		}

		.gaia a.wolf_add_to_wishlist:hover,
		.wolf-2017 a.add_to_cart_button:hover,
		.gaia a.add_to_cart_button:hover,
		.wolf-2017 a.more-link:hover,
		.gaia a.more-link:hover{
			background-color: %1$s!important;
			border-color : %1$s!important;
		}

		.wolf-2017 a.add_to_cart_button:hover,
		.gaia a.add_to_cart_button:hover{
			color:white!important;
		}

		.wolf-2017 a.wolf_add_to_wishlist:hover,
		.gaia a.wolf_add_to_wishlist:hover{
			color:red!important;
		}

		.bypostauthor .avatar {
			border: 3px solid %1$s;
		}

		::selection {
			background: %1$s;
		}
		::-moz-selection {
			background: %1$s;
		}

		/*********************
			WPB
		***********************/
		.wpb-icon-box.wpb-icon-type-circle .wpb-icon-no-custom-style.wpb-hover-fill-in:hover, .wpb-icon-box.wpb-icon-type-square .wpb-icon-no-custom-style.wpb-hover-fill-in:hover {
			-webkit-box-shadow: inset 0 0 0 1em %1$s;
			box-shadow: inset 0 0 0 1em %1$s;
			border-color: %1$s;
		}

		.wpb-pricing-table-featured-text,
		.wpb-pricing-table-price-strike:before,
		.wpb-pricing-table-button a{
			background: %1$s;
		}

		.wpb-pricing-table-price,
		.wpb-pricing-table-currency{
			color: %1$s;
		}

		.wpb-team-member-social-container a:hover{
			color: %1$s;
		}

		.wpb-arrow-down:after{
			background: %1$s;
		}

		.wpb-arrow-down:hover {
			background: %1$s;
			border: 2px solid %1$s;
		}

		.wr-instruction-number{
			background: %1$s;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $accent_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_accent_color_css', 11 );

/**
 * Enqueues front-end CSS for the main_text color.
 *
 * @see wp_add_inline_style()
 */
function inkpro_main_text_color_css() {
	$color_scheme          = inkpro_get_color_scheme();
	$default_color         = $color_scheme[3];
	$main_text_color = wolf_get_theme_mod( 'main_text_color', $default_color );

	$css = '
		/* Main Text Color */
		body,
		.nav-label{
			color: %1$s;
		}

		.spinner-color, .sk-child:before, .sk-circle:before, .sk-cube:before{
			background-color: %1$s!important;
		}

		.ball-pulse > div,
		.ball-grid-pulse > div,

		.ball-clip-rotate-pulse-multiple > div,
		.ball-pulse-rise > div,
		.ball-rotate > div,
		.ball-zig-zag > div,
		.ball-zig-zag-deflect > div,
		.ball-scale > div,
		.line-scale > div,
		.line-scale-party > div,
		.ball-scale-multiple > div,
		.ball-pulse-sync > div,
		.ball-beat > div,
		.ball-spin-fade-loader > div,
		.line-spin-fade-loader > div,
		.pacman > div,
		.ball-grid-beat > div{
			background-color: %1$s!important;
		}

		.ball-clip-rotate-pulse > div:first-child{
			background-color: %1$s;
		}

		.ball-clip-rotate-pulse > div:last-child {
			border: 2px solid %1$s;
			border-color: %1$s transparent %1$s transparent;
		}

		.ball-scale-ripple-multiple > div,
		.ball-triangle-path > div{
			border-color: %1$s;
		}

		.pacman > div:first-of-type,
		.pacman > div:nth-child(2){
			background: none!important;
			border-right-color: transparent;
			border-top-color: %1$s;
			border-left-color: %1$s;
			border-bottom-color: %1$s;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $main_text_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_main_text_color_css', 11 );


/**
 * Enqueues front-end CSS for the secondary text color.
 *
 * @see wp_add_inline_style()
 */
function inkpro_secondary_text_color_css() {
	$color_scheme          = inkpro_get_color_scheme();
	$default_color         = $color_scheme[4];
	$secondary_text_color = wolf_get_theme_mod( 'secondary_text_color', $default_color );

	$css = '
		/* Secondary Text Color */
		.categories-links a,
		.tags-links a,
		.posted-on a,
		.comment-meta,
		.comment-meta a,
		.comment-awaiting-moderation,
		.ping-meta,
		.entry-meta,
		.entry-meta a,
		.posted-on,
		.edit-link{
			color: %1$s!important;
		}

		#top-search-form-container {
			color: %1$s;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $secondary_text_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_secondary_text_color_css', 11 );

/**
 * Enqueues front-end CSS for the strong text color.
 *
 * @see wp_add_inline_style()
 */
function inkpro_strong_text_color_css() {
	$color_scheme          = inkpro_get_color_scheme();
	$default_color         = $color_scheme[5];
	$strong_text_color = wolf_get_theme_mod( 'strong_text_color', $default_color );

	// Convert main text hex color to rgba.
	$strong_text_color_rgb = wolf_hex_to_rgb( $strong_text_color );

	// If the rgba values are empty return early.
	if ( empty( $strong_text_color_rgb ) ) {
		return;
	}

	// If we get this far, we have a custom color scheme.
	$border_color = vsprintf( 'rgba( %s, 0.15)', $strong_text_color_rgb );

	$css = '
		/* Strong Text Color */
		a,strong,
		.products li .price,
		.products li .star-rating,
		#top-search-form-container input,
		#close-search,
		.wr-print-button,
		table.cart thead, #content table.cart thead{
			color: %1$s;
		}

		.menu-hover-style-line .nav-menu li a span.menu-item-text-container:after{
			background-color: %1$s;
		}

		.bit-widget-container,
		h1,h2,h3,h4,h5,h6,
		.entry-link,
		#toggle,
		#navbar-container,
		#navbar-container a,
		#navbar-container .wpb-social{
			color: %1$s;
		}

		.widget:not(.wpm_playlist_widget) a,
		.entry-title a,
		.woocommerce-tabs ul.tabs li:not(.active) a:hover{
			color: %1$s!important;
		}

		/* Border Color */
		footer.entry-meta,
		.post-title-divider{
			border-top-color:%2$s;
		}

		.widget-title{
			border-bottom-color:%2$s;
		}

		#topbar .wrap{
			box-shadow: inset 0 -1px 0 0 %2$s;
		}

		#wolf-recipe-box{
			border-color:%2$s;
		}

		.widget_layered_nav_filters ul li a{
			border-color:%2$s;
		}

		hr{
			background:%2$s;
		}

		.wr-stars > span.wr-star-voted:before, .wr-stars>span.wr-star-voted~span:before{
			color: %1$s!important;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $strong_text_color, $border_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_strong_text_color_css', 11 );

/**
 * Enqueues front-end CSS for the sub menu background color.
 *
 * @see wp_add_inline_style()
 */
function inkpro_submenu_background_color_css() {
	$color_scheme          = inkpro_get_color_scheme();
	$default_color         = $color_scheme[6];
	$submenu_background_color = wolf_get_theme_mod( 'submenu_background_color', $default_color );

	$css = '
		/* Submenu color */
		.nav-menu li ul.sub-menu li a, .nav-menu li ul.children li a,
		.nav-menu li.mega-menu ul.sub-menu,
		.cart-menu-panel{
			background:%1$s;
		}

		.menu-hover-style-border .nav-menu li:hover,
		.menu-hover-style-border .nav-menu li.current_page_item,
		.menu-hover-style-border .nav-menu li.current-menu-parent,
		.menu-hover-style-border .nav-menu li.current-menu-item,
		.menu-hover-style-border .nav-menu li.menu-link-active{
			box-shadow: inset 0px 5px 0px 0px %1$s;
		}

		.menu-hover-style-plain .nav-menu li:hover,
		.menu-hover-style-plain .nav-menu li.current_page_item,
		.menu-hover-style-plain .nav-menu li.current-menu-parent,
		.menu-hover-style-plain .nav-menu li.current-menu-item,
		.menu-hover-style-plain .nav-menu li.menu-link-active{
			background:%1$s;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $submenu_background_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_submenu_background_color_css', 11 );

/**
 * Enqueues front-end CSS for the entry background color.
 *
 * @see wp_add_inline_style()
 */
function inkpro_entry_content_background_color_css() {
	$color_scheme          = inkpro_get_color_scheme();
	$default_color         = $color_scheme[7];
	$entry_content_background_color = wolf_get_theme_mod( 'entry_content_background_color', $default_color );

	$css = '
		/* Entry Content Background Color */
		.blog-display-grid2 .entry-content,
		.blog-display-column .entry-content,
		.blog-display-masonry .entry-content,
		.blog-display-masonry2 .entry-content,
		.portfolio-display-grid2 .entry-content,
		.portfolio-display-column .entry-content,
		.portfolio-display-masonry .entry-content,
		.portfolio-display-masonry2 .entry-content,
		#wolf-recipe-box{
			background: %1$s;
		}

		.post-grid2-entry a.entry-thumbnail:before{
			border-bottom-color: %1$s;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $entry_content_background_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_entry_content_background_color_css', 11 );

/**
 * Enqueues front-end CSS for the shop tabs
 *
 * @see wp_add_inline_style()
 */
function inkpro_product_tabs_css() {
	$color_scheme          = inkpro_get_color_scheme();

	$default_bg_color = $color_scheme[8];
	$product_tabs_background_color = wolf_get_theme_mod( 'product_tabs_background_color', $default_bg_color );

	$default_text_color = $color_scheme[9];
	$product_tabs_text_color = wolf_get_theme_mod( 'product_tabs_text_color', $default_text_color );

	$css = '
		.woocommerce-tabs .panel,
		.woocommerce-tabs ul.tabs li.active{
			background: %1$s;
		}

		/*.woocommerce-tabs ul.tabs li:not(.active) a:hover{
			color: %2$s!important;
		}*/

		.woocommerce-tabs .panel,
		.woocommerce-tabs ul.tabs li.active a,
		.woocommerce-tabs .panel h1,
		.woocommerce-tabs .panel h2,
		.woocommerce-tabs .panel h3,
		#reviews .stars a{
			color: %2$s!important;
		}

		#reviews .form-submit input#submit{
			color:%2$s!important;
			border-color:%2$s!important;
		}

		#reviews .form-submit input#submit:hover{
			border-color:%2$s!important;
			background:%2$s!important;
		}

		#reviews .form-submit input#submit:hover{
			color:%1$s!important;
		}
	';

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'inkpro-style', sprintf( $css, $product_tabs_background_color, $product_tabs_text_color ) );
}
add_action( 'wp_enqueue_scripts', 'inkpro_product_tabs_css', 11 );

/**
 * Enqueues front-end CSS for layout
 *
 * @see wp_add_inline_style()
 */
function inkpro_customizer_layout_css() {

	$layout_css = '';

	/* make "hot" & "new" menu label translatable */
	$layout_css .= '
		.nav-menu li.hot > a .menu-item-text-container:before{
			content : "' . esc_html__( 'hot', 'inkpro' ) . '";
		}

		.nav-menu li.new > a .menu-item-text-container:before{
			content : "' . esc_html__( 'new', 'inkpro' ) . '";
		}
	';

	$site_width = apply_filters( 'inkpro_site_width', wolf_get_theme_mod( 'site_width' ) );

	if ( $site_width ) {
		$layout_css .= '
			body.site-layout-boxed.desktop .site-container,
			body.site-layout-boxed.desktop .parallax-mirror{
				max-width:' . absint( $site_width ) . 'px;
			}
		';
	}

	$site_margin = apply_filters( 'inkpro_site_margin', wolf_get_theme_mod( 'site_margin' ) );

	if ( $site_margin ) {

		if ( is_numeric( $site_margin ) ) {
			$site_margin = absint( $site_margin ) . 'px';
		} else {
			$site_margin = esc_attr( $site_margin );
		}

		$layout_css .= "
			body.desktop.site-layout-frame .site-container{
				margin:$site_margin;
			}
		";
	}

	/* Link style */
	$accent = apply_filters( 'inkpro_accent_color', wolf_get_theme_mod( 'accent_color' ) );
	if ( $accent ) {
		$text_link_style = apply_filters( 'inkpro_text_link_style', wolf_get_theme_mod( 'text_link_style', 'colored' ) );
		$a_selector = 'a:not(.menu-link):not(.wpb-image-inner):not(.wpb-button):not(.wpb-bigtext-link):not(.wpb-fittext-link):not(.wpb-icon-link):not(.ui-tabs-anchor):not(.wpb-icon-title-link):not(.wpb-icon-link):not(.wpb-team-member-social)';

		if ( 'colored' == $text_link_style ) {
			$layout_css .= "
			$a_selector{ color:$accent; }
			$a_selector:hover{opacity:0.8;}
			";
		} elseif ( 'colored_hover' == $text_link_style ) {
			$layout_css .= "
			$a_selector{ font-weight:700; }
			$a_selector:hover{color:$accent;}
			";
		}
	}

	/* Menu height */
	$menu_height = absint( wolf_get_theme_mod( 'menu_height', 80 ) );

	if ( $menu_height ) {
		$menu_height_with_top_bar = ( inkpro_display_topbar() ) ? 38 : 0;
		$menu_height_with_top_bar = $menu_height_with_top_bar + $menu_height;

		$layout_css .= '
			.nav-menu li,
			.nav-menu li a{
				height: ' . $menu_height . 'px;
			}

			body.desktop:not(.sticking) .logo-container{
				height: ' . $menu_height . 'px;
			}

			#nav-holder,
			#navbar-container{
				min-height: ' . $menu_height . 'px;
			}

			#navbar-container ul.sub-menu{
				top: ' . $menu_height . 'px;
			}

			.desktop .post-header-inner,
			.desktop .post-header-holder{
				padding-top:' . $menu_height_with_top_bar . 'px;
			}

			.wolf-page-builder.desktop .post-header-holder{
				padding-top:0;
			}

			.menu-type-standard.wolf-page-builder.desktop.no-hero .site-header{
				min-height: ' . $menu_height_with_top_bar . 'px;
			}

			/* deprecated
			.menu-type-standard.desktop.no-hero .site-header{
				min-height: ' . $menu_height_with_top_bar . 'px;
			}

			.wolf-page-builder.no-hero.desktop .wpb-first-section{
				padding-top:' . $menu_height_with_top_bar . 'px;
			}

			.menu-type-absolute.no-hero.desktop .wpb-first-section{
				padding-top:0!important;
			}*/
			';

			$logo_shrink_menu = wolf_get_theme_mod( 'logo_shrink_menu' );

			if ( $logo_shrink_menu ) {
				$layout_css .= '
				.logo a img{
					max-height:'. $menu_height . 'px;
				}

				.sticking .logo a img{
					max-height:80px;
				}
				';
			}
	}

	/* Menu height */
	$menu_item_padding = absint( wolf_get_theme_mod( 'menu_item_padding' ) );

	if ( $menu_item_padding ) {

		$menu_item_padding = $menu_item_padding / 2;

		$layout_css .= '
			.nav-menu li a{
				padding: 0 '  .$menu_item_padding . 'px;
			}
		';
	}

	/* Logo with */
	$logo_width = absint( wolf_get_theme_mod( 'logo_width', 200 ) );

	if ( $logo_width && 'centered' != wolf_get_theme_mod( 'menu_layout' ) ) {
		$layout_css .= '
			.logo-container{
				width:' . $logo_width . 'px;
			}
			.logo-img-inner img{
				max-width:' . $logo_width . 'px!important;
			}

			.logo-table-cell,
			.icons-table-cell{
				width:' . $logo_width . 'px!important;
			}
		';
	}

	/* Logo vertical align */
	$logo_vertical_align = wolf_get_theme_mod( 'logo_vertical_align' );
	if ( $logo_vertical_align ) {
		$layout_css .= '
			body.desktop .logo{
				top: 50%;
			}

			body.desktop .logo a img{
				-webkit-transform:translate(0, -50%);
				transform:translate(0, -50%);
			}
		';
	}

	// Menu item separator if anny
	$main_menu_item_separator = wolf_get_theme_mod( 'main_menu_item_separator' );
	if ( $main_menu_item_separator ) {
		$layout_css .= '.nav-menu li:before{
			content:" ' . $main_menu_item_separator . ' ";
		}';
	}

	/* 404 Background */
	$background_404 = wolf_get_theme_option( '404_bg' );

	if ( $background_404 ) {
		$background_404_img_url = esc_url( wolf_get_url_from_attachment_id( $background_404, 'inkpro-XL' ) );
		$layout_css .= '
			body.error404 .content-inner{
				color: #FFF;
				background-image: url(' . $background_404_img_url . ')!important;
			}
		';
	}

	if ( ! SCRIPT_DEBUG ) {
		$layout_css = wolf_compact_css( $layout_css );
	}

	wp_add_inline_style( 'inkpro-style', $layout_css );
}
add_action( 'wp_enqueue_scripts', 'inkpro_customizer_layout_css' );

/**
 * Enqueues front-end CSS for fonts
 *
 * @see wp_add_inline_style()
 */
function inkpro_customizer_fonts_css() {

	$font_css = '';

	/* Body Font */
	$body_font = wolf_get_theme_mod( 'body_font_name' );
	$body_selectors = 'body, blockquote.wpb-testimonial-content';

	if ( $body_font ) {
		$font_css .= "$body_selectors{font-family:$body_font}";
	}

	/* Heading Font */
	$heading_font = wolf_get_theme_mod( 'heading_font_name' );
	$heading_family_selectors = 'h1, h2, h3, h4, h5, h6, .post-title, .entry-title, h2.entry-title > .entry-link, h2.entry-title, .widget-title, .wpb-counter-text, .wpb-countdown-period';
	$heading_selectors = 'h1:not(.wpb-bigtext):not(.wpb-fittext), h2:not(.wpb-bigtext):not(.wpb-fittext), h3:not(.wpb-bigtext):not(.wpb-fittext), h4:not(.wpb-bigtext):not(.wpb-fittext), h5:not(.wpb-bigtext):not(.wpb-fittext), .post-title, .entry-title, h2.entry-title > .entry-link, h2.entry-title, .widget-title, .wpb-counter-text, .wpb-countdown-period';

	if ( $heading_font && 'default' != $heading_font ) {
		$font_css .= "$heading_family_selectors{font-family:$heading_font}";
	}

	$heading_font_weight = wolf_get_theme_mod( 'heading_font_weight' );

	if ( $heading_font_weight ) {
		$font_css .= "$heading_selectors{font-weight:$heading_font_weight!important}";
	}

	$heading_font_transform = wolf_get_theme_mod( 'heading_font_transform' );

	if ( $heading_font_transform ) {
		$font_css .= "$heading_selectors{text-transform:$heading_font_transform}";
	}

	$heading_font_style = wolf_get_theme_mod( 'heading_font_style' );

	if ( $heading_font_style ) {
		$font_css .= "$heading_selectors{font-style:$heading_font_style}";
	}

	$heading_letterspacing = wolf_get_theme_mod( 'heading_font_letter_spacing' );

	if ( $heading_letterspacing ) {
		$heading_letterspacing = intval( $heading_letterspacing ) . 'px';
		$font_css .= "$heading_selectors{letter-spacing:$heading_letterspacing}";
	}

	/* Menu Font */
	$menu_font_size = wolf_get_theme_mod( 'menu_font_size' );
	$menu_font_size_desktop_selector = '.nav-menu li';

	if ( is_numeric( $menu_font_size ) ) {
		$menu_font_size = absint( $menu_font_size ) . 'px';
	}

	if ( $menu_font_size ) {
		$font_css .= "$menu_font_size_desktop_selector{font-size:$menu_font_size}";
	}

	$menu_font_size_mobile = wolf_get_theme_mod( 'menu_font_size_mobile' );
	$menu_font_size_mobile_selector = '.nav-menu-mobile li';

	if ( is_numeric( $menu_font_size_mobile ) ) {
		$menu_font_size_mobile = absint( $menu_font_size_mobile ) . 'px';
	}

	if ( $menu_font_size_mobile ) {
		$font_css .= "$menu_font_size_mobile_selector{font-size:$menu_font_size_mobile}";
	}


	$menu_font = wolf_get_theme_mod( 'menu_font_name' );
	$menu_selectors = '.nav-menu li a span.menu-item-inner, .nav-menu-mobile li a span.menu-item-inner';

	if ( $menu_font && 'default' != $menu_font ) {
		$font_css .= "$menu_selectors{ font-family:'$menu_font'}";
	}

	$menu_font_weight = wolf_get_theme_mod( 'menu_font_weight' );

	if ( $menu_font_weight ) {
		$font_css .= "$menu_selectors{font-weight:$menu_font_weight}";
	}

	$menu_font_transform = wolf_get_theme_mod( 'menu_font_transform' );

	if ( $menu_font_transform ) {
		$font_css .= "$menu_selectors{text-transform:$menu_font_transform}";
	}

	$menu_font_style = wolf_get_theme_mod( 'menu_font_style' );

	if ( $menu_font_style ) {
		$font_css .= "$menu_selectors{font-style:$menu_font_style}";
	}

	$menu_letterspacing = wolf_get_theme_mod( 'menu_font_letter_spacing' );

	if ( $menu_letterspacing ) {
		$menu_letterspacing = intval( $menu_letterspacing ) . 'px';
		$font_css .= "$menu_selectors{letter-spacing:$menu_letterspacing}";
	}

	if ( ! SCRIPT_DEBUG ) {
		$font_css = wolf_compact_css( $font_css );
	}

	wp_add_inline_style( 'inkpro-style', $font_css );
}
add_action( 'wp_enqueue_scripts', 'inkpro_customizer_fonts_css' );

/**
 * Enqueues front-end CSS for background
 *
 * @see wp_add_inline_style()
 */
function inkpro_customizer_backgrounds_css() {

	$backgrounds_css = '';

	$backgrounds = array(
		'light_background' => '.wpb-font-dark:not(.wpb-block)',
		'dark_background' => '.wpb-font-light:not(.wpb-block)',
		'footer_bg' => '.sidebar-footer',
		'bottom_bar_bg' => '.site-infos',
		'music_network_bg' => '.music-social-icons-container',
	);

	/*-----------------------------------------------------------------------------------*/
	/*  wBounce
	/*-----------------------------------------------------------------------------------*/
	if ( get_header_image() ) {
		$backgrounds_css .= '.has-default-header .wbounce-modal-sub{background-image:url( ' . get_header_image() . ' );}';
	}

	$backgrounds_css .= inkpro_get_customizer_bg_css( $backgrounds );

	if ( ! SCRIPT_DEBUG ) {
		$backgrounds_css = wolf_compact_css( $backgrounds_css );
	}

	wp_add_inline_style( 'inkpro-style', $backgrounds_css );
} // end function
add_action( 'wp_enqueue_scripts', 'inkpro_customizer_backgrounds_css' );
