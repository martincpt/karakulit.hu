<?php
/**
 * Template part for displaying posts with excerpts
 *
 * Used in Search Results and for Recent Posts in Front Page panels.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<article <?php kayo_post_attr(); ?>>
	<a href="<?php the_permalink(); ?>" class="entry-link-mask"></a>
	<div class="entry-container">
		<div class="entry-box">
			<?php if ( has_post_thumbnail() ) : ?>
				<div class="entry-image">
					<?php echo kayo_post_thumbnail( 'kayo-masonry' ); ?>
				</div><!-- .entry-image -->
			<?php endif; ?>
			<div class="entry-summary">
				<div class="entry-summary-inner">
					<?php if ( kayo_get_post_type_name() ) : ?>
						<span class="entry-post-type-name"><?php echo esc_html( kayo_get_post_type_name() ); ?></span>
					<?php endif; ?>
					<h2 class="entry-title">
						<?php the_title(); ?>
					</h2>
					<div class="entry-excerpt">
						<?php
						/**
						 * Post search excerpt hook
						 *
						 * @since 1.0.0
						 */
						do_action( 'kayo_post_search_excerpt' );
						?>
					</div><!-- .entry-excerpt -->
				</div><!-- .entry-summary-inner -->
			</div><!-- .entry-summary -->
		</div><!-- .entry-box -->
	</div><!-- .entry-container -->
</article><!-- #post-## -->
