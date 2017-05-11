<?php
/**
 * InkPro conditional functions
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Check if the current post uses Wolf Page Builder
 *
 * @return bool
 */
function inkpro_is_wpb() {
	if ( class_exists( 'Wolf_Page_Builder' ) ) {
		if ( function_exists( 'is_wpb' ) ) {
			return is_wpb();
		}
	}
}

/**
 * Check if VC is used on this page
 *
 * @param
 * @return
 */
function inkpro_is_vc() {

	global $post;

	if ( is_page() && 'default' == get_post_meta( get_the_ID(), '_wp_page_template', true ) ) {
		if ( is_object( $post ) ) {
			$pattern = get_shortcode_regex();
			if ( preg_match( "/$pattern/s", $post->post_content, $match ) ) {
				if ( 'vc_row' == $match[2] ) {
					return true;
				}
			}
		}
	}
}

/**
 * Check if the home page is set to default
 *
 * Returns true if not page for post and front page are set in the reading settings
 *
 * @return bool
 */
function inkpro_is_home_as_blog() {
	return ! get_option( 'page_for_posts' ) && ! get_option( 'page_on_front' ) && is_home();
}

/**
 * Check if the hero content is set
 *
 * @return bool
 */
function inkpro_has_hero() {

	/**
	 * Is header image ?
	 */
	$header_post_id  = inkpro_get_header_post_id();
	$post_header_type = get_post_meta( $header_post_id, '_post_header_type', true );
	$header_bg_type = ( get_post_meta( $header_post_id, '_post_bg_type', true ) ) ? get_post_meta( $header_post_id, '_post_bg_type', true ) : 'image';
	$header_bg_color = get_post_meta( $header_post_id, '_post_bg_color', true );
	$header_bg_img = get_post_meta( $header_post_id, '_post_bg_img', true );
	$header_bg_mp4 = get_post_meta( $header_post_id, '_post_video_bg_mp4', true );
	$header_video_bg_type = get_post_meta( $header_post_id, '_post_video_bg_type', true );
	$header_video_bg_youtube_url = get_post_meta( $header_post_id, '_post_video_bg_youtube_url', true );

	if ( 'none' == wolf_get_theme_mod( 'auto_header_type' ) || 'none' == $post_header_type ) {
		return;
	}

	if ( function_exists( 'is_product_category' ) && is_product_category() && get_woocommerce_term_meta( get_queried_object()->term_id, 'thumbnail_id', true ) ) {
		return true;
	}

	// Default header image
	if ( get_header_image() ) {
		return true;
	}

	// dafaullt customizer options that uses the featured image
	if ( 'image' == $header_bg_type && 'yes' == wolf_get_theme_mod( 'auto_header' ) && has_post_thumbnail( $header_post_id ) && ! $header_bg_color && ! $header_bg_img ) {

		return true;

	// Header image from the page settings
	} elseif ( $header_post_id ) {

		if ( 'image' == $header_bg_type ) {

			if ( $header_bg_img || $header_bg_color ) {

				return true;
			}

		} elseif ( 'video' == $header_bg_type ) {

			if ( 'youtube' == $header_video_bg_type && $header_video_bg_youtube_url ) {
				return true;
			}

			if ( 'selfhosted' == $header_video_bg_type && $header_bg_mp4 ) {
				return true;
			}
		}
	}
}

/**
 * Check if we're on the blog index page
 *
 * @return bool
 */
function inkpro_is_blog_index() {

	global $wp_query;

	return inkpro_is_home_as_blog() || ( is_object( $wp_query ) && isset( $wp_query->queried_object ) && isset( $wp_query->queried_object->ID ) && $wp_query->queried_object->ID == get_option( 'page_for_posts' ) );
}

/**
 * Check if we're on a blog page
 *
 * @return bool
 */
function inkpro_is_blog() {

	$is_blog = ( inkpro_is_home_as_blog() || inkpro_is_blog_index() || is_search() || is_archive() ) && ! inkpro_is_woocommerce() && 'post' == get_post_type();
	return ( true == $is_blog );
}

/**
 * Check if we're on a portfolio page
 *
 * @return bool
 */
function inkpro_is_portfolio() {

	return function_exists( 'wolf_portfolio_get_page_id' ) && is_page( wolf_portfolio_get_page_id() ) || is_tax( 'work_type' );
}

