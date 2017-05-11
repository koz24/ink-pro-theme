<?php
/**
 * InkPro social meta helper
 *
 * @package WordPress
 * @subpackage %NAME %
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_get_meta_share_img' ) ) {
	/**
	 * Get the share image
	 *
	 * @since InkPro 1.0.0
	 * @param int $post_id
	 * @return string $share_image
	 */
	function inkpro_get_meta_share_img( $post_id ) {
		global $post;

		/* We define the default image first and see if the post contains an image after */
		$share_image = ( wolf_get_theme_option( 'share_img' ) ) ?  wolf_get_url_from_attachment_id( absint( wolf_get_theme_option( 'share_img' ) ), 'large' ) : null;

		if ( has_post_thumbnail( $post_id ) ) {
			$share_image = wolf_get_post_thumbnail_url( 'large', $post_id );
		}

		return $share_image;
	}
}

if ( ! function_exists( 'inkpro_get_meta_permalink' ) ) {
	/**
	 * Get the current page permalink
	 *
	 * @since InkPro 1.0.0
	 * @param int $post_id
	 * @return string $share_image
	 */
	function inkpro_get_meta_permalink() {

		global $post, $wp_query;

		$post_id = null;

		if ( ! is_404() && ! is_search() && $post ) {
			$post_id = $post->ID;

			if ( $wp_query && isset( $wp_query->queried_object->ID ) )
				$post_id = $wp_query->queried_object->ID;
		}

		if ( $post_id ) {
			$permalink = esc_url( get_permalink( $post_id ) );
		} else {
			$permalink = esc_url( home_url( '/' ) );
		}

		return esc_url( $permalink );
	}
}

if ( ! function_exists( 'inkpro_get_meta_description' ) ) {
	/**
	 * Get the current page description
	 *
	 * @since InkPro 1.0.0
	 * @param int $post_id
	 * @return string $share_image
	 */
	function inkpro_get_meta_description( $post ) {
		$excerpt = '';

		$excerpt = sanitize_text_field( $post->post_excerpt );

		if ( '' == $excerpt ) {
			$excerpt = strip_tags( preg_replace( '/' . get_shortcode_regex() . '/i', '', $post->post_content ) );
			$excerpt = preg_replace( '/\s+/', ' ', $excerpt );
			$excerpt = wolf_sample( sanitize_text_field( $excerpt ) );
		}

		return $excerpt;
	}
}

if ( ! function_exists( 'inkpro_get_wp_title' ) ) {
	/**
	 * Get the wp_title
	 *
	 * @since InkPro 1.0.0
	 * @return string $share_image
	 */
	function inkpro_get_wp_title() {
		$wp_title = '';
		ob_start();
		wp_title();
		$wp_title = ob_get_contents();
		ob_end_clean();
		$wp_title = preg_replace( '/&#?[a-z0-9]{2,8};/i', '', $wp_title );
		$wp_title = preg_replace( '/\s+/', ' ', $wp_title );

		// if ( '' == $wp_title ) {
		// 	$wp_title = get_the_title();
		// }
		
		if ( $wp_title ) {
			return $wp_title;
		}
	}
}

if ( ! function_exists( 'inkpro_do_social_meta' ) ) {
	/**
	 * Output social meta
	 *
	 * @since InkPro 1.0.0
	 * @return string $share_image
	 */
	function inkpro_do_social_meta() {
		global $post, $wp_query;
		$site_name = get_bloginfo( 'name' );

		if ( ! is_404() && ! is_search() && ( is_object( $post ) ) ) {
			$post_id = $post->ID;

			if ( $wp_query && isset( $wp_query->queried_object ) && isset( $wp_query->queried_object->ID ) )
				$post_id = $wp_query->queried_object->ID; ?>


<?php if ( inkpro_get_meta_description( $post ) ) : ?>
	<!-- google meta -->
	<meta name="description" content="<?php echo esc_attr( inkpro_get_meta_description( $post ) ); ?>" />
<?php endif; ?>

<!-- facebook meta -->
<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>" />

<?php if ( inkpro_get_wp_title() ) : ?>
	<meta property="og:title" content="<?php echo esc_attr( inkpro_get_wp_title() ); ?>" />
<?php endif; ?>

<meta property="og:url" content="<?php echo get_permalink( $post_id ); ?>" />
<?php if ( inkpro_get_meta_share_img( $post_id ) ) : ?><meta property="og:image" content="<?php echo esc_attr( inkpro_get_meta_share_img( $post_id ) ); ?>" />
<?php endif;
if ( inkpro_get_meta_description( $post ) ) : ?><meta property="og:description" content="<?php echo esc_attr( inkpro_get_meta_description( $post ) ); ?>" />
<?php endif; ?>

<!-- twitter meta -->
<meta name="twitter:card" content="summary">
<meta name="twitter:url" content="<?php echo get_permalink( $post_id ); ?>">
<?php if ( inkpro_get_wp_title() ) : ?>
	<meta name="twitter:title" content="<?php echo esc_attr( inkpro_get_wp_title() ); ?>">
<?php endif; ?>
<?php if ( inkpro_get_meta_share_img( $post_id ) ) : ?>
	<meta name="twitter:image" content="<?php echo esc_attr( inkpro_get_meta_share_img( $post_id ) ); ?>">
<?php endif;
if ( inkpro_get_meta_description( $post ) ) : ?>
	<meta name="twitter:description" content="<?php echo esc_attr( inkpro_get_meta_description( $post ) ); ?>">
<?php endif; ?>

<!-- google plus meta -->
<meta itemprop="name" content="<?php echo esc_attr( $site_name ); ?>" />
<?php if ( inkpro_get_meta_share_img( $post_id ) ) : ?>
	<meta itemprop="image" content="<?php echo esc_attr( inkpro_get_meta_share_img( $post_id ) ); ?>" />
<?php endif;
if ( inkpro_get_meta_description( $post ) ) : ?>
	<meta itemprop="description" content="<?php echo esc_attr( inkpro_get_meta_description( $post ) ); ?>" />
<?php endif; ?>
	<?php
		}
	}
} // end function check

if ( ! function_exists( 'inkpro_meta_sample' ) ) {
	/**
	 * Create a formatted sample of a page content
	 *
	 * @since InkPro 1.0.0
	 * @return string $share_image
	 */
	function inkpro_meta_sample( $text, $nbcar = 140, $after = '...' ) {
		$text = strip_tags( $text );

		if ( strlen( $text ) > $nbcar ) {

			preg_match( '!.{0,'.$nbcar.'}\s!si', $text, $match );
			if ( isset( $match[0] ) ) {
				$str = trim( $match[0] ) . $after;
			} else {
				$str = $text;
			}
		} else {
			$str = $text;
		}

		$str = preg_replace( '/\s\s+/', '', $str );
		$str = preg_replace(  '|\[(.+?)\](.+?\[/\\1\])?|s', '', $str );
		$str = preg_replace( '/\b(https?|ftp|file):\/\/[-A-Z0-9+&@#\/%?=~_|$!:,.;]*[A-Z0-9+&@#\/%=~_|$]/i', '', $str );
		return $str;
	}
}

/* Ouput metatags is option is check and YOAST plugin is not activated */
if ( wolf_get_theme_option( 'social_meta' ) && ! inkpro_is_seo_plugin_installed() ) {
	add_action( 'wolf_meta_head', 'inkpro_do_social_meta' );
}