<?php
/**
 * Single Product Thumbnails
 *
 * We need to overwrite the original template to add the main product image to the thumbnail list
 * As the main image is replaced by a slider, it is the way to allow the main image to be open in a lightbox as well
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @author WooThemes
 * @package WooCommerce/Templates
 * @version  3.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $post, $product, $woocommerce;

$attachment_ids = $product->get_gallery_image_ids();

if ( $attachment_ids ) {
	$loop 		= 0;
	$columns 	= apply_filters( 'woocommerce_product_thumbnails_columns', 4 );
	?>
	<div class="thumbnails <?php echo 'columns-' . $columns; ?>"><?php

		$attachment_count = count( $product->get_gallery_image_ids() );
		$gallery          = $attachment_count > 0 ? '[product-gallery]' : '';
		$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
		$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), array(
			'title'	 => $props['title'],
			'alt'    => $props['alt'],
		) );
		echo apply_filters(
			'woocommerce_single_product_image_thumbnail_html',
			sprintf(
				'<a href="%s" style="width:%s" class="zoom first" title="%s" data-rel="prettyPhoto%s">%s</a>',
				esc_url( $props['url'] ),
				round( 100 / $columns, 2, PHP_ROUND_HALF_DOWN ) . '%',
				esc_attr( $props['caption'] ),
				$gallery,
				$image
			),
			$post->ID
		);

		foreach ( $attachment_ids as $attachment_id ) {

			$classes = array( 'zoom' );

			/* We don't really need the first and last class as we handle it with CSS */
			if ( $loop === 0 || $loop % $columns === 0 ) {
				$classes[] = 'first';
			}

			if ( ( $loop + 1 ) % $columns === 0 ) {
				$classes[] = 'last';
			}

			$image_class = implode( ' ', $classes );
			$props       = wc_get_product_attachment_props( $attachment_id, $post );

			if ( ! $props['url'] ) {
				continue;
			}

			echo apply_filters(
				'woocommerce_single_product_image_thumbnail_html',
				sprintf(
					'<a href="%s" style="width:%s" class="%s" title="%s" data-rel="prettyPhoto[product-gallery]">%s</a>',
					esc_url( $props['url'] ),
					absint( 100 / $columns ) . '%',
					esc_attr( $image_class ),
					esc_attr( $props['caption'] ),
					wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_small_thumbnail_size', 'shop_thumbnail' ), 0, $props )
				),
				$attachment_id,
				$post->ID,
				esc_attr( $image_class )
			);

			$loop++;
		}

	?></div>
	<?php
}