/**
 * Check if we're on a albums page
 *
 * @return bool
 */
function inkpro_is_albums() {

	return function_exists( 'wolf_albums_get_page_id' ) && is_page( wolf_albums_get_page_id() ) || is_tax( 'gallery_type' );
}

/**
 * Check if we're on a videos page
 *
 * @return bool
 */
function inkpro_is_videos() {

	return function_exists( 'wolf_videos_get_page_id' ) && is_page( wolf_videos_get_page_id() ) || is_tax( 'video_type' ) || is_tax( 'video_tag' );
}

/**
 * Check if we're on a events page
 *
 * @return bool
 */
function inkpro_is_events() {

	return function_exists( 'wolf_events_get_page_id' ) && is_page( wolf_events_get_page_id() ) || is_tax( 'we_artist' );
}

/**
 * Check if we're on a plugins page
 *
 * @return bool
 */
function inkpro_is_plugins() {

	return function_exists( 'wolf_plugins_get_page_id' ) && is_page( wolf_plugins_get_page_id() ) || is_tax( 'plugin_cat' ) || is_tax( 'plugin_tag' );
}

/**
 * Check if we're on a themes page
 *
 * @return bool
 */
function inkpro_is_themes() {

	return function_exists( 'wolf_themes_get_page_id' ) && is_page( wolf_themes_get_page_id() ) || is_tax( 'themes_cat' ) || is_tax( 'themes_tag' );
}

/**
 * Check if we're on a discography page
 *
 * @return bool
 */
function inkpro_is_discography() {

	return function_exists( 'wolf_discography_get_page_id' ) && is_page( wolf_discography_get_page_id() ) || is_tax( 'label' ) || is_tax( 'band' );
}

/**
 * Check if we need to diaply the sidebar depending on context
 *
 * @return bool
 */
function inkpro_should_display_sidebar() {
	global $wp_customize;
	$is_customizer = ( isset( $wp_customize ) ) ? true : false;

	$is_right_post_type = ! is_singular( 'show' );
	$blog_layout = inkpro_is_blog() && ( 'sidebar' == inkpro_get_blog_layout() || 'sidebar-left' == inkpro_get_blog_layout() || 'sidebar-right' == inkpro_get_blog_layout() );
	$shop_layout = inkpro_is_woocommerce() && ( 'sidebar-left' == wolf_get_theme_mod( 'shop_layout' ) || 'sidebar-right' == wolf_get_theme_mod( 'shop_layout' ) );
	$disco_layout = inkpro_is_discography() && ( 'sidebar-left' == wolf_get_theme_mod( 'discography_layout' ) || 'sidebar-right' == wolf_get_theme_mod( 'discography_layout' ) );
	$videos_layout = inkpro_is_videos() && ( 'sidebar-left' == wolf_get_theme_mod( 'videos_layout' ) || 'sidebar-right' == wolf_get_theme_mod( 'videos_layout' ) );
	$albums_layout = inkpro_is_albums() && ( 'sidebar-left' == wolf_get_theme_mod( 'albums' ) || 'sidebar-right' == wolf_get_theme_mod( 'albums' ) );
	$portfolio_layout = inkpro_is_portfolio() && ( 'sidebar-left' == wolf_get_theme_mod( 'portfolio' ) || 'sidebar-right' == wolf_get_theme_mod( 'portfolio' ) );
	$events_layout = inkpro_is_events() && ( 'sidebar-left' == wolf_get_theme_mod( 'events' ) || 'sidebar-right' == wolf_get_theme_mod( 'events' ) );
	$is_single_sidebar = is_single() && ( ( 'sidebar' == get_post_meta( get_the_ID(), '_single_post_layout', true ) ) || ( 'sidebar-left' == get_post_meta( get_the_ID(), '_single_post_layout', true ) ) || ( 'sidebar-right' == get_post_meta( get_the_ID(), '_single_post_layout', true ) ) );
	
	if ( $is_right_post_type ) {
		return $blog_layout || $portfolio_layout || $events_layout || $shop_layout || $is_customizer || $is_single_sidebar || $disco_layout || $videos_layout || $albums_layout;
	}
}

/**
 * Check if we are on a woocommerce page
 *
 * @return bool
 */
