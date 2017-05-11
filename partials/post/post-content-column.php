<?php
/**
 * The post content displayed in the loop for the "column" display 
 *
 * @package WordPress
 * @subpackage InkPro
 */
?>
<article <?php inkpro_post_attr(); ?> <?php inkpro_article_schema(); ?> <?php post_class( array( 'entry-display-classic' ) ); ?>>
	<?php wolf_post_start(); ?>
	<div class="entry-inner clearfix">
		<?php
			if ( is_sticky() && ! is_paged() ) {
				echo '<span class="sticky-post">' . esc_html__( 'Featured', 'inkpro' ) . '</span>';
			}
		?>
		<header class="entry-header">
			<a class="lightbox entry-thumbnail" href="<?php echo esc_url( wolf_get_post_thumbnail_url( 'inkpro-XL' ) ); ?>">
				<?php the_post_thumbnail( 'inkpro-thumb', array( 'itemprop' => 'image' ) ); ?>
			</a>
		</header><!-- header.entry-header -->

		<?php if ( ! post_password_required() ) : ?>
			<div class="entry-content clearfix">
				<h2 class="entry-title">
					<a href="<?php the_permalink(); ?>" class="entry-link" rel="bookmark">
						<?php the_title(); ?>
					</a>
				</h2>
				<div class="entry-meta">
					<?php inkpro_entry_meta( true, false, true ); // display date, cat and tags ?>
				</div><!-- .entry-meta -->
				<div class="entry-summary">
					<div class="entry-summary-inner" itemprop="text">
						<p><?php echo wolf_sample( get_the_excerpt(), 18 ); ?></p>
					</div><!-- .entry-summary-inner -->
				</div><!-- .entry-summary -->

				<footer class="entry-meta">
					<?php inkpro_entry_meta( false, true, false, false ); // display author only ?>
					<?php inkpro_entry_icon_meta(); ?>
					<?php edit_post_link( esc_html__( 'Edit', 'inkpro' ), '<span class="edit-link">', '</span>' ); ?>
				</footer><!-- .entry-meta -->
			</div><!-- .entry-content -->
		<?php endif; ?>
	</div><!-- entry-inner -->
</article><!-- article -->