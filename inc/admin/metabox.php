<?php
/**
 * InkPro metaboxes
 *
 * Register metabox for the theme with the inkpro_do_metaboxes function
 * This function can be overwritten in a child theme
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_do_metaboxes' ) ) {
	/**
	 * Set theme metaboxes
	 *
	 * Allow to add specific style options for each page
	 *
	 * @since InkPro 1.0.0
	 */
	function inkpro_do_metaboxes() {

		/* Header params */
		$inkpro_header_metaboxes = array(
			'header_settings' => array(
				'title' => esc_html__( 'Header Options', 'inkpro' ),
				'page' => apply_filters( 'inkpro_header_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'we_event', 'theme_documentation', 'plugin_documentation' ) ),
				'help' => esc_html__( 'It will overwrite all other header image settings.', 'inkpro' ),

				'metafields' => array(

					array(
						'label'	=> esc_html__( 'Header Background Type', 'inkpro' ),
						'id'	=> '_post_bg_type',
						'type'	=> 'select',
						'choices' => array(
							'image' => esc_html__( 'Image', 'inkpro' ),
							'video' => esc_html__( 'Video', 'inkpro' ),
						),
					),

					array(
						'label'	=> esc_html__( 'Header Background', 'inkpro' ),
						'id'	=> '_post_bg',
						'type'	=> 'background',
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'image' ) ),
					),

					array(
						'label'	=> esc_html__( 'Header Background Effect', 'inkpro' ),
						'id'	=> '_post_bg_effect',
						'type'	=> 'select',
						'choices' => array(
							'zoomin' => esc_html__( 'Zoom', 'inkpro' ),
							'parallax' => esc_html__( 'Parallax', 'inkpro' ),
							'none' => esc_html__( 'None', 'inkpro' ),
						),
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'image' ) ),
					),

					// array(
					// 	'label'	=> esc_html__( 'Header font color', 'inkpro' ),
					// 	'id'	=> '_post_font_color',
					// 	'type'	=> 'select',
					// 	'choices' => array(
					// 		'' => esc_html__( 'Auto', 'inkpro' ),
					// 		'dark' => esc_html__( 'Dark', 'inkpro' ),
					// 		'light' => esc_html__( 'Light', 'inkpro' ),
					// 	),
					// ),

					array(
						'label'	=> esc_html__( 'Video Background Type', 'inkpro' ),
						'id'	=> '_post_video_bg_type',
						'type'	=> 'select',
						'choices' => array(
							'selfhosted' => esc_html__( 'Self hosted', 'inkpro' ),
							'youtube' => 'Youtube',
						),
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'video' ) ),
					),

					array(
						'label'	=> esc_html__( 'YouTube URL', 'inkpro' ),
						'id'	=> '_post_video_bg_youtube_url',
						'type'	=> 'text',
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'video' ) ),
					),

					array(
						'label'	=> esc_html__( 'Video Background', 'inkpro' ),
						'id'	=> '_post_video_bg',
						'type'	=> 'video',
						'dependency' => array( 'element' => '_post_bg_type', 'value' => array( 'video' ) ),
					),

					array(
						'label'	=> esc_html__( 'Add Header Overlay', 'inkpro' ),
						//'desc'   =>esc_html__( 'Is your image too light or too dark to read the text?', 'inkpro' ),
						'id'	=> '_post_overlay',
						'type'	=> 'select',
						'choices' => array(
							'yes' => esc_html__( 'Yes', 'inkpro' ),
							'' => esc_html__( 'No', 'inkpro' ),
						),
					),

					array(
						'label'	=> esc_html__( 'Overlay Color', 'inkpro' ),
						'id'	=> '_post_overlay_color',
						'type'	=> 'colorpicker',
						'value' 	=> '#000000',
						'dependency' => array( 'element' => '_post_overlay', 'value' => array( 'yes' ) ),
					),

					array(
						'label'	=> esc_html__( 'Overlay Opacity (in percent)', 'inkpro' ),
						'id'	=> '_post_overlay_opacity',
						'desc'	=> esc_html__( 'Adapt the header overlay opacity if needed', 'inkpro' ),
						'type'	=> 'int',
						'value'	=> 40,
						'dependency' => array( 'element' => '_post_overlay', 'value' => array( 'yes' ) ),
					),

				),
			),
		);

		$common_params = array(

				array(
					'label'	=> '',
					'id'	=> '_post_subheading',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Menu Style', 'inkpro' ),
					'id'	=> '_post_menu_type',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'Default (set in the customizer)', 'inkpro' ),
						'standard' => esc_html__( 'Solid', 'inkpro' ),
						'semi-transparent' => esc_html__( 'Semi-transparent White', 'inkpro' ),
						'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'inkpro' ),
						'transparent' => esc_html__( 'Transparent', 'inkpro' ),
						'absolute' => esc_html__( 'Solid in absolute position', 'inkpro' ),
						'none' => esc_html__( 'Hide menu', 'inkpro' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Page Header Type', 'inkpro' ),
					'id'	=> '_post_header_type',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'Default (set in the customizer)', 'inkpro' ),
						'standard' => esc_html__( 'Standard', 'inkpro' ),
						'big' => esc_html__( 'Big', 'inkpro' ),
						'small' => esc_html__( 'Small', 'inkpro' ),
						'breadcrumb' => esc_html__( 'Breadcrumb', 'inkpro' ),
						'none' => esc_html__( 'No header', 'inkpro' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Hide Title', 'inkpro' ),
					'id'	=> '_post_hide_title_text',
					'type'	=> 'checkbox',
				),
				
				array(
					'label'	=> esc_html__( 'Hide featured image on single post/page (if displayed)', 'inkpro' ),
					'id'	=> '_post_hide_featured_image',
					'type'	=> 'checkbox',
				),

				array(
					'label'	=> esc_html__( 'Hide Footer', 'inkpro' ),
					'id'	=> '_post_hide_footer',
					'type'	=> 'checkbox',
				),

				array(
					'label'	=> esc_html__( 'Custom CSS', 'inkpro' ),
					'id'	=> '_post_css',
					'type'	=> 'textarea',
				),
		);
		
		/************** Page options ******************/
		$inkpro_page_metaboxes = array(

			'meta_options' => array(
					
				'title' => esc_html__( 'Page Options', 'inkpro' ),
				'page' => apply_filters( 'inkpro_page_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'we_event', 'theme_documentation', 'plugin_documentation' ) ),
				'metafields' => array(),
			),
		);

		foreach ( $common_params as $param ) {
			$inkpro_page_metaboxes['meta_options']['metafields'][] = $param;
		}
		
		/************** Post options ******************/
		$inkpro_post_metaboxes = array(

			'meta_options' => array(
				'title' => esc_html__( 'Post Options', 'inkpro' ),
				'page' => array( 'post' ),
				'metafields' => array(
					array(
						'label'	=> esc_html__( 'Post Layout', 'inkpro' ),
						'id'	=> '_single_post_layout',
						'type'	=> 'select',
						'choices' => array(
							'small-width' => esc_html__( 'Standard', 'inkpro' ),
							'full-width' => esc_html__( 'Full width', 'inkpro' ),
							'sidebar' => esc_html__( 'Sidebar', 'inkpro' ),
							'split' => esc_html__( 'Split', 'inkpro' ),
						),
					),

					array(
						'label'	=> esc_html__( 'Thumbnail Size (for metro layout only)', 'inkpro' ),
						'id'	=> '_single_post_metro_thumbnail_size',
						'type'	=> 'select',
						'choices' => array(
							'' => esc_html__( 'Auto (depends on post format)', 'inkpro' ),
							'small-square' => esc_html__( 'Small square', 'inkpro' ),
							'big-square' => esc_html__( 'Big square', 'inkpro' ),
							'landscape' => esc_html__( 'Landscape', 'inkpro' ),
							'portrait' => esc_html__( 'Portrait', 'inkpro' ),
						),
					),
				),
			),
		);

		foreach ( $common_params as $param ) {
			$inkpro_post_metaboxes['meta_options']['metafields'][] = $param;
		}

		/************** Gallery options ******************/
		$inkpro_gallery_metaboxes = array(

			'meta_options' => array(
				'title' => esc_html__( 'Gallery Options', 'inkpro' ),
				'page' => array( 'gallery' ),
				'metafields' => array(
					array(
						'label'	=> esc_html__( 'Gallery Layout', 'inkpro' ),
						'id'	=> '_single_gallery_layout',
						'type'	=> 'select',
						'choices' => array(
							'standard' => esc_html__( 'Standard', 'inkpro' ),
							'large-width' => esc_html__( 'Large width', 'inkpro' ),
							'full-width' => esc_html__( 'Full window', 'inkpro' ),
						),
					),
				),
			),
		);

		foreach ( $common_params as $param ) {
			$inkpro_gallery_metaboxes['meta_options']['metafields'][] = $param;
		}

		/************** Portfolio options ******************/
		$inkpro_work_metaboxes = array(

			'meta_options' => array(
				'title' => esc_html__( 'Work Options', 'inkpro' ),
				'page' => array( 'work' ),
				'metafields' => array(
					array(
						'label'	=> esc_html__( 'Work Layout', 'inkpro' ),
						'id'	=> '_single_work_layout',
						'type'	=> 'select',
						'choices' => array(
							'small-width' => esc_html__( 'Standard', 'inkpro' ),
							'full-width' => esc_html__( 'Full width', 'inkpro' ),
							'sidebar' => esc_html__( 'Sidebar', 'inkpro' ),
							'split' => esc_html__( 'Split', 'inkpro' ),
						),
					),
				),
			),
		);

		foreach ( $common_params as $param ) {
			$inkpro_work_metaboxes['meta_options']['metafields'][] = $param;
		}
		
		$inkpro_do_page_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'inkpro_page_metaboxes',  $inkpro_page_metaboxes ) );
		$inkpro_do_post_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'inkpro_post_metaboxes',  $inkpro_post_metaboxes ) );
		$inkpro_do_gallery_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'inkpro_gallery_metaboxes',  $inkpro_gallery_metaboxes ) );
		$inkpro_do_work_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'inkpro_work_metaboxes',  $inkpro_work_metaboxes ) );
		$inkpro_do_header_metaboxes = new Wolf_Theme_Admin_Metabox( apply_filters( 'inkpro_header_metaboxes',  $inkpro_header_metaboxes ) );
	}

	inkpro_do_metaboxes(); // do metaboxes
}