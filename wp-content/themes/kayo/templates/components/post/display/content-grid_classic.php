<?php
/**
 * Template part for displaying posts with the "grid" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

extract(
	wp_parse_args(
		$template_args,
		array(
			'post_excerpt_length'   => 'shorten',
			'post_display_elements' => 'show_thumbnail,show_date,show_text,show_author,show_category',
		)
	)
);

$post_display_elements = kayo_list_to_array( $post_display_elements );
$show_thumbnail        = ( in_array( 'show_thumbnail', $post_display_elements, true ) );
$show_date             = ( in_array( 'show_date', $post_display_elements, true ) );
$show_text             = ( in_array( 'show_text', $post_display_elements, true ) );
$show_author           = ( in_array( 'show_author', $post_display_elements, true ) );
$show_category         = ( in_array( 'show_category', $post_display_elements, true ) );
$show_tags             = ( in_array( 'show_tags', $post_display_elements, true ) );
$show_extra_meta       = ( in_array( 'show_extra_meta', $post_display_elements, true ) );
?>
<article <?php kayo_post_attr(); ?>>
	<a href="<?php the_permalink(); ?>" class="entry-link-mask"></a>
	<div class="entry-box">
		<div class="entry-container">
			<?php if ( $show_thumbnail ) : ?>
				<?php if ( kayo_has_post_thumbnail() ) : ?>
					<div class="entry-image">
						<?php if ( $show_category ) : ?>
							<a class="category-label" href="<?php echo kayo_get_first_category_url(); ?>"><?php echo kayo_get_first_category(); ?></a>
						<?php endif; ?>
						<?php
						if ( is_sticky() && ! is_paged() ) {
							echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'kayo' ) ) . '"></span>';
						}
						?>
						<div class="entry-cover">
							<?php
								echo kayo_background_img( array( 'background_img_size' => 'medium' ) );
							?>
						</div><!-- entry-cover -->
					</div><!-- .entry-image -->
				<?php endif; ?>
			<?php endif; ?>
			<div class="entry-summary">
				<div class="entry-summary-inner">
					<div class="entry-summary-content">
						<?php if ( $show_date ) : ?>
							<span class="entry-date">
								<?php kayo_entry_date(); ?>
							</span>
						<?php endif; ?>
						<h2 class="entry-title">
							<?php if ( ! has_post_thumbnail() || ! $show_thumbnail ) : ?>
								<?php
								if ( is_sticky() && ! is_paged() ) {
									echo '<span class="sticky-post" title="' . esc_attr( __( 'Featured', 'kayo' ) ) . '"></span>';
								}
								?>
							<?php endif; ?>
							<?php the_title(); ?>
						</h2>
						<?php if ( $show_text ) : ?>
							<div class="entry-excerpt">
								<?php do_action( 'kayo_post_grid_classic_excerpt', $post_excerpt_length ); ?>
							</div><!-- .entry-excerpt -->
						<?php endif; ?>
						<?php if ( $show_category && ( ! has_post_thumbnail() || ! $show_thumbnail ) ) : ?>
							<div class="entry-category-list">
								<?php echo get_the_term_list( get_the_ID(), 'category', esc_html__( 'In', 'kayo' ) . ' ', esc_html__( ', ', 'kayo' ), '' ); ?>

							</div>
						<?php endif; ?>
					</div><!-- .entry-text -->
				</div><!-- .entry-summary-inner -->
				<?php if ( $show_author || $show_tags || $show_extra_meta || kayo_edit_post_link( false ) ) : ?>
					<div class="entry-meta">
						<?php if ( $show_author ) : ?>
							<?php kayo_get_author_avatar(); ?>
						<?php endif; ?>
						<?php if ( $show_tags ) : ?>
							<?php kayo_entry_tags(); ?>
						<?php endif; ?>
						<?php if ( $show_extra_meta ) : ?>
							<?php kayo_get_extra_meta(); ?>
						<?php endif; ?>
						<?php kayo_edit_post_link(); ?>
					</div><!-- .entry-meta -->
				<?php endif; ?>
			</div><!-- .entry-summary -->
		</div><!-- .entry-container -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->
