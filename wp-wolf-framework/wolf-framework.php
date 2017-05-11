<?php
/**
 * WolfFramework main class
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Main Framework Class
 *
 * @since 1.4.2
 */
final class Wolf_Framework {

	/**
	 * @var string
	 */
	public $version = '3.2.0';

	/**
	 * @var string
	 * @since 3.0.2
	 */
	private $framework_root_folder_name = 'wp-wolf-framework';

	/**
	 * @var The single instance of the class
	 */
	protected static $_instance = null;

	/**
	 * Default theme settings
	 *
	 * @var array
	 */
	public $options = array(
		'menus' => array( 'primary' => 'Main Menu' ),
		'images' => array(),
	);

	/**
	 * Main Theme Instance
	 *
	 * Ensures only one instance of the theme is loaded or can be loaded.
	 *
	 * NOT USED YET
	 *
	 * @static
	 * @see WLFRMK()
	 * @return Theme - Main instance
	 */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
	}
	
	/**
	 * Cloning is forbidden.
	 * @since 2.3.1
	 */
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'inkpro' ), $this->version );
	}

	/**
	 * Unserializing instances of this class is forbidden.
	 * @since 2.3.1
	 */
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, esc_html__( 'Cheatin&#8217; huh?', 'inkpro' ), $this->version );
	}

	/**
	 * Wolf_Framework Constructor.
	 */
	public function __construct( $options = array() ) {

		$this->options = $options + $this->options;

		// Define constants
		$this->define_constants();
		
		// Includes
		$this->includes();
		
		// Hooks
		$this->init_hooks();
		
		do_action( 'wolf_framework_loaded' );
	}

	/**
	 * Hook into actions and filters
	 * @since  2.3.1
	 */
	private function init_hooks() {
		add_action( 'after_setup_theme', array( $this, 'setup' ) );
		//add_action( 'init', array( $this, 'includes' ) );
	}

	/**
	 * Define config constants
	 *
	 * These constant can be overwritten in a child theme
	 *
	 */
	private function define_config_constants() {

		$constants = array(
			'WOLF_REQUIRED_PHP_VERSION' => '5.4.0',
			'WOLF_REQUIRED_WP_VERSION' => '4.5',
			'WOLF_REQUIRED_WP_MEMORY_LIMIT' => '96M',
			'WOLF_REQUIRED_SERVER_MEMORY_LIMIT' => '96M',
			'WOLF_REQUIRED_MAX_INPUT_VARS' => 3000,
			'WOLF_UPDATE_NOTICE' => true,
			'WOLF_ENABLE_CUSTOMIZER' => true,
			'WOLF_ENABLE_ABOUT_MESSAGE' => true,
			'WOLF_DEBUG' => false,
		);

		foreach ( $constants as $name => $value ) {
			$this->define( $name, $value );
		}
	}

	/**
	 * Define constants
	 */
	private function define_constants() {

		$theme_data = wp_get_theme( get_template() );

		$constants = array(
			'WOLF_DOMAIN' => 'wolfthemes.com',
			'WOLF_UPDATE_URI' => 'https://updates.wolfthemes.com',
			'WOLF_SUPPORT_URI' => 'https://help.wolfthemes.com',
			'WOLF_THEME_DIR' => get_template_directory(),
			'WOLF_STYLESHEET_DIR' => get_stylesheet_directory(),
			'WOLF_THEME_URI' => trailingslashit( get_template_directory_uri() ),
			'WOLF_THEME_CSS' => trailingslashit( get_template_directory_uri() ) . 'assets/css',
			'WOLF_THEME_JS' => trailingslashit( get_template_directory_uri() ) . 'assets/js',
			'WOLF_THEME_CONFIG_DIR' => trailingslashit( get_template_directory() ) . 'config',
			'WOLF_FRAMEWORK_DIR' => trailingslashit( get_template_directory() ) . $this->framework_root_folder_name,
			'WOLF_FRAMEWORK_URI' => trailingslashit( get_template_directory_uri() ) . $this->framework_root_folder_name,
			'WOLF_FRAMEWORK_VERSION' => $this->version,
			'WOLF_THEME_VERSION' => $theme_data->Version,
			'WOLF_THEME_NAME' => $theme_data->Name,
			'WOLF_THEME_SLUG' => $theme_data->template,
			'WOLF_CACHE_DURATION' => 60 * 60 * 6,
		);

		foreach ( $constants as $name => $value ) {
			$this->define( $name, $value );
		}

		$this->define_config_constants();
	}

	/**
	 * Define constant if not already set
	 * @param  string $name
	 * @param  string|bool $value
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * What type of request is this?
	 * string $type ajax, frontend or admin
	 * @return bool
	 */
	private function is_request( $type ) {
		switch ( $type ) {
			case 'admin' :
				return is_admin();
			case 'ajax' :
				return defined( 'DOING_AJAX' );
			case 'cron' :
				return defined( 'DOING_CRON' );
			case 'frontend' :
				return ( ! is_admin() || defined( 'DOING_AJAX' ) ) && ! defined( 'DOING_CRON' );
		}
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {

		// Core functions
		include_once( WOLF_FRAMEWORK_DIR . '/inc/filters.php' );
		include_once( WOLF_FRAMEWORK_DIR . '/inc/functions.php' );
		include_once( WOLF_FRAMEWORK_DIR . '/inc/hooks-functions.php' );
		include_once( WOLF_FRAMEWORK_DIR . '/inc/class-customizer.php' );

		// Includes files from theme inc dir in both frontend and backend
		include_once( WOLF_THEME_DIR . '/inc/core-functions.php' );
		include_once( WOLF_THEME_DIR . '/inc/fonts.php' );
		include_once( WOLF_THEME_DIR . '/inc/sidebars.php' );

		// Includes config file (colors, add support, WooCommerce thumbnail size etc...)
		wolf_include( 'config/config.php' );

		// Includes WPB extend functions
		wolf_include( 'wpb-extend/wpb-extend.php' );

		// VC extends
		wolf_include( 'inc/vc-extend.php' );

		if ( $this->is_request( 'admin' ) ) {
			$this->admin_includes();
		}

		if ( $this->is_request( 'frontend' ) ) {
			$this->frontend_includes();
		}

		if ( $this->is_request( 'ajax' ) ) {
			$this->ajax_includes();
		}

		// Customizer related function needs to be included in both admin and frontend
		$this->customizer_includes();
	}

	/**
	 * Includes customizer files.
	 *
	 * They must be enqueued in front end and backend as well
	 */
	public function customizer_includes() {

		// Includes files from theme inc/customizer dir
		include_once( WOLF_THEME_DIR . '/inc/customizer/customizer-functions.php' );
		include_once( WOLF_THEME_DIR . '/inc/customizer/customizer-options.php' );
		include_once( WOLF_THEME_DIR . '/inc/customizer/customizer-frontend.php' );
	}

	/**
	 * Includes framework filters, functions, specific front end options & template-tags
	 */
	public function frontend_includes() {

		// includes files from theme inc/frontend dir
		include_once( WOLF_THEME_DIR . '/inc/frontend/class-menu-walker.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/body-classes.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/comments.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/functions.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/conditional-functions.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/gallery.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/template-tags.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/hooks.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/scheme.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/video-background.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/medias.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/options-styles.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/single-post-styles.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/social-meta.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/styles.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/woocommerce.php' );
		include_once( WOLF_THEME_DIR . '/inc/frontend/scripts.php' );

		wolf_include( 'inc/frontend/theme-functions.php' ); // theme specific functions if any
	}

	/**
	 * Includes ajax functions
	 */
	public function ajax_includes() {

		// Includes framework AJAX functions
		include_once( WOLF_FRAMEWORK_DIR . '/inc/ajax/ajax-functions.php' );

		// Includes files from theme inc/ajax dir
		include_once( WOLF_THEME_DIR . '/inc/ajax/ajax-functions.php' );
	}

	/**
	 * Includes framework filters, functions, specific front end options & template-tags
	 */
	public function admin_includes() {

		// Core admin functions and classes
		include_once( WOLF_FRAMEWORK_DIR . '/inc/admin/admin-functions.php' );
		include_once( WOLF_FRAMEWORK_DIR . '/inc/admin/admin-scripts.php' );
		include_once( WOLF_FRAMEWORK_DIR . '/inc/admin/class-admin.php' );
		include_once( WOLF_FRAMEWORK_DIR . '/inc/admin/class-options.php' );
		include_once( WOLF_FRAMEWORK_DIR . '/inc/admin/class-metabox.php' );
		include_once( WOLF_FRAMEWORK_DIR . '/inc/admin/class-category-meta.php' );

		// Includes menu files
		include_once( WOLF_THEME_DIR . '/inc/admin/class-menu-item-custom-fields.php' );
		
		// Includes admin files
		include_once( WOLF_THEME_DIR . '/inc/admin/admin-functions.php' );
		include_once( WOLF_THEME_DIR . '/inc/admin/admin-scripts.php' );
		include_once( WOLF_THEME_DIR . '/inc/admin/category-meta.php' );
		include_once( WOLF_THEME_DIR . '/inc/admin/gallery-settings.php' );
		include_once( WOLF_THEME_DIR . '/inc/admin/metabox.php' );
		include_once( WOLF_THEME_DIR . '/inc/admin/options.php' );

		// Includes recommend plugins files if any
		wolf_admin_include( 'config/plugins.php' );

		// Includes demo importer files if any
		wolf_admin_include( 'config/importer.php' );

		// Default theme options are defined in "config/default-options.php"
		wolf_admin_include( 'config/default-options.php' );

		// Update actions
		wolf_admin_include( 'config/update.php' );
	}

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 */
	public function setup() {

		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on the theme, use a find and replace
		 * to change 'inkpro' to the name of your theme in all the template files
		 */
		load_theme_textdomain( 'inkpro', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form', 'comment-form', 'comment-list', 'gallery', 'caption'
		) );

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support( 'post-formats', array(
			'aside', 'image', 'video', 'quote', 'link', 'gallery', 'status', 'audio', 'chat'
		) );

		/**
		 * Add custom background support
		 */
		add_theme_support( 'custom-background', array(
				'default-color' => '',
				'default-repeat' => 'no-repeat',
				'default-attachment' => 'fixed',
			)
		);

		/**
		 * Add custom header support to set a default header image for every page
		 *
		 * Diable the header text because we will handle it automatically to display the page title
		 */
		add_theme_support( 'custom-header', array(
				'header-text' => false,
				'height' => 1024, // recommended height
				'width' => 1280, // recommended width
				'flex-height' => true,
				'flex-width' => true,
			)
		);

		/**
		 * Indicate widget sidebars can use selective refresh in the Customizer.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/*
		 * This theme styles the visual editor to resemble the theme style,
		 * specifically typography
		 */
		if ( is_file( WOLF_THEME_DIR . '/assets/css/admin/editor-style.css' ) ) {
			add_editor_style( 'assets/css/admin/editor-style.css' );
		}

		$this->set_post_thumbnail_sizes();
		$this->register_nav_menus();
	}

	/**
	 * Set the different thumbnail sizes needed in the design
	 * (set in functions.php)
	 */
	public function set_post_thumbnail_sizes() {
		global $content_width;
		set_post_thumbnail_size( $content_width, $content_width / 2 ); // default Post Thumbnail dimensions

		$image_sizes = apply_filters( 'wolf_image_sizes', $this->options['images'] );

		if ( $image_sizes != array() ) {
			if ( function_exists( 'add_image_size' ) ) {
				foreach ( $image_sizes as $k => $v ) {
					add_image_size( $k, $v[0], $v[1], $v[2] );
				}
			}
		}
	}

	/**
	 * Register menus
	 */
	public function register_nav_menus() {
		if ( function_exists( 'register_nav_menus' ) ) {
			register_nav_menus( apply_filters( 'wolf_menus', $this->options['menus'] ) );
		}
	}
} // end class

/**
 * Returns the main instance of WLFRMK to prevent the need to use globals.
 *
 * @return Wolf_Framework
 */
function WLFRMK( $options = array() ) {
	return new Wolf_Framework( $options );
}