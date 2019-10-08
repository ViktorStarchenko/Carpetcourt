<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Carpet_Court
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

<div id="comments" class="comments-area">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'carpet-court' ); ?></h2>

		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>

		<div class="col-left col">
			<h2 class="comments-title">
				<?php global $post;
				if ( $post->post_type == 'wpsl_stores' ) {
					echo "What others say";
				} else {

					printf( // WPCS: XSS OK.
						esc_html( _nx( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'comments title', 'carpet-court' ) ),
						number_format_i18n( get_comments_number() ),
						'<span>' . get_the_title() . '</span>'
					);
				}
				?>
			</h2>

			<ol class="comment-list">
				<?php

				global $post;
				if ( $post->post_type == 'wpsl_stores') {

					$comment_args['style'] = 'div';
					$comment_args['short_ping'] = true;
					$comment_args['reverse_top_level'] = true;
					$comment_args['callback'] = 'mytheme_comment';
				} else {
					$comment_args['style'] = 'ol';
					$comment_args['short_ping'] = true;
					$comment_args['reverse_top_level'] = true;
				}
					wp_list_comments( $comment_args );

				?>
			</ol><!-- .comment-list -->

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'carpet-court' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php paginate_comments_links(); ?></div>
				<div class="nav-next"></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().
	?>
		</div>

<?php


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'carpet-court' ); ?></p>
		<?php
		endif;

			comment_form(array('title_reply' => 'Have your say', 'comment_notes_before'=>''));
		?>

</div><!-- #comments -->