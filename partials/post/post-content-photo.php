<?php
/**
 * The post content displayed in the loop for the "photo" display 
 *
 * @package WordPress
 * @subpackage InkPro
 */
$format = get_post_format() ? get_post_format() : 'standard';
$thumb_size = 'inkpro-thumb';
$link = inkpro_get_first_url();
$permalink = ( 'link' == $format && $link ) ? $link : get_permalink();
?>
<?php if ( has_post_thumbnail() ) : ?>
	<article <?php inkpro_post_attr(); ?> <?php post_class( array( 'entry-display-photo' ) ); ?> <?php inkpro_article_schema(); ?>>
		<?php wolf_post_start(); ?>
		<div class="post-photo-container">
			<?php
				if ( is_sticky() && ! is_paged() ) {
					echo '<span class="sticky-post">' . esc_html__( 'Featured', 'inkpro' ) . '</span>';
				}
			?>
			<a href="<?php echo esc_url( $permalink ); ?>" class="entry-thumbnail entry-link post-photo-container-entry-link">
				<?php the_post_thumbnail( $thumb_size, array( 'itemprop' => 'image' ) ); ?>
				<div class="post-photo-title-container">
					<div class="post-photo-title-inner table">
						<div class="post-photo-content table-cell">
							<h2 class="entry-title"><?php the_title(); ?></h2>
							<span class="post-photo-entry-meta">
								<?php 
									/* Avatar */
									echo '<span class="author-meta" itemscope="itemscope" itemtype="http://schema.org/Person" itemprop="author">';
									echo get_avatar( get_the_author_meta( 'user_email' ), 20 );
									printf(
										esc_html__( 'by', 'inkpro' ) . ' <span class="author vcard">%s</span>',
										get_the_author()
									);
									echo '</span>';

									/* Date */
									echo '<time class="date" itemprop="datePublished" datetime="' . esc_attr( get_the_date( 'c' ) ) . '">';
									printf( esc_html__( ' &mdash; %s ago', 'inkpro' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) );
									echo '</time>';
								?>
							</span><!-- .post-photo-entry-meta -->
						</div><!-- .post-photo-content -->
					</div><!-- .post-photo-title-inner -->
				</div><!-- .post-photo-title-container -->
			</a><!-- .post-photo-container-entry-link -->
		</div><!-- .post-photo-container -->
	</article><!-- article.post -->
<?php endif; ?>
