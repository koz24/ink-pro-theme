<?php
/**
 * Update
 *
 * Update options and mods from previous version if needed
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Update last posts shortcodes
 */
function inkpro_update_last_posts_shortcodes() {
	
	$pages = get_pages();

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		$content = get_post_meta( $page_id, '_wpb_shortcode_content', true );

		$content = str_replace( 'wpb_theme_posts', 'wpb_posts', $content );

		update_post_meta( $page_id, '_wpb_shortcode_content', $content );
	}
}

/**
 * Update custom theme button class attribute
 */
function inkpro_update_theme_button_attr() {
	
	$pages = get_pages();

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		$content = get_post_meta( $page_id, '_wpb_shortcode_content', true );

		$content = str_replace( 'wolf-button', 'wolf-wpb-button', $content );

		update_post_meta( $page_id, '_wpb_shortcode_content', $content );
	}
}

/**
 * Set new mods
 */
function inkpro_set_new_mods() {

	$current_version = get_option( wolf_get_theme_slug() . '_version' );

	// Control version
	if ( version_compare( $current_version, '1.0.0', '<' ) ) {

		if ( get_theme_mod( 'skin' ) && ! get_theme_mod( 'color_scheme' ) ) {
			set_theme_mod( 'color_scheme', get_theme_mod( 'skin' ) );
		}

		$pages = get_pages();

		foreach ( $pages as $p ) {
			delete_post_meta( $p->ID, '_post_menu_type' );

			if ( get_post_meta( $p->ID, '_post_hide_title', true ) ) {
				update_post_meta( $p->ID, '_post_header_type', 'none' );
				delete_post_meta( $p->ID, '_post_hide_title' );
			}
		}

		// Set new theme mods default value
		set_theme_mod( 'logo_shrink_menu', 'true' );
		set_theme_mod( 'logo_vertical_align', 'true' );
		set_theme_mod( 'auto_header_type', 'standard' );
	}

	if ( version_compare( $current_version, '1.3.4', '<' ) ) {
		
		if ( 'fullwidth' == get_theme_mod( 'shop_layout' ) ) {
			set_theme_mod( 'shop_layout', 'standard' );
		}

		set_theme_mod( 'footer_widgets_layout', '4-cols' );
	}

	if ( version_compare( $current_version, '1.4.7', '<' ) ) {
		inkpro_update_last_posts_shortcodes();
	}

	if ( version_compare( $current_version, '1.5.7', '<' ) ) {
		if ( get_theme_mod( 'search_menu_item' ) ) {
			set_theme_mod( 'search_menu_item', 'overlay' );
		} else {
			set_theme_mod( 'search_menu_item', '' );
		}
	}

	if ( version_compare( $current_version, '1.6.0', '<' ) ) {

		$old_display = get_theme_mod( 'shop_display' );
		$product_display = array(
			'grid2' => 'loren',
			'grid3' => 'agathe',
		);

		if ( 'grid2' == $old_display || 'grid3' == $old_display ) {
			set_theme_mod( 'shop_display', $product_display[ $old_display ] );
		}

		inkpro_update_theme_button_attr();

		set_theme_mod( 'footer_layout', 'boxed' );
	}
}
add_action( 'wolf_do_update', 'inkpro_set_new_mods' );