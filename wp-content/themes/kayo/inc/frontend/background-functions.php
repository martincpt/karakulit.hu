<?php
/**
 * Kayo background functions
 *
 * @package Kayo/Frontend
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Display background overlay
 *
 * @param  array $args
 * @return string $output
 */
function kayo_background_overlay( $args ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'overlay_color'        => 'black',
				'overlay_custom_color' => '#000000',
				'overlay_opacity'      => '',
			)
		)
	);

	$overlay_opacity = ( $overlay_opacity ) ? absint( $overlay_opacity ) / 100 : .4;

	$overlay_style = '';
	$class         = 'bg-overlay';

	if ( ( 'custom' === $overlay_color || 'auto' === $overlay_color ) && $overlay_custom_color ) {

		$overlay_style .= 'background-color:' . kayo_sanitize_color( $overlay_custom_color ) . ';';

	} else {

		if ( class_exists( 'Wolf_Core' ) ) {
			$class .= " background-color-$overlay_color"; // color class.

		} else {
			$class .= " wvc-background-color-$overlay_color"; // color class.
		}
	}

	$overlay_style .= "opacity:$overlay_opacity;";

	return '<div style="' . kayo_esc_style_attr( $overlay_style ) . '" class="' . kayo_sanitize_html_classes( $class ) . '"></div><!--.bg-overlay-->';
}

/**
 * Display image background
 *
 * @param array $args
 */
function kayo_background_img( $args = array(), $post_id = null ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'background_img'          => get_post_thumbnail_id( $post_id ),
				'background_color'        => '',
				'background_position'     => 'center center',
				'background_repeat'       => 'no-repeat',
				'background_size'         => 'cover',
				'background_effect'       => '',
				'background_img_size'     => 'kayo-XL',
				/**
				 * Filters wheter to use lazyload or not on the image background
				 *
				 * @since 1.0.0
				 */
				'background_img_lazyload' => apply_filters( 'wvc_bg_img_lazyload', true ),
				'placeholder_fallback'    => false,
			)
		)
	);

	$output = '';

	if ( $background_effect ) {
		$background_repeat = 'no-repeat';
		$background_size   = 'cover';
	}
	$do_object_fit = ( wp_attachment_is_image( $background_img ) && 'no-repeat' === $background_repeat && 'default' !== $background_size && 'parallax' !== $background_effect && ! kayo_is_edge() && ! wp_is_mobile() );

	if ( $do_object_fit ) {
		$position = array(
			'center center' => '50% 50%',
			'center top'    => '50% 0',
			'left top'      => '0 0',
			'right top'     => '100% 0',
			'center bottom' => '50% 100%',
			'left bottom'   => '0 100%',
			'right bottom'  => '100% 100%',
			'left center'   => '50% 0',
			'right center'  => '100% 50%',
		);

		$src                = kayo_get_url_from_attachment_id( $background_img, $background_img_size );
		$srcset             = wp_get_attachment_image_srcset( $background_img, $background_img_size );
		$alt                = get_post_meta( $background_img, '_wp_attachment_image_alt', true );
		$blank              = get_template_directory_uri() . '/assets/img/blank.gif';
		$img_dominant_color = kayo_get_image_dominant_color( $background_img );

		$original_src = ( $background_img_lazyload ) ? $blank : $src;

		$cover_class = "img-$background_size cover";

		if ( $background_img_lazyload ) {
			$cover_class .= ' lazy-hidden lazyload-bg skip-auto-lazy ';
		}

		$cover_style = 'object-position:' . $position[ $background_position ] . ';';

		$container_class = 'img-bg';
		$container_style = '';

		if ( 'zoomin' === $background_effect ) {
			$cover_class .= ' zoomin';
		}

		if ( $img_dominant_color ) {
			$img_dominant_color = kayo_sanitize_color( $img_dominant_color );
			$container_style   .= "background-color:$img_dominant_color;";
		}

		$output .= '<div class="' . kayo_sanitize_html_classes( $container_class ) . '" style="' . kayo_esc_style_attr( $container_style ) . '">';

		$bg_img_meta  = wp_get_attachment_metadata( $background_img );
		$bg_img_width = ( $bg_img_meta && isset( $bg_img_meta['width'] ) ) ? $bg_img_meta['width'] . 'px' : '';

		$output .= '<img
			src="' . esc_url( $original_src ) . '"
			style="' . kayo_esc_style_attr( $cover_style ) . '"
			data-src="' . esc_url( $src ) . '"';

		if ( $srcset ) {
			$output .= ' srcset="' . esc_attr( $srcset ) . '"';
		}

		$output .= ' class="' . kayo_sanitize_html_classes( $cover_class ) . '"
			sizes="(max-width: ' . esc_attr( $bg_img_width ) . ') 100vw, ' . esc_attr( $bg_img_width ) . '"
			alt="' . esc_attr( $alt ) . '">';

		$output .= '<div class="img-bg-overlay"></div></div>';

	} elseif ( wp_attachment_is_image( $background_img ) || $background_color ) {

		$style           = '';
		$attrs           = '';
		$container_class = 'img-bg';

		if ( 'parallax' === $background_effect && wp_attachment_is_image( $background_img ) ) {

			$container_class .= ' parallax';

			$background_color = kayo_get_image_dominant_color( $background_img );

			if ( $background_color ) {
				$style .= 'background-color:' . esc_attr( $background_color ) . ';';
			}

			$src    = kayo_get_url_from_attachment_id( $background_img, $background_img_size );
			$srcset = wp_get_attachment_image_srcset( $background_img, $background_img_size );
			$attrs  = ' data-image-src="' . $src . '"';
			$attrs .= ' data-image-srcset="' . $srcset . '"';
			$attrs .= ' data-speed="0.5"';

			$style .= 'background-image:url(' . $src . ');';
			$bg_meta = wp_get_attachment_metadata( $background_img );

			if ( is_array( $bg_meta ) && isset( $bg_meta['width'] ) ) {
				$attrs .= ' data-image-width="' . $bg_meta['width'] . '"';
			}

			if ( is_array( $bg_meta ) && isset( $bg_meta['height'] ) ) {
				$attrs .= ' data-image-height="' . $bg_meta['height'] . '"';
			}
		}

		if ( 'parallax' !== $background_effect ) {

			if ( $background_color ) {
				$style .= 'background-color:' . esc_attr( $background_color ) . ';';
			}

			if ( $background_position ) {
				$style .= 'background-position:' . esc_attr( $background_position ) . ';';
			}

			if ( $background_repeat ) {
				$style .= 'background-repeat:' . esc_attr( $background_repeat ) . ';';
			}

			if ( $background_size ) {
				$style .= 'background-size:' . esc_attr( $background_size ) . ';';
			}

			if ( wp_attachment_is_image( $background_img ) ) {
				$background_img_url = kayo_get_url_from_attachment_id( $background_img, $background_img_size );
				$style             .= 'background-image:url(' . esc_url( $background_img_url ) . ');';
			}
		}

		$output .= '<div ' . $attrs . ' class="' . kayo_sanitize_html_classes( $container_class ) . '" style="' . esc_attr( $style ) . '"></div>';

	} elseif ( kayo_is_instagram_post() ) {

		$container_class = 'img-bg';

		$instagram_url = kayo_get_instagram_image_url();
		$output       .= '<div class="' . kayo_sanitize_html_classes( $container_class ) . '" style="background-size:cover;background-image:url(' . esc_url( $instagram_url ) . ');"></div>';

	} elseif ( $placeholder_fallback ) {

		$container_class = 'img-bg';

		if ( 'parallax' === $background_effect ) {
			$container_class .= ' parallax';
		}

		$bg_fallback_url = kayo_get_placeholder_url();

		$output .= '<div class="' . kayo_sanitize_html_classes( $container_class ) . '" style="background-size:cover;background-image:url(' . esc_url( $bg_fallback_url ) . ');"></div>';
	}

	return $output;
}

