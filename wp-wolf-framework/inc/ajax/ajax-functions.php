<?php
/**
 * WolfFramework AJAX functions
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Delete customizer init function to force customizer to reset to default theme options
 */
function wolf_ajax_customizer_reset() {

	if ( ! is_customize_preview() ) {
		wp_send_json_error( 'not_preview' );
		echo 'preview error';
	}

	if ( ! check_ajax_referer( 'wolf-customizer-reset', 'nonce', false ) ) {
		wp_send_json_error( 'invalid_nonce' );
		echo 'nonce';
	}

	if ( delete_option( wolf_get_theme_slug() . '_customizer_init' ) ) {
		echo 'OK';
	}
	exit;

}
add_action( 'wp_ajax_wolf_ajax_customizer_reset', 'wolf_ajax_customizer_reset' );