function inkpro_is_woocommerce() {

	if ( class_exists( 'WooCommerce' ) ) {

		if ( is_woocommerce() ) {
			return true;
		}

		if ( is_shop() ) {
			return true;
		}

		if ( is_checkout() || is_order_received_page() ) {
			return true;
		}

		if ( is_cart() ) {
			return true;
		}

		if ( is_account_page() ) {
			return true;
		}
	}
}

/**
 * Check if there is a main menu to display
 *
 * @return bool
 */
function inkpro_is_main_menu() {
	$is_centered = 'centered' == inkpro_get_menu_layout() && has_nav_menu( 'primary-left' ) || has_nav_menu( 'primary-right' );
	$is_standard = 'centered' != inkpro_get_menu_layout() && has_nav_menu( 'primary' );
	$has_logo = wolf_get_theme_mod( 'logo_light' ) || wolf_get_theme_mod( 'logo_dark' );
	return $is_centered || $is_standard || $has_logo;
}

/**
 * Check if infinite scroll must apply on the current context
 *
 * @param
 * @return bool
 */
function inkpro_do_infinitescroll() {

	if ( ( inkpro_is_blog() ) && wolf_get_theme_mod( 'blog_infinitescroll' ) ) {
		return true;
	} elseif ( ( inkpro_is_portfolio() ) && wolf_get_theme_mod( 'portfolio_infinitescroll' ) ) {
		return true;
	}
}

/**
 * Do the infintescroll must be done with a trigger button
 *
 * @return bool
 */
function inkpro_do_infinitescroll_trigger() {

	if ( ( inkpro_is_blog() ) && wolf_get_theme_mod( 'blog_infinitescroll_trigger' ) ) {
		
		return true;
	
	} elseif ( ( inkpro_is_portfolio() ) && wolf_get_theme_mod( 'portfolio_infinitescroll_trigger' ) ) {
		
		return true;
	}
}

/**
 * Do packery
 *
 * @return bool
 */
function inkpro_do_masonry() {

	$masonry_display = array( 'masonry', 'masonry2', 'metro' );

	$return = false;

	if ( inkpro_is_blog() ) {
	
		$return = in_array( wolf_get_theme_mod( 'blog_display' ), $masonry_display );

	} elseif ( inkpro_is_portfolio() ) {

		$return = in_array( wolf_get_theme_mod( 'portfolio_display' ), $masonry_display );
	}

	return $return;
}

/**
 * Do packery
 *
 * @return bool
 */
function inkpro_do_packery() {

	if ( inkpro_is_blog() ) {
	
		return 'metro' == wolf_get_theme_mod( 'blog_display' );
	
	} elseif ( inkpro_is_portfolio() ) {

		return 'metro' == wolf_get_theme_mod( 'portfolio_display' );
	}
}

/**
 * Check if infinite scroll must apply on the current context
 *
 * @return bool
 */
function inkpro_do_ajax_category_filter() {

	$display = array( 'metro', 'masonry', 'masonry2', 'photo', 'grid', 'grid2', 'grid3', 'column' );

	$return = null;

	if ( ( inkpro_is_blog() ) && wolf_get_theme_mod( 'blog_category_filter' ) ) {
		
		$return = in_array( inkpro_get_blog_display(), $display ); 
	
	}

	return $return;
}

/**
 * Check if we are on the customizer page
 *
 * @return bool
 */
function inkpro_is_customizer() {

	global $wp_customize;
	if ( isset( $wp_customize ) ) {
		return true;
	}
}

/**
 * Is AJAX navigation enabled?
 *
 * @return bool
 */
function inkpro_do_ajax_nav() {

	return apply_filters( 'inkpro_do_ajax_nav', wolf_get_theme_mod( 'ajax_nav' ) );
}

/**
 * Display top bar?
 *
 * @return bool
 */
function inkpro_display_topbar() {

	if ( apply_filters( 'inkpro_display_topbar', '' ) ) {
		if ( has_nav_menu( 'secondary' ) || wolf_get_theme_mod( 'topbar_content' ) ) {
			return true;
		}
	}
}

/**
 * Is SEO by YOAST plugin insalled
 *
 * @return bool
 */
function inkpro_is_seo_plugin_installed() {
	return defined( 'WPSEO_VERSION' );
}