<?php
/**
 * Template part for displaying video posts layout
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
extract( // phpcs:ignore
	wp_parse_args(
		$template_args,
		array(
			'layout'                => '',
			'video_onclick'         => kayo_get_theme_mod( 'video_onclick', 'lightbox' ),
			'video_preview'         => false,
			'custom_thumbnail_size' => '',
		)
	)
);

// Video link.
$permalink = ( 'lightbox' === $video_onclick ) ? kayo_get_first_video_url() : get_the_permalink();

// Link class.
$link_class = 'entry-link-mask';

if ( ( 'lightbox' === $video_onclick ) ) {
	$link_class .= ' lightbox-video pause-players';
}
?>
<article <?php kayo_post_attr(); ?>>
	<div class="entry-box">
		<div class="entry-outer">
			<div class="entry-container">
				<a href="<?php echo esc_url( $permalink ); ?>" class="<?php echo kayo_sanitize_html_classes( $link_class ); ?>"></a>
				<?php
				if ( $video_preview ) {

					$args = array();

					if ( get_post_meta( get_the_ID(), '_wvc_video_post_preview', true )   ) {
						$args['video_bg_url'] = esc_url( get_post_meta( get_the_ID(), '_wvc_video_post_preview', true ) );
					}

					/**
					 * Video Background
					 */
					echo kayo_background_video( $args, true );
				}

				$style              = '';
				$img_dominant_color = kayo_get_image_dominant_color( get_post_thumbnail_id() );

				if ( $img_dominant_color ) {
					$img_dominant_color = kayo_sanitize_color( $img_dominant_color );
					$style              = "background-color:$img_dominant_color;";
				}
				?>

				<div class="entry-image" style="<?php echo kayo_esc_style_attr( $style ); ?>">
					<?php

					if ( $custom_thumbnail_size ) {

						$thumbnail = kayo_get_img_by_size(
							array(
								'attach_id'  => get_post_thumbnail_id(),
								'thumb_size' => $custom_thumbnail_size,
								'class'      => 'resized-thumbnail',
							)
						);

						echo kayo_kses( $thumbnail['thumbnail'] );

					} else {
						echo kayo_background_img(
							array(
								'background_img_size'  => 'medium',
								'placeholder_fallback' => true,
							)
						);
					}
					?>
				</div><!-- .entry-image -->

				<div class="video-play-button">
					<span class="fa fa-3x video-play-icon"></span>
				</div><!-- .video-play-button -->
				<div class="video-summary">
					<div class="video-summary-inner">
						<h2 class="entry-title">
							<?php the_title(); ?>
						</h2>

					</div><!-- .video-summary-inner -->
				</div><!-- .video-summary -->
			</div><!-- .entry-container -->
		</div><!-- .entry-outer -->
	</div><!-- .entry-box -->
	<?php do_action( 'kayo_video_content_after', $layout ); ?>
</article>
