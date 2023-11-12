<?php
/**
 * Instagram Advanced Gallery shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Templates
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'sb_instagram_feed_init' ) ) {
	echo sprintf( wvc_kses( __( '<p>Please install <a href="%s" target="_blank">%s</a> plugin to display this element.</p>', 'wolf-visual-composer' ) ),
		'https://wordpress.org/plugins/instagram-feed/',
		'Smash Balloon Instagram Feed'
	);
	return;
}
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(

	'num' => 18,
	'cols' => 6,
	'username' => '',
	'accesstoken' => '',
	'imagepadding' => '',
	'showheader' => 'false',
	'showbio' => 'false',
	'showbutton' => 'false',
	'showfollow' => 'false',
	'follow_button' => '',
	'button_text' => '',

	'add_padding' => '',

	'type' => 'grid',
	'metro_pattern' => 'auto',
	'count' => 18, 
	'username' => '',
	'api_key' => '',
	'tag' => '',
	'slides_per_view' => '',
	'autoplay' => 'yes',
	'transition' => 'auto',
	'slideshow_speed' => 4000,
	'pause_on_hover' => 'yes',
	'nav_dots_tone' => 'light',
	'nav_arrows_tone' => 'light',
	'nav_bullets' => 'yes',
	'nav_arrows' => 'yes',
	'group_cells' => 'yes',
	'img_padding' => '',
	'hover_effect' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'css_animation_each' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$inline_atts = '';
$output = $figure_class = $figure_style = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( $css_animation_each ) {

	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$figure_class .= wvc_get_css_animation( $css_animation );
	}

} else {

	if ( ! wvc_is_new_animation( $css_animation ) ) {
		$class .= wvc_get_css_animation( $css_animation );
		$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
	}
}

if ( function_exists( 'sb_instagram_feed_init' ) ) {

	if ( 'carousel' === $type ) {

		wp_enqueue_script( 'flickity' );
		wp_enqueue_script( 'wvc-carousels' );
	}

	if ( 'masonry' === $type ) {
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'isotope' );
		wp_enqueue_script( 'wvc-galleries' );
	}

	if ( 'metro' === $type ) {
		wp_enqueue_script( 'imagesloaded' );
		wp_enqueue_script( 'isotope' );
		wp_enqueue_script( 'packery-mode' );
		wp_enqueue_script( 'wvc-galleries' );
	}

	if ( 'justified' === $type ) {
		wp_enqueue_script( 'flex-images' );
		wp_enqueue_script( 'wvc-galleries' );
	}
}

if ( ! class_exists( 'Wolf_Gram' ) && function_exists( 'sb_instagram_feed_init' ) ) {

	$class .= " wvc-i-follow_button-$follow_button wvc-wolf-gram-shortcode-container wvc-element";

	$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

	if ( $follow_button ) {

		$button_text = ( ! $button_text ) ? sprintf( esc_html__( 'Instagram @%s', 'wolf-visual-composer' ), $username ) : $button_text;

		$button_link = 'https://instagram.com/' . $username;
		$button_text = apply_filters( 'wolf_gram_button_text', $button_text );
		$button_link = apply_filters( 'wolf_gram_button_link', $button_link );

		ob_start();
		?>
		<a class="wolf-gram-follow-button" href="<?php echo esc_url( $button_link ); ?>" target="_blank">
			<?php echo sanitize_text_field( $button_text ); ?>
		</a>
		<?php
		$output .= ob_get_clean();
	}

	$atts['num'] = $count;
	$atts['cols'] = $slides_per_view;

	if ( $add_padding ) {
		
		$atts['imagepadding'] = '5px';

	} elseif ( $img_padding ) {
		
		$atts['imagepadding'] = '5px';
	
	} else {
		$atts['imagepadding'] = '0px';
	}

	$atts['showheader'] = isset( $atts['showheader'] ) ? $atts['showheader'] : 'false';
	$atts['showbio'] = isset( $atts['showbio'] ) ? $atts['showbio'] : 'false';
	$atts['showbutton'] = isset( $atts['showbutton'] ) ? $atts['showbutton'] : 'false';
	$atts['showfollow'] = isset( $atts['showfollow'] ) ? $atts['showfollow'] : 'false';

	foreach ( $atts as $key => $value ) {

		if ( 'showheader' === $key ) {
			if ( '' === $value ) {
				$value = 'false';
			}
		}

		if ( 'showbio' === $key ) {
			if ( '' === $value ) {
				$value = 'false';
			}
		}

		if ( 'showbutton' === $key ) {
			if ( '' === $value ) {
				$value = 'false';
			}
		}

		if ( 'showfollow' === $key ) {
			if ( '' === $value ) {
				$value = 'false';
			}
		}

		if ( $value ) {
			$inline_atts .= ' ' . $key . '="' . $value . '"';
		}
	}

//debug( $atts );
//debug( $inline_atts );

	$output .= apply_filters( 'wvc_sb_instagram_feed_shortcode', do_shortcode( '[instagram-feed ' . $inline_atts . ']' ) );


} else {

	$class .= " wvc-instagram-gallery wvc-clearfix wvc-gallery wvc-gallery-$type wvc-gallery-padding-$img_padding wvc-metro-$metro_pattern wvc-element";

	if ( 'mosaic' !== $type && 'carousel' !== $type ) {
		$class .= " wvc-gallery-columns-$slides_per_view";
	}

	if ( 'carousel' === $type ) {
		$class .= " wvc-carousel-columns-$slides_per_view";
	}

	$figure_class .= ' wolf-instagram-item';

	$carousel_data = '';

	/* Add carousel attributes */
	if ( 'carousel' === $type ) {
		$carousel_data = "data-pause-on-hover='$autoplay'
			data-autoplay='$autoplay'
			data-transition='$transition'
			data-slideshow-speed='$slideshow_speed'
			data-nav-arrows='$nav_arrows'
			data-nav-bullets='$nav_bullets'
			data-group-cells='$group_cells'";

		//$carousel_data .= 'data-flickity="' . esc_js( '{ "lazyLoad": true }' ) . '"';

		$class .= " wvc-carousel-nav-dots-tone-$nav_dots_tone wvc-carousel-nav-arrows-tone-$nav_arrows_tone";

		if ( 'true' === $nav_bullets ) {
			$class .= ' wvc-carousel-has-bullet';
		}
	}

	$output .= '<div ' . $carousel_data . ' class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

	if ( ! $css_animation_each ) {
		$output .= wvc_element_aos_animation_data_attr( $atts );
		
	}

	$output .= '>';

	$single_animation_delay = ( $css_animation_delay ) ? $css_animation_delay : 0;

	$img_class = '';

	$images = wolf_gram_get_feed( $count, '', $api_key, $username );

	if ( ! $images ) {
		return;
	}

	$i = 0;

	foreach( $images as $image ) {

		$link = $image['link'];
		$src = $image['image_large'];
		$tags = ( isset( $image['tags'] ) ) ? $image['tags'] : array();

		if ( $count && $i == $count ) {
			break;
		}

		if ( $tag && ! in_array( $tag, $tags ) ) {
			//$i = $i - 1;
			continue;
		}

		$metro_class = '';
		
		if ( 'metro' === $type ) {

			$img_class = 'wvc-img-cover';

			$metro_class .= 'wvc-metro-item';
		}

		/* Item */
		if ( ! wvc_is_new_animation( $css_animation ) ) {
			$figure_style = 'animation-delay:' . absint( $single_animation_delay ) . 'ms;';
		}

		$single_animation_delay = $single_animation_delay + 200;

		$output .= "<figure class='$figure_class $metro_class wvc-img-$type' style='$figure_style'";
				
			if ( $css_animation_each ) {
				$atts['css_animation_delay'] = $single_animation_delay;
				$output .= wvc_element_aos_animation_data_attr( $atts );
			}

		$output .= '>'; // end opening tag

		if ( 'metro' === $type ) {
			$output .= '<div class="wvc-metro-box wvc-img-metro-box">';
			$output .= '<div class="wvc-img-metro-outer">';
			$output .= '<div class="wvc-img-metro-inner">';
		}

		// Link
		$output .= '<a class="wvc-img" href="' . esc_url( $link ) . '" target="_blank">';

		/* Images */
		if ( preg_match( '/video/', $src ) ) {

			$output .= '<video muted="true" autoplay="true" loop="loop" preload="auto" controls="false">
						<source src="' . esc_url( $src ) . '"
	            type="video/mp4">
					</video>';

		} else {
			$output .= '<img src="' . esc_url( $src ) . '" alt="insta-pic">';
		}

		

		$output .= '<div class="wolf-instagram-overlay">
			<span  class="wolf-instagram-meta-container">
				<i class="fa socicon-instagram"></i>
			</span>
		</div>';


		$output .= '</a>';

		// closing tags
		if ( 'metro' === $type ) {
			$output .= '</div></div></div>';
		}

		$output .= '</figure>';

		$i++;
	} // endforeach

} // endif wolfgram

$output .= '</div>';

echo $output;