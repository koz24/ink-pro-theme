<article <?php inkpro_article_schema(); ?> id="post-<?php the_ID(); ?>" <?php post_class(); ?> data-post-id="<?php the_ID(); ?>">
	<?php wolf_post_start(); ?>

	<?php if ( inkpro_post_media() ) : ?>
		<header class="entry-header clearfix">
			<div class="entry-header-inner">
				<?php echo inkpro_post_media(); ?>
			</div><!-- .entry-header-inner -->
		</header><!-- header.entry-header -->
	<?php endif; ?>

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
	</div><!-- .entry-content -->

	<footer class="entry-meta clearfix">
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
	</footer><!-- footer.entry-meta -->
	
	<?php wolf_post_end(); ?>
		
	<?php comments_template(); ?>
	
</article><!-- article.post -->