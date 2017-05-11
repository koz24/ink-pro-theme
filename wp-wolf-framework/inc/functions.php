<?php
/**
 * WolfFramework functions used in admin and frontend
 *
 * @package WordPress
 * @subpackage WolfFramework
 * @author WolfThemes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Get the theme slug
 *
 * @return string
 */
function wolf_get_theme_slug() {

	return apply_filters( 'wolf_theme_slug', sanitize_title_with_dashes( get_template() ) );
}

/**
 * Add metatags with Theme and Framework Versions
 * Useful for support
 *
 */
function wolf_add_version_meta() {

	echo '<meta name="generator" content="' . WOLF_THEME_NAME . ' ' . WOLF_THEME_VERSION .'" />' . "\n";
	echo '<meta name="generator" content="Wolf Framework ' . WOLF_FRAMEWORK_VERSION . '" />' . "\n";

}
add_action( 'wolf_meta_head', 'wolf_add_version_meta' );

/**
 * Get any thumbnail URL
 * @param string $format
 * @param int $post_id
 * @return string
 */
function wolf_get_post_thumbnail_url( $format = 'medium', $post_id = null ) {
	global $post;

	if ( is_object( $post ) && isset( $post->ID ) && null == $post_id ) {

		$ID = $post->ID;
	} else {
		$ID = $post_id;
	}

	if ( $ID && has_post_thumbnail( $ID ) ) {

		$attachment_id = get_post_thumbnail_id( $ID );
		if ( $attachment_id ) {
			$img_src = wp_get_attachment_image_src( $attachment_id, $format );

			if ( $img_src && isset( $img_src[0] ) ) {
				return esc_url( $img_src[0] );
			}
		}
	}
}

/**
 * Check if a file exists in a child theme
 * else returns the URL of the parent theme file
 * Mainly uses for images
 *
 * @param string $file
 * @return string
 */
function wolf_get_theme_uri( $file = null ) {

	$file = untrailingslashit( $file );

	if ( is_file( get_stylesheet_directory() . '/' . $file ) ) {

		return esc_url( get_stylesheet_directory_uri() . '/' . $file );
	
	} elseif ( is_file( get_template_directory() . '/' . $file ) ) {

		return esc_url( get_template_directory_uri() . '/' . $file );
	}
}

/**
 * Check if a file exists in a child theme
 * else returns the path of the parent theme file
 * Mainly uses for config files
 *
 * @param string $file
 * @return string
 */
function wolf_get_theme_dir( $file = null ) {

	$file = untrailingslashit( $file );

	if ( is_file( get_stylesheet_directory() . '/' . $file ) ) {

		return get_stylesheet_directory() . '/' . $file;
	
	} elseif ( is_file( get_template_directory() . '/' . $file ) ) {

		return get_template_directory() . '/' . $file;
	}
}

if ( ! function_exists( 'wolf_get_theme_option' ) ) {
	/**
	 * Get theme option from "wolf_theme_options_{theme_name}" array
	 *
	 * @param string $o
	 * @param string $default
	 * @return string
	 */
	function wolf_get_theme_option( $o, $default = '' ) {

		global $options;

		$wolf_theme_options = get_option( 'wolf_theme_options_' . wolf_get_theme_slug() );

		if ( isset( $wolf_theme_options[ $o ] ) ) {

			$option = $wolf_theme_options[ $o ];

			if ( function_exists( 'icl_t' ) ) {

				$option = icl_t( wolf_get_theme_slug(), $o, $option ); // WPML
			}

			return $option;

		} elseif ( $default ) {

			return $default;
		}
	}
}

if ( ! function_exists( 'wolf_get_theme_mod' ) ) {
	/**
	 * Get theme mod
	 *
	 * @param string $o
	 * @param string $default
	 * @return string
	 */
	function wolf_get_theme_mod( $o, $default = '' ) {

		// Be sure to set the default value if set and if the setting is empty
		if ( $default && '' == get_theme_mod( $o, $default ) ) {
			return $default;
		} else {
			return get_theme_mod( $o, $default );
		}
	}
}

/**
 * Get category meta data if any
 *
 * @param string $o
 */
function wolf_get_category_meta( $o ) {

	if ( is_category() ) {

		$cat_id = get_query_var( 'cat' );
		$cat_meta = get_option( "_wolf_post_category_meta_$cat_id" );
		if ( $cat_meta ) {
			if ( isset( $cat_meta[$o] ) && isset( $cat_meta[$o] ) ) {
				return $cat_meta[$o];
			}
		}
	}
}

/**
 * Inject/update an option in the theme options array
 *
 * @param string $key
 * @param string $value
 */
function wolf_update_theme_option( $key, $value ) {

	$wolf_theme_options = ( get_option( 'wolf_theme_options_' . wolf_get_theme_slug() ) ) ? get_option( 'wolf_theme_options_' . wolf_get_theme_slug() ) : array();
	$wolf_theme_options[ $key ] = $value;
	update_option( 'wolf_theme_options_' . wolf_get_theme_slug(), $wolf_theme_options );
}

