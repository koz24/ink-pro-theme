<?php
/**
 * InkPro site page hook functions
 *
 * Inject content through template hooks
 *
 * @package WordPress
 * @subpackage InkPro
 * @version 2.0.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Output scroll arrow
 *
 * @since InkPro 1.0.0
 */
function inkpro_top_anchor() {
	?>
	<div id="top"></div>
	<?php
}
add_action( 'wolf_body_start', 'inkpro_top_anchor' );

/**
 * Scroll down arrow
 *
 * @since InkPro 1.0.0
 */
function inkpro_scroll_top_top_link() {

	if ( 'none' != wolf_get_theme_mod( 'scroll_to_top_link_type' ) ) {
		?>
		<a href="#top" class="scroll" id="back-to-top"><?php esc_html_e( 'Back to the top', 'inkpro' ); ?></a>
		<?php
	}
}
add_action( 'wolf_body_start', 'inkpro_scroll_top_top_link' );

/**
 * Output loader overlay
 *
 * @since InkPro 1.0.0
 */
function inkpro_page_loading_overlay() {

	if ( wolf_get_theme_mod( 'no_loading_overlay' ) ) {
		return;
	}
	?>
	<div id="loading-overlay" class="loading-overlay">
		<?php inkpro_loader(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'wolf_body_start', 'inkpro_page_loading_overlay' );

/**
 * Add mobile closer overlay
 */
function inkpro_add_mobile_closer_overlay() {
	?>
	<div id="mobile-closer-overlay" class="mobile-menu-toggle-button"></div>
	<?php
}
add_action( 'wolf_body_start', 'inkpro_add_mobile_closer_overlay' );

/**
 * Output ajax loader overlay
 */
function inkpro_ajax_loading_overlay() {

	if ( wolf_get_theme_mod( 'no_transition_overlay' ) ) {
		return;
	}
	?>
	<div id="ajax-loading-overlay" class="loading-overlay">
		<?php inkpro_loader(); ?>
	</div><!-- #loading-overlay.loading-overlay -->
	<?php
}
add_action( 'wolf_site_content_start', 'inkpro_ajax_loading_overlay' );

/**
 * Output search form overlay
 */
function inkpro_menu_overlay_search_form() {

	if ( 'overlay' == wolf_get_theme_mod( 'search_menu_item' ) ) {
		get_template_part( 'partials/search/search', 'overlay' );
	}

}
add_action( 'wolf_body_start', 'inkpro_menu_overlay_search_form' );

/**
 * Output search form overlay
 */
function inkpro_menu_product_search_form() {

	if ( 'woocommerce' == wolf_get_theme_mod( 'search_menu_item' ) && function_exists( 'get_product_search_form' ) ) {
		get_template_part( 'partials/search/search', 'woocommerce' );
	}

}
add_action( 'inkpro_wooocommerce_search', 'inkpro_menu_product_search_form' );

/**
 * Output blog pagination
 */
function inkpro_output_blog_pagination() {

	if ( inkpro_do_infinitescroll() ) {
		/**
		 * Theme standard pagination used for infinite scroll
		 */
		inkpro_paging_nav();

	} else {
		/**
		 * Pagination numbers
		 */
		the_posts_pagination( array(
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>',
		) );
	}
}
add_action( 'inkpro_blog_pagination', 'inkpro_output_blog_pagination' );

/**
 * Output bottom bar with menu copyright text and social icons
 */
function inkpro_bottom_bar() {
	$services = sanitize_text_field( wolf_get_theme_mod( 'footer_socials_services' ) );
	$display_menu = has_nav_menu( 'tertiary' );
	$credits = wolf_get_theme_mod( 'copyright' );

	if ( $services || $display_menu || $credits ) :
	?>
	<div class="site-infos clearfix">
		<div class="bottom-social-links">
			<?php

			if ( function_exists( 'wpb_socials' ) && $services ) {
				echo wpb_socials( array( 'services' => $services ) );
			}
			?>
		</div><!-- .bottom-social-links -->
		<?php
			/**
			 * Fires in the InkPro bottom menu
			 *
			 */
			do_action( 'inkpro_bottom_menu' );
		?>
		<?php if ( has_nav_menu( 'tertiary' ) ) : ?>
		<div class="clear"></div>
		<?php endif; ?>
		<div class="credits">
			<?php
				/**
				 * Fires in the InkPro footer text for customization.
				 *
				 * @since InkPro 1.0
				 */
				do_action( 'inkpro_credits' );
			?>
		</div><!-- .credits -->
	</div><!-- .site-infos -->
	<?php
	endif;

}
add_action( 'inkpro_bottom_bar', 'inkpro_bottom_bar' );

/**
 * Copyright/site info text
 *
 * @since InkPro 1.0.0
 */
function inkpro_site_infos() {

	$footer_text = wolf_get_theme_mod( 'copyright' );

	if ( $footer_text ) {
		$footer_text = '<span class="copyright-text">' . $footer_text . '</span>';
		echo apply_filters( 'inkpro_copyright_text', $footer_text );
	}
}
add_action( 'inkpro_credits', 'inkpro_site_infos' );