<?php
/**
 * Template part for displaying release with the "lateral" display
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
			'release_alternate_thumbnail_position' => '',
			'index'                                => 0,
			'release_custom_thumbnail_size'        => '',
		)
	)
);

$even_class = '';
$even       = ( 0 === $index % 2 );
$odd        = ( 0 !== $index % 2 );

if ( $odd && $release_alternate_thumbnail_position ) {
	$even_class = 'odd';
} elseif ( $even && $release_alternate_thumbnail_position ) {
	$even_class = 'even';
}
?>
<article <?php kayo_post_attr(); ?>>
	<div class="entry-box">
		<div class="entry-outer">
			<div class="entry-container <?php echo esc_attr( $even_class ); ?>">
				<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
				<?php if ( $odd || ! $release_alternate_thumbnail_position ) : ?>
					<div class="entry-image">
					<?php

					if ( $release_custom_thumbnail_size ) {

						$thumbnail = kayo_get_img_by_size(
							array(
								'attach_id'  => get_post_thumbnail_id(),
								'thumb_size' => $release_custom_thumbnail_size,
							)
						);

						echo kayo_kses( $thumbnail['thumbnail'] ); // WCS XSS ok.

					} else {

						?>
							<div class="entry-cover">
							<?php echo kayo_background_img(); // WCS XSS ok. ?>
							</div><!-- entry-cover -->
							<?php
					}
					?>
					</div>
				<?php endif; ?>
				<div class="entry-summary">
					<div class="entry-summary-inner">
						<a href="<?php the_permalink(); ?>" class="entry-link">
							<?php the_title( '<h3 class="entry-title">', '</h3>' ); ?>
						</a>
						<?php
							/**
							 * Release Meta Hook
							 */
							do_action( 'kayo_release_meta' );
						?>
					</div><!--  .entry-summary-inner  -->
				</div><!--  .entry-summary  -->
				<?php if ( $even && $release_alternate_thumbnail_position ) : ?>
					<div class="entry-image">
						<div class="entry-cover">
							<?php
								echo kayo_background_img(); // WCS XSS ok.
							?>
						</div><!-- entry-cover -->
					</div>
				<?php endif; ?>
			</div>
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->
