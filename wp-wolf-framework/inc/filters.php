<?php
/**
 * WolfFramework common filters
 *
 * Create customizer inputs from array
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'wolf_page_menu_args' ) ) {
	/**
	 * Menu fallback function
	 * (display the list of pages as menu if no menu is created)
	 *
	 * @param array $args
	 * @return array $args
	 */
	function wolf_page_menu_args( $args ) {
		$args['sort_column'] = 'post_date';
		return $args;
	}
	add_filter( 'wp_page_menu_args', 'wolf_page_menu_args' );
}

if ( ! function_exists( 'wolf_add_menuclass' ) ) {
	/**
	 * Add a menu class to the fallback menu
	 * In case if the user didn't set any menu in the WP menu admin panel
	 * That way the default menu will have the same list CSS class
	 *
	 * @param string $page_markup
	 * @return string $new_markup
	 */
	function wolf_add_menuclass( $page_markup ) {
		preg_match( '/^<div class=\"([a-z0-9-_]+)\">/i', $page_markup, $matches );
		$div_class   = $matches[1];
		$to_replace = array( '<div class="' . $div_class . '">', '</div>' );
		$new_markup = str_replace( $to_replace, '', $page_markup );
		$new_markup = preg_replace( '/^<ul>/i', '<ul class="nav-menu">', $new_markup );
		return $new_markup;
	}
	add_filter( 'wp_page_menu', 'wolf_add_menuclass' );
}