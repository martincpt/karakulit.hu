<?php
/**
 * Template part for displaying single video content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<article <?php kayo_post_attr(); ?>>
	<?php
		/**
		 * The post content
		 */
		the_content();

		/**
		 * Video Meta
		 */
		do_action( 'kayo_video_meta' );

		/**
		 * Share icon meta
		 */
		do_action( 'kayo_share' );
	?>
</article><!-- #post-## -->