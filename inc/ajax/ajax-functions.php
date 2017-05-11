<?php
/**
 * InkPro ajax Functions
 *
 * General core functions available on both the front-end and admin.
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_ajax_get_page_markup' ) ) {
	/**
	 * Get page markup by URL for ajax purpose
	 */
	function inkpro_ajax_get_page_markup() {

		extract( $_POST );

		if ( isset( $_POST['url'] ) ) {

			$url = esc_url( $_POST['url'] );
			$url = str_replace( '&#038;', '&', $url ); // decode URL parameters
			$cookies = array();

			/*
			Cookie comes empty in wp_remote_get response if we do nothing
			Pass cookies in case we need it
			*/
			foreach ( $_COOKIE as $name => $value ) {
				$cookies[] = new WP_Http_Cookie( array( 'name' => $name, 'value' => $value ) );
			}

			// send request
			$response = wp_remote_get( $url , array(
					'timeout' => 10,
					'cookies' => $cookies,
				)
			);

			// get result if no error
			if ( ! is_wp_error( $response ) && is_array( $response ) ) {
				$html = wp_remote_retrieve_body( $response ); // use the content
				ob_start();
				print( $html ); // output page HTML content
				header( 'Content-Length: ' . ob_get_length() ); // set lenght for progress bar
				header( 'Accept-Ranges: bytes');
			} else {
				echo 'error';
			}
		}
		exit;
	}
	add_action( 'wp_ajax_inkpro_ajax_get_page_markup', 'inkpro_ajax_get_page_markup' );
	add_action( 'wp_ajax_nopriv_inkpro_ajax_get_page_markup', 'inkpro_ajax_get_page_markup' );
}

if ( ! function_exists( 'inkpro_ajax_get_admin_bar_params' ) ) {
	/**
	 * Get posy ID and cusomizer URL to update admin bar
	 *
	 * @since 1.1.4
	 */
	function inkpro_ajax_get_admin_bar_params() {

		extract( $_POST );
		$result = array();

		if ( isset( $_POST['url'] ) ) {

			$url = esc_url( $_POST['url'] );
			$post_id = absint( url_to_postid( $url ) );

			if ( $post_id ) {
				$edit_url = esc_url( admin_url( 'post.php?post=' . $post_id . '&action=edit' ) );
				$customizer_url = esc_url( admin_url( 'customize.php?url=' . urlencode( $url ) ) );
				$result['editUrl'] = $edit_url;
				$result['customizerUrl'] = $customizer_url;
				echo json_encode( $result );
			}

		}
		exit;
	}
	add_action( 'wp_ajax_inkpro_ajax_get_admin_bar_params', 'inkpro_ajax_get_admin_bar_params' );
	add_action( 'wp_ajax_nopriv_inkpro_ajax_get_admin_bar_params', 'inkpro_ajax_get_admin_bar_params' );
}

if ( ! function_exists( 'inkpro_ajax_get_video_url_from_post_id' ) ) {
	/**
	 * Get Video URL for ajax request
	 */
	function inkpro_ajax_get_video_url_from_post_id() {

		extract( $_POST );

		if ( isset( $_POST['id'] ) ) {
			$post_id = absint( $_POST['id'] );
			echo esc_url( inkpro_get_first_video_url( $post_id ) );
		}

		exit;

	}
	add_action( 'wp_ajax_inkpro_ajax_get_video_url_from_post_id', 'inkpro_ajax_get_video_url_from_post_id' );
	add_action( 'wp_ajax_nopriv_inkpro_ajax_get_video_url_from_post_id', 'inkpro_ajax_get_video_url_from_post_id' );
}

if ( ! function_exists( 'inkpro_ajax_like' ) ) {
	/**
	 * Likes
	 *
	 * Increment likes meta
	 */
	function inkpro_ajax_like() {
		extract( $_POST );
		if ( isset( $_POST['postId'] ) ){
			$post_id = absint( $_POST['postId'] );
			$likes = absint( get_post_meta( $post_id , '_inkpro_likes', true ) );
			$new_likes = $likes + 1;
			update_post_meta( $post_id, '_inkpro_likes', $new_likes );
			echo absint( $new_likes );
			exit;
		}
	}
	add_action( 'wp_ajax_inkpro_ajax_like', 'inkpro_ajax_like' );
	add_action( 'wp_ajax_nopriv_inkpro_ajax_like', 'inkpro_ajax_like' );
}