/**
 * Display slideshow background
 *
 * @param  array $args arguments array.
 * @return string $output
 */
function kayo_background_slideshow( $args = array() ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'slideshow_image_size' => '1920x3000',
				'slideshow_img_ids'    => '',
				'slideshow_speed'      => 3500,
				'slideshow_img_count'  => 0,
			)
		)
	);

	$output = '';

	if ( '' === $slideshow_img_ids ) {
		$slideshow_img_ids = kayo_get_post_gallery_ids();
	}

	$slideshow_img_ids = kayo_list_to_array( $slideshow_img_ids );

	$do_object_fit = ( ! kayo_is_edge() && ! wp_is_mobile() );

	if ( array() !== $slideshow_img_ids && is_array( $slideshow_img_ids ) ) {

		if ( $slideshow_img_count && ( absint( $slideshow_img_count ) < count( $slideshow_img_ids ) ) ) {
			$slideshow_img_ids = array_slice( $slideshow_img_ids, 0, absint( $slideshow_img_count ) );
		}

		$output .= '<div data-slideshow-speed="' . absint( $slideshow_speed ) . '" class="slideshow-background flexslider"><ul class="slides">';

		foreach ( $slideshow_img_ids as $image_id ) {

			$src = esc_url( kayo_get_url_from_attachment_id( $image_id, $slideshow_image_size ) );

			$output .= '<li class="slide">';

			if ( $do_object_fit ) {
				$output .= kayo_resized_thumbnail( $slideshow_image_size, 'cover', $image_id, false );

			} else {

				$output .= '<div style="position:absolute;top:0;left:0;right:0;bottom:0;width:100%;height:100%;background:url(' . $src . ') center center;background-size:cover;"></div>';
			}

			$output .= '</li>';
		}

		$output .= '</ul></div>';
	}

	return $output;
}

