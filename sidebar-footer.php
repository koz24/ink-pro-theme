<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */
if ( is_active_sidebar( 'sidebar-footer' ) ) : ?>
	<section id="tertiary" class="sidebar-footer">
		<div class="sidebar-footer-inner wrap">
			<div class="widget-area clearfix">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div>
		</div>
	</section><!-- #tertiary .sidebar-footer -->
<?php endif; ?>