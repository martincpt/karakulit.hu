<?php
/**
 * Template part for displaying related posts
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
		 * Output related post content
		 *
		 * @since 1.0.0
		 */
		do_action( 'kayo_related_post_content' );
	?>
</article><!-- #post-## -->
