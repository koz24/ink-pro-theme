<?php
/**
 * InkPro logo
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_logo_mods( $inkpro_mods ) {

	$inkpro_mods['logo'] = array(
		'id' => 'logo',
		'title' => esc_html__( 'Logo', 'inkpro' ),
		'icon' => 'visibility',
		'description' => sprintf(
			wp_kses(
				__( 'Your theme recommends a logo size of <strong>%d &times; %d</strong> pixels.', 'inkpro' ),
				array(
					'strong' => array(),
				)
			),
			200, 80
		),
		'options' => array(
			'logo_dark' => array(
				'id' => 'logo_dark',
				'label' => esc_html__( 'Logo - dark version', 'inkpro' ),
				'type' => 'image',
			),

			'logo_light' => array(
				'id' => 'logo_light',
				'label' => esc_html__( 'Logo - light version', 'inkpro' ),
				'type' => 'image',
			),

			'logo_width' => array(
				'id' => 'logo_width',
				'label' => esc_html__( 'Desktop Logo Width', 'inkpro' ),
				'type' => 'int',
			),

			'logo_mobile_dark' => array(
				'id' => 'logo_mobile_dark',
				'label' => esc_html__( 'Logo for Mobile Devices - dark version (optional)', 'inkpro' ),
				'type' => 'image',
			),

			'logo_mobile_light' => array(
				'id' => 'logo_mobile_light',
				'label' => esc_html__( 'Logo for Mobile Devices - light version (optional)', 'inkpro' ),
				'type' => 'image',
			),

			'logo_shrink_menu' => array(
				'id' =>'logo_shrink_menu',
				'label' => esc_html__( 'Forces Logo to fit the menu height. The menu height must be set in the navigation section', 'inkpro' ),
				'type' => 'checkbox',
			),

			'logo_vertical_align' => array(
				'id' =>'logo_vertical_align',
				'label' => esc_html__( 'Align the logo image vertically', 'inkpro' ),
				'type' => 'checkbox',
			),

			// 'shrink_logo_sticky_menu' => array(
			// 	'id' =>'shrink_logo_sticky_menu',
			// 	'label' => esc_html__( 'Shrink Logo in Sticky Menu', 'inkpro' ),
			// 	'type' => 'checkbox',
			// 	'description' => esc_html__( 'Force logo to fit the menu height', 'inkpro' ),
			// ),
		),
	);

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_logo_mods' );