if ( ! function_exists( 'inkpro_ajax_share' ) ) {
	/**
	 * Shares
	 *
	 * Increment shares meta
	 */
	function inkpro_ajax_share() {
		extract( $_POST );
		if ( isset( $_POST['postId'] ) ){
			$post_id = absint( $_POST['postId'] );
			$shares = absint( get_post_meta( $post_id , '_inkpro_shares', true ) );
			$new_shares = $shares + 1;
			update_post_meta( $post_id, '_inkpro_shares', $new_shares );
			echo absint( $new_shares );
			exit;
		}
	}
	add_action( 'wp_ajax_inkpro_ajax_share', 'inkpro_ajax_share' );
	add_action( 'wp_ajax_nopriv_inkpro_ajax_share', 'inkpro_ajax_share' );
}

if ( ! function_exists( 'inkpro_ajax_view' ) ) {
	/**
	 * Views
	 *
	 * Increment views meta
	 *
	 */
	function inkpro_ajax_view() {
		extract( $_POST );
		if ( isset( $_POST['postId'] ) ){
			$post_id = absint( $_POST['postId'] );
			$views     = absint( get_post_meta( $post_id , '_inkpro_views', true ) );
			$new_views = $views + 1;
			update_post_meta( $post_id, '_inkpro_views', $new_views );
			echo absint( $new_views );
			exit;
		}
	}
	add_action( 'wp_ajax_inkpro_ajax_view', 'inkpro_ajax_view' );
	add_action( 'wp_ajax_nopriv_inkpro_ajax_view', 'inkpro_ajax_view' );
}

if ( ! function_exists( 'inkpro_ajax_woocommerce_live_search' ) ) {
	/**
	 * Views
	 *
	 * Increment views meta
	 *
	 */
	function inkpro_ajax_woocommerce_live_search() {

		extract( $_POST );

		if ( isset( $_POST['s'] ) && '' != $_POST['s'] ) {

			$typed = esc_attr( $_POST['s'] );

			if ( 2 < strlen( $typed ) ) {

				$query = inkpro_woocommerce_ajax_search_query( $typed, true );

				if ( $query && $query->have_posts() ) {

					while ( $query->have_posts() ) {

						$query->the_post();
						$product = wc_get_product( get_the_ID() );
						if ( $product && $product->exists() ) {

							$title = str_ireplace( $typed, '<strong>' . $typed . '</strong>', get_the_title() );
							$title = get_the_title();

							$terms = explode( ' ', $typed );

							$words = array();
							$strong_words = array();

							foreach ( $terms as $t ) {
								$words[] = ucfirst( $t );
								$words[] = $t;
							}

							foreach ( $words as $w ) {
								$strong_words[] = "<strong>$w</strong>";
							}

							$words = array_diff( $words, array( 'strong', 's', 'st', 'str', 'stron' ) );

							$title = get_the_title();
							$title = str_replace( $words, $strong_words, $title );
							?>
							<li>
								<a href="<?php the_permalink(); ?>" class="ajax-link product-search-link table">
									<div class="product-search-image table-cell">
										<?php echo wp_kses_post( $product->get_image() ); ?>
									</div>
									<div class="product-search-title table-cell">
										<?php echo wp_kses( $title, array(
											'strong' => array(),
										) ); ?>
									</div>
									<div class="product-search-price table-cell">
										<?php
										if( is_a( $product, 'WC_Product_Bundle' ) ){
											if ( $product->min_price != $product->max_price ){
												printf( '%s - %s', wc_price( $product->min_price ), wc_price( $product->max_price ) );
											} else{
												echo wp_striptags( wc_price( $product->min_price ) );
											}
										} elseif ( $product->price != '0' ) {
											echo wp_kses_post( $product->get_price_html() );
										}
										?>
									</div>
								</a>
							</li>
							<?php
						}
					} // endwhile

				} // endif
			}
		}
		exit;
	}
	add_action( 'wp_ajax_inkpro_ajax_woocommerce_live_search', 'inkpro_ajax_woocommerce_live_search' );
	add_action( 'wp_ajax_nopriv_inkpro_ajax_woocommerce_live_search', 'inkpro_ajax_woocommerce_live_search' );
}