/**
 * Display video background
 *
 * @param array $args The video background arguments.
 * @param bool  $vimeo force vimeo background.
 */
function kayo_background_video( $args = array(), $vimeo = true ) {

	$args = wp_parse_args(
		$args,
		array(
			'video_bg_url'        => kayo_get_first_video_url(),
			'video_bg_img'        => get_post_thumbnail_id(),
			'video_bg_controls'   => '',
			'video_bg_img_size'   => 'large',
			'video_bg_parallax'   => '',
			'video_bg_start_time' => '',
			'class'               => '',
		)
	);

	$output = '';

	if ( '' !== $args['video_bg_parallax'] ) {

		$output .= kayo_parallax_video_bg( $args );

	} else {

		if ( 'selfhosted' === kayo_get_video_url_type( $args['video_bg_url'] ) ) {

			$output .= kayo_video_bg( $args );

		} elseif ( 'youtube' === kayo_get_video_url_type( $args['video_bg_url'] ) ) {

			$output .= kayo_youtube_video_bg( $args );

		} elseif ( 'vimeo' === kayo_get_video_url_type( $args['video_bg_url'] ) && $vimeo ) {

			$output .= kayo_vimeo_video_bg( $args );
		}
	}

	return $output;
}

/**
 * Display a parallax video background
 *
 * Use jarallax script to output the parallax video background
 *
 * @param array $args
 * @return string $output
 */
function kayo_parallax_video_bg( $args ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'video_bg_url'        => '',
				'video_bg_img'        => '',
				'video_bg_img_mobile' => '',
				'video_bg_img_size'   => 'kayo-XL',
				'video_bg_start_time' => 0,
				'video_bg_end_time'   => 0,
				'video_bg_loop'       => true,
				'video_bg_unmute'     => false,
			)
		)
	);

	wp_enqueue_script( 'jarallax' );
	wp_enqueue_script( 'jarallax-video' );

	$output          = '';
	$data_start_time = '';
	$data_end_time   = '';

	/**
	 * Background start and endtime
	 * 
	 * @todo debug start and endtime
	 */
	$video_bg_start_time = esc_attr( $video_bg_start_time );
	$video_bg_end_time   = esc_attr( $video_bg_end_time );

	if ( $video_bg_start_time ) {
		$data_start_time .= 'data-video-start-time="' . absint( $video_bg_start_time ) . '"';
	}

	if ( $video_bg_end_time ) {
		$data_end_time .= 'data-video-end-time="' . absint( $video_bg_end_time ) . '"';
	}

	if ( strpos( $video_bg_url, 'mp4' ) ) {
		$video_bg_url = 'mp4:' . $video_bg_url;
	} else {
		$video_bg_url = esc_url( $video_bg_url );
	}

	$output .= '<div class="video-parallax" data-jarallax-video="' . esc_attr( $video_bg_url ) . '" ' . $data_start_time . ' ' . $data_end_time . '>';
	$output .= kayo_video_bg_img_fallback( $args );

	$output .= '</div><!-- .video-parallax -->';

	return $output;
}

/**
 * Video background image fallback
 *
 * @param array $args
 * @return string $image
 */
function kayo_video_bg_img_fallback( $args ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'video_bg_img_size'   => 'kayo-XL',
				'video_bg_img'        => '',
				'video_bg_img_mobile' => '',
			)
		)
	);

	$image     = '';
	$is_mobile = wp_is_mobile();

	if ( $is_mobile && wp_get_attachment_image( $video_bg_img_mobile ) ) {

		$image = wp_get_attachment_image( $video_bg_img_mobile, $video_bg_img_size, false, array( 'class' => 'img-cover video-bg-fallback video-bg-fallback-mobile' ) );

	} elseif ( $video_bg_img ) {
		$image = wp_get_attachment_image( $video_bg_img, $video_bg_img_size, false, array( 'class' => 'img-cover video-bg-fallback' ) );
	}

	return $image;
}

/**
 * Display a slef hosted video background
 *
 * Output a basic HTML5 video markup. WordPress will apply mediaelement script automatically to it
 *
 * @param  array $args The video background arguments.
 * @return string $output
 */
