<?php
/**
 * InkPro colors
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_color_scheme_mods( $inkpro_mods ) {

	$color_scheme = inkpro_get_color_scheme();

	$inkpro_mods['colors'] = array(
		'id' => 'colors',
		'icon' => 'admin-customizer',
		'title' => esc_html__( 'Colors', 'inkpro' ),
		'options' => array(
			array(
				'label' => esc_html__( 'Color scheme', 'inkpro' ),
				'id' => 'color_scheme',
				'type' => 'select',
				'choices'  => inkpro_get_color_scheme_choices(),
				'transport' => 'postMessage',
			),
			array(
				'id' => 'body_background_color',
				'label' => esc_html__( 'Background Color', 'inkpro' ),
				'description' => esc_html__( 'Only visible with the boxed layout.', 'inkpro' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[0],
			),
			array(
				'id' => 'page_background_color',
				'label' => esc_html__( 'Page Background Color', 'inkpro' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[1],
			),
			array(
				'id' => 'accent_color',
				'label' => esc_html__( 'Accent Color', 'inkpro' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[2],
			),
			array(
				'id' => 'main_text_color',
				'label' => esc_html__( 'Main Text Color', 'inkpro' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[3],
			),
			array(
				'id' => 'secondary_text_color',
				'label' => esc_html__( 'Secondary Text Color', 'inkpro' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[4],
			),
			array(
				'id' => 'strong_text_color',
				'label' => esc_html__( 'Strong Text Color', 'inkpro' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[5],
			),

			array(
				'id' =>'submenu_background_color',
				'label' => esc_html__( 'Submenu Background Color', 'inkpro' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[6],
			),

			array(
				'id' =>'entry_content_background_color',
				'label' => esc_html__( 'Entry Content Background Color', 'inkpro' ),
				'type' => 'color',
				'transport' => 'postMessage',
				'default' => $color_scheme[7],
			),
		),
	);

	if ( class_exists( 'WooCommerce' ) ) {
		$inkpro_mods['colors']['options'][] = array(
			'id' =>'product_tabs_background_color',
			'label' => esc_html__( 'Product Tabs Background Color', 'inkpro' ),
			'type' => 'color',
			'transport' => 'postMessage',
			'default' => $color_scheme[8],
		);

		$inkpro_mods['colors']['options'][] = array(
			'id' =>'product_tabs_text_color',
			'label' => esc_html__( 'Product Tabs Text Color', 'inkpro' ),
			'type' => 'color',
			'transport' => 'postMessage',
			'default' => $color_scheme[9],
		);
	}

	return $inkpro_mods;

}
add_filter( 'inkpro_customizer_options', 'inkpro_set_color_scheme_mods' );