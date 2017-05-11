<?php
/**
 * InkPro WooCommerce functions
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

add_filter( 'woocommerce_enqueue_styles', '__return_false' ); // disable Woocommerce CSS

/**
 * WooCommerce AJAX search result
 */
function inkpro_woocommerce_ajax_search_query( $typed = null ) {

	$args = array(
		'post_type' => array( 'product' ),
		'post_status' => 'publish',
		'posts_per_page' => 5,
		's' => $typed,
	);

	// Search by title
	add_filter( 'posts_search', 'inkpro_product_search_by_title_only', 500, 2 );

	return new WP_Query( $args );
}

/**
 * Search by title only for WooCommerce ajax live search
 */
function inkpro_product_search_by_title_only( $search, &$wp_query ) {
	global $wpdb;
	if ( empty( $search ) )
	    	return $search; // skip processing - no search term in query
		$q = $wp_query->query_vars;
		$n = ! empty( $q['exact'] ) ? '' : '%';
		$search = '';
		$searchand = '';
	foreach ( (array) $q['search_terms'] as $term ) {
		$term = esc_sql( $wpdb->esc_like( $term ) );
		$search .= "{$searchand}($wpdb->posts.post_title LIKE '{$n}{$term}{$n}')";
		$searchand = ' AND ';
	}
	if ( ! empty( $search ) ) {
		$search = " AND ({$search}) ";

		if ( ! is_user_logged_in() )
			$search .= " AND ($wpdb->posts.post_password = '') ";
	}
	return $search;
}

/**
 * Get a slider from product images gallery
 */
function inkpro_single_product_images_gallery() {

	global $post, $product;

	$attachment_ids = $product->get_gallery_image_ids();

	$output = '';

	if ( $attachment_ids ) {
		$output .= '<div class="woocommerce-single-product-images-slider flexslider"><ul class="slides">';

		$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
		$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
			'title'	 => $props['title'],
			'alt'    => $props['alt'],
		) );
		$output .= apply_filters(
			'inkpro_woocommerce_single_product_image_slide_html',
			sprintf(
				'<li class="slide">%s</li>',
				$image
			),
			$post->ID
		);

		foreach ( $attachment_ids as $attachment_id ) {

			$props = wc_get_product_attachment_props( $attachment_id, $post );

			if ( ! $props['url'] ) {
				continue;
			}

			$output .= apply_filters(
				'inkpro_woocommerce_single_product_image_slide_html',
				sprintf(
					'<li class="slide">%s</li>',
					wp_get_attachment_image( $attachment_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), 0, $props )
				)
			);
		}

		$output .= '</ul><!-- .slides --></div><!-- .flexslider -->';

	} elseif ( get_the_post_thumbnail( $post->ID ) ) {
		$props            = wc_get_product_attachment_props( get_post_thumbnail_id(), $post );
		$image            = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
			'title'	 => $props['title'],
			'alt'    => $props['alt'],
		) );
		$output .= apply_filters(
			'inkpro_woocommerce_single_product_image_slide_html',
			sprintf(
				'%s',
				$image
			),
			$post->ID
		);
	}

	return $output;
}

/**
 * Get alternative product thumbnail using the first image from product gallery
 */
function inkpro_woocommerce_second_product_thumbnail( $size = 'shop_catalog', $echo = true ) {
	global $post, $product;

	$output = '';
	$attachment_ids = $product->get_gallery_image_ids();
	$image_size = apply_filters( 'single_product_large_thumbnail_size', $size );

	if ( $attachment_ids && isset( $attachment_ids[0] ) ) {

		$attachment_id = $attachment_ids[0];

		$props = wc_get_product_attachment_props( $attachment_id, $post );

		if ( ! $props['url'] ) {
			return;
		}

		$output .= apply_filters(
			'inkpro_woocommerce_single_product_image_slide_html',
			sprintf(
				'<div class="product-second-thumbnail">%s</div>',
				wp_get_attachment_image( $attachment_id, $image_size, 0, $props )
			)
		);
	}

	if ( $echo ) {
		echo wp_kses_post( $output );
	}

	return $output;
}

/**
 * Filter WooCommerce apgination arguments
 *
 * @param array $args
 * @return array $args
 */
function inkpro_filter_woocommerce_pagination_args( $args ) {

	$args['prev_text'] = '<i class="fa fa-angle-left"></i>';
	$args['next_text'] = '<i class="fa fa-angle-right"></i>';

	return $args;
}
add_filter( 'woocommerce_pagination_args', 'inkpro_filter_woocommerce_pagination_args' );

/**
 * Set products per page
 *
 * @return int
 */
