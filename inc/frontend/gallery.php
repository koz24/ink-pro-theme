<?php
/**
 * InkPro gallery functions
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_shortcode_images_gallery' ) ) {
	/**
	 * Gallery shortcode
	 *
	 * Will overwrite the default gallery shortcode
	 *
	 * @since InkPro 1.0.0
	 * @param array $atts
	 * @return string
	 */
	function inkpro_shortcode_images_gallery( $output = '', $atts, $instance ) {

		$output = $output; // fallback

		extract( shortcode_atts( array(
			'ids' => '',
			'layout' => 'simple',
			'columns' => '3',
			'size' => 'inkpro-2x1',
			'link' => 'attachment',
			'padding' => 'no',
			'hover_effect' => 'default',
			'orderby' => '',
			'inline_style' => '',
			'class' => '',
		), $atts ) );

		$images = explode( ',', $ids );
		$size = ( 'thumbnail' == $size ) ? 'inkpro-2x1' : $size;

		if ( ! is_single() && 'gallery' == get_post_format() ) {

			if ( 'masonry2' == inkpro_get_blog_display() ) {
				$size = 'inkpro-portrait';
			}
			$output = inkpro_flexslider_gallery( $images, $size, $orderby );

		} else {

			if ( 'simple' == $layout ) {
				$output = inkpro_simple_gallery( $images, $link, $size, $padding, $columns, $hover_effect, $orderby, $inline_style, $class );

			} elseif ( 'mosaic' == $layout ) {
				$carousel = ( $layout == 'carousel_mosaic' ) ? true : false;
				$output = inkpro_mosaic_gallery( $images, $link, $hover_effect, $orderby, $carousel, $inline_style, $class );

			
			} elseif ( 'slider' == $layout  ) {
				$output = inkpro_flexslider_gallery( $images, $size, $orderby, $inline_style, $class );
			}
		}

		return $output;
	}
	add_filter( 'post_gallery', 'inkpro_shortcode_images_gallery', 10, 3 );
}

if ( ! function_exists( 'inkpro_flexslider_gallery' ) ) {
	/**
	 * Display a slider with the image frome the gallery shortcode
	 *
	 * @since InkPro 1.0.0
	 * @param array $images
	 * @param string $orderby
	 * @return string $output
	 */
	function inkpro_flexslider_gallery( $images = array(), $size = 'inkpro-2x1', $orderby, $inline_style = '', $class = '' ) {

		if ( 'rand' == $orderby ) {
			shuffle( $images );
		}

		$post_id = get_the_ID();
		$permalink = get_permalink();
		$selector = "gallery-$post_id";

		$style = '';
		$class .= ' gallery post-gallery-slider flexslider clearfix';

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		if ( inkpro_is_blog() && 'masonry2' == inkpro_get_blog_display() ) {
			$class .= ' post-gallery-slider-slideshow';
		}

		if ( array() != $images ) {
			$output = '<div class="' . wolf_sanitize_html_classes( $class ) . '" id="' . esc_attr( $selector ) . '"><ul class="slides">';

			foreach ( $images as $image_id ) {
				$attachment = get_post( $image_id );

				if ( $attachment ) {
					$image_url = esc_url( wolf_get_url_from_attachment_id( $image_id, $size ) );
					$title = wptexturize( $attachment->post_title );
					$alt = esc_attr( get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) );
					$alt = ( $alt ) ? $alt : $title;
					$post_excerpt = wolf_sample( wptexturize( $attachment->post_excerpt ), 88 );
					$title_attr = ( $post_excerpt ) ? $post_excerpt : '';

					$output .= '<li class="slide">';
					$output .= '<img src="' . esc_url( $image_url ) . '" alt="' .esc_attr( $alt ) . '">';

						if ( $post_excerpt ) {
							$output .= '<p class="flex-caption">' . sanitize_text_field( $post_excerpt ) . '</p>';
						}

					$output .= '</li>';
				}
			}

			$output .= '</ul></div>';
		}

		return $output;
	}
}

