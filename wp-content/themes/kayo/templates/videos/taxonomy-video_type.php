<?php
/**
 * The "video type" taxonomy template file.
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
get_header();
?>
	<div id="primary" class="content-area">
		<main id="content" class="clearfix">
			<?php
				/**
				 * Output post loop through hook so we can do the magic however we want
				 */
				do_action( 'kayo_posts', array(
					'video_index' => true,
					'el_id' => 'videos-index',
					'post_type' => 'video',
					'videos_per_page' => kayo_get_theme_mod( 'videos_per_page', '' ),
					'pagination' => kayo_get_theme_mod( 'video_pagination', '' ),
					'grid_padding' => kayo_get_theme_mod( 'video_grid_padding', 'yes' ),
					'item_animation' => kayo_get_theme_mod( 'video_item_animation' ),
				) );
			?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar( 'videos' );
get_footer();
?>