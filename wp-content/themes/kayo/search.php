<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

get_header(); ?>
	<div id="primary" class="content-area">
		<main id="content" class="clearfix">
			<?php
				/**
				 * Search_content_before hook
				 *
				 * @see inc/fontend/hooks.php
				 * @since Kayo 1.0.0
				 */
				do_action( 'kayo_search_content_before' );
			?>
			<div id="search-index" class="clearfix items masonry-container grid grid-padding-yes">
				<?php
				if ( have_posts() ) :
						/* Start the Loop */
					while ( have_posts() ) :
						the_post();

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( kayo_get_template_dirname() . '/components/post/content', 'search' );

					endwhile; // End of the loop.
					?>
			</div><!-- #search-index -->
					<?php
						the_posts_pagination(
							array(
								'prev_text' => '<i class="pagination-icon-prev"></i>',
								'next_text' => '<i class="pagination-icon-next"></i>',
							)
						);
					?>
					<?php

				else :
					get_template_part( 'templates/components/post/content', 'none' );
				endif;
				?>
		</main><!-- #content -->
	</div><!-- #primary -->
<?php
get_sidebar();
get_footer();
?>
