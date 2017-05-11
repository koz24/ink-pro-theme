<?php
/**
 * The post content displayed in the loop for the "grid" display 
 *
 * @package WordPress
 * @subpackage InkPro
 */
$format = get_post_format() ? get_post_format() : 'standard';
$thumb_size = inkpro_get_image_size_fallback( 'inkpro-2x2', 'inkpro-1x1' );
$cat_list = '';
$classes = array( 'post-grid2-entry', 'entry-display-grid2' );
$post_id = get_the_ID();
if ( get_the_category( $post_id ) ) {
	foreach ( get_the_category( $post_id ) as $cat ) {
		$classes[] = $cat->slug .' ';
	}
}
?>
<?php if ( has_post_thumbnail() ) : ?>
	<article <?php inkpro_post_attr(); ?> <?php inkpro_article_schema(); ?> <?php post_class( $classes ); ?>>
	<?php wolf_post_start(); ?>
		<a href="<?php the_permalink(); ?>" class="entry-thumbnail entry-link">
			<?php
				if ( is_sticky() && ! is_paged() ) {
					echo '<span class="sticky-post">' . esc_html__( 'Featured', 'inkpro' ) . '</span>';
				}
			?>
			<?php the_post_thumbnail( $thumb_size, array( 'itemprop' => 'image' ) ); ?>
		</a>
		<?php if ( ! post_password_required() ) : ?>
			<div class="post-grid2-entry-content entry-content clearfix">
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
	</article><!-- article.post -->
<?php endif; ?>