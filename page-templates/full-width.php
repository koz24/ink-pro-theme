<?php
/*
 * Template Name: Full Width
 */
get_header();
wolf_page_before();
?>
	<div id="primary" class="content-area">
		<main id="content" class="clearfix" role="main">
		
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