function kayo_video_bg( $args ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'video_bg_url'      => '',
				'video_bg_webm'     => '',
				'video_bg_ogv'      => '',
				'video_bg_img'      => '',
				'video_bg_controls' => '',
				'video_bg_img_size' => 'kayo-XL',
				'class'             => '',
			)
		)
	);

	extract( $args );

	$unique_id = uniqid( 'video-bg-' );
	$output    = '';
	$class    .= ' video-bg-container';
	$output   .= "<div class='$class'>";

	if ( $video_bg_img ) {
		$output .= kayo_resized_thumbnail( $video_bg_img_size, 'cover video-bg-fallback', $video_bg_img, false );
	}

	$output .= '<video class="video-bg" id="' . esc_attr( $unique_id ) . '" preload="auto" autoplay loop="loop" muted>';

	if ( $video_bg_url ) {
		$output .= '<source src="' . esc_url( $video_bg_url ) . '" type="video/mp4">';
	}

	if ( $video_bg_webm ) {
		$output .= '<source src="' . esc_url( $video_bg_webm ) . '" type="video/webm">';
	}

	if ( $video_bg_ogv ) {
		$output .= '<source src="' . esc_url( $video_bg_ogv ) . '" type="video/ogg">';
	}

	$output .= '</video>';
	$output .= '<div class="video-bg-overlay"></div>';
	/* Video controls can be found in the shortcode file section.php */
	$output .= '</div>';

	return $output;
}

/**
 * Display a YouTube video background
 *
 * Output YouTube video background markup
 *
 * @param  array $args The YT video background arguments.
 * @return string $output
 */
function kayo_youtube_video_bg( $args ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'video_bg_url'        => '',
				'video_bg_start_time' => '',
				'video_bg_img'        => '',
				'video_bg_img_size'   => 'kayo-XL',
				'class'               => '',
			)
		)
	);

	wp_enqueue_script( 'kayo-youtube-video-background' );

	$output              = '';
	$style               = '';
	$class              .= ' video-bg-container youtube-video-bg-container';
	$video_bg_url        = esc_url( $video_bg_url );
	$container_unique_id = uniqid( 'youtube-video-bg-container-' );
	$unique_id           = uniqid( 'youtube-player-' );

	if (
		preg_match( '#youtube(?:\-nocookie)?\.com/watch\?v=([A-Za-z0-9\-_]+)#', $video_bg_url, $match )
		|| preg_match( '#youtube(?:\-nocookie)?\.com/v/([A-Za-z0-9\-_]+)#', $video_bg_url, $match )
		|| preg_match( '#youtube(?:\-nocookie)?\.com/embed/([A-Za-z0-9\-_]+)#', $video_bg_url, $match )
		|| preg_match( '#youtu.be/([A-Za-z0-9\-_]+)#', $video_bg_url, $match )
	) {

		if ( $match && isset( $match[1] ) ) {

			$youtube_id = $match[1];
			$embed_url  = 'https://youtube.com/embed/' . $youtube_id;

			$output .= "<div class='$class' data-youtube-start-time='$video_bg_start_time' id='$container_unique_id' data-youtube-video-id='$youtube_id'>";
			$output .= wp_get_attachment_image( $video_bg_img, $video_bg_img_size, false, array( 'class' => 'cover' ) );
			$output .= "<div class='youtube-player youtube-bg' id='$unique_id'></div>";
			$output .= '<div class="video-bg-overlay"></div>';
			$output .= '</div><!-- .youtube-video-bg -->';
		}
	}
	return $output;
}

/**
 * Display a vimeo video background
 *
 * Output vimeo video background markup
 *
 * @param  array $args The Vimeo video background arguments.
 * @return string $output
 */
function kayo_vimeo_video_bg( $args ) {

	extract(
		wp_parse_args(
			$args,
			array(
				'video_bg_url'      => '',
				'video_bg_img'      => '',
				'video_bg_img_size' => 'kayo-XL',
				'class'             => '',
			)
		)
	);

	wp_enqueue_script( 'vimeo-player' );
	wp_enqueue_script( 'kayo-vimeo' );

	$output       = '';
	$style        = '';
	$class       .= ' video-bg-container vimeo-video-bg-container';
	$video_bg_url = esc_url( $video_bg_url );

	if (
		preg_match( '#vimeo\.com/([0-9a-z\#=]+)#', $video_bg_url, $match )
	) {

		if ( $match && isset( $match[1] ) ) {

			$vimeo_id  = $match[1];
			$embed_url = 'https://player.vimeo.com/' . $vimeo_id;

			$output .= '<div class="vimeo-video-bg-container video-bg-container">';
			$output .= wp_get_attachment_image( $video_bg_img, $video_bg_img_size, false, array( 'class' => 'cover video-bg-fallback' ) );

			$output .= '<iframe class="vimeo-bg video-bg" src="https://player.vimeo.com/video/' . esc_attr( $vimeo_id ) . '?autoplay=1&loop=1&byline=0&title=0&background=1"></iframe>';

			$output .= '<div class="video-bg-overlay"></div>';
			$output .= '</div><!--.video-bg-container-->';
		}
	}
	return $output;
}
