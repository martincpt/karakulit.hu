<?php
/**
 * Kayo featured media function
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Get post featured media
 *
 * Output post media depending on post format and content available
 *
 * @param int $post_id The post ID.
 * @return string
 */
function kayo_featured_media( $post_id = null ) {

	$output             = '';
	$post_id            = ( $post_id ) ? $post_id : kayo_get_the_id();
	$post_format        = ( get_post_format( $post_id ) ) ? get_post_format( $post_id ) : 'standard';
	$has_post_thumbnail = ( has_post_thumbnail( $post_id ) );
	$permalink          = get_permalink( $post_id );

	$default_thumbnail = '';

	if ( $has_post_thumbnail ) {

		$default_thumbnail     .= '<div class="entry-thumbnail">';
			$default_thumbnail .= '<a href="' . esc_url( $permalink ) . '" class="entry-link" title="' . esc_attr(
				sprintf(
				/* translators: %s: the post title attribute */
					__( 'Permalink to %s', 'kayo' ),
					the_title_attribute( 'echo=0' )
				)
			) . '">';
			$default_thumbnail .= get_the_post_thumbnail( '', 'large' );
			$default_thumbnail .= '<span class="entry-thumbnail-overlay"></span><!-- .entry-thumbnail-overlay -->';
			$default_thumbnail .= '</a>';
		$default_thumbnail     .= '</div><!-- .entry-thumbnail -->';
	}

	if ( 'standard' === $post_format || 'chat' === $post_format ) {

		if ( $default_thumbnail ) {

			$output .= $default_thumbnail;
		}
	} elseif ( 'image' === $post_format ) {

		if ( kayo_is_instagram_post( $post_id ) ) {

			/**
			 * Embed Instagram
			 */
			$output .= kayo_get_instagram_image( $post_id );

		} elseif ( $has_post_thumbnail ) {

			/**
			 * Featured image
			 */
			$large_img_src = get_the_post_thumbnail_url( '', 'kayo-XL' );
			$output       .= '<div class="entry-thumbnail">';
			$output       .= '<a href="' . esc_url( $large_img_src ) . '" data-fancybox="' . esc_attr( get_the_title( $post_id ) ) . '" class="lightbox" title="' . the_title_attribute(
				array(
					'echo' => false,
					'post' => $post_id,
				)
			) . '">';

			$output .= get_the_post_thumbnail( $post_id, 'large' );

			$output .= '<span class="entry-thumbnail-overlay"></span><!-- .entry-thumbnail-overlay -->';

			$output .= '</a>';
			$output .= '</div><!-- .entry-thumbnail -->';
		}
	} elseif ( 'gallery' === $post_format ) {

		if ( kayo_entry_slider() ) {

			$output .= kayo_entry_slider();

		} elseif ( $default_thumbnail ) {

			$output .= $default_thumbnail;
		}
	} elseif ( 'video' === $post_format ) {

		$video_url = kayo_get_first_url( $post_id );
		if ( $video_url ) {
			$output .= '<div class="entry-video">';
			$output .= wp_oembed_get( $video_url );
			$output .= '</div>';
		}
	} elseif ( 'audio' === $post_format ) {

		/* If it's not a playlist, we show the featured image */
		if ( ! kayo_is_playlist_audio_player( $post_id ) ) {
			$output .= $default_thumbnail;
		}

		/* Highlight the audio file. */
		if ( kayo_get_audio_embed_content( $post_id ) ) {
			$output .= kayo_get_audio_embed_content( $post_id );
		}
	} elseif ( 'quote' === $post_format ) {

		if ( kayo_get_first_quote( $post_id ) ) {

			$output  = '<div class="entry-thumbnail">';
			$output .= '<a href="' . esc_url( $permalink ) . '" class="entry-link-mask" title="' . esc_attr(
				sprintf(
				/* translators: %s: the post title attribute */
					__( 'Permalink to %s', 'kayo' ),
					the_title_attribute( 'echo=0' )
				)
			) . '"></a>';

			$blockquote  = kayo_background_img();
			$blockquote .= '<div class="entry-summary-overlay">';
			$blockquote .= kayo_get_first_quote( $post_id );
			$blockquote .= '</div><!-- .entry-summary-overlay -->';

			/**
			 * Filters the post featured blockquote
			 *
			 * @since 1.0.0
			 */
			$output .= apply_filters( 'kayo_featured_blockquote', $blockquote, $post_id );

			$output .= '</div><!-- .entry-thumbnail -->';

		}
	} elseif ( 'link' === $post_format ) {

		if ( kayo_get_first_elementor_link( $post_id ) ) {

			$output .= kayo_get_first_elementor_link( $post_id );

		} elseif ( kayo_get_first_url( $post_id ) ) {
			$output     .= '<div class="entry-thumbnail">';
			$output     .= '<a href="' . esc_url( kayo_get_first_url( $post_id ) ) . '" target="_blank" class="entry-link-mask"></a>';
			$output     .= kayo_background_img();
			$output     .= '<div class="entry-summary-overlay">';
			$output     .= '<h2 class="entry-featured-link">';
				$output .= get_the_title();
				$output .= '<span class="meta-icon format-link-title-icon"></span>';
			$output     .= '</h2><!-- .entry-featured-link -->';
			$output     .= '</div><!-- .entry-summary-overlay -->';
			$output     .= '</div><!-- .entry-thumbnail -->';
		}
	} elseif ( 'aside' === $post_format || 'status' === $post_format ) {

		if ( get_the_content() ) {
			$output     .= '<div class="entry-thumbnail">';
				$output .= '<a href="' . esc_url( $permalink ) . '" class="entry-link-mask" title="' . esc_attr(
					sprintf(
					/* translators: %s: the post title attribute */
						__( 'Permalink to %s', 'kayo' ),
						the_title_attribute( 'echo=0' )
					)
				) . '"></a>';
				$output .= kayo_background_img();

				$output         .= '<div class="entry-summary-overlay">';
					$output     .= '<div class="entry-featured-status">';
						$output .= kayo_sample( get_the_content(), 33 );
					$output     .= '</div><!-- .entry-featured-status -->';
					$output     .= '<div class="author-meta">';
							/**
							 * Avatar
							 */
							$output .= get_avatar( get_the_author_meta( 'user_email' ), 20 );
							$output .= sprintf(
								'<span class="author vcard">by %s</span>',
								get_the_author()
							);
					$output         .= '</div>';
				$output             .= '</div><!-- .entry-summary-overlay -->';
			$output                 .= '</div><!-- .entry-thumbnail -->';
		}
	}

	if ( class_exists( 'WPBMap' ) && method_exists( 'WPBMap', 'addAllMappedShortcodes' ) ) {
		WPBMap::addAllMappedShortcodes();
	}

	return $output;
}
