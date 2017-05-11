<?php
/**
 * InkPro customizer functions
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get default color skin
 *
 * Get old option name if empty
 *
 * @version 2.0.3
 * @return string
 */
function inkpro_get_color_scheme_option() {
	return apply_filters( 'inkpro_color_scheme_option', get_theme_mod( 'color_scheme', get_theme_mod( 'skin', 'default' ) ) );
}

/**
 * Registers color schemes for InkPro.
 *
 * Can be filtered with {@see 'inkpro_color_schemes'}.
 *
 * The order of colors in a colors array:
 * 1. Main Background Color.
 * 2. Page Background Color.
 * 3. Link Color.
 * 4. Main Text Color.
 * 5. Secondary Text Color.
 * 5. Strong Text Color.
 * 6. Sub Menu Background Color.
 * 7. Entry Content Frame Background Color.
 *
 * @return array An associative array of color scheme options.
 */
function inkpro_get_color_schemes() {
	/**
	 * Filter the color schemes registered for use with InkPro.
	 *
	 * The default schemes include 'default', 'dark', 'light'
	 *
	 *
	 * @param array $schemes {
	 *     Associative array of color schemes data.
	 *
	 *     @type array $slug {
	 *         Associative array of information for setting up the color scheme.
	 *
	 *         @type string $label  Color scheme label.
	 *         @type array  $colors HEX codes for default colors prepended with a hash symbol ('#').
	 *                              Colors are defined in the following order: Main background, page
	 *                              background, link, main text, secondary text.
	 *     }
	 * }
	 */
	return apply_filters( 'inkpro_color_schemes', array(
		'default' => array(
			'label'  => esc_html__( 'Default', 'inkpro' ),
			'colors' => array(
				'#282828', // bg
				'#ffffff', // page bg
				'#007acc', // accent
				'#666', // main text
				'#2d2d2d', // second text
				'#333333', // strong text
				'#333333', // submenu
				'#ffffff', // content frame
				'#007acc', // shop tabs background
				'#ffffff', // shop tabs text
			),
		),
		'light' => array(
			'label'  => esc_html__( 'Light', 'inkpro' ),
			'colors' => array(
				'#ffffff', // bg
				'#ffffff', // page bg
				'#333333', // accent
				'#666', // main text
				'#2d2d2d', // second text
				'#333333', // strong text
				'#333333', // submenu
				'#ffffff', // content frame,
				'#333333', // shop tabs background
				'#ffffff', // shop tabs text
			),
		),
		'dark' => array(
			'label'  => esc_html__( 'Dark', 'inkpro' ),
			'colors' => array(
				'#262626', // bg
				'#1a1a1a', // page bg
				'#63a69f', // accent
				'#e5e5e5', // main text
				'#c1c1c1', // second text
				'#FFFFFF', // strong text
				'#282828', // submenu
				'#0d0d0d', // content frame,
				'#63a69f', // shop tabs background
				'#ffffff', // shop tabs text
			),
		),
	) );
}

/**
 * Deregister background and header settings to add it later where we want them
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function inkpro_customize_deregister( $wp_customize ) {
	$wp_customize->remove_control( 'background_color' );
	$wp_customize->remove_control( 'header_textcolor' );
}
add_action( 'customize_register', 'inkpro_customize_deregister', 11 );

/**
 * Removes the core 'Menus' panel from the Customizer.
 *
 * As we have added a lot of menu item options with a Walker class we don't want the menu to be save and reset all the options
 *
 * @param array $components Core Customizer components list.
 * @return array (Maybe) modified components list.
 */
function wofltheme_remove_nav_menus_panel( $wp_customize ) {

	$wp_customize->get_panel( 'nav_menus' )->active_callback = '__return_false';
}
add_action( 'customize_register', 'wofltheme_remove_nav_menus_panel', 50 );


if ( ! function_exists( 'inkpro_get_color_scheme' ) ) {
	/**
	 * Retrieves the current InkPro color scheme.
	 *
	 * Create your own inkpro_get_color_scheme() function to override in a child theme.
	 *
	 * @return array An associative array of either the current or default color scheme HEX values.
	 */
	function inkpro_get_color_scheme() {
		$color_scheme_option = inkpro_get_color_scheme_option();
		$color_schemes = inkpro_get_color_schemes();

		if ( array_key_exists( $color_scheme_option, $color_schemes ) ) {
			return $color_schemes[ $color_scheme_option ]['colors'];
		} else {
			return $color_schemes['default']['colors'];
		}
	}
}

