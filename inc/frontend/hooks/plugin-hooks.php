<?php
/**
 * InkPro plugins hook functions
 *
 * Inject content through template hooks
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


/*-------------------------------------------------------------------------

	Wolf Albums hooks and filters

/*-------------------------------------------------------------------------*/

/**
 * Overwrite release thumbnail size
 *
 * @param string $size
 * @see Wolf Albums http://wolfthemes.com/plugin/wolf-albums/
 */
function inkpro_album_thumbnail_size( $size ) {

	$size = wolf_get_theme_mod( 'album_cover_thumbnail_size', 'inkpro-2x1' );

	return $size;
}
add_filter( 'wa_thumbnail_size', 'inkpro_album_thumbnail_size' );

/**
 * Overwrite album posts per page
 *
 * @param int $posts_per_page
 * @see Wolf Albums http://wolfthemes.com/plugin/wolf-albums/
 */
function inkpro_album_posts_per_page( $posts_per_page ) {

	$posts_per_page = wolf_get_theme_mod( 'gallery_posts_per_page', -1 );

	return $posts_per_page;
}
add_filter( 'wa_posts_per_page', 'inkpro_album_posts_per_page' );

/*-------------------------------------------------------------------------

	Wolf Videos hooks and filters

/*-------------------------------------------------------------------------*/

/**
 * Overwrite video posts per page
 *
 * @param int $posts_per_page
 * @see Wolf Videos http://wolfthemes.com/plugin/wolf-videos/
 */
function inkpro_video_posts_per_page( $posts_per_page ) {

	$posts_per_page = wolf_get_theme_mod( 'video_posts_per_page', -1 );

	return $posts_per_page;
}
add_filter( 'wv_posts_per_page', 'inkpro_video_posts_per_page' );

/*-------------------------------------------------------------------------

	Wolf Page Builder

/*-------------------------------------------------------------------------*/

/**
 * Big post slider summary
 *
 * Display the subheading on desired post type is available
 *
 * @param string $text
 * @return string $text
 */
function inkpro_last_posts_big_slide_summary( $text ) {

	$post_type = get_post_type();

	if ( 'gallery' == $post_type ) {
		$text = inkpro_get_the_subheading();
	}

	return $text;
}
add_filter( 'wpb_last_posts_big_slide_summary', 'inkpro_last_posts_big_slide_summary' );