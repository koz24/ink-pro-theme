<?php
/**
 * The post content displayed in the loop for the "masonry" display
 *
 * @package WordPress
 * @subpackage InkPro
 */
$post_id   = get_the_ID();
$format = get_post_format() ? get_post_format() : 'standard';
$standard_post = ( 'standard' == $format );
$content = get_the_content();
$bg = wolf_get_post_thumbnail_url( 'large' );
$classes = array( 'masonry-item', 'entry-display-masonry2' );

$has_tweet = preg_match( inkpro_get_regex( 'twitter' ), $content );
$is_tweet = $has_tweet && ( 'status' == $format );
$is_instagram = ( 'image' == $format ) && preg_match( inkpro_get_regex( 'instagram' ), $content );
if ( get_the_category( $post_id ) ) {
	foreach ( get_the_category( $post_id ) as $cat ) {
		$classes[] = $cat->slug .' ';
	}
}

$thumb_size = 'inkpro-2x2';

if ( 'image' == $format || 'gallery' == $format) {
	$thumb_size = 'inkpro-portrait';
}

?>
<article <?php inkpro_post_attr(); ?> <?php inkpro_article_schema(); ?> <?php post_class( $classes ); ?>  data-bg="<?php echo esc_url( $bg ); ?>">
	<?php wolf_post_start(); ?>
	<section class="entry-frame">
		<?php if ( 'video' == $format ) : ?>
			<?php inkpro_get_video_background_from_first_video_url(); ?>
		<?php endif; ?>
		<?php if ( 'gallery' == $format || 'audio' == $format || $is_instagram || $is_tweet ) : ?>
			<?php echo inkpro_post_media( true, $thumb_size ); ?>
		<?php endif; ?>
		<?php if ( 'image' == $format && ! $is_instagram || 'standard' == $format ) : ?>
			<?php the_post_thumbnail( $thumb_size ); ?>
		<?php endif; ?>
		<a class="entry-mask-link" href="<?php the_permalink(); ?>"></a>
		<div class="entry-frame-inner">
			<div class="entry-frame-overlay"></div>
			<div class="table">
				<div class="table-cell">
					<div class="entry-frame-inner-caption">
					<?php if ( 'video' == $format || 'gallery' == $format || 'image' == $format || 'standard' == $format ) : ?>

						<?php
							if ( 'standard' != $format && inkpro_get_first_category() ) {
								echo '<span class="entry-frame-category category-label">' . sanitize_text_field( inkpro_get_first_category() ) . '</span>';
							}
						?>

						<?php if ( 'standard' != $format) : ?>
							<h2 class="entry-title"><?php the_title(); ?></h2>
						<?php endif; ?>

						<!-- <a class="button" href="<?php the_permalink(); ?>"> -->
						<span class="view-more">
							<?php esc_html_e( 'View post', 'inkpro' ); ?>
						</span>
						<!-- </a> -->
					<?php endif; ?>
					</div>
					<?php if ( 'status' ==  $format ) : ?>
						<div class="entry-avatar text-center">
							<a class="author-link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
								<?php echo get_avatar( get_the_author_meta( 'user_email' ), 80 ); ?>
							</a>
						</div><!-- .entry-avatar -->
					<?php endif; ?>
					<?php if ( 'aside' == $format || 'status' == $format ) : ?>
						<div class="entry-summary">
							<?php echo wolf_sample( get_the_excerpt(), 25 ); ?>
						</div>
					<?php endif; ?>
					<?php if ( 'link' == $format || 'quote' == $format ) : ?>
						<?php echo inkpro_post_media( true, $thumb_size ); ?>
					<?php endif; ?>
				</div>
			</div>
		</div><!-- .post-media-container -->
		<?php if ( 'video' == $format || 'gallery' == $format || 'image' == $format ) : ?>
			<div class="entry-meta entry-icons-meta">
				<?php inkpro_entry_icon_meta(); ?>
			</div>
		<?php endif; ?>
	</section><!-- section.entry-frame -->
	<?php if ( ! post_password_required() && $standard_post ) : ?>
		<section class="entry-masonry2-content">
				<?php inkpro_entry_title(); ?>

			<header class="entry-meta">
				<?php inkpro_entry_meta( true, true, true, false ); // display date, author, and category only ?>
			</header><!-- .entry-meta -->

			<div class="entry-text">
				<?php echo wolf_sample( get_the_excerpt(), 25 ); ?>
			</div><!-- .entry-text -->

			<footer class="entry-meta">
				<?php inkpro_entry_meta( false, false, false, false ); // display author only ?>
				<?php inkpro_entry_icon_meta(); ?>
				<?php edit_post_link( esc_html__( 'Edit', 'inkpro' ), '<span class="edit-link">', '</span>' ); ?>
			</footer><!-- .entry-meta -->
		</section><!-- section.entry-masonry2-content -->
	<?php endif; ?>
</article><!-- article.post -->