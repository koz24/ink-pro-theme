<?php
/**
 * InkPro admin functions
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Enqueue admin script
 */
function inkpro_enqueue_admin_script() {
	wp_enqueue_script( 'inkpro-admin', WOLF_THEME_JS . '/admin.js', array( 'jquery' ), WOLF_THEME_VERSION, true );
	// Add JS global variables
	wp_localize_script(
		'inkpro-admin', 'InkproAdminParams', array(
			'subHeadingPlaceholder' => esc_html__( 'Subheading', 'inkpro' ),
		)
	);
}
add_action( 'admin_enqueue_scripts', 'inkpro_enqueue_admin_script' );

/**
 * Custom Default Avatar
 *
 * @param array $avatar_defaults
 * @return array
 */
function inkpro_gravatar( $avatar_defaults ) {

	if ( wolf_get_theme_option( 'custom_avatar' ) ) {

		$custom_avatar = wolf_get_theme_option( 'custom_avatar' );

		if ( is_numeric( $custom_avatar ) ) {

			$custom_avatar_url = wolf_get_url_from_attachment_id( absint( $custom_avatar ) );
		} else {
			$custom_avatar_url = esc_url( $custom_avatar );
		}

		$avatar_defaults[ $custom_avatar_url ] = sprintf( esc_html__( '%s avatar', 'inkpro' ), WOLF_THEME_NAME );
	}

	return $avatar_defaults;
}
add_filter( 'avatar_defaults', 'inkpro_gravatar' );

/**
 * Sync font loader option between WPB fonts and theme fonts
 *
 * @param array $options
 * @return array $options
 */
function inkpro_sync_font_options_to_theme( $options ) {

	if ( class_exists( 'Wolf_Page_Builder' ) ) {

		if ( isset( $options['google_fonts'] ) ) {
			$fonts = $options['google_fonts'];
			wolf_update_theme_option( 'google_fonts', $fonts );
		}
	}

	return $options;
}
add_action( 'wpb_after_options_save', 'inkpro_sync_font_options_to_theme' );

/**
 * Sync font loader option between theme fonts and WPB fonts
 */
function inkpro_sync_font_options_from_theme() {

	if ( class_exists( 'Wolf_Page_Builder' ) ) {
		wpb_update_option( 'fonts', 'google_fonts', wolf_get_theme_option( 'google_fonts' ) );
	}
}
add_action( 'wolf_after_options_save', 'inkpro_sync_font_options_from_theme' );

/**
 * Remove unuseful post formats on work posts
 */
function inkpro_work_post_formats() {

	$post_type = '';

	if ( isset( $_GET['post_type'] ) ) {
		$post_type = sanitize_title( $_GET['post_type'] );

	} elseif ( isset( $_GET['post'] ) ) {
		$post_type = get_post_type( absint( $_GET['post'] ) );
	}

	if ( 'work' == $post_type ) {
		add_theme_support( 'post-formats', array( 'image', 'video', 'audio', 'gallery' ) );
	}

}
add_action( 'load-post.php', 'inkpro_work_post_formats' );
add_action( 'load-post-new.php', 'inkpro_work_post_formats' );

/**
 * Custom theme CSS to display about badge and WPB welcome message background
 *
 * Get the files from child theme config folder if they existst or get them from parent theme
 *
 * @see wolf_get_theme_uri
 */
function inkpro_admin_custom_css() {

	$css = '
		/* About page badge */
		.svg .wp-badge.wolf-about-page-logo,
		.wp-badge.wolf-about-page-logo {
			background-image: url(' . wolf_get_theme_uri( 'config/about-badge.png' ) . ');
		}
	';

	if ( wolf_get_theme_uri( 'config/wpb-bg.jpg' ) ) {
		$css .= '
			/* WPB Welcome panel BG */
			.wpb-admin #welcome-panel{
				background-image: url(' . wolf_get_theme_uri( 'config/wpb-bg.jpg' ) . ');
			}
		';
	}

	if ( ! SCRIPT_DEBUG ) {
		$css = wolf_compact_css( $css );
	}

	wp_add_inline_style( 'wolf-admin', $css );
}
add_action( 'admin_enqueue_scripts', 'inkpro_admin_custom_css' );

