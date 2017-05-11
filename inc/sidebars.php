<?php
/**
 * InkPro sidebars
 *
 * Register default sidebar for the theme with the inkpro_sidebars_init function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_sidebars_init' ) ) {
	/**
	 * Register footer widget area and main sidebar
	 *
	 * Add a shop sidebar if WooCommerce is installed
	 *
	 * @since InkPro 1.0.0
	 */
	function inkpro_sidebars_init() {

		// Blog Sidebar
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Blog Sidebar', 'inkpro' ),
				'id'            		=> 'sidebar-main',
				'description'   		=> esc_html__( 'Appears in blog pages if it contains widgets', 'inkpro' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'  		=> '</div></aside>',
				'before_title' 	 	=> '<h3 class="widget-title">',
				'after_title'  	 	=> '</h3>',
			)
		);

		// Page Sidebar
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Page Sidebar', 'inkpro' ),
				'id'            		=> 'sidebar-page',
				'description'   		=> esc_html__( 'Appears in pages if it contains wigets', 'inkpro' ),
				'before_widget' 	=> '<aside id="%1$s" class="clearfix widget %2$s"><div class="widget-content">',
				'after_widget'		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);

		// Woocommerce Siderbar
		if ( class_exists( 'Woocommerce' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Shop Sidebar', 'inkpro' ),
					'id'            		=> 'woocommerce',
					'description'   		=> esc_html__( 'Appears in WooCommerce pages if a layout with sidebar is set', 'inkpro' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  	=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Discography Siderbar
		if ( class_exists( 'Wolf_Discography' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Discography Sidebar', 'inkpro' ),
					'id'            		=> 'sidebar-discography',
					'description'   		=> esc_html__( 'Appears on the discography pages if a layout with sidebar is set', 'inkpro' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Videos Siderbar
		if ( class_exists( 'Wolf_Videos' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Videos Sidebar', 'inkpro' ),
					'id'            		=> 'sidebar-videos',
					'description'   		=> esc_html__( 'Appears on the videos pages if a layout with sidebar is set', 'inkpro' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Albums Siderbar
		if ( class_exists( 'Wolf_Albums' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Albums Sidebar', 'inkpro' ),
					'id'            		=> 'sidebar-albums',
					'description'   		=> esc_html__( 'Appears on the albums pages if a layout with sidebar is set', 'inkpro' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Events Siderbar
		if ( class_exists( 'Wolf_Events' ) ) {
			register_sidebar(
				array(
					'name'          		=> esc_html__( 'Events Sidebar', 'inkpro' ),
					'id'            		=> 'sidebar-events',
					'description'   		=> esc_html__( 'Appears on the events pages if a layout with sidebar is set', 'inkpro' ),
					'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
					'after_widget'  		=> '</div></aside>',
					'before_title'  		=> '<h3 class="widget-title">',
					'after_title'   		=> '</h3>',
				)
			);
		}

		// Footer Sidebar
		register_sidebar(
			array(
				'name'          		=> esc_html__( 'Footer Widget Area', 'inkpro' ),
				'id'            		=> 'sidebar-footer',
				'description'   		=> esc_html__( 'Appears in the footer section of the site', 'inkpro' ),
				'before_widget' 	=> '<aside id="%1$s" class="widget %2$s"><div class="widget-content">',
				'after_widget'		=> '</div></aside>',
				'before_title'  		=> '<h3 class="widget-title">',
				'after_title'   		=> '</h3>',
			)
		);
	}
	add_action( 'widgets_init', 'inkpro_sidebars_init' );
} // end function check
