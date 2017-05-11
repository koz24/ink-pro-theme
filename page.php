<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */
get_header();
wolf_page_before();
?>
	<div id="primary" class="content-area">
		<main id="content" class="clearfix">

			<p><?php do_action( 'wolf_ads', 'content' ) ?></p>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'partials/content/content', 'page' ); ?>

			<?php endwhile; ?>

		</main><!-- main#content .site-content-->
	</div><!-- #primary .content-area -->
<?php
wolf_page_after();
get_footer();
?>