<?php
/**
 * InkPro footer
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_footer_mods( $inkpro_mods ) {

	$inkpro_mods['footer'] = array(

		'id' => 'footer',
		'title' => esc_html__( 'Footer', 'inkpro' ),
		'icon' => 'minus',
		'options' => array(

			array(
				'label' => esc_html__( 'Footer Width', 'inkpro' ),
				'id' => 'footer_layout',
				'type' => 'select',
				'choices' => array(
		 			'boxed' => esc_html__( 'Boxed', 'inkpro' ),
					'wide' => esc_html__( 'Wide', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Foot Widgets Layout', 'inkpro' ),
				'id' => 'footer_widgets_layout',
				'type' => 'select',
				'choices' => array(
		 			'3-cols' => esc_html__( '3 Columns', 'inkpro' ),
					'4-cols' => esc_html__( '4 Columns', 'inkpro' ),
					'one-half-two-quarter' => esc_html__( '1 Half/2 Quarters', 'inkpro' ),
					'two-quarter-one-half' => esc_html__( '2 Quarters/1 Half', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Scroll to Top Link Type', 'inkpro' ),
				'id' => 'scroll_to_top_link_type',
				'type' => 'select',
				'choices' => array(
		 			'arrow' => esc_html__( 'Arrow', 'inkpro' ),
					// 'text' => esc_html__( 'Text in footer', 'inkpro' ),
					'none' => esc_html__( 'None', 'inkpro' ),
				),
			),

			array(
				'label' => esc_html__( 'Scroll to Top Arrow Style', 'inkpro' ),
				'id' => 'scroll_to_top_arrow_style',
				'description' => esc_html__( 'If "arrow" if set above', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
		 			'round' => esc_html__( 'Round', 'inkpro' ),
					'square' => esc_html__( 'Square', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'label' => esc_html__( 'Bottom Bar Layout', 'inkpro' ),
				'id' => 'bottom_bar_layout',
				'type' => 'select',
				'choices' => array(
		 			'default' => esc_html__( 'Default', 'inkpro' ),
					'centered' => esc_html__( 'Centered', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			array(
				'id' => 'bottom_menu_item_separator',
				'label' => esc_html__( 'Botom Menu Separator', 'inkpro' ),
				'type' => 'text',
			),

			'copyright' => array(
				'id' => 'copyright',
				'label' => esc_html__( 'Copyright Text', 'inkpro' ),
				'type' => 'text',
			),
		),
	);

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_footer_mods' );