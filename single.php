<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */
get_header();
wolf_post_before();
?>
	<div id="primary" class="content-area">
		<main id="content" class="site-content clearfix" role="main">
			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
					/**
					 * Get a different file depending on the layout option
					 */
					get_template_part( 'partials/post/single/single-post-content', inkpro_get_single_post_layout() );
				?>
			<?php endwhile; ?>
		</main><!-- main#content .site-content-->
	</div><!-- #primary .content-area -->
<?php
wolf_post_after();
get_footer(); 
?>