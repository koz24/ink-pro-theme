<?php
/**
 * WolfFramework admin class
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! class_exists( 'Wolf_Framework_Admin' ) ) {
	/**
	 * Admin Theme Class
	 *
	 * @class Wolf_Framework_Admin
	 * @since 1.4.2
	 * @package WolfFramework
	 * @author WolfThemes
	 */
	class Wolf_Framework_Admin {

		/**
		 * Wolf_Framework_Admin Constructor.
		 */
		public function __construct() {

			// Update
			add_action( 'admin_init', array( $this, 'update' ), 0 );

			// Add theme options menu
			add_action( 'admin_menu', array( $this, 'menu' ), 8 );
			
			// Hide theme update menu so we show the page only when an update is available
			add_action( 'admin_head', array( $this, 'hide_menu_items' ) );
			
			// Add notices if the theme is not correctly installed or if any error
			add_action( 'admin_notices', array( $this, 'display_notice' ) );
		
			// Set default options and customizer mods
			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ) );
			//$this->after_setup_theme();

			// Include about page class
			include_once( 'class-about-page.php' );
		}

		/**
		 * Perform actions on updating the theme id needed
		 */
		public function update() {

			if ( ! defined( 'IFRAME_REQUEST' ) && ! defined( 'DOING_AJAX' ) && ( get_option( wolf_get_theme_slug() . '_version' ) != WOLF_THEME_VERSION ) ) {
			
				// Update hook
				do_action( 'wolf_do_update' );

				// Update version
				delete_option( wolf_get_theme_slug() . '_version' );
				add_option( wolf_get_theme_slug() . '_version', WOLF_THEME_VERSION );

				// After update hook
				do_action( 'wolf_updated' );
			}
		}

		/**
		 * Add the Theme menu to the WP admin menu
		 */
		public function menu() {
			add_theme_page( esc_html__( 'Theme Options', 'inkpro' ), esc_html__( 'Theme Options', 'inkpro' ), 'manage_options', 'wolf-theme-options', array( $this, 'options' ) );
			add_theme_page( esc_html__( 'Theme Updates', 'inkpro' ), esc_html__( 'Theme Updates', 'inkpro' ), 'manage_options', 'wolf-theme-update', array( $this, 'update_page' ) );
		}

		/**
		 * Add an update or error notice to the dashboard when needed
		 */
		public function display_notice() {

			global $pagenow;

			// Theme update notifications
			if ( $pagenow == 'index.php' ) {
				wolf_theme_update_notification_message();
			}

			/* Incorect Installation */
			$wrong_install = sprintf(
				wp_kses( 
					__( 'It seems that <strong>the theme has been installed incorrectly</strong>. Go <a href="%s" target="_blank">here</a> to find instructions about theme installation.', 'inkpro' ),
					array( 'strong' => array(), 'a' => array( 'href' => array(), 'target' => array() ) )
					),
					esc_url( 'http://wolfthemes.com/common-wordpress-theme-issues-44/' )
			);

			//  be sure that the framewwork is in the root folder of the theme
			$wolf_wp_themes_folder = basename( dirname( dirname( WOLF_FRAMEWORK_DIR ) ) );

			if ( $wolf_wp_themes_folder != 'themes' ) {
				wolf_admin_notice( $wrong_install , 'error' );
			}

			/* WordPress not up-to-date */
			$wordpress_version_too_old = sprintf(
				wp_kses( 
					__( 'It seems that <strong>your WordPress installation is a bit old</strong>. It is recommended to <a href="%s">update your installation</a> to the latest version.', 'inkpro' ),
					array( 'strong' => array(), 'a' => array( 'href' => array(), 'target' => array() ) )
					),
					esc_url( admin_url( '/update-core.php' ) )
			);

			global $wp_version;

			if ( ! version_compare( $wp_version, WOLF_REQUIRED_WP_VERSION, '>=' ) ) {
				wolf_admin_notice( $wordpress_version_too_old , 'warning', 'phaedra-wp-old' );
			}

			return false;
		}

		/**
		 * Update Page
		 */
		public function update_page() {
			include_once( WOLF_FRAMEWORK_DIR . '/pages/update.php' );
		}

		/**
		 * Theme options
		 * Generate Theme options page with the Wolf_Theme_options class
		 * The theme options are set in includes/options.php as an array
		 */
		public function options() {
			if ( class_exists( 'Wolf_Theme_Admin_Options' ) ) {
				$wolf_theme_options = apply_filters( 'wolf_theme_options', '' );
				$wolf_do_theme_settings = new Wolf_Theme_Admin_Options( $wolf_theme_options );
			}
		}

		/**
		 * Hide theme update page
		 */
		public function hide_menu_items() {
			remove_submenu_page( 'themes.php', 'wolf-theme-update' );
		}

		/**
		 * After switch theme hook
		 */
		public function after_setup_theme() {
			$this->default_mods();
			$this->default_options();
		}

		/**
		 * Theme customizer_settings
		 */
		public function default_mods() {

			$file_content = wolf_file_get_contents( 'config/customizer.dat' );

			// Check if default mods have already been set
			if ( get_option( wolf_get_theme_slug() . '_customizer_init' ) || ! $file_content ) {
				return;
			}

			if ( false !== ( $data= @unserialize( $file_content ) ) ) {

				$mods = $data['mods'];

				unset( $mods['nav_menu_locations'] );

				$mods = apply_filters( 'wolf_default_mods', $mods ); // filter default mods if needed

				foreach ( $mods as $key => $value ) {

					// remove external URL to avoid hot linking
					if ( wolf_is_external_url( $value ) ) {
						$mods[ $key ] = '';
					}

					set_theme_mod( $key, $value );
				}

				// Add option to flag that the default mods have been set
				add_option( wolf_get_theme_slug() . '_customizer_init', true );
			}
		}

		/**
		 * Theme default options
		 *
		 * Fires hook where the theme can set the default options
		 */
		public function default_options() {

			do_action( 'wolf_theme_default_options_init' ); // set default theme options hook

			// delete_option( wolf_get_theme_slug() . '_wp_options_init' );
			if ( ! get_option( wolf_get_theme_slug() . '_wp_options_init' ) ) {
			
				do_action( 'wolf_wp_default_options_init' ); // set default WP options hook, can only be fired once

				// Add option to flag that the default mods have been set
				add_option( wolf_get_theme_slug() . '_wp_options_init', true );
			}
		}

	} // end class
	new Wolf_Framework_Admin;
} // end class exists check