/**
 * Get the URL of an attachment from its id
 *
 * @param int $id
 * @return string $url
 */
function wolf_get_url_from_attachment_id( $id, $size = 'thumbnail' ) {

	if ( is_numeric( $id ) ) {
		$src = wp_get_attachment_image_src( absint( $id ), $size );
		if ( isset( $src[0] ) ) {
			return esc_url( $src[0] );
		}
	} else {
		return esc_url( $id );
	}
}

/**
 * Return an ID of an attachment by searching the database with the file URL.
 *
 * First checks to see if the $url is pointing to a file that exists in
 * the wp-content directory. If so, then we search the database for a
 * partial match consisting of the remaining path AFTER the wp-content
 * directory. Finally, if a match is found the attachment ID will be
 * returned.
 *
 * @param string $url The URL of the full size image (ex: http://mysite.com/wp-content/uploads/2013/05/test-image.jpg)
 * @return int|null $attachment Returns an attachment ID, or null if no attachment is found
 */
function wolf_get_id_from_attachment_url( $url ) {

	// Split the $url into two parts with the wp-content directory as the separator
	$parsed_url  = explode( parse_url( WP_CONTENT_URL, PHP_URL_PATH ), $url );

	// Get the host of the current site and the host of the $url, ignoring www
	$this_host = str_ireplace( 'www.', '', parse_url( esc_url( home_url( '/' ) ), PHP_URL_HOST ) );
	$file_host = str_ireplace( 'www.', '', parse_url( $url, PHP_URL_HOST ) );

	// Return nothing if there aren't any $url parts or if the current host and $url host do not match
	if ( ! isset( $parsed_url[1] ) || empty( $parsed_url[1] ) || ( $this_host != $file_host ) ) {
		return;
	}

	// Now we're going to quickly search the DB for any attachment GUID with a partial path match
	// Example: /uploads/2013/05/test-image.jpg
	global $wpdb;

	$attachment = $wpdb->get_col( $wpdb->prepare( "SELECT ID FROM {$wpdb->prefix}posts WHERE guid RLIKE %s;", $parsed_url[1] ) );

	// Returns null if no attachment is found
	return $attachment[0];
}

/**
 * Add wolf theme options to admin toolbar
 *
 */
function wolf_add_theme_options_menu_item_to_admin_bar() {
	global $wp_admin_bar;
	$wp_admin_bar->add_menu(
		array(
			'parent' => 'site-name',
			'id' => 'wolf_options',
			'title' => esc_html__( 'Theme options', 'inkpro' ),
			'href' => esc_url( admin_url( 'admin.php?page=wolf-theme-options' ) ),
			'meta' => array( 'class' => 'wolf-admin-bar-theme-options' ),
		)
	);
}
add_action( 'wp_before_admin_bar_render', 'wolf_add_theme_options_menu_item_to_admin_bar' );

/**
 * Admin bar css fix
 */
function wolf_adminbar_css_fix() {
	if ( is_user_logged_in() ) {
		?>
		<style type="text/css">
			#wp-admin-bar-site-name-default{
				padding-bottom: 0!important;
				margin-bottom: 0!important;
			}
			#wp-admin-bar-appearance{
				padding-top: 0!important;
				margin-top: 0!important;
			}
		</style>
		<?php
	}
}
add_action( 'wolf_head', 'wolf_adminbar_css_fix' );

/**
 * Create a formatted sample of any text
 *
 * Remove HTML and shortcode, sanitize and shorten a string
 *
 * @param string $text
 * @param int $num_words
 * @param string $more
 * @return string
 */
function wolf_sample( $text, $num_words = 55, $more = '...' ) {
	return wp_trim_words( strip_shortcodes( $text ), $num_words, $more );
}

/**
 * Display WP pagination
 *
 * @param object $loop
 * @return string
 */
function wolf_pagination( $loop = null ) {

	if ( ! $loop ) {
		global $wp_query;
		$max = $wp_query->max_num_pages;
	} else {
		$max = $loop->max_num_pages;
	}

	$big  = 999999999; // need an unlikely integer
	$args = array(
		'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
		'format' => '?paged=%#%',
		'prev_text' => '&larr;',
		'next_text' => '&rarr;',
		'type' => 'list',
		'current' => max( 1, get_query_var( 'paged' ) ),
		'total' => $max,
	);

	if ( 1 < $max ) {
		echo '<div class="pagination">';
		echo paginate_links( $args ) . '<div style="clear:both"></div>';
		echo '</div>';
	}
}

/**
 * Remove spaces in inline CSS
 *
 * @param string $css
 * @return string
 */
function wolf_compact_css( $css, $hard = true ) {
	return preg_replace( '/\s+/', ' ', $css );
}

