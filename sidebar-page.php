<?php
/**
 * The Sidebar containing the page widget areas.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */
if ( is_active_sidebar( 'sidebar-page' ) ) : ?>
	<div id="secondary" class="sidebar-container sidebar-page" role="complementary" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php get_template_part( 'partials/sidebar', 'content' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #secondary .sidebar-container -->
<?php endif; ?>