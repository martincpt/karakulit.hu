<?php
/**
 * The "band" taxonomy template file.
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
				do_action(
					'kayo_posts',
					array(
						'release_index'     => true,
						'el_id'             => 'discography-index',
						'post_type'         => 'release',
						'pagination'        => kayo_get_theme_mod( 'release_pagination', '' ),
						'releases_per_page' => kayo_get_theme_mod( 'releases_per_page', '' ),
						'grid_padding'      => kayo_get_theme_mod( 'release_grid_padding', 'yes' ),
						'item_animation'    => kayo_get_theme_mod( 'release_item_animation' ),
					)
				);
				?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar( 'discography' );
get_footer();
