<?php
/**
 * InkPro extend Wolf Page Builder functions
 *
 * Add element to WPB that are available in the theme
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

/**
 * Add blog display type
 *
 * We will use the theme style to display the last posts
 */
function inkpro_add_wpb_post_display_types( $types ) {

	$types[] = 'classic';
	$types[] = 'grid';
	$types[] = 'grid2';
	$types[] = 'grid3';
	$types[] = 'photo';

	return $types;
}
add_filter( 'wpb_posts_display_types', 'inkpro_add_wpb_post_display_types' );

/**
 * Add blog display type without column
 *
 * Specify the display type that we want without column setting
 */
function inkpro_add_wpb_post_display_types_without_columns( $types ) {

	$types[] = 'classic';

	return $types;
}
add_filter( 'wpb_posts_display_types_without_columns', 'inkpro_add_wpb_post_display_types_without_columns' );

/**
 * Add elements
 *
 * @param array $elements
 * @return array $elements
 */
function inkpro_add_wpb_elements( $elements ) {

	$elements[] = 'last-posts-theme';

	return $elements;

}
add_filter( 'wpb_element_list', 'inkpro_add_wpb_elements' );