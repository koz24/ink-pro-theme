<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage InkPro
 * @since InkPro 1.0.0
 */
get_header();
wolf_page_before();
?>
	<div id="primary" class="content-area entry-content full-height">
		<div id="content" class="site-content table" role="main">
			<article id="post-0" class="post error404 not-found text-center table-cell">
				<?php inkpro_404_logo(); ?>
				<h1 id="error-404-bigtext">
					<span><?php esc_html_e( 'Error 404', 'inkpro' ); ?></span>
					<span><?php esc_html_e( 'Page not found !', 'inkpro' ); ?></span>
				</h1>
				<h5><?php esc_html_e( 'You\'ve tried to reach a page that doesn\'t exist.', 'inkpro' ); ?></h5>
				<p><a class="wolf-button" href="<?php echo esc_url( home_url( '/' ) ); ?>">&larr; <?php esc_html_e( 'back home', 'inkpro' ); ?></a></p>
			</article>
		</div><!-- #content .site-content-->
	</div><!-- #primary .content-area -->
<?php
wolf_page_after();
get_footer();
?>