/**
 * Set default logo
 *
 * @param $mods
 * @return $mods
 */
function inkpro_set_default_customizer_images( $mods ) {

	// Dark logo
	if ( wolf_get_theme_uri( 'config/logo_dark.png' ) ) {
		$mods['logo_dark'] = wolf_get_theme_uri( 'config/logo_dark.png' );
	}

	// Light logo
	if ( wolf_get_theme_uri( 'config/logo_light.png' ) ) {
		$mods['logo_light'] = wolf_get_theme_uri( 'config/logo_light.png' );
	}

	// Background
	if ( wolf_get_theme_uri( 'config/bg.jpg' ) ) {
		$mods['background_image'] = wolf_get_theme_uri( 'config/bg.jpg' );
	}

	// Upload default image header
	if ( wolf_get_theme_uri( 'config/header.jpg' ) ) {

		$filename = 'config/header.jpg';

		if ( ! function_exists( 'wp_handle_upload' ) ) {
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
		}

		$movefile = wp_upload_bits( 'header.jpg', null, wolf_file_get_contents( $filename ) );

		if ( $movefile && isset( $movefile['url'] ) && empty( $movefile['error'] ) ) {

			// Prepare an array of post data for the attachment.
			$movefile_url = $movefile['url'];
			$movefile_file = $movefile['file'];
			$filetype = wp_check_filetype( basename( $movefile_file ), null );
			$attachment = array(
				'guid' => $movefile_url,
				'post_mime_type' => $filetype['type'],
				'post_title' => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
				'post_content' => '',
				'post_status' => 'inherit'
			);

			$attach_id = wp_insert_attachment( $attachment, $movefile_file );

			if ( $attach_id  ) {
				$mods['header_image'] = wolf_get_theme_uri( 'config/header.jpg' );
				$header_image_data = new stdClass();
				$header_image_data->attachment_id = $attach_id;
				$header_image_data->url = $movefile_file;
				$header_image_data->thumbnail_url = $movefile_url;
				$header_image_data->width = 1280;
				$header_image_data->height = 1024;
				$mods['header_image_data'] = $header_image_data;
			}
		}
	}

	return $mods;
}
add_filter( 'wolf_default_mods', 'inkpro_set_default_customizer_images' );

/**
 * Define WooCommerce image sizes on theme activation
 *
 * Can be overwritten with the inkpro_woocommerce_thumbnail_sizes filter
 */
function inkpro_woocommerce_image_sizes() {
	global $pagenow;

	if ( ! isset( $_GET['activated'] ) || $pagenow != 'themes.php' ) {
		return;
	}

	$woocommerce_thumbnails = apply_filters( 'inkpro_woocommerce_thumbnail_sizes', array(
			'catalog' => array(
				'width' 	=> '400',	// px
				'height'	=> '400',	// px
				'crop'	=> 1 		// true
			),

			'single' => array(
				'width' 	=> '600',	// px
				'height'	=> '600',	// px
				'crop'	=> 1 		// true
			),

			'thumbnail' => array(
				'width' 	=> '120',	// px
				'height'	=> '120',	// px
				'crop'	=> 0 		// false
			),
		)
	);

	// Image sizes
	update_option( 'shop_catalog_image_size', $woocommerce_thumbnails['catalog'] ); // Product category thumbs
	update_option( 'shop_single_image_size', $woocommerce_thumbnails['single'] ); // Single product image
	update_option( 'shop_thumbnail_image_size', $woocommerce_thumbnails['thumbnail'] ); // Image gallery thumbs

	// enable ajax cart
	update_option( 'woocommerce_enable_ajax_add_to_cart', 'yes' );

	// disable WooCommerce lightbox so we can handle it
	update_option( 'woocommerce_enable_lightbox', 'no' );
}
add_action( 'after_switch_theme', 'inkpro_woocommerce_image_sizes', 1 );

/**
 * Set default wBounce modal window content on theme activation
 *
 * can be overwritten with wbounce_content filter
 *
 * @see https://wordpress.org/plugins/wbounce/
 */
