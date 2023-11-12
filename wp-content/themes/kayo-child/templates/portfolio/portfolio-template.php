<?php
/**
 * The portoflio template file.
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
					'el_id' => 'portfolio-index',
					'post_type' => 'work',
					'pagination' => kayo_get_theme_mod( 'work_pagination', '' ),
					'works_per_page' => kayo_get_theme_mod( 'works_per_page', '' ),
					'grid_padding' => kayo_get_theme_mod( 'work_grid_padding', 'yes' ),
					'item_animation' => kayo_get_theme_mod( 'work_item_animation' ),
					'work_layout' => 'standard',
				) );
			?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar( 'portfolio' );
get_footer();
?>