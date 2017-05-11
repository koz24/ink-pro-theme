<?php
/**
 * InkPro body classes
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

if ( ! function_exists( 'inkpro_body_classes' ) ) {
	/**
	 * Add specific class to the body depending on theme options and page template
	 *
	 * @version 2.0.3
	 * @param array $classes
	 * @return array $classes
	 */
	function inkpro_body_classes( $classes ) {

		if ( inkpro_is_customizer() ) {
			$classes[] = 'is-customizer';
		}

		$classes[] = 'loading'; // will be removed with JS
		$classes[] = 'wolf';
		$classes[] = wolf_get_theme_slug();

		$classes[] = 'site-layout-' . wolf_get_theme_mod( 'site_layout', 'wide' ); // layout

		if ( ! inkpro_is_wpb() && ! inkpro_is_vc() ) {
			/*
			 * Output skin class on non page builder pages only 
			 */
			$classes[] = 'skin-' . inkpro_get_color_scheme_option();
		}

		$classes[] = 'global-skin-' . inkpro_get_color_scheme_option();	
		
		$classes[] = 'text-link-style-' . wolf_get_theme_mod( 'text_link_style', 'default' ); // text link

		$classes[] = 'lightbox-' . apply_filters( 'inkpro_lightbox', wolf_get_theme_mod( 'lightbox', 'swipebox' ) ); // lightbox

		if ( wolf_get_theme_mod( 'no_loading_overlay' ) ) {
			$classes[] = 'no-loading-overlay';
		}

		if ( get_header_image() ) {
			$classes[] = 'has-default-header';
		}

		/**
		 * Ajax navigation
		 */
		if ( inkpro_do_ajax_nav() ) {
			$classes[] = 'is-ajax-nav';
		}

		if ( wolf_get_theme_mod( 'no_ajax_progress_bar' ) ) {
			$classes[] = 'hide-ajax-progress-bar';
		}

		$classes[] = 'blog-navigation-' . wolf_get_theme_mod( 'blog_post_navigation_type' ); // blog nav

		/* Blog pages */
		if ( inkpro_is_blog() ) {

			$classes[] = 'is-blog';
			$classes[] = 'blog-layout-' . inkpro_get_blog_layout(); // blog layout
			$classes[] = 'blog-display-' . inkpro_get_blog_display(); // blog display
			$classes[] = 'blog-grid-padding-' . inkpro_get_blog_padding(); // blog grid padding

			if ( wolf_get_theme_mod( 'blog_hide_date' ) ) {
				$classes[] = 'blog-hide-date';
			}

			if ( wolf_get_theme_mod( 'blog_hide_author' ) ) {
				$classes[] = 'blog-hide-author';
			}

			if ( wolf_get_theme_mod( 'blog_hide_category' ) ) {
				$classes[] = 'blog-hide-category';
			}

			if ( wolf_get_theme_mod( 'blog_hide_tags' ) ) {
				$classes[] = 'blog-hide-tags';
			}

			if ( wolf_get_theme_mod( 'blog_hide_comments_count' ) ) {
				$classes[] = 'blog-hide-comments-count';
			}

			if ( wolf_get_theme_mod( 'blog_hide_share' ) ) {
				$classes[] = 'blog-hide-share';
			}
		}

		if ( wolf_get_theme_mod( 'blog_hide_views' ) ) {
			$classes[] = 'blog-hide-views';
		}

		if ( wolf_get_theme_mod( 'blog_hide_likes' ) ) {
			$classes[] = 'blog-hide-likes';
		}

		if ( inkpro_do_infinitescroll() ) {
			$classes[] = 'is-infinitescroll';
		}

		if ( inkpro_do_infinitescroll_trigger() ) {
			$classes[] = 'is-infinitescroll-trigger';
		}

		if ( inkpro_do_masonry() ) {
			$classes[] = 'is-masonry';
		}

		if ( inkpro_do_ajax_category_filter() ) {
			$classes[] = 'is-ajax-category-filter';
		}
		
		// WooCommerce
		if ( inkpro_is_woocommerce() ) {
			
			if ( is_singular( 'product' ) ) {
				$classes[] = 'shop-layout-' . wolf_get_theme_mod( 'shop_single_layout', 'fullwidth' );
			} else {
				$classes[] = 'shop-layout-' . wolf_get_theme_mod( 'shop_layout', 'sidebar-right' );
			}
			
			$classes[] = 'shop-columns-' . wolf_get_theme_mod( 'shop_columns', 4 );

			// display shop padding class on every page in case the shortcode it used
			//$classes[] = 'shop-padding-' . wolf_get_theme_mod( 'shop_padding', 'yes' );
		}

		// output this class on all pages in case shortcodes are used
		$classes[] = 'shop-display-' . apply_filters( 'inkpro_shop_display', wolf_get_theme_mod( 'shop_display', 'grid' ) );

		/* Is WPB installed? */
		if ( inkpro_has_wpb() ) {
			$classes[] = 'has-wpb';
		}

		/* Is VC used? */
		if ( inkpro_is_vc() ) {
			$classes[] = 'is-vc';
		}

		/* No logo */
		if ( ! wolf_get_theme_mod( 'logo_light' ) && ! wolf_get_theme_mod( 'logo_dark' ) ) {
			$classes[] = 'no-logo';
		}

		/* Menu */
		if ( ! inkpro_is_main_menu() ) {
			$classes[] = 'no-menu';
		}

		$classes[] = 'menu-search-' . wolf_get_theme_mod( 'search_menu_item', 'overlay' );

		/* Header has content */
		if ( inkpro_has_hero() ) {
			
			$classes[] = 'has-hero';
		} else {
			
			$classes[] = 'no-hero';
		}

		/* Full screen home header */
		if ( wolf_get_theme_option( 'full_screen_header' ) ) {
			$classes[] = 'full-window-header';
		}

		/* Multi author */
		if ( is_multi_author() ) {
			$classes[] = 'is-multi-author';
		}

		/* Menu */
		if ( wolf_get_theme_mod( 'sticky_menu' ) ) {
			$classes[] = 'sticky-menu';
		}

		/* Menu layout */
		if ( inkpro_display_topbar() ) {
			$classes[] = 'is-top-bar';
		}

		$menu_layout = inkpro_get_menu_layout();
		$classes[] = 'menu-layout-' . $menu_layout;

		/* Menu width */
		$classes[] = 'menu-width-' . wolf_get_theme_mod( 'menu_width', 'boxed' );

		/* Menu centered aligment */
		$classes[] = 'menu-centered-alignment-' . wolf_get_theme_mod( 'menu_centered_alignment', 'boxed' );

		/* Sub menu width */
		$classes[] = 'submenu-width-' . wolf_get_theme_mod( 'submenu_width', 'boxed' );

		/* Menu type (transparent/solid etc..) */
		$classes[] = 'menu-type-' . inkpro_get_menu_type();

		/* Menu hover style */
		$classes[] = 'menu-hover-style-' . wolf_get_theme_mod( 'menu_hover_style', 'none' );

		/* Button style */
		$classes[] = 'button-style-' . wolf_get_theme_mod( 'button_style', 'default' );

		/* Bottom bar layout */
		$classes[] = 'bottom-bar-layout-' . wolf_get_theme_mod( 'bottom_bar_layout', 'default' );

		if ( has_nav_menu( 'tertiary' ) ) {
			$classes[] = 'has-bottom-menu';
		} else {
			$classes[] = 'no-bottom-menu';
		}

		/* Post title area */

		$header_type = inkpro_get_header_type();
		$classes[] = 'post-header-type-' . $header_type;

		if ( get_post_meta( inkpro_get_header_post_id(), '_post_hide_title_text', true ) ) {
			$classes[] = 'post-hide-title-text';
		} else {
			$classes[] = 'post-is-title-text';
		}

		/* Post title area */
		if ( 'none' == inkpro_get_header_type() ) {
			$classes[] = 'post-hide-title-area';
		} else {
			$classes[] = 'post-is-title-area';
		}

		/* Hide footer if post option is set */
		if ( get_post_meta( inkpro_get_header_post_id(), '_post_hide_footer', true ) ) {
			$classes[] = 'post-hide-footer';
		}

		/* Hide featured image if post options is set */
		if ( get_post_meta( inkpro_get_header_post_id(), '_post_hide_featured_image', true ) ) {
			$classes[] = 'post-hide-featured-image';
		}

		/* Page template clean classes */
		if ( is_page_template( 'page-templates/full-width.php' ) ) {
			$classes[] = 'page-full-width';
		}

		if ( is_page_template( 'page-templates/page-sidebar-right.php' ) ) {
			$classes[] = 'page-sidebar-right';
		}
			
		if ( is_page_template( 'page-templates/page-sidebar-left.php' ) ) {
			$classes[] = 'page-sidebar-left';
		}

		if ( is_page_template( 'page-templates/post-archives.php' ) ) {
			$classes[] = 'page-post-archives';
		}

		/* Footer widget layout */
		$classes[] = 'footer-layout-' . wolf_get_theme_mod( 'footer_layout', 'boxed' );
		$classes[] = 'footer-widgets-layout-' . wolf_get_theme_mod( 'footer_widgets_layout', '4-cols' );

		/* Scroll to top link typ */
		$classes[] = 'scroll-to-top-' . wolf_get_theme_mod( 'scroll_to_top_link_type', 'arrow' );
		$classes[] = 'scroll-to-top-arrow-style-' . wolf_get_theme_mod( 'scroll_to_top_arrow_style', 'round' );

		/* Menu bottom */
		if ( wolf_get_theme_mod( 'menu_bottom_border', '' ) ) {
			$classes[] = 'menu-bottom-border';
		}

		/* Single post */
		if ( is_single() && 'post' == get_post_type() ) {
			$classes[] = 'single-post-layout-' . inkpro_get_single_post_layout();
		}

		/* Plugins */
		if ( inkpro_is_albums() ) {
			$classes[] = 'albums-layout-' . wolf_get_theme_mod( 'albums_layout', 'standard' );
			$classes[] = 'albums-columns-' . wolf_get_theme_mod( 'albums_columns', 4 );
			$classes[] = 'albums-padding-' . wolf_get_theme_mod( 'albums_padding', 'yes' );
			$classes[] = 'albums-display-' . inkpro_get_albums_display();
		}

		/* Single gallery */
		if ( is_singular( 'gallery' ) ) {
			$classes[] = 'single-gallery-layout-' . inkpro_get_single_gallery_layout();
		}

		if ( inkpro_is_discography() ) {
			$classes[] = 'is-discography';
			$classes[] = 'discography-layout-' . wolf_get_theme_mod( 'discography_layout', 'standard' );
			$classes[] = 'discography-display-' . wolf_get_theme_mod( 'discography_display', 'list' );
			$classes[] = 'discography-columns-' . wolf_get_theme_mod( 'discography_columns', 4 );
			$classes[] = 'discography-padding-' . wolf_get_theme_mod( 'discography_padding', 'yes' );
		}

		if ( inkpro_is_videos() ) {
			$classes[] = 'videos-layout-' . wolf_get_theme_mod( 'videos_layout', 'standard' );
			$classes[] = 'videos-padding-' . wolf_get_theme_mod( 'videos_padding', 'yes' );
			$classes[] = 'videos-columns-' . wolf_get_theme_mod( 'videos_columns', 3 );
			//$classes[] = 'videos-hover-' . wolf_get_theme_mod( 'videos_hover_effect', 'effect-1' );

			if ( wolf_get_theme_mod( 'videos_lightbox' ) ) {
				$classes[] = 'do-video-lightbox';
			}
		}

		/* is 404 header image? */
		if ( is_404() ) {
			if ( wolf_get_theme_option( '404_bg' ) ) {
				$classes[] = 'has-404-bg';
			} else {
				$classes[] = 'no-404-bg';
			}
		}

		return $classes;
	}
	add_filter( 'body_class', 'inkpro_body_classes' );
}