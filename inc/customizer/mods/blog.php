<?php
/**
 * InkPro blog
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function inkpro_set_blog_mods( $inkpro_mods ) {

	$inkpro_mods['blog'] = array(
		'id' => 'blog',
		'icon' => 'welcome-write-blog',
		'title' => esc_html__( 'Blog', 'inkpro' ),
		'options' => array(

			'blog_layout' => array(
				'id' =>'blog_layout',
				'label' => esc_html__( 'Blog Layout', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'inkpro' ),
					'fullwidth' => esc_html__( 'Full width', 'inkpro' ),
					'sidebar-right' => esc_html__( 'Sidebar at right', 'inkpro' ),
					'sidebar-left' => esc_html__( 'Sidebar at left', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			'blog_display' => array(
				'id' =>'blog_display',
				'label' => esc_html__( 'Blog Display', 'inkpro' ),
				'type' => 'select',
				'choices' => apply_filters( 'inkpro_blog_display_options', array(
					'classic' => esc_html__( 'Classic', 'inkpro' ),
					'grid2' => esc_html__( 'Grid', 'inkpro' ),
				) ),
			),

			'blog_more_link_type' => array(
				'id' => 'blog_more_link_type',
				'label' => esc_html__( 'More Link Type', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'wolf-button' => esc_html__( 'Button', 'inkpro' ),
					'wolf-more-text' => esc_html__( 'Text', 'inkpro' ),
				),
				//'transport' => 'postMessage',
			),

			'blog_category_filter' => array(
				'label' => esc_html__( 'Display category filter if available', 'inkpro' ),
				'id' => 'blog_category_filter',
				'type' => 'checkbox',
			),

			'blog_infinitescroll' => array(
				'label' => esc_html__( 'Infinite scroll', 'inkpro' ),
				'id' => 'blog_infinitescroll',
				'type' => 'checkbox',
			),

			'blog_infinitescroll_trigger' => array(
				'label' => esc_html__( 'Trigger infinite scroll with button', 'inkpro' ),
				'id' => 'blog_infinitescroll_trigger',
				'type' => 'checkbox',
			),

			'blog_grid_padding' => array(
				'id' => 'blog_grid_padding',
				'label' => esc_html__( 'Padding (for grid style display only)', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'inkpro' ),
					'no' => esc_html__( 'No', 'inkpro' ),
				),
				'transport' => 'postMessage',
			),

			'blog_post_navigation_type' => array(
				'id' =>'blog_post_navigation_type',
				'label' => esc_html__( 'Blog Single Post Navigation Type', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Previous and next post', 'inkpro' ),
					'related' => esc_html__( 'Related posts', 'inkpro' ),
					'both' => esc_html__( 'Standard navigation + Related posts', 'inkpro' ),
					'none' => esc_html__( 'No Navigation', 'inkpro' ),
				),
			),

			'date_format' => array(
				'id' =>'date_format',
				'label' => esc_html__( 'Date Format', 'inkpro' ),
				'type' => 'select',
				'choices' => array(
					'standard' => esc_html__( 'Standard', 'inkpro' ),
					'human_diff' => esc_html__( 'Differential ( e.g: 10 days ago )', 'inkpro' ),
				),
			),

			'blog_hide_date' => array(
				'label' => esc_html__( 'Hide date', 'inkpro' ),
				'id' => 'blog_hide_date',
				'type' => 'checkbox',
			),

			'blog_hide_author' => array(
				'label' => esc_html__( 'Hide author', 'inkpro' ),
				'id' => 'blog_hide_author',
				'type' => 'checkbox',
			),

			'blog_hide_category' => array(
				'label' => esc_html__( 'Hide category', 'inkpro' ),
				'id' => 'blog_hide_category',
				'type' => 'checkbox',
			),

			'blog_hide_tags' => array(
				'label' => esc_html__( 'Hide tags', 'inkpro' ),
				'id' => 'blog_hide_tags',
				'type' => 'checkbox',
			),

			'blog_hide_comments_count' => array(
				'label' => esc_html__( 'Hide comments count', 'inkpro' ),
				'id' => 'blog_hide_comments_count',
				'type' => 'checkbox',
			),

			'blog_hide_views' => array(
				'label' => esc_html__( 'Hide views', 'inkpro' ),
				'id' => 'blog_hide_views',
				'type' => 'checkbox',
			),

			'blog_hide_likes' => array(
				'label' => esc_html__( 'Hide likes', 'inkpro' ),
				'id' => 'blog_hide_likes',
				'type' => 'checkbox',
			),
		),
	);


	return $inkpro_mods;
}
add_filter( 'inkpro_customizer_options', 'inkpro_set_blog_mods' );