if ( ! function_exists( 'inkpro_get_color_scheme_choices' ) ) {
	/**
	 * Retrieves an array of color scheme choices registered for InkPro.
	 *
	 * Create your own inkpro_get_color_scheme_choices() function to override
	 * in a child theme.
	 *
	 *
	 * @return array Array of color schemes.
	 */
	function inkpro_get_color_scheme_choices() {
		$color_schemes = inkpro_get_color_schemes();
		$color_scheme_control_options = array();

		foreach ( $color_schemes as $color_scheme => $value ) {
			$color_scheme_control_options[ $color_scheme ] = $value['label'];
		}

		return $color_scheme_control_options;
	}
}

if ( ! function_exists( 'inkpro_sanitize_color_scheme' ) ) {
	/**
	 * Handles sanitization for InkPro color schemes.
	 *
	 * Create your own inkpro_sanitize_color_scheme() function to override
	 * in a child theme.
	 *
	 * @param string $value Color scheme name value.
	 * @return string Color scheme name.
	 */
	function inkpro_sanitize_color_scheme( $value ) {
		$color_schemes = inkpro_get_color_scheme_choices();

		if ( ! array_key_exists( $value, $color_schemes ) ) {
			return 'default';
		}

		return $value;
	}
}

/**
 * Binds the JS listener to make Customizer color_scheme control.
 *
 * Passes color scheme data as colorScheme global.
 *
 */