function inkpro_set_wbounce_content() {

	// wBounce
	$wbounce_content = '<div class="modal-title">
	<h3>' . esc_html__( 'Never miss out any news!', 'inkpro' ) . '</h3>
</div>

<div class="modal-body">
	<p>' . esc_html__( 'Subscribe to receive the latest news by email', 'inkpro' ) . '</p>
	[wpb_mailchimp use_bg="false" label=""]
</div>

<div class="modal-footer">
       	<p>' . esc_html__( 'no thanks', 'inkpro' ) . '</p>
</div>';

	update_option( 'wbounce_content', apply_filters( 'inkpro_wbounce_content', $wbounce_content ) );

}
add_action( 'after_switch_theme', 'inkpro_set_wbounce_content', 1 );

/**
 * Set default theme options on theme activation and options reset
 *
 * The hook when the function occurs is called by the framework on theme activation and when the user click on "reset options"
 * These are the most common options and can filtered using the inkpro_default_options filter
 *
 * @see wp-wolf-framework/admin/class-admin.php
 * @see wp-wolf-framework/admin/class-options.php
 */
function inkpro_default_theme_options_init() {

	//delete_option( 'wolf_theme_options_' . wolf_get_theme_slug() );
	$theme_options = get_option( 'wolf_theme_options_' . wolf_get_theme_slug() );

	$default_options = array(); // set empty array to start with

	$default_options['post_share_buttons'] = 'true';
	$default_options['share'] = esc_html__( 'Share', 'inkpro' );
	$default_options['social_meta'] = 'true';
	$default_options['share_facebook'] = 'true';
	$default_options['share_twitter'] = 'true';

	// Default 404 bg if available in config folder
	if ( wolf_get_theme_uri( 'config/404.jpg' ) ) {
		$default_options['404_bg'] = wolf_get_theme_uri( 'config/404.jpg' );
	}

	$default_options['google_fonts'] = ''; // must be set to fill the google_fonts index by default

	// apply fiters to default options
	$default_options = apply_filters( 'inkpro_default_options', $default_options );

	// if option don't exist (may have been deleted on option reset)
	if ( ! $theme_options ) {

		update_option( 'wolf_theme_options_' . wolf_get_theme_slug(), $default_options );

		// update WPB font option as well
		if ( function_exists( 'wpb_update_option' ) ) {
			wpb_update_option( 'fonts', 'google_fonts', $default_options['google_fonts'] );
		}
	}
}
add_action( 'wolf_theme_default_options_init', 'inkpro_default_theme_options_init' );

/**
 * Set default WP options on theme activation
 *
 * This option is fired on wolf_wp_default_options_init hook that's fired only once after theme activation
 *
 * @see wp-wolf-framework/admin/class-admin.php
 */
function inkpro_default_wp_options_init() {

	// default WP options
	update_option( 'image_default_link_type', 'file' );
}
add_action( 'wolf_wp_default_options_init', 'inkpro_default_wp_options_init' );

/**
 * Hook WPB activation to save theme fonts in plugins settings
 *
 * We import the fonts from the theme in the page builder settings
 */
function inkpro_set_wpb_default_google_fonts( $settings ) {

	// Get theme fonts
	$theme_google_font_option = wolf_get_theme_option( 'google_fonts' );

	if ( class_exists( 'Wolf_Page_Builder' ) && $theme_google_font_option  ) {

		$settings['fonts']['google_fonts'] = $theme_google_font_option;
	}

	return $settings;
}
add_filter( 'wpb_default_settings', 'inkpro_set_wpb_default_google_fonts' );


/**
 * Disable OCDI PT branding
 *
 * @param bool
 * @return bool
 */
function inkpro_disable_ocdi_pt_branding( $bool ) {
	return true;
}
add_filter( 'pt-ocdi/disable_pt_branding', 'inkpro_disable_ocdi_pt_branding' );

/**
 * Set menu location after demo import
 *
 * @param array $menu_name
 */
function inkpro_set_menu_locations( $menus = array() ) {

	$menu_to_insert = array();

	foreach ( $menus as $location => $name ) {
		$menu = get_term_by( 'name', $name, 'nav_menu' );

		if ( $menu ) {
			$menu_to_insert[ $location ] = $menu->term_id;
		}
	}

	set_theme_mod( 'nav_menu_locations', $menu_to_insert );
}

/**
 * Set permalinks after import
 */
