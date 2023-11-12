<?php
/**
 * Template part for displaying work posts masonry layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
extract( wp_parse_args( $template_args, array( // phpcs:ignore
	'layout' => '',
	'overlay_color' => 'auto',
	'overlay_custom_color' => '',
	'overlay_opacity' => 88,
	'overlay_text_color' => '',
	'overlay_text_custom_color' => '',
	'work_is_gallery' => '',
) ) );

$text_style = '';

if ( $overlay_text_color && 'overlay' === $layout ) {
	$text_color = kayo_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$text_style .= 'color:' . kayo_sanitize_color( $text_color ) . ';';
	}
}

$thumbnail_size = apply_filters( 'kayo_portfolio_masonry_thumbnail_size', ( kayo_is_gif( get_post_thumbnail_id() ) ) ? 'full' : 'kayo-masonry' );

$dominant_color = kayo_get_image_dominant_color( get_post_thumbnail_id() );
$actual_overlay_color = '';

if ( 'auto' === $overlay_color ) {

	$actual_overlay_color = $dominant_color;

} else {
	$actual_overlay_color = kayo_convert_color_class_to_hex_value( $overlay_color, $overlay_custom_color );
}

$overlay_tone_class = 'overlay-tone-' . kayo_get_color_tone( $actual_overlay_color );

$the_permalink = ( $work_is_gallery ) ? '#' : get_the_permalink();
$gallery_params = ( $work_is_gallery && function_exists( 'kayo_get_gallery_params' ) ) ? kayo_get_gallery_params() : '';
$link_class = ( $work_is_gallery ) ? 'gallery-quickview entry-link entry-link-mask' : 'entry-link entry-link-mask';
?>
<figure <?php kayo_post_attr( array( $overlay_tone_class ) ); ?> data-dominant-color="<?php echo esc_attr( $dominant_color ) ?>">
	<div class="entry-box">
		<div class="entry-container">
			<a data-gallery-params="<?php echo esc_js( wp_json_encode( $gallery_params ) ); ?>" class="<?php echo esc_attr( $link_class ); ?>" href="<?php echo esc_url( $the_permalink ); ?>"></a>
			<?php do_action( 'kayo_work_bg', $template_args, 'masonry' ); ?>
			<div class="entry-inner">
				<div class="entry-inner-padding">
					<?php

						if ( $dominant_color && 'auto' === $overlay_color ) {
							$overlay_custom_color = $dominant_color;
						}

						/**
						 * Overlay
						 */
						echo kayo_background_overlay( array(
							'overlay_color' => $overlay_color,
							'overlay_custom_color' => $overlay_custom_color,
							'overlay_opacity' => $overlay_opacity, )
						);
					?>
					<div style="<?php echo kayo_esc_style_attr( $text_style ); ?>" class="entry-summary">
						<?php do_action( 'kayo_work_masonry_summary_start', $template_args ); ?>

						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" style="<?php echo kayo_esc_style_attr( $text_style ); ?>"><?php the_title(); ?></a></h3>

						<?php do_action( 'kayo_work_masonry_summary_end', $template_args ); ?>
					</div><!--  .entry-summary  -->
				</div><!--  .entry-inner-padding  -->
			</div><!--  .entry-inner  -->
		</div>
	</div><!-- .entry-container -->
</figure><!-- #post-## -->