function inkpro_products_per_page() {

	// Display 12 products per page by default
	$products_per_page = 12;

	if ( wolf_get_theme_mod( 'products_per_page' ) ) {
		$products_per_page = wolf_get_theme_mod( 'products_per_page' );
	}

	return $products_per_page;

}
add_filter( 'loop_shop_per_page', 'inkpro_products_per_page', 20 );

/**
 * Set related products count
 *
 * @return int
 */
function inkpro_related_products_args( $args ) {

	if ( 'fullwidth' == wolf_get_theme_mod( 'shop_single_layout' ) ) {
		$args['posts_per_page'] = 4;
	} else {
		$args['posts_per_page'] = 3;
	}

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'inkpro_related_products_args' );

/**
 * Number of product per row
 */
function inkpro_loop_columns() {

	return 99999; // set inifinite number to handle this with CSS
}
add_filter( 'loop_shop_columns', 'inkpro_loop_columns' );

/**
 * Get WooCommerce shop page id
 *
 * @return int
 */
function inkpro_get_woocommerce_shop_page_id() {

	$page_id = null;

	if ( class_exists( 'Woocommerce' ) ) {
		$page_id = get_option( 'woocommerce_shop_page_id' );
	}

	return $page_id;
}

/**
 * Replace the Woocommerce placeholder image
 *
 * @param
 * @return
 */
function inkpro_custom_woocomerce_placeholder() {

	add_filter( 'woocommerce_placeholder_img_src', 'custom_woocommerce_placeholder_img_src' );

	function custom_woocommerce_placeholder_img_src( $src ) {

		$src = wolf_get_theme_uri( 'assets/img/woocommerce/placeholder.jpg' );

		return $src;
	}
}
add_action( 'init', 'inkpro_custom_woocomerce_placeholder' );

if ( ! function_exists( 'inkpro_update_cart_total_cookie' ) ) {
	/**
	 * Cart cookie
	 *
	 * Set cart content with cookie in case a cache plugin is used
	 */
	function inkpro_update_cart_total_cookie() {
		if ( ! is_admin()  && function_exists( 'is_woocommerce' ) ) {
			$item_count = WC()->cart->cart_contents_count;
			$cart_total = WC()->cart->get_cart_total();
			setcookie( 'inkpro_woocommerce_items_count', absint( $item_count ), 0, '/' );
			setcookie( 'inkpro_woocommerce_cart_total', sanitize_text_field( $cart_total ), 0, '/' );
		}
	}
	add_action( 'wp_loaded', 'inkpro_update_cart_total_cookie' );
}

/**
 *  Add Woocommece ajax Cart feature
 */
if ( ! function_exists( 'inkpro_woocommerce_add_to_cart_fragment_item_count' ) ) {
	/**
	 * Ensure cart contents update when products are added to the cart via AJAX
	 * @see http://docs.woothemes.com/document/show-cart-contents-total/
	 */
	function inkpro_woocommerce_add_to_cart_fragment_item_count( $fragments ) {
		ob_start();
		?>
		<span class="product-count"><?php echo absint( WC()->cart->cart_contents_count ); ?></span>
		<?php
		$fragments['.product-count'] = ob_get_clean();

		return $fragments;

	}
	add_filter( 'add_to_cart_fragments', 'inkpro_woocommerce_add_to_cart_fragment_item_count' );
}

if ( ! function_exists( 'inkpro_woocommerce_add_to_cart_fragment_item_count_with_text' ) ) {
	/**
	 * Ensure cart contents update when products are added to the cart via AJAX
	 * @see http://docs.woothemes.com/document/show-cart-contents-total/
	 */
	function inkpro_woocommerce_add_to_cart_fragment_item_count_with_text( $fragments ) {

		ob_start();
		?>
		<span class="panel-product-count"><?php echo sprintf(_n('%d item', '%d items', WC()->cart->cart_contents_count, 'inkpro' ), WC()->cart->cart_contents_count ); ?></span>
		<?php
		$fragments['.panel-product-count'] = ob_get_clean();

		return $fragments;

	}
	add_filter( 'add_to_cart_fragments', 'inkpro_woocommerce_add_to_cart_fragment_item_count_with_text' );
}

if ( ! function_exists( 'inkpro_woocommerce_add_to_cart_fragment_total' ) ) {
	/**
	 * Ensure cart contents update when products are added to the cart via AJAX
	 * @see http://docs.woothemes.com/document/show-cart-contents-total/
	 */
	function inkpro_woocommerce_add_to_cart_fragment_total( $fragments ) {

		ob_start();
		?>
		<span class="panel-total"><?php esc_html_e( 'Total:', 'inkpro' ); ?> <?php echo sanitize_text_field( WC()->cart->get_cart_total() ); ?></span>
		<?php
		$fragments['.panel-total'] = ob_get_clean();

		return $fragments;

	}
	add_filter( 'add_to_cart_fragments', 'inkpro_woocommerce_add_to_cart_fragment_total' );
}