function inkpro_set_permalinks_after_import() {

	// Set pretty permalinks if they're not set yet
	if ( ! get_option( 'permalink_structure' ) ) {
		update_option( 'permalink_structure', '/%year%/%monthnum%/%postname%/' );
	}
}
add_action( 'pt-ocdi/after_import', 'inkpro_set_permalinks_after_import' );

/**
 * Set pages after import
 *
 * Assign each possible page from plugin (Home and Blog pages, Wolf plugins pages, WooCommerce pages etc...)
 */
function inkpro_set_pages_after_import() {

	// Assign front page and posts page (blog page).
	$front_page = get_page_by_title( 'Home' );
	$blog_page  = get_page_by_title( 'Blog' );

	update_option( 'show_on_front', 'page' );

	if ( $front_page ) {
		update_option( 'page_on_front', $front_page->ID );
	}

	if ( $blog_page ) {
		update_option( 'page_for_posts', $blog_page->ID );
	}

	// Assign plugins pages
	$wolf_pages = array(
		'Portfolio', 'Albums', 'Videos', 'Discography', 'Events', 'Wishlist',
	);

	foreach ( $wolf_pages as $page_title ) {

		$page = get_page_by_title( $page_title );

		if ( $page ) {
			update_option( '_wolf_' . strtolower( $page_title ) . '_page_id', $page->ID );
		}
	}

	// Assign WooCommerce pages
	$woocommerce_pages = array(
		'Shop', 'Cart', 'Checkout', 'My Account'
	);

	foreach ( $woocommerce_pages as $page_title ) {

		$page = get_page_by_title( $page_title );

		if ( 'My Account' == $page_title ) {

			$page_slug = 'myaccount';
		} else {
			$page_slug = strtolower( $page_title );
		}

		if ( $page ) {
			update_option( '_woocommerce_' . $page_slug . '_page_id', $page->ID );
		}
	}
}
add_action( 'pt-ocdi/after_import', 'inkpro_set_pages_after_import' );

/**
 * Demo importer Intro text
 *
 * @param string $default_text
 * @return string
 */
function inkpro_plugin_intro_text( $default_text ) {

	ob_start();
	?>
	<div class="wolf-ocdi-intro-text">

		<h1><?php esc_html_e( 'Install demo content', 'inkpro' ); ?></h1>

		<p class="about-description">
			<?php esc_html_e( 'Importing demo data is the easiest way to setup your theme. It will allow you to quickly edit everything instead of creating content from scratch.', 'inkpro' ); ?>
		</p>

		<hr>

		<p><?php esc_html_e( 'When you import the data, the following things might happen', 'inkpro' ); ?>:</p>

		<ul>
			<li><?php esc_html_e( 'No existing posts, pages, categories, images, custom post types or any other data will be deleted or modified.', 'inkpro' ); ?></li>
			<li><?php esc_html_e( 'Posts, pages, images, widgets, menus and other theme settings will get imported.', 'inkpro' ); ?></li>
			<li><?php esc_html_e( 'Images will be downloaded from our server.', 'inkpro' ); ?></li>
			<li><?php esc_html_e( 'Please click on the "Import" button only once and wait, it can take a few minutes.', 'inkpro' ); ?></li>
		</ul>

		<div class="wolf-ocdi-notice">
			<h4><?php esc_html_e( 'Important', 'inkpro' ); ?></h4>

			<ul>
				<li>
					<?php
					printf(
						__( 'Before you begin, make sure that your server settings fulfill the <a href="%s">server requirements</a>.', 'inkpro' ),
						admin_url( 'themes.php?page=wolf-theme-about' )
					);
				?>
				</li>
				<li><?php printf( esc_html__( 'Make sure all the required plugins are activated.', 'inkpro' ), '' ); ?></li>
				<li><?php esc_html_e( 'Deactivate all 3rd party plugins except the one recommended by the theme.', 'inkpro' ); ?></li>
				<li><?php esc_html_e( 'It is recommended to delete all pages that may have been created by plugins and empty the trash to avoid duplicate content.', 'inkpro' ); ?></li>
				<li><?php esc_html_e( 'It is always recommended to run the import on a fresh WordPress installation.', 'inkpro' ); ?></li>
				<li><?php esc_html_e( 'Some of the images may be replaced by placeholder images if they are copyrighted material.', 'inkpro' ); ?></li>
				<li><?php esc_html_e( 'As custom scripts may be used on the demo website to showcase layout variation options, some layout example pages may show the default customizer settings.', 'inkpro' ); ?></li>
				<li><?php
					printf(
						__( 'In the case of import failure, we recommend resetting your install before try it again using <a href="%s" target="_blank">WordPress Reset</a> plugin.', 'inkpro' ),
						'https://wordpress.org/plugins/wordpress-reset/'
					);
				?></li>
			</ul>
		</div><!-- .wolf-ocdi-notice -->
		<hr>
	</div><!-- .wolf-ocdi-intro-text -->
	<?php
	return ob_get_clean();
}
add_filter( 'pt-ocdi/plugin_intro_text', 'inkpro_plugin_intro_text' );

