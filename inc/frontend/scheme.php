<?php
/**
 * InkPro microdata hook functions
 *
 * Inject microdata content through template hooks
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_post_microdata' ) ) {
	/**
	 * Output post microdata
	 */
	function inkpro_post_microdata() {
		?>
		<meta itemprop="publisher" content="<?php echo esc_url( home_url( '/' ) ); ?>">
		<meta itemprop="mainEntityOfPage" content="<?php the_permalink(); ?>">
		<meta itemprop="name" content="<?php the_title(); ?>">
		<?php if ( is_single() ) : ?>
			<meta itemprop="headline" content="<?php the_title(); ?>">
		<?php endif; ?>
		<meta itemprop="image" content="<?php echo wolf_get_post_thumbnail_url( 'large' ); ?>">
		<meta itemprop="description" content="<?php echo wolf_sample( get_the_excerpt() ); ?>">
		<?php if ( comments_open() ) : ?>
		<meta itemprop="commentCount" content="<?php echo absint( get_comment_count() ); ?>">
		<?php endif; ?>
		<?php
	}
	//add_action( 'wolf_post_start', 'inkpro_post_microdata' );
}

/**
 * Get schema type depending on content
 */
function inkpro_get_body_schema_type( $type = 'WebPage' ) {

	$type = 'WebPage'; // default

	// Is blog home, archive or category
	if ( is_home() || is_archive() || is_category() ) {

		$type = 'Blog';
	}

	// Is static front page
	else if ( is_front_page() ) {

		$type = 'Website';
	}

	// Is search results page
	elseif ( is_search() ) {

		$type = 'SearchResultsPage';
	}

	return apply_filters( 'inkpro_body_schema_type', $type );
}

/**
 * Ouptut HTML microdata
 */
function inkpro_body_schema() {

	$schema = 'http://schema.org/';

	echo 'itemscope="itemscope" itemtype="' . esc_attr( $schema ) . esc_attr( inkpro_get_body_schema_type() ) . '"';
}

/**
 * Get schema type
 */
function inkpro_get_article_schema_type( $type = 'CreativeWork' ) {

	return apply_filters( 'inkpro_article_schema_type', $type );
}

/**
 * Ouptut HTML microdata
 */
function inkpro_article_schema() {

	$schema = 'http://schema.org/';

	echo 'itemscope itemtype="' . esc_attr( $schema ) . esc_attr( inkpro_get_article_schema_type() ) . '"';
}

/**
 * Add itemprop attributes to menu links
 */
function inkpro_add_menu_atts( $atts, $item, $args ) {
	$atts['itemprop'] = 'url';
	return $atts;
}
add_filter( 'nav_menu_link_attributes', 'inkpro_add_menu_atts', 10, 3 );