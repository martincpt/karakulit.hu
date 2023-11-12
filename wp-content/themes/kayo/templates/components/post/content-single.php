<?php
/**
 * Template part for displaying single post content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<article <?php kayo_post_attr( 'content-section' ); ?>>
		<?php
			/**
			 * Post_content_before hook
			 *
			 * @see inc/fontend/hooks.php
			 * @since 1.0.0
			 */
			do_action( 'kayo_post_content_before' );
		?>
		<div class="single-post-content-container">
			<?php
				/**
				 * Post_content_start hook
				 *
				 * @see inc/fontend/hooks.php
				 * @since 1.0.0
				 */
				do_action( 'kayo_post_content_start' );
			?>
				<div class="entry-content clearfix">
					<?php
						/**
						 * The post content
						 */
						the_content();

						wp_link_pages( array(
							'before' => '<div class="clear"></div><div class="page-links clearfix">' . esc_html__( 'Pages:', 'kayo' ),
							'after' => '</div>',
							'link_before' => '<span class="page-number">',
							'link_after' => '</span>',
						) );
					?>
				</div><!-- .entry-content -->
			<?php
				/**
				 * Post_content_end hook
				 *
				 * @see inc/fontend/hooks.php
				 * @since 1.0.0
				 */
				do_action( 'kayo_post_content_end' );
			?>
		</div><!-- .single-post-content-container -->
		<?php
			/**
			 * Post_content_after hook
			 *
			 * @see inc/fontend/hooks.php
			 * @since 1.0.0
			 */
			do_action( 'kayo_post_content_after' );
		?>
</article>
