<?php
/**
 * The "artist" taxonomy template file.
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
						'event_index'    => true,
						'el_id'          => 'events-index',
						'post_type'      => 'event',
						'grid_padding'   => kayo_get_theme_mod( 'event_grid_padding', 'yes' ),
						'item_animation' => kayo_get_theme_mod( 'event_item_animation' ),
					)
				);
				?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar( 'events' );
get_footer();
