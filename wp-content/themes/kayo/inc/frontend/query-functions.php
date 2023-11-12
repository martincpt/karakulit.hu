<?php
/**
 * Kayo blog related functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Filter found_posts to avoid 404 error on last page if post offset is set
 *
 * @link http://wordpress.stackexchange.com/questions/155758/have-different-number-of-posts-on-first-page
 */
function kayo_offset_pagination_fix( $found_posts, $query ) {

	$offset = $query->get( 'offset' );

	if ( $offset ) {
		$found_posts = $found_posts - $offset;
	}

	return $found_posts;
}

/**
 * Get related posts query
 *
 * @return object WP_Query
 */
function kayo_related_post_query( $posts_per_page = 3 ) {

	global $post;

	/**
	 * Filters related posts count
	 * 
	 * @since 1.0.0
	 */
	$posts_per_page = apply_filters( 'kayo_related_posts_count', $posts_per_page );

	$post_id            = $post->ID;
	$post_type          = get_post_type();
	$do_not_duplicate[] = $post->ID;
	$terms              = get_the_category( $post_id );

	$args = array(
		'post_type'           => $post_type,
		'posts_per_page'      => $posts_per_page,
		'meta_key'            => '_thumbnail_id',
		'post__not_in'        => $do_not_duplicate,
		'ignore_sticky_posts' => 1,
	);

	if ( ! empty( $terms ) ) {

		$term = array_shift( $terms );

		$args['cat'] = $term->term_id;
	}

	/**
	 * Filters related posts query arguments
	 * 
	 * @since 1.0.0
	 */
	$query = new WP_Query( apply_filters( 'kayo_related_post_query_args', $args ) );

	if ( $query && 0 < $query->post_count ) {
		return $query;
	}
}

if ( ! function_exists( 'kayo_paging_nav' ) ) {
	/**
	 * Displays navigation to next/previous set of posts when applicable.
	 *
	 * Used for infinite scroll
	 *
	 * @param object $query
	 */
	function kayo_paging_nav( $query = null ) {

		if ( ! $query ) {
			global $wp_query;
			$max = $wp_query->max_num_pages;
		} else {
			$max = $query->max_num_pages;
		}
		if ( $max < 2 ) {
			return;
		}

		?>
		<nav class="navigation paging-navigation hidden">
			<div class="nav-links clearfix">
				<?php if ( get_next_posts_link( '', $max ) ) : ?>
					<div class="nav-previous"><?php next_posts_link( wp_kses_post( __( '<span class="meta-nav">&larr;</span> Older posts', 'kayo' ) ), $max ); ?></div>
				<?php endif; ?>

				<?php if ( get_previous_posts_link( '', $max ) ) : ?>
					<div class="nav-next"><?php previous_posts_link( wp_kses_post( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'kayo' ) ), $max ); ?></div>
				<?php endif; ?>

			</div><!-- .nav-links -->
		</nav><!-- .navigation -->
		<?php
	}
}

/**
 * Overwrite posts per page
 *
 * Not used at the moment
 *
 * @param object $query
 * @return object $query
 */
function kayo_set_posts_per_page( $query ) {

	global $wp_the_query;

	/**
	 * Filters the post per page option in the blog
	 * 
	 * @since 1.0.0
	 */
	$posts_per_page_option = apply_filters( 'kayo_blog_posts_per_page', kayo_get_theme_mod( 'blog_posts_per_page' ) );

	if ( $posts_per_page_option ) {
		$query->set( 'posts_per_page', $posts_per_page_option );
	}

	return $query;
}
add_action( 'pre_get_posts', 'kayo_set_posts_per_page' );
