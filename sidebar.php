<?php
/**
 * The Sidebar containing the main widget areas for blogs
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */
if ( inkpro_should_display_sidebar() ) : // see includes/conditional-functions.php ?>
	<div id="secondary" class="sidebar-container sidebar-main" role="complementary" itemtype="http://schema.org/WPSideBar">
		<div class="sidebar-inner">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-main' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-inner -->
	</div><!-- #secondary .sidebar-container -->
<?php endif; ?>