/**
 * Replace hard coded URLs from demo data WPB content to local URL
 *
 * Scan external URL and replace them by local ones in the Page Builder content
 */
function inkpro_replace_wpb_content_urls_after_import() {

	// update links in page builder content
	$pages = get_pages();

	// simple URL regex
	$url_regex = '/(http:|https:)?\/\/[a-zA-Z0-9\/.?&=_-]+/';
	$demo_url_reg_ex = '/(http|https)?:\/\/([a-z0-9.]+)\.' . WOLF_DOMAIN . '/';

	foreach ( $pages as $page ) {

		$page_id = $page->ID;

		//if ( 579 != $page_id ) { // dev
		//	continue;
		//}

		$content = get_post_meta( $page_id, '_wpb_shortcode_content', true );

		// Loop all URLs
		$content = preg_replace_callback( $url_regex, function ( $matches ) use ( $demo_url_reg_ex ) {

			$output = '';

			if ( isset( $matches[0] ) ) {
				$url = $matches[0];

				//var_dump( $demo_url_reg_ex );

				//  check it match demo URL
				if ( preg_match( $demo_url_reg_ex, $url, $matches ) ) {

					if ( isset( $matches[0] ) ) {

						$wolf_root_url = $matches[0];
						$site_url = home_url( '/' ); // current site url
						$url_array = explode( '/', $url );
						if ( isset( $url_array[3] ) ) {

							$demo_slug = $url_array[3];
							$wolf_url = $wolf_root_url . '/' . $demo_slug . '/';
							$output .= str_replace( $wolf_url, $site_url, $url );
							//var_dump( $output );
						}
					}
				}
			}

			return $output;

		}, $content );

		// Update content
		update_post_meta( $page_id, '_wpb_shortcode_content', $content );
	}
}
add_action( 'pt-ocdi/after_import', 'inkpro_replace_wpb_content_urls_after_import' );

/**
 * Replace hard coded URLs from demo data to local URL
 */
function inkpro_replace_menu_item_custom_urls_after_import() {

	// update hard coded links in menu items
	$main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );
	$demo_url_reg_ex = '/(http|https)?:\/\/([a-z0-9.]+)\.' . WOLF_DOMAIN . '/';

	if ( $main_menu ) {

		$nav_items = wp_get_nav_menu_items( $main_menu->term_id );

		foreach ( $nav_items as $nav_item ) {

			if ( 'custom' == $nav_item->type ) {

				$nav_item_url = $nav_item->url;
				//$nav_item_url = 'https://demo.wolfthemes.com/czte/some-page/';

				// if hard coded URL
				if ( preg_match( $demo_url_reg_ex, $nav_item_url, $matches ) ) {

					if ( isset( $matches[0] ) ) {
						$wolf_root_url = $matches[0];

						$site_url = home_url( '/' ); // current site url
						$url_array = explode( '/', $nav_item_url );

						if ( isset( $url_array[3] ) ) {
							$demo_slug = $url_array[3];

							$wolf_url = $wolf_root_url . '/' . $demo_slug . '/';
							$new_nav_item_url = str_replace( $wolf_url, $site_url, $nav_item_url );
							$menu_item_db_id = $nav_item->ID;
							update_post_meta( $menu_item_db_id, '_menu_item_url', esc_url_raw( $new_nav_item_url ) );
						}
					}
				}
			}
		}
	}
}
add_action( 'pt-ocdi/after_import', 'inkpro_replace_menu_item_custom_urls_after_import' );