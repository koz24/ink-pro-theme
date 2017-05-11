<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */
get_header();
wolf_page_before(); // before page hook
?>
	<div id="primary" class="content-area">

		<?php get_template_part( 'partials/filter/filter', 'category' ); ?>

		<main id="content" class="clearfix">

		<?php if ( have_posts() ) : ?>

			<?php /* The loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php
					/**
					 * The post content template
					 */
					get_template_part( 'partials/content/content', 'post' );

				?>
			<?php endwhile; ?>

		<?php else : ?>

			<?php get_template_part( 'partials/content/content', 'none' ); ?>

		<?php endif; ?>

		</main><!-- #content -->

		<?php if ( inkpro_do_infinitescroll_trigger() ) : ?>
				<div class="trigger-container">
				<?php
					global $wp_query;
					$max = $wp_query->max_num_pages;
					if ( 1 < $max ) :
					?>
					<span id="trigger" class="trigger" data-max="<?php echo esc_attr( $max ); ?>">
						<?php next_posts_link( '', $max ); ?>
						<span class="trigger-spinner"></span>
					</span><!-- #trigger -->
					<?php endif; ?>
				</div><!-- .trigger-container -->
			<?php endif; ?>
		<?php

			/**
			 * inkpro_blog_pagination hook
			 *
			 * @see inc/frontend/hooks/site-page-hooks.php inkpro_output_blog_pagination function
			 */
			do_action( 'inkpro_blog_pagination' );
		?>

	</div><!-- #primary -->
<?php
get_sidebar();
wolf_page_after(); // after page hook
get_footer();
?>