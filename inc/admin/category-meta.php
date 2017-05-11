<?php
/**
 * InkPro category metaboxes
 *
 * Register category metabox for the theme with the inkpro_do_category_metaboxes function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_do_category_metaboxes' ) ) {
	/**
	 * Set theme metaboxes
	 *
	 * Allow to add specific style options for each page
	 * @since InkPro 1.0.0
	 */
	function inkpro_do_category_metaboxes() {
		$category_metaboxes = array(
			array(
				'label' => esc_html__( 'Blog layout', 'inkpro' ),
				'id' =>'blog_layout',
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default (set in the customizer options)', 'inkpro' ),
					'standard' => esc_html__( 'Standard', 'inkpro' ),
					'fullwidth' => esc_html__( 'Full width', 'inkpro' ),
					'sidebar-left' => esc_html__( 'Sidebar at left', 'inkpro' ),
					'sidebar-right' => esc_html__( 'Sidebar at right', 'inkpro' ),
				),
			),

			array(
				'label' => esc_html__( 'Blog display', 'inkpro' ),
				'id' =>'blog_display',
				'type' => 'select',
				'choices' => array(
					'' => esc_html__( 'Default (set in the customizer options)', 'inkpro' ),
					'standard' => esc_html__( 'Standard', 'inkpro' ),
					'classic' => esc_html__( 'Classic', 'inkpro' ),
					'grid' => esc_html__( 'Square grid', 'inkpro' ),
					'column' => esc_html__( 'Columns', 'inkpro' ),
					'masonry' => esc_html__( 'Masonry', 'inkpro' ),
					'metro' => esc_html__( 'Metro', 'inkpro' ),
					'medium-image' => esc_html__( 'Medium image', 'inkpro' ),
					'photo' => esc_html__( 'Photo', 'inkpro' ),
				),
			),

			array(
				'id' => 'blog_grid_padding',
				'label' => esc_html__( 'Padding (for grid style display only)', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'inkpro' ),
					'no' => esc_html__( 'No', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),
		);
		$inkpro_do_category_metaboxes = new Wolf_Theme_Admin_Category_Meta( $category_metaboxes );
	}
	//inkpro_do_category_metaboxes();
}