if ( ! function_exists( 'inkpro_simple_gallery' ) ) {
	/**
	 * Generate a simple gallery
	 *
	 * @since InkPro 1.0.0
	 * @param array $images
	 * @param string $link
	 * @param string $size
	 * @param string $padding
	 * @param int $columns
	 * @param string $hover_effect
	 * @param string $orderby
	 * @return string $output
	 */
	function inkpro_simple_gallery( $images = array(), $link = 'attachment', $size = 'inkpro-thumb', $padding = 'no', $columns = 3, $hover_effect = 'default', $orderby = '', $inline_style = '', $class = '' ) {

		if ( 'rand' == $orderby ) {
			shuffle( $images );
		}

		$rand_id = rand( 0,999 );
		$selector = "gallery-$rand_id";

		$style = '';
		$class .= " gallery wolf-images-gallery clearfix simple-gallery hover-$hover_effect";

		if ( $inline_style ) {
			$style .= $inline_style;
		}

		if ( 'yes' == $padding ) {
			$class .= " padding";
		}

		$columns = absint( $columns );

		$output = '';

		if ( 1 == $columns ) {
			$size = 'inkpro-XL';
		}

		$class .= ' gallery-' . $columns . '-columns'; 

		$output .= '<div class="' . wolf_sanitize_html_classes( $class ) . '" id="' . esc_attr( $selector ) . '" style="' . wolf_sanitize_style_attr( $style ) . '">';

		if ( array() == $images ) {
			return;
		}

		foreach ( $images as $image_id ) {

			$attachment = get_post( $image_id );

			if ( $attachment ) {
				$image_url = esc_url( wolf_get_url_from_attachment_id( $image_id, $size ) );

				$file = esc_url( wolf_get_url_from_attachment_id( $image_id, 'inkpro-XL' ) );
				$image_page = get_attachment_link( $image_id );
				$href = ( 'post' == $link || 'attachment' == $link ) ? $image_page : $file;
				$class = ( 'file' == $link ) ? 'lightbox image-item' : 'image-item';

				$title = wptexturize( $attachment->post_title );
				$post_excerpt = wolf_sample( wptexturize( $attachment->post_excerpt ), 88 );
				$title_attr = ( $post_excerpt ) ? $post_excerpt : '';

				$output .= "<div class='block'>";

				if ( 'none' != $link ) {
					$output .= '<a title="' . esc_attr( $title_attr ) . '" href="' . esc_url( $href ) . '" class="' . wolf_sanitize_html_classes( $class ) . '" rel="' . esc_attr( $selector ) . '">';
				} else {
					$output .= '<span class="' . wolf_sanitize_html_classes( $class ) . '">';
				}

				$do_lazy_load = wolf_get_theme_mod( 'do_lazyload' );
				
				$src = ( $do_lazy_load ) ? WOLF_THEME_URI . '/assets/img/blank.gif' : $image_url;
				
				$lazy_load = ( $do_lazy_load ) ? ' class="lazy-hidden" data-src="' . esc_url( $image_url ) . '"' : '';

				$output .= '<img' . $lazy_load . ' src="' . esc_url( $src ) . '" alt="' .esc_attr( $title ) . '">';

				if ( 'none' != $link )
					$output .= '</a>';
				else
					$output .= '</span>';

				$output .= '</div>';
			}
		}

		$output .= '</div>';

		if ( array() != $images )
			return $output;
	}
}

