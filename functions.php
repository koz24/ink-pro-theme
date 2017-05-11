<?php
/**
 * InkPro functions and definitions
 *
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_setup_config' ) ) {
	/**
	 * Sets up theme defaults and registers support for various WordPress features using the Wolf_Theme_Framework class
	 */
	function inkpro_setup_config() {
		/**
		 * Set the content width based on the theme's design and stylesheet.
		 *
		 * @since InkPro 1.0.0
		 */
		$GLOBALS['content_width'] = apply_filters( 'inkpro_content_width', 750 );

		/**
		 *  Require the wolf themes framework core file
		 */
		require_once get_template_directory() . '/wp-wolf-framework/wolf-framework.php';

		/**
		 * Set theme main settings
		 *
		 * We this array to configure the main theme settings
		 */
		$inkpro_theme = array(

			/* Menus (id => name) */
			'menus' => array(
				'primary-left' => esc_html__( 'Main Menu Left Part', 'inkpro' ),
				'primary-right' => esc_html__( 'Main Menu Right Part', 'inkpro' ),
				'primary' => esc_html__( 'Main Menu Standard', 'inkpro' ),
				'tertiary' => esc_html__( 'Bottom Menu', 'inkpro' ),
			),

			/**
			 *  We define wordpress thumbnail sizes that we will use in our design
			 */
			'images' => array(

				/**
				 * Create Wolf Page Builder image sizes if the plugin is not installed
				 * We will use the same image size names to avoid duplicated image sizes in the case the plugin is active
				 */
				'inkpro-thumb' => array( 640, 360, true ),
				'inkpro-photo' => array( 640, 640, false ),
				'inkpro-video-thumb' => array( 480, 270, true ),
				'inkpro-portrait' => array( 600, 900, true ),
				'inkpro-2x1' => array( 960, 480, true ), // landscape
				'inkpro-2x2' => array( 960, 960, true ), // square
				'inkpro-1x1' => array( 360, 360, true ), // square small
				'inkpro-1x2' => array( 480, 960, true ), // portrait
				'inkpro-XL' => array( 2000, 1500, false ), // XL
			),
		);
		WLFRMK( $inkpro_theme );
	}
} // end if function exists
inkpro_setup_config();
