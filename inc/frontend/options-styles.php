<?php
/**
 * InkPro - print custom CSS in head tag
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Inline CSS from the theme settings
 *
 * @since InkPro 1.0.0
 * @return string $css
 */
function inkpro_settings_css() {

	$css = '';

	/*-----------------------------------------------------------------------------------*/
	/*  Heading Font
	/*-----------------------------------------------------------------------------------*/

	$heading_font = wolf_get_theme_option( 'heading_font_name' );
	$heading_selectors = 'h1, h2, h3, h4, h5, h2.entry-title, .widget-title, .counter-text, .countdown-period, .wolf-slide-title';

	if ( $heading_font ) {
		$css .= "$heading_selectors{font-family:'$heading_font'}";
	}

	$heading_font_weight = wolf_get_theme_option( 'heading_font_weight' );

	if ( $heading_font_weight ) {
		$css .= "$heading_selectors{font-weight:$heading_font_weight}";
	}

	$heading_font_transform = wolf_get_theme_option( 'heading_font_transform' );

	if ( 'uppercase' == $heading_font_transform ) {
		$css .= "$heading_selectors{text-transform:uppercase}";
	}

	$heading_font_style = wolf_get_theme_option( 'heading_font_style' );

	if ( $heading_font_style ) {
		$css .= "$heading_selectors{font-style:$heading_font_style}";
	}

	$heading_letterspacing = wolf_get_theme_option( 'heading_font_letter_spacing' );

	if ( $heading_letterspacing ) {
		$heading_letterspacing = $heading_letterspacing . 'px';
		$css .= "$heading_selectors{letter-spacing:$heading_letterspacing}";
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Page title Font
	/*-----------------------------------------------------------------------------------*/

	$page_title_font = wolf_get_theme_option( 'page_title_font_name' );
	$page_title_selectors = 'h1.page-title';

	if ( $page_title_font ) {
		$css .= "$page_title_selectors{font-family:'$page_title_font'}";
	}

	$page_title_font_weight = wolf_get_theme_option( 'page_title_font_weight' );

	if ( $page_title_font_weight ) {
		$css .= "$page_title_selectors{font-weight:$page_title_font_weight}";
	}

	$page_title_font_transform = wolf_get_theme_option( 'page_title_font_transform' );

	if ( 'uppercase' == $page_title_font_transform ) {
		$css .= "$page_title_selectors{text-transform:uppercase}";
	}

	$page_title_font_style = wolf_get_theme_option( 'page_title_font_style' );

	if ( $page_title_font_style ) {
		$css .= "$page_title_selectors{font-style:$page_title_font_style}";
	}

	$page_title_letterspacing = wolf_get_theme_option( 'page_title_font_letter_spacing' );

	if ( $page_title_letterspacing ) {
		$page_title_letterspacing = $page_title_letterspacing . 'px';
		$css .= "$heading_selectors{letter-spacing:$heading_letterspacing}";
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Menu Font
	/*-----------------------------------------------------------------------------------*/

	$menu_font = wolf_get_theme_option( 'menu_font_name' );
	$menu_selectors = '.nav-menu li a, #navbar-container-right';

	if( $menu_font ) {
		$css .= "$menu_selectors{ font-family:'$menu_font'}";
	}

	$menu_font_weight = wolf_get_theme_option( 'menu_font_weight' );

	if( $menu_font_weight ) {
		$css .= "$menu_selectors{font-weight:$menu_font_weight}";
	}

	$menu_font_transform = wolf_get_theme_option( 'menu_font_transform' );

	if ( 'uppercase' == $menu_font_transform ) {
		$css .= "$menu_selectors{text-transform:uppercase}";
	}

	$menu_font_style = wolf_get_theme_option( 'menu_font_style' );

	if ( $menu_font_style ) {
		$css .= "$menu_selectors{font-style:$menu_font_style}";
	}

	$menu_letterspacing = wolf_get_theme_option( 'menu_font_letter_spacing' );

	if ( $menu_letterspacing ) {
		$menu_letterspacing = $menu_letterspacing . 'px';
		$css .= "$menu_selectors{letter-spacing:$menu_letterspacing}";
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Body Font
	/*-----------------------------------------------------------------------------------*/

	$body_font = wolf_get_theme_option( 'body_font_name' );
	$body_selectors = 'body, blockquote.wpb-testimonial-content';

	if( $body_font ) {
		$css .= "$body_selectors{font-family:'$body_font'}";
	}


	/*-----------------------------------------------------------------------------------*/
	/*  Custom CSS
	/*-----------------------------------------------------------------------------------*/
	if ( wolf_get_theme_option( 'c' ) ) {
		$css .= stripslashes( wolf_get_theme_option( 'c' ) );
	}

	if ( wolf_get_theme_option( 'css' ) ) {
		$css .= stripslashes( wolf_get_theme_option( 'css' ) );
	}

	if ( wolf_get_theme_option( 'custom_css' ) ) {
		$css .= stripslashes( wolf_get_theme_option( 'custom_css' ) );
	}

	if ( get_option( 'wolf_theme_css_' . wolf_get_theme_slug() ) ) {
		$css .= stripslashes( get_option( 'wolf_theme_css_' . wolf_get_theme_slug() ) );
	}

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	return $css;
	
} // end function

/**
 * Output the custom CSS
 *
 * @since InkPro 1.0.0
 */
function inkpro_output_settings_options_css() {
	
	$css = '';

	if ( inkpro_settings_css() ) {
		$css .= '/* inkpro options */' . "\n";
		$css .= inkpro_settings_css() . "\n";
	}
	wp_add_inline_style( 'inkpro-style', $css );
}
add_action( 'wp_enqueue_scripts', 'inkpro_output_settings_options_css', 11 );

/**
 * Get background CSS
 *
 * @since InkPro 1.0.0
 * @param string $selector
 * @param string $option_name
 * @return  string
 */
function inkpro_get_background_css( $selector, $option_name ) {

	$css = '';

	$url        = null;
	$img        = wolf_get_theme_option( $option_name . '_img' );
	$color      = wolf_get_theme_option( $option_name . '_color' );
	$repeat     = wolf_get_theme_option( $option_name . '_repeat' );
	$position   = wolf_get_theme_option( $option_name . '_position' );
	$attachment = wolf_get_theme_option( $option_name . '_attachment' );
	$size       = wolf_get_theme_option( $option_name . '_size' );
	$parallax   = wolf_get_theme_option( $option_name . '_parallax' );

	if ( $img )
		$url = 'url("'. wolf_get_url_from_attachment_id( $img, 'extra-large' ) .'")';

	if ( $color || $img ) {

		if ( $parallax ) {

			$css .= "$selector {background : $color $url $repeat fixed}";
			$css .= "$selector {background-position : 50% 0}";

		} else {
			$css .= "$selector {background : $color $url $position $repeat $attachment}";
		}

		if ( $size == 'cover' ) {

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

		if ( $size == 'resize' ) {

			$css .= "$selector {
				-webkit-background-size: 100%;
				-o-background-size: 100%;
				-moz-background-size: 100%;
				background-size: 100%;
			}";
		}
	}

	return $css;
}