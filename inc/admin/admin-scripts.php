<?php
/**
 * InkPro Admin scripts
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ){
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_enqueue_admin_scripts' ) ) {
	/**
	 * Enqueue admin scripts
	 *
	 * Styles and scripts for the theme options page
	 *
	 * @since InkPro 1.0.0
	 */
	function inkpro_enqueue_admin_scripts() {

		$inkpro_slug = wolf_get_theme_slug();

		// CSS
		wp_enqueue_media();
		wp_enqueue_style( $inkpro_slug . '-admin', WOLF_THEME_CSS. '/admin/admin.css', array(), WOLF_THEME_VERSION );
	}
	add_action( 'admin_enqueue_scripts', 'inkpro_enqueue_admin_scripts' );
}