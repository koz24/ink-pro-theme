<?php
/**
 * Split post content
 */
?>
<article <?php inkpro_article_schema(); ?> id="post-<?php the_ID(); ?>" <?php post_class( array( 'split clearfix' ) ); ?> data-post-id="<?php the_ID(); ?>">
	<?php wolf_post_start(); ?>

	<div class="panel-left">
		<?php if ( inkpro_post_media() ) : ?>
			<?php echo inkpro_post_media(); ?>
		<?php endif; ?>
	</div><!-- .panel-left -->

	<div class="panel-right">
		<?php if ( inkpro_no_media_content() ) : ?>
			<div class="entry-content clearfix">
				<?php if ( inkpro_no_media_content() ) : ?>
					
					<?php echo inkpro_no_media_content(); ?>
				
					<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'inkpro' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

					<?php
						/**
						 * inkpro_after_post_content hook
						 */
						do_action( 'inkpro_after_post_content' );
					?>

				<?php endif; ?>
				<div class="entry-meta clearfix">
					<?php inkpro_entry_meta(); ?>

					<?php if ( comments_open() ) : ?>
					<span class="comments-link">
						<?php
							/**
							 * Comments
							 */
							comments_popup_link(
								'<span class="leave-reply">' . esc_html__( 'Leave a comment', 'inkpro' ) . '</span>',
								esc_html__( 'One comment so far', 'inkpro' ),
								esc_html__( 'View all % comments', 'inkpro' ),
								'scroll'
							);
						?>
					</span><!-- .comments-link -->
					<?php endif; // comments_open() ?>
					<?php
						/**
						 * Icons
						 */
						inkpro_entry_icon_meta( true, true, false );
					?>
					<?php edit_post_link( esc_html__( 'Edit', 'inkpro' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- div.entry-meta -->
			</div><!-- .entry-content -->
			<?php wolf_post_end(); ?>
			<?php comments_template(); ?>
		<?php endif; ?>
	</div><!-- .panel-right -->
</article><!-- article.post -->