function inkpro_customize_control_js() {

	wp_enqueue_style( 'inkpro-customizer-style', WOLF_THEME_CSS . '/customizer.css' );

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WOLF_THEME_VERSION;
	wp_enqueue_script( 'inkpro-customize-color-scheme-control', WOLF_THEME_JS . '/color-scheme-control.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), $version, true );
	wp_localize_script( 'inkpro-customize-color-scheme-control', 'colorScheme', inkpro_get_color_schemes() );
}
add_action( 'customize_controls_enqueue_scripts', 'inkpro_customize_control_js' );

/**
 * Enqueue customizer preview script
 */
function inkpro_customize_preview_js() {

	$version = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? time() : WOLF_THEME_VERSION;
	wp_enqueue_script( 'inkpro-customize-preview', WOLF_THEME_JS . '/customize-preview.js', array( 'jquery', 'customize-preview' ), $version, true );
}
add_action( 'customize_preview_init', 'inkpro_customize_preview_js' );

/**
 * Returns CSS for the color schemes.
 *
 *
 * @param array $colors Color scheme colors.
 * @return string Color scheme CSS.
 */
function inkpro_get_color_scheme_css( $colors ) {

	$colors = wp_parse_args( $colors, array(
		'body_background_color'      => '',
		'page_background_color' => '',
		'accent_color'            => '',
		'main_text_color'       => '',
		'secondary_text_color'  => '',
		'strong_text_color'     	=> '',
		'submenu_background_color' => '',
		'entry_content_background_color' => '',
		'product_tabs_background_color' => '',
		'product_tabs_text_color' => '',
		'border_color' => '',
		'search_overlay_background_color' => '',
	) );

	$a_selector = 'a:not(.menu-link):not(.wpb-image-inner):not(.wpb-button):not(.wpb-bigtext-link):not(.wpb-fittext-link):not(.wpb-icon-link):not(.ui-tabs-anchor):not(.wpb-icon-title-link):not(.wpb-icon-link):not(.wpb-team-member-social)';
	$text_link_style = apply_filters( 'inkpro_text_link_style', wolf_get_theme_mod( 'text_link_style', 'colored' ) );

	if ( 'colored_hover' == $text_link_style ) {
		$a_selector = $a_selector . ':hover';
	}

	return <<<CSS
	/* Color Scheme */

	/* Background Color */
	body {
		background-color: {$colors['body_background_color']};
	}

	/* Page Background Color */
	.site-header,
	.post-header-container,
	.content-inner,
	#navbar-container,
	#mobile-bar,
	.loading-overlay,
	#topbar{
		background-color: {$colors['page_background_color']};
	}

	/* Accent Color */

	$a_selector{ color:{$colors['accent_color']}; }

	.accent,
	body.text-link-hover-no a:not(.wpb-button):not(.wpb-bigtext-link):not(.wpb-fittext-link),
	.comment-reply-link,
	.bypostauthor .avatar,
	.wolf-bigtweet-content:before,
	.wolf-more-text,
	#topbar a:hover{
		color:{$colors['accent_color']};
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
		border-color: {$colors['accent_color']};
		background: {$colors['accent_color']};
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
		color: {$colors['accent_color']}!important;
	}

	.wolf-button.wolf-button-outline:hover {
		color: #fff!important;
		background: {$colors['accent_color']}!important;
	}

	.nav-menu li ul.sub-menu li a, .nav-menu li ul.children li a,
	.nav-menu li.mega-menu ul.sub-menu,
	.product-count,
	span.onsale,
	.widget_price_filter .ui-slider .ui-slider-range,
	.woocommerce-tabs .panel,
	.woocommerce-tabs ul.tabs li.active,
	#infscr-loading,
	#ajax-progress-bar,
	.tagcloud a,
	.sticky-post,
	.scroll-to-top-arrow-style-square #back-to-top:after{
		background: {$colors['accent_color']};
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
		color:{$colors['accent_color']}!important;
	}

	/* #navbar-container .nav-menu li a.wpb-social-link span.wpb-social:hover, */

	.background-accent,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current,
	.mejs-container .mejs-controls .mejs-time-rail .mejs-time-current, .mejs-container .mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current{
		background: {$colors['accent_color']}!important;
	}

	.trigger,
	span.page-numbers.current,
	a.page-numbers.current,
	.page-links > span:not(.page-links-title)
	{
		background-color: {$colors['accent_color']}!important;
		border : solid 1px {$colors['accent_color']};
	}

	.wolf-wpb-button{
		background-color: {$colors['accent_color']}!important;
		border : solid 1px {$colors['accent_color']}!important;
	}

	.wolf-2017 a.wolf_add_to_wishlist:hover,
	.gaia a.wolf_add_to_wishlist:hover,
	.wolf-2017 a.add_to_cart_button:hover,
	.gaia a.add_to_cart_button:hover,
	.wolf-2017 a.more-link:hover,
	.gaia a.more-link:hover{
		background-color: {$colors['accent_color']}!important;
		border-color : {$colors['accent_color']}!important;
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
		border: 3px solid {$colors['accent_color']};
	}

	::selection {
		background: {$colors['accent_color']};
	}
	::-moz-selection {
		background: {$colors['accent_color']};
	}

	/*********************
		WPB
	***********************/
	.wpb-icon-box.wpb-icon-type-circle .wpb-icon-no-custom-style.wpb-hover-fill-in:hover, .wpb-icon-box.wpb-icon-type-square .wpb-icon-no-custom-style.wpb-hover-fill-in:hover {
		-webkit-box-shadow: inset 0 0 0 1em {$colors['accent_color']};
		box-shadow: inset 0 0 0 1em {$colors['accent_color']};
		border-color: {$colors['accent_color']};
	}

	.wpb-pricing-table-featured-text,
	.wpb-pricing-table-price-strike:before,
	.wpb-pricing-table-button a{
		background: {$colors['accent_color']};
	}

	.wpb-pricing-table-price,
	.wpb-pricing-table-currency{
		color: {$colors['accent_color']};
	}

	.wpb-team-member-social-container a:hover{
		color: {$colors['accent_color']};
	}

	.wpb-arrow-down:after{
		background:{$colors['accent_color']};
	}

	.wpb-arrow-down:hover {
		background: {$colors['accent_color']};
		border: 2px solid {$colors['accent_color']};
	}

	.wr-instruction-number{
		background: {$colors['accent_color']};
	}

	/* Main Text Color */
	body,
	.nav-label{
		color: {$colors['main_text_color']};
	}

	.spinner-color, .sk-child:before, .sk-circle:before, .sk-cube:before{
		background-color: {$colors['main_text_color']}!important;
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
			background-color: {$colors['main_text_color']}!important;
		}

		.ball-clip-rotate-pulse > div:first-child{
			background-color: {$colors['main_text_color']};
		}

		.ball-clip-rotate-pulse > div:last-child {
			border: 2px solid {$colors['main_text_color']};
			border-color: {$colors['main_text_color']} transparent {$colors['main_text_color']} transparent;
		}

		.ball-scale-ripple-multiple > div,
		.ball-triangle-path > div{
			border-color: {$colors['main_text_color']};
		}

		.pacman > div:first-of-type,
		.pacman > div:nth-child(2){
			background: none!important;
			border-right-color: transparent;
			border-top-color: {$colors['main_text_color']};
			border-left-color: {$colors['main_text_color']};
			border-bottom-color: {$colors['main_text_color']};
		}

	/* Border Color */
	footer.entry-meta,
	.post-title-divider{
		border-top-color:{$colors['border_color']};
	}

	.widget-title{
		border-bottom-color:{$colors['border_color']};
	}

	#topbar .wrap{
		box-shadow: inset 0 -1px 0 0 {$colors['border_color']};
	}

	#wolf-recipe-box{
		border-color:{$colors['border_color']};
	}

	hr{
		background:{$colors['border_color']};
	}

	.widget_layered_nav_filters ul li a{
		border-color:{$colors['border_color']};
	}

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
		color: {$colors['secondary_text_color']}!important;
	}

	#top-search-form-container {
		color: {$colors['secondary_text_color']};
	}

	/* Strong Text Color */
	a,strong,
	.products li .price,
	.products li .star-rating,
	#top-search-form-container input,
	#close-search,
	.wr-print-button,
	table.cart thead, #content table.cart thead{
		color: {$colors['strong_text_color']};
	}

	.menu-hover-style-line .nav-menu li a span.menu-item-text-container:after{
		background-color: {$colors['strong_text_color']};
	}

	.bit-widget-container,
	h1,h2,h3,h4,h5,h6,
	.entry-link,
	#toggle,
	#navbar-container,
	#navbar-container a,
	#navbar-container .wpb-social{
		color: {$colors['strong_text_color']};
	}

	.widget:not(.wpm_playlist_widget) a,
	.entry-title a,
	.woocommerce-tabs ul.tabs li:not(.active) a:hover{
		color: {$colors['strong_text_color']}!important;
	}

	.wr-stars>span.wr-star-voted:before, .wr-stars>span.wr-star-voted~span:before{
		color: {$colors['strong_text_color']}!important;
	}

	/* Submenu color */
	.nav-menu li ul.sub-menu li a, .nav-menu li ul.children li a,
	.nav-menu li.mega-menu ul.sub-menu,
	.cart-menu-panel{
		background:{$colors['submenu_background_color']};
	}

	.menu-hover-style-border .nav-menu li:hover,
	.menu-hover-style-border .nav-menu li.current_page_item,
	.menu-hover-style-border .nav-menu li.current-menu-parent,
	.menu-hover-style-border .nav-menu li.current-menu-item,
	.menu-hover-style-border .nav-menu li.menu-link-active{
		box-shadow: inset 0px 5px 0px 0px {$colors['submenu_background_color']};
	}

	.menu-hover-style-plain .nav-menu li:hover,
	.menu-hover-style-plain .nav-menu li.current_page_item,
	.menu-hover-style-plain .nav-menu li.current-menu-parent,
	.menu-hover-style-plain .nav-menu li.current-menu-item,
	.menu-hover-style-plain .nav-menu li.menu-link-active{
		background:{$colors['submenu_background_color']};
	}

	/* Entry Content Background Color */
	.blog-display-grid2 .entry-content,
	.blog-display-column .entry-content,
	.blog-display-masonry .entry-content,
	.portfolio-display-grid2 .entry-content,
	.portfolio-display-column .entry-content,
	.portfolio-display-masonry .entry-content,
	#wolf-recipe-box{
		background: {$colors['entry_content_background_color']};
	}

	.post-grid2-entry a.entry-thumbnail:before{
		border-bottom-color: {$colors['entry_content_background_color']};
	}


	/* Product tabs */
	.woocommerce-tabs .panel,
	.woocommerce-tabs ul.tabs li.active{
		background: {$colors['product_tabs_background_color']};
	}

	/*.woocommerce-tabs ul.tabs li:not(.active) a:hover{
		color: {$colors['product_tabs_text_color']}!important;
	}*/

	.woocommerce-tabs .panel,
	.woocommerce-tabs ul.tabs li.active a,
	.woocommerce-tabs .panel h1,
	.woocommerce-tabs .panel h2,
	.woocommerce-tabs .panel h3,
	#reviews .stars
	{
		color: {$colors['product_tabs_text_color']}!important;
	}

	#reviews .form-submit input#submit{
		color:{$colors['product_tabs_text_color']}!important;
		border-color:{$colors['product_tabs_text_color']}!important;
	}

	#reviews .form-submit input#submit:hover{
		border-color:{$colors['product_tabs_text_color']}!important;
		background:{$colors['product_tabs_text_color']}!important;
	}

	#reviews .form-submit input#submit:hover{
		color:{$colors['product_tabs_background_color']}!important;
	}

