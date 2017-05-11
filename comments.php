<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage InkPro
 * @since 1.0.0
 * @version 2.0.3
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>
<div id="comments" class="comments-area"><?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
				printf(
					_nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'inkpro' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' 
				);
			?>
		</h2>

		<ol class="comment-list">
			<?php wp_list_comments( array( 'callback' => 'inkpro_comment', 'style' => 'ol' ) ); ?>
		</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="navigation comment-navigation clearfix" role="navigation">
			<div class="previous"><?php previous_comments_link( esc_html__( '&larr; Older Comments', 'inkpro' ) ); ?></div>
			<div class="next"><?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'inkpro' ) ); ?></div>
		</nav><!-- .comment-navigation -->
		<?php endif; // Check for comment navigation ?>

		<?php if ( ! comments_open() && get_comments_number() ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.' , 'inkpro' ); ?></p><!-- .no-comments -->
		<?php endif;

	endif; // have_comments() 

	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ? " aria-required='true'" : '' );
	$fields    = array(
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
		'must_log_in' => '<p class="must-log-in">' .  sprintf( wp_kses( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'inkpro' ), array( 'a' => array( 'title' => array(), 'href' => array() ) ) ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'logged_in_as' => '<p class="logged-in-as">' . sprintf( wp_kses( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'inkpro' ), array( 'a' => array( 'title' => array(), 'href' => array() ) ) ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'title_reply' => esc_html__( 'Leave a Reply', 'inkpro' ),
		'title_reply_to' => esc_html__( 'Leave a Reply to %s', 'inkpro' ),
		'cancel_reply_link' => esc_html__( 'Cancel Reply', 'inkpro' ),
		'label_submit' => esc_html__( 'Submit Comment', 'inkpro' )
	);

	comment_form( $fields );
?></div><!-- #comments -->