if ( ! function_exists( 'inkpro_mosaic_gallery' ) ) {
	/**
	 * Generate a mosaic carouel layout gallery
	 *
	 * @since InkPro 1.0.0
	 * @param array $images
	 * @param string $link
	 * @param string $hover_effect
	 * @param string $orderby
	 * @param bool $carousel
	 * @return string $output
	 */
	function inkpro_mosaic_gallery( $images = array(), $link = 'attachment', $hover_effect = 'default', $orderby = '', $carousel = true, $inline_style = '', $class = '' ) {

		if ( array() == $images ) return;


		if ( 'rand' == $orderby ) {
			shuffle( $images );
		}

		$rand_id = rand( 0,999 );
		$selector = "gallery-$rand_id";

		$style = '';
		$class .= " gallery wolf-images-gallery clearfix hover-$hover_effect";

		if ( $carousel ) {
			$class .= " carousel-mosaic-gallery owl-carousel";
		} else {
			$class .= " mosaic-gallery";
		}

		if ( $inline_style ) {
			$style .= $inline_style;
		}


		$output = '<div class="' . wolf_sanitize_html_classes( $class ) . '" id="' . esc_attr( $selector ) . '" style="' . wolf_sanitize_style_attr( $style ) . '">';

		$i = 0;

		foreach ( $images as $image_id ) {
			if ( $i%6 == 0) {
				if ( $i == 0 ) {
					$output .= "\n";
					$output .= '<div class="slide block">';
					$output .= "\n";
				} elseif ( $i != count( $images ) ) {
					$output .= '</div><!--.block-->';
					$output .= "\n";
					$output .= '<div class="slide block">';
					$output .= "\n";
				} else {
					$output .= '</div><!--.block-->';
					$output .= "\n";
				}
			}

			/* Images sizes */
			if ( $i%6 == 1) {
				$size = 'inkpro-2x1';

			} elseif ($i%6 == 3 ) {
				$size = 'inkpro-1x2';

			} elseif( $i%6 == 5 ) {
				$size = 'inkpro-2x1';

			} else {
				$size = 'inkpro-2x2';
			}

			$i++;

			$attachment = get_post( $image_id );

			if ( $attachment ) {
				$image_url = esc_url( wolf_get_url_from_attachment_id( $image_id, $size ) );

				$file = esc_url( wolf_get_url_from_attachment_id( $image_id, 'inkpro-XL' ) );
				$image_page = get_attachment_link( $image_id );
				$href = ( 'post' == $link || 'attachment' == $link ) ? $image_page : $file;
				$class = ( 'file' == $link ) ? 'lightbox image-item' : 'image-item';

				$title = wptexturize( $attachment->post_title );
				$post_excerpt = esc_attr( wolf_sample( wptexturize( $attachment->post_excerpt ), 88 ) );
				$title_attr = ( $post_excerpt ) ? " title='$post_excerpt'" : '';

				if ( 'none' != $link ) {
					$output .= '<a title="' . esc_attr( $post_excerpt ) . '" href="' . esc_url( $href ) . '" class="' . wolf_sanitize_html_classes( $class ) . '" rel="' . esc_attr( $selector ) . '">';
					$output .= "\n";
				} else {
					$output .= '<span class="' . wolf_sanitize_html_classes( $class ) . '">';
					$output .= "\n";
				}

				$do_lazy_load = wolf_get_theme_mod( 'do_lazyload' );
				$src = ( $do_lazy_load ) ? WOLF_THEME_URI . '/assets/img/blank.gif' : $image_url;
				$lazy_load = ( $do_lazy_load ) ? ' class="lazy-hidden" data-src="' . esc_url( $image_url ) . '"' : '';
				$output .= '<img' . $lazy_load . ' src="' . esc_url( $src ) . '" alt="' .esc_attr( $title ) . '">';

				$output .= "\n";

				if ( 'none' != $link ) {
					$output .= '</a>';
					$output .= "\n";
				} else {
					$output .= '</span>';
					$output .= "\n";
				}
			}

		} // end for each

		$output .= '</div><!--.block-->';
		$output .= "\n";
		$output .= '</div><!--.wolf-images-gallery-->';

		if ( array() != $images ) {
			return $output;
		}
	}
}