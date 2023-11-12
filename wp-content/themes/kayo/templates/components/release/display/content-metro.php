<?php
/**
 * Template part for displaying releases with the "metro" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
extract( wp_parse_args( $template_args, array(
	'overlay_color' => 'auto',
	'overlay_custom_color' => '',
	'overlay_opacity' => 88,
	'overlay_text_color' => '',
	'overlay_text_custom_color' => '',
) ) );

$text_style = '';
$overlay_text_color = apply_filters( 'wvc_release_overlay_text_color', $overlay_text_color );
if (  $overlay_text_color && 'overlay' === $layout ) {
	$text_color = kayo_convert_color_class_to_hex_value( $overlay_text_color, $overlay_text_custom_color );
	if ( $text_color ) {
		$text_style .= 'color:' . kayo_sanitize_color( $text_color ) . '!important;';
	}
}

$dominant_color = kayo_get_image_dominant_color( get_post_thumbnail_id() );
$actual_overlay_color = '';

if ( 'auto' === $overlay_color ) {

	$actual_overlay_color = $dominant_color;

} else {
	$actual_overlay_color = kayo_convert_color_class_to_hex_value( $overlay_color, $overlay_custom_color );
}

$overlay_tone_class = 'overlay-tone-' . kayo_get_color_tone( $actual_overlay_color );
?>
<article <?php kayo_post_attr(); ?>>
	<div class="entry-box">
		<div class="entry-outer">
			<div class="entry-container">
				<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
				<div class="entry-image">
					<div class="entry-cover">
						<?php
							echo kayo_background_img( array( 'background_img_size' => 'large', ) );
						?>
					</div><!-- entry-cover -->
				</div>
				<div class="entry-inner">
					<?php
						$dominant_color = kayo_get_image_dominant_color( get_post_thumbnail_id() );

						if ( $dominant_color && 'auto' === $overlay_color ) {
							$overlay_custom_color = $dominant_color;
						}

						echo kayo_background_overlay( array(
							'overlay_color' => $overlay_color,
							'overlay_custom_color' => $overlay_custom_color,
							'overlay_opacity' => $overlay_opacity, )
						);
					?>
					<div class="entry-summary">
						<h3 class="entry-title"><a href="<?php the_permalink(); ?>" style="<?php echo kayo_esc_style_attr( $text_style ); ?>"><?php the_title(); ?></a></h3>
						<div class="entry-taxonomy">
							<?php echo get_the_term_list( get_the_ID(), 'band', apply_filters( 'kayo_release_tax_before', '' ), ' / ', '' ); ?>
						</div><!-- .entry-taxonomy -->
					</div><!--  .entry-summary  -->
				</div>
			</div><!-- .entry-container -->
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
</article><!-- #post-## -->