CSS;
}

/**
 * Get array of colors of the Underscore template
 *
 * @return array $colors
 */
function inkpro_get_template_identifiers() {
	$colors = array(
		'body_background_color',
		'page_background_color',
		'accent_color',
		'main_text_color',
		'secondary_text_color',
		'strong_text_color',
		'submenu_background_color',
		'entry_content_background_color',
		'product_tabs_background_color',
		'product_tabs_text_color',
		'border_color',
		'search_overlay_background_color',
	);

	return $colors;
}

/**
 * Get array of colors of the Underscore template
 *
 * @return array $colors
 */
function inkpro_get_template_colors() {

	$colors = array();

	foreach ( inkpro_get_template_identifiers() as $id ) {
		$colors[ $id ] =  '{{ data.' . $id . ' }}';
	}

	return $colors;
}


/**
 * Outputs an Underscore template for generating CSS for the color scheme.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function inkpro_color_scheme_css_template() {

	$colors = inkpro_get_template_colors();
	?>
	<script type="text/html" id="tmpl-inkpro-color-scheme">
		<?php echo inkpro_get_color_scheme_css( $colors ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'inkpro_color_scheme_css_template' );

/**
 * Get bg CSS
 *
 */
function inkpro_get_customizer_bg_css( $selectors = array() ) {

	$css = '';

	foreach ( $selectors as $id => $selector ) {

		$img = '';
		$color = wolf_get_theme_mod( $id . '_color' );
		$repeat = wolf_get_theme_mod( $id . '_repeat' );
		$position = wolf_get_theme_mod( $id . '_position' );
		$attachment = wolf_get_theme_mod( $id . '_attachment' );
		$size = wolf_get_theme_mod( $id . '_size' );
		$none = wolf_get_theme_mod( $id . '_none' );
		$parallax = wolf_get_theme_mod( $id . '_parallax' );
		$opacity = intval(wolf_get_theme_mod( $id . '_opacity', 100 )) / 100;
		$color_rgba = 'rgba(' . wolf_hex_to_rgb( $color ) . ', ' . $opacity .')';

		/* Backgrounds
		---------------------------------*/
		if ( '' == $none ) {

			if ( wolf_get_theme_mod( $id . '_img' ) )
				$img = 'url("'. wolf_get_theme_mod( $id . '_img' ) .'")';

			if ( $color || $img ) {

				if ( ! $img ) {
					$css .= "$selector {background-color:$color;background-color:$color_rgba;}";
				}

				if ( $img )  {

					if ( $parallax ) {

						$css .= "$selector {background : $color $img $repeat fixed}";
						$css .= "$selector {background-position : 50% 0}";

					} else {
						$css .= "$selector {background : $color $img $position $repeat $attachment}";
					}

					if ( 'cover' == $size ) {

						$css .= "$selector {
							-webkit-background-size: 100%;
							-o-background-size: 100%;
							-moz-background-size: 100%;
							background-size: 100%;
							-webkit-background-size: cover;
							-o-background-size: cover;
							background-size: cover;
						}";
					}

					if ( 'resize' == $size ) {

						$css .= "$selector {
							-webkit-background-size: 100%;
							-o-background-size: 100%;
							-moz-background-size: 100%;
							background-size: 100%;
						}";
					}
				}
			}
		} else {
			$css .= "$selector {background:none;}";
		}

	} // end foreach selectors

	return $css;
}