<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package    WordPress
 * @subpackage Kayo
 * @version    1.5.1
 */

defined( 'ABSPATH' ) || exit;

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
*/
if ( post_password_required() ) {
	return;
}
?>
<section class="comments-container content-section">
	<div id="comments" class="comments-area">
		<?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) :
			?>
			<h2 class="comments-title">
			<?php
			$comments_number = get_comments_number();
			if ( '1' === $comments_number ) {
				/* translators: %s: post title */
				printf( esc_attr( _x( 'One reply to &ldquo;%s&rdquo;', 'comments title', 'kayo' ) ), esc_attr( get_the_title() ) ); // WCS XSS ok.
			} else {
				printf(
					esc_attr(
						/* translators: 1: number of comments, 2: post title */
						_nx(
							'%1$s Reply to &ldquo;%2$s&rdquo;',
							'%1$s Replies to &ldquo;%2$s&rdquo;',
							$comments_number,
							'comments title',
							'kayo'
						)
					),
					esc_attr( number_format_i18n( $comments_number ) ),
					esc_attr( get_the_title() )
				);
			}
			?>
			</h2>

			<div class="comment-list">
			<?php
			wp_list_comments(
				array(
					'walker'     => new Kayo_Walker_Comment(),
					'style'      => 'ul',
					'short_ping' => true,
				)
			);
			?>
			</ol>
			<?php
			/**
			 * Comment Pagination
			 */
			the_comments_pagination();

		endif; // Check for have_comments().
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
			?>

			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'kayo' ); ?></p>
			<?php
		endif;
		comment_form(
			array(
				'title_reply' => esc_html__( 'Leave a Comment', 'kayo' ),
			)
		);
		?>
	</div><!-- #comments -->
</section><!-- .comments-container-->
