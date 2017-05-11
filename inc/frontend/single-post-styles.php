<?php
/**
 * InkPro Single post styles
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get background CSS
 *
 * @param string $selector
 * @param string $meta_name
 * @return string
 */
function inkpro_post_meta_get_background_css( $selector, $meta_name ) {

	$css = '';

	// If WooCommerce category
	if ( function_exists( 'is_product_category' ) && is_product_category() && get_woocommerce_term_meta( get_queried_object()->term_id, 'thumbnail_id', true ) ) {

		$thumbnail_id = get_woocommerce_term_meta( get_queried_object()->term_id, 'thumbnail_id', true );
		$url = wolf_get_url_from_attachment_id( $thumbnail_id, 'inkpro-XL' );
		$css = "$selector {background:url($url) no-repeat center center;}
			$selector {
				-webkit-background-size: 100%;
				-o-background-size: 100%;
				-moz-background-size: 100%;
				background-size: 100%;
				-webkit-background-size: cover;
				-o-background-size: cover;
				background-size: cover;
			}
		";
		$css .= ".has-hero .header-overlay{background-color:#000; opacity:.4}";

	} else {
		if ( ! inkpro_get_header_post_id() ) {

			// Default custom header image
			if ( get_header_image() ) {
				$url = get_header_image();
				$css = "$selector {background:url($url) no-repeat center center;}
					$selector {
						-webkit-background-size: 100%;
						-o-background-size: 100%;
						-moz-background-size: 100%;
						background-size: 100%;
						-webkit-background-size: cover;
						-o-background-size: cover;
						background-size: cover;
					}
				";
				$css .= ".has-hero .header-overlay{background-color:#000; opacity:.4}";
			}

		} elseif ( inkpro_get_header_post_id() ) {

			//debug( inkpro_get_header_post_id() );

			$post_id 		= inkpro_get_header_post_id();
			$bg_type 		= ( get_post_meta( $post_id, '_post_bg_type', true ) ) ? get_post_meta( $post_id, '_post_bg_type', true ) : 'image';
			$url       		= null;
			$attachment_id 	= get_post_meta( $post_id, $meta_name . '_img', true );
			$color      		= get_post_meta( $post_id, $meta_name . '_color', true );
			$repeat     		= get_post_meta( $post_id, $meta_name . '_repeat', true );
			$position   		= get_post_meta( $post_id, $meta_name . '_position', true );
			$attachment 		= get_post_meta( $post_id, $meta_name . '_attachment', true );
			$size       		= get_post_meta( $post_id, $meta_name . '_size', true );

			$overlay 		= 'yes' == get_post_meta( $post_id, '_post_overlay', true );
			$overlay_opacity 	= get_post_meta( $post_id, '_post_overlay_opacity', true );
			$overlay_img        	= get_post_meta( $post_id, '_post_overlay_img', true );
			$overlay_pattern 	= ( $overlay_img ) ? esc_url( wolf_get_url_from_attachment_id( $overlay_img ) ) : '';
			$overlay_color      	= get_post_meta( $post_id, '_post_overlay_color', true );

			// featured image as default header img if the option is set
			if ( 'image' == $bg_type && ( ( wolf_get_theme_mod( 'auto_header' ) && has_post_thumbnail( $post_id ) ) || get_header_image() ) && ! $color && ! $attachment_id ) {
				$overlay 		= true;
				$overlay_opacity 	= 40;
				$overlay_color 	= '#000000';
				$repeat     		= 'no-repeat';
				$position   		= 'center center';
				$size       		= 'cover';

				if ( has_post_thumbnail( $post_id ) && wolf_get_theme_mod( 'auto_header' ) ) {

					$attachment_id = get_post_thumbnail_id( $post_id );

				} else {

					$attachment_id = get_custom_header()->attachment_id;
				}
			}

			if ( $attachment_id ) {
				$url = 'url('. wolf_get_url_from_attachment_id( $attachment_id, 'inkpro-XL' ) .')';
			}

			if ( $color || $attachment_id ) {

				$css .= "$selector {background : $color $position $repeat $attachment}";

				if ( $attachment_id ) {
					$css .= "$selector {background-image:$url;}";
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

			if ( $overlay ) {

				if ( $overlay_color ) {
					$css .= ".has-hero .header-overlay{background-color:$overlay_color;}";
				}

				if ( $overlay_pattern ) {
					$css .= ".has-hero .header-overlay{background-image:url($overlay_pattern);}";
				}

				if ( 0 < $overlay_opacity ) {
					$css .= '.has-hero .header-overlay{opacity:' . $overlay_opacity / 100 . '}';
				}
			}

			$skin = get_post_meta( $post_id, '_post_skin', true );

			if ( 'light' == $skin ) {
				$css .= '
					.has-hero #logo-dark{
						display: block;
					}

					.has-hero #logo-light{
						display: none;
					}

					.has-hero #navbar-container a,
					.has-hero #toggle,
					.has-hero .post-header,
					.post-title-container h1 {
						color: #333;
					}
				';
			}

			if ( get_post_meta( $post_id, '_hide_featured_image', true ) ) {
				$css .= ".entry-thumbnail{display:none;}";
			}

			$custom_css = get_post_meta( $post_id, '_post_css', true );

			if ( $custom_css ) {
				$css .= $custom_css;
			}
		}
	}

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	return $css;
}

/**
 * Output the post CSS
 */
function inkpro_output_post_header_css() {

	if ( is_404() ) {
		return;
	}

	$css =  '/* Single post styles */';

	if ( 'none' != inkpro_get_header_type() ) {
		$css .= "\n";
	    	$css .= inkpro_post_meta_get_background_css( 'body.wolf .post-header-container', '_post_bg' );
	}
	wp_add_inline_style( 'inkpro-single-post-style', $css );
}
add_action( 'wp_enqueue_scripts', 'inkpro_output_post_header_css', 14 );