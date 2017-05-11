<?php
/**
 * InkPro navigation
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_navigation_mods( $inkpro_mods ) {

	$inkpro_mods['navigation'] = array(
		'id' => 'navigation',
		'icon' => 'menu',
		'title' => esc_html__( 'Navigation', 'inkpro' ),
		'options' => array(

			'ajax_nav' => array(
				'id' =>'ajax_nav',
				'label' => esc_html__( 'AJAX Navigation', 'inkpro' ),
				'type' => 'checkbox',
				'description' => esc_html__( 'Navigate without reloading the page.', 'inkpro' ),
			),

			'menu_layout' => array(
				'id' => 'menu_layout',
				'label' => esc_html__( 'Main Menu Layout', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'inkpro' ),
					'centered' => esc_html__( 'Logo Centered', 'inkpro' ),
					'centered-socials' => esc_html__( 'Centered with Social Icons at Right', 'inkpro' ),
					'centered-blog' => esc_html__( 'Centered with Search Icon at Right', 'inkpro' ),
				),
				'description' => esc_html__( 'Create your menu(s) accordingly in the menu admin panel.', 'inkpro' ),
			),

			'menu_width' => array(
				'id' => 'menu_width',
				'label' => esc_html__( 'Main Menu Width for Standard Style', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'boxed' => esc_html__( 'Boxed', 'inkpro' ),
					'wide' => esc_html__( 'Wide', 'inkpro' ),
					'fullwidth' => esc_html__( '100% Width', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			'menu_centered_alignment' => array(
				'id' => 'menu_centered_alignment',
				'label' => esc_html__( 'Main Menu Alignment for Logo Centered Style', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'boxed' => esc_html__( 'Boxed (menu item close to the logo)', 'inkpro' ),
					'wide' => esc_html__( 'Wide (menu items far from the logo)', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			'auto_menu_type' => array(
				'id' =>'auto_menu_type',
				'label' => esc_html__( 'Main Menu Style', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'semi-transparent' => esc_html__( 'Semi-transparent White', 'inkpro' ),
					'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'inkpro' ),
					'standard' => esc_html__( 'Solid', 'inkpro' ),
					'absolute' => esc_html__( 'Absolute position', 'inkpro' ),
					'transparent' => esc_html__( 'Transparent', 'inkpro' ),
				),
			),

			'menu_hover_style' => array(
				'id' => 'menu_hover_style',
				'label' => esc_html__( 'Main Menu Hover Style', 'inkpro' ),
				'type' => 'select',
				'choices' => apply_filters( 'inkpro_main_menu_hover_style_options', array(
					'none' => esc_html__( 'None', 'inkpro' ),
					'opacity' => esc_html__( 'Opacity', 'inkpro' ),
					'line' => esc_html__( 'Line', 'inkpro' ),
					'line2' => esc_html__( 'Line 2', 'inkpro' ),
					'border' => esc_html__( 'Border', 'inkpro' ),
					'plain' => esc_html__( 'Plain', 'inkpro' ),
				) ),
				'transport' => 'postMessage',
			),

			'main_menu_item_separator' => array(
				'id' => 'main_menu_item_separator',
				'label' => esc_html__( 'Main Menu Item Separator', 'inkpro' ),
				'type' => 'text',
				'description' => sprintf( wp_kses(
					__( 'This will be output via CSS, so you need to use ISO format if you want to use special characters (<a href="%s" target="_blank">cheat sheet</a>).', 'inkpro' ),
						array( 'a' => array( 'href' => array(), 'target' => array(), ) )
					),
					esc_url( 'https://brajeshwar.github.io/entities/' )
				),
			),

			// 'sub_menu_color' => array(
			// 	'id' =>'sub_menu_color',
			// 	'label' => esc_html__( 'Submenu Color', 'inkpro' ),
			// 	'type' => 'color',
			// ),

			'submenu_width' => array(
				'id' => 'submenu_width',
				'label' => esc_html__( 'Mega Menu Width', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'boxed' => esc_html__( 'Boxed', 'inkpro' ),
					'wide' => esc_html__( 'Wide', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			'menu_height' => array(
				'id' =>'menu_height',
				'label' => esc_html__( 'Menu Height in px', 'inkpro' ),
				'type' => 'text',
				//'transport' => 'postMessage',
			),

			'menu_item_padding' => array(
				'id' =>'menu_item_padding',
				'label' => esc_html__( 'Menu item horizontal padding in px', 'inkpro' ),
				'type' => 'text',
			),

			// 'menu_font_size' => array(
			// 	'id' =>'menu_font_size',
			// 	'label' => esc_html__( 'Menu font size', 'inkpro' ),
			// 	'type' => 'text',
			// ),

			'menu_breakpoint' => array(
				'id' =>'menu_breakpoint',
				'label' => esc_html__( 'Main Menu Breakpoint', 'inkpro' ),
				'type' => 'text',
				'description' => esc_html__( 'Below each width would you like to display the mobile menu? 0 will always show the desktop menu and 99999 will always show the mobile menu.', 'inkpro' ),
			),

			'sticky_menu' => array(
				'id' =>'sticky_menu',
				'label' => esc_html__( 'Sticky Menu', 'inkpro' ),
				'type' => 'checkbox',
				'description' => esc_html__( 'The menu will stay at the top while scrolling.', 'inkpro' ),
			),

			'menu_bottom_border' => array(
				'label' => esc_html__( 'Menu Bottom Border', 'inkpro' ),
				'id' => 'menu_bottom_border',
				'type' => 'checkbox',
			),

			'search_menu_item' => array(
				'label' => esc_html__( 'Search Menu Item', 'inkpro' ),
				'id' => 'search_menu_item',
				'type' => 'select',
				'choices' => array(
					'overlay' => esc_html__( 'Overlay', 'inkpro' ),
					'' => esc_html__( 'No Search Menu Item', 'inkpro' ),
				),
			),

			'search_menu_item_icon' => array(
				'label' => esc_html__( 'Search Menu Item Icon', 'inkpro' ),
				'id' => 'search_menu_item_icon',
				'type' => 'select',
				'choices' => array(
					'fa-search' => esc_html__( 'Icon 1', 'inkpro' ),
					'line-icon-search' => esc_html__( 'Icon 2', 'inkpro' ),
				),
			),
		),
	);

	if ( apply_filters( 'inkpro_display_topbar', '' ) ) {
		$inkpro_mods['navigation']['options']['topbar_content'] = array(
			'label' => esc_html__( 'Optional content to display in the top bar.', 'inkpro' ),
			'id' => 'topbar_content',
			'type' => 'text',
		);
	}

	if ( class_exists( 'WooCommerce' ) ) {
		$inkpro_mods['navigation']['options']['menu_layout']['choices']['centered-shop'] = esc_html__( 'Centered with Cart Icon at Right', 'inkpro' );
	}

	if ( function_exists( 'icl_object_id' ) ) {
		$inkpro_mods['navigation']['options']['menu_layout']['choices']['centered-wpml'] = esc_html__( 'Centered with Language Switcher at Right', 'inkpro' );
	}

	if ( class_exists( 'Wolf_Page_Builder' ) ) {
		$inkpro_mods['navigation']['options']['menu_socials_services'] = array(
			'id' =>'menu_socials_services',
			'label' => esc_html__( 'Menu Socials', 'inkpro' ),
			'description' => sprintf( wp_kses(
				__( 'Enter the social networks names separated by a comma. e.g "twitter, facebook, instagram". ( see Wolf Page Builder options <a href="%s">social profiles tab</a>).', 'inkpro' ),
					array( 'a' => array( 'href' => array(), ) )
				),
				esc_url( admin_url( 'admin.php?page=wpb-socials' ) )
			),
			'type' => 'text',
		);
	}

	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_navigation_mods' );