/**
 * sanitize_html_class works just fine for a single class
 * Some times le wild <span class="blue hedgehog"> appears, which is when you need this function,
 * to validate both blue and hedgehog,
 * Because sanitize_html_class doesn't allow spaces.
 *
 * @uses   sanitize_html_class
 * @param  (mixed: string/array) $class   "blue hedgehog goes shopping" or array("blue", "hedgehog", "goes", "shopping")
 * @param  (mixed) $fallback Anything you want returned in case of a failure
 * @return (mixed: string / $fallback )
 */
function wolf_sanitize_html_classes( $class, $fallback = null ) {

	// Explode it, if it's a string
	if ( is_string( $class ) ) {
		$class = explode(" ", $class);
	}

	if ( is_array( $class ) && count( $class ) > 0 ) {
		$class = array_map( 'sanitize_html_class', $class );
		return implode( " ", $class );
	}
	else {
		return sanitize_html_class( $class, $fallback );
	}
}

/**
 * Convert hex color to rgb
 *
 * @param string $hex
 * @return string
 */
function wolf_hex_to_rgb( $hex ) {
	$hex = str_replace( '#', '', $hex );

	if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex,0,1 ) );
		$g = hexdec( substr( $hex, 1, 1 ) . substr( $hex,1,1 ) );
		$b = hexdec( substr( $hex, 2, 1 ) . substr( $hex,2,1 ) );
	} else {
		$r = hexdec( substr( $hex, 0, 2 ) );
		$g = hexdec( substr( $hex, 2, 2 ) );
		$b = hexdec( substr( $hex, 4, 2 ) );
	}
	$rgb = array( $r, $g, $b );
	return implode( ',', $rgb ); // returns the rgb values separated by commas
	//return $rgb; // returns an array with the rgb values
}

/**
 * Brightness color function simiar to sass lighten and darken
 *
 * @param string $hex
 * @param int $percent
 * @return string
 */
function wolf_color_brightness( $hex, $percent ) {

	$steps = ( ceil( ( $percent * 200 ) / 100 ) ) * 2;

	// Steps should be between -255 and 255. Negative = darker, positive = lighter
	$steps = max( -255, min( 255, $steps ) );

	// Format the hex color string
	$hex = str_replace( '#', '', $hex );
	if ( strlen( $hex ) == 3 ) {
		$hex = str_repeat( substr( $hex,0,1 ), 2 ).str_repeat( substr( $hex,1,1 ), 2 ).str_repeat( substr( $hex, 2, 1 ), 2 );
	}

	// Get decimal values
	$r = hexdec( substr( $hex, 0, 2 ) );
	$g = hexdec( substr( $hex, 2, 2 ) );
	$b = hexdec( substr( $hex, 4, 2 ) );

	// Adjust number of steps and keep it inside 0 to 255
	$r = max( 0, min( 255, $r + $steps ) );
	$g = max( 0, min( 255, $g + $steps ) );
	$b = max( 0, min( 255, $b + $steps ) );

	$r_hex = str_pad( dechex( $r ), 2, '0', STR_PAD_LEFT );
	$g_hex = str_pad( dechex( $g ), 2, '0', STR_PAD_LEFT );
	$b_hex = str_pad( dechex( $b ), 2, '0', STR_PAD_LEFT );

	return '#' . $r_hex . $g_hex . $b_hex;
}

/**
 * Sanitize html style attribute
 *
 * @param string $style
 * @return string
 */
function wolf_sanitize_style_attr( $style ) {
	return esc_attr( trim( wolf_compact_css( $style ) ) );
}

/**
 * Check if a file exists before including it
 *
 * Check if the file exists in the child theme with wolf_locate_file or else check if the file exists in the parent theme
 *
 * @param string $file
 */
function wolf_include( $file ) {
	if ( wolf_locate_file( $file ) ) {
		return include( wolf_locate_file( $file ) );
	}
}

/**
 * Same as wolf_include but includ only in admin
 *
 * @param string $file
 */
function wolf_admin_include( $file ) {
	if ( wolf_locate_file( $file ) && is_admin() ) {
		return include( wolf_locate_file( $file ) );
	}
}

/**
 * Locate a file and return the path for inclusion.
 *
 * Used to check if the file exists, is in a parent or child theme folder
 *
 * @param string $filename
 * @return string
 */
function wolf_locate_file( $filename ) {

	$file = null;

	if ( is_file( get_stylesheet_directory() . '/' . untrailingslashit( $filename ) ) ) {
		
		$file = get_stylesheet_directory() . '/' . untrailingslashit( $filename );
	
	} elseif ( is_file( get_template_directory() . '/' . untrailingslashit( $filename ) ) ) {

		$file = get_template_directory() . '/' . untrailingslashit( $filename );
	}

	// Return what we found
	return apply_filters( 'wolf_locate_file', $file );
}

if ( ! function_exists( 'debug' ) ) {
	/**
	 *  Debug function for developpment
	 *  Display less infos than a var_dump
	 *
	 * @param string $var
	 * @return string
	 */
	function debug( $var ) {
		echo '<br><pre style="border: 1px solid #ccc; padding:5px; width:98%">';
		print_r( $var );
		echo '</pre>';
	}
}