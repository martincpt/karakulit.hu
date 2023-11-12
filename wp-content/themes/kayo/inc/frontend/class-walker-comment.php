<?php
/**
 * Kayo Walker comment class
 *
 * @package Kayo/Frontend
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Kayo_Walker_Comment' ) ) {

	class Kayo_Walker_Comment extends Walker_Comment { // phpcs:ignore

		public $tree_type = '';
		public $db_fields = array();
		public function __construct() {

			$this->tree_type = 'comment';
			$this->db_fields = array(
				'parent' => 'comment_parent',
				'id'     => 'comment_ID',
			);
			?>

			<section class="comments-list clearfix">

			<?php
		}
		public function start_lvl( &$output, $depth = 0, $args = array() ) {

			$GLOBALS['comment_depth'] = $depth + 2; // phpcs:ignore
			?>

			<section class="child-comments comments-list">

			<?php
		}
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
			$GLOBALS['comment_depth'] = $depth + 2; // phpcs:ignore
			?>

			</section>

			<?php
		}
		public function start_el( &$output, $comment, $depth = 0, $args = array(), $id = 0 ) {
			$depth++;
			$GLOBALS['comment_depth'] = $depth; // phpcs:ignore
			$GLOBALS['comment']       = $comment; // phpcs:ignore
			$parent_class = ( empty( $args['has_children'] ) ? '' : 'parent' );

			if ( 'article' === $args['style'] ) {
				$tag       = 'article';
				$add_below = 'comment';
			} else {

				$tag       = 'article';
				$add_below = 'comment';
			}
			?>
			<article <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>" itemscope itemtype="http://schema.org/Comment">
				<div class="comment-content" itemprop="text">
					<figure class="gravatar">
					<?php
					echo get_avatar(
						$comment,
						/**
						* Filters theme comment avatar size
						*
						* @since 1.0.0
						*/
						apply_filters( 'kayo_comment_avatar_size', 256 )
					);
					?>
					</figure>
					<div class="comment-meta post-meta" role="complementary">
						<div class="comment-author">
							<b class="fn">
								<a rel="external nofollow" class="url comment-author-link" href="<?php comment_author_url(); ?>" itemprop="author"><?php comment_author(); ?></a>
							</b>
						</div>
						<time class="comment-meta-item" datetime="<?php comment_date( 'Y-m-d' ); ?>T<?php comment_time( 'H:iP' ); ?>" itemprop="datePublished"><span><?php comment_date( 'F jS Y' ); ?>, <a href="#comment-<?php comment_ID(); ?>" itemprop="url"><?php comment_time(); ?></a></span></time>
						<?php edit_comment_link( '<p class="comment-meta-item">' . esc_html__( 'Edit this comment', 'kayo' ) . '</p>', '', '' ); ?>
						<?php if ( ! $comment->comment_approved ) : ?>
							<p class="comment-meta-item"><?php esc_html_e( 'Your comment is awaiting moderation.', 'kayo' ); ?></p>
						<?php endif; ?>
						<?php comment_text(); ?>
						<?php
						comment_reply_link(
							array_merge(
								$args,
								array(
									'reply_text' => '<span>' . esc_html__( 'Reply', 'kayo' ) . '</span>',
									'add_below'  => $add_below,
									'depth'      => $depth,
									'max_depth'  => $args['max_depth'],
								)
							)
						);
						?>
					</div>
				</div>
			<?php
		}
		public function end_el( &$output, $comment, $depth = 0, $args = array() ) {
			?>
			</article>
			<?php
		}
		public function __destruct() {
			?>
			</section>
			<?php
		}
	}
} // end class check
