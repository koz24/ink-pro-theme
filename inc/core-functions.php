<?php
/**
 * Core functions
 *
 * General core functions available on admin and frontend
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get available blog display options
 *
 * Can be used in WPB extension
 *
 * @return array
 */
function inkpro_get_blog_post_display_options() {
	return array(
		'grid2' => esc_html__( 'Grid', 'inkpro' ),
		'grid' => esc_html__( 'Square Grid', 'inkpro' ),
		'grid3' => esc_html__( 'Portrait Grid', 'inkpro' ),
		'photo' => esc_html__( 'Photo Style', 'inkpro' ),
		'classic' =>  esc_html__( 'Classic', 'inkpro' ),
	);
}

if ( ! function_exists( 'inkpro_format_number' ) ) {
	/**
	 * Format number : 1000 -> 1K
	 *
	 * @since InkPro 1.0.0
	 * @param int $n
	 * @return string
	 */
	function inkpro_format_number( $n ) {

		$s   = array( 'K', 'M', 'G', 'T' );
		$out = '';
		while ( $n >= 1000 && count( $s ) > 0) {
			$n   = $n / 1000.0;
			$out = array_shift( $s );
		}
		return round( $n, max( 0, 3 - strlen( (int)$n ) ) ) ." $out";
	}
}

if ( ! function_exists( 'inkpro_has_wpb' ) ) {
	/**
	 * Check if Wolf Page Builder is activated
	 *
	 * @since InkPro 1.0.0
	 * @return bool
	 */
	function inkpro_has_wpb() {

		if ( class_exists( 'Wolf_Page_Builder' ) ) {
			return true;
		}
	}
}

/**
 * Filter theme menu layour mod
 *
 * If WPM is not installed and the menu with language switcher is set, return another menu layout instead
 *
 * @param $mod
 * @return $mod
 */
function inkpro_filter_menu_layout_theme_mods( $mod ) {

	if ( 'centered-wpml' == $mod && ! function_exists( 'icl_object_id' ) ) {
		$mod = 'centered-socials';
	}

	return $mod;
}
add_filter( 'theme_mod_menu_layout', 'inkpro_filter_menu_layout_theme_mods' );