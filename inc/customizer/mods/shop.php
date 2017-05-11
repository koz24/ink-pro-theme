<?php
/**
 * InkPro shop
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_shop_mods( $inkpro_mods ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$inkpro_mods['shop'] = array(
			'id' => 'shop',
			'title' => esc_html__( 'Shop', 'inkpro' ),
			'icon' => 'cart',
			'options' => array(

				'shop_layout' => array(
					'id' => 'shop_layout',
					'label' => esc_html__( 'Products Layout', 'inkpro' ),
					'type' => 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'inkpro' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'inkpro' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'inkpro' ),
						'fullwidth' => esc_html__( 'Full width', 'inkpro' ),
					),
					'transport' => 'postMessage',
				),

				'shop_single_layout' => array(
					'id' => 'shop_single_layout',
					'label' => esc_html__( 'Single Product Layout', 'inkpro' ),
					'type' => 'select',
					'choices' => array(
						'fullwidth' => esc_html__( 'Full width', 'inkpro' ),
						//'standard' => esc_html__( 'Standard', 'inkpro' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'inkpro' ),
						'sidebar-left' => esc_html__( 'Sidebar at left', 'inkpro' ),
					),
					'transport' => 'postMessage',
				),

				'shop_display' => array(
					'id' => 'shop_display',
					'label' => esc_html__( 'Display', 'inkpro' ),
					'type' => 'select',
					'choices' => apply_filters( 'inkpro_shop_display_options', array(
						'grid' => esc_html__( 'Default Grid', 'inkpro' ),
						'list' => esc_html__( 'List', 'inkpro' ),
					) ),
				),

				// 'shop_padding' => array(
				// 	'id' => 'shop_padding',
				// 	'label' => esc_html__( 'Padding', 'inkpro' ),
				// 	'type' => 'select',
				// 	'choices' => array(
				// 		'yes' => esc_html__( 'Yes', 'inkpro' ),
				// 		'no' => esc_html__( 'No', 'inkpro' ),
				// 	),
				// 	'transport' => 'postMessage',
				// ),

				'shop_columns' => array(
					'id' => 'shop_columns',
					'label' => esc_html__( 'Columns (for grid display only)', 'inkpro' ),
					'type' => 'select',
					'choices' => array(
						3 => 3,
						2 => 2, 
						4 => 4, 
						5 => 5, 
						6 => 6,
					),
					'transport' => 'postMessage',
				),

				'cart_menu_item' => array(
					'label' => esc_html__( 'Add a Cart Menu Item', 'inkpro' ),
					'id' => 'cart_menu_item',
					'type' => 'checkbox',
				),

				'cart_menu_item_icon' => array(
					'label' => esc_html__( 'Cart Menu Item Icon', 'inkpro' ),
					'id' => 'cart_menu_item_icon',
					'type' => 'select',
					'choices' => array(
						'ti-basket' => esc_html__( 'Basket', 'inkpro' ),
						'ti-cart' => esc_html__( 'Cart 1', 'inkpro' ),
						'fa-shopping-cart' => esc_html__( 'Cart 2', 'inkpro' ),
						'lnr-cart' => esc_html__( 'Cart 3', 'inkpro' ),

					),
				),

				'cart_menu_panel_icon' => array(
					'label' => esc_html__( 'Cart Menu Panel Icon', 'inkpro' ),
					'id' => 'cart_menu_panel_icon',
					'type' => 'select',
					'choices' => array(
						'ti-basket' => esc_html__( 'Basket', 'inkpro' ),
						'ti-cart' => esc_html__( 'Cart 1', 'inkpro' ),
						'fa fa-shopping-cart' => esc_html__( 'Cart 2', 'inkpro' ),
						'lnr-cart' => esc_html__( 'Cart 3', 'inkpro' ),
						'dashicons-cart' => esc_html__( 'Cart 4', 'inkpro' ),

					),
				),

				'products_per_page' => array(
					'label' => esc_html__( 'Products per Page', 'inkpro' ),
					'id' => 'products_per_page',
					'type' => 'text',
				),
			),
		);
	}

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_shop_mods' );