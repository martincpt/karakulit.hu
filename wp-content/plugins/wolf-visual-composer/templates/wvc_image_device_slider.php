<?php
/**
 * Image device slider shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Templates
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'images' => '',
	'img_size' => '',
	'custom_img_size' => '',
	'device' => 'default',
	'autoplay' => '',
	'transition' => 'auto',
	'autoplay' => 'yes',
	'transition' => 'auto',
	'slideshow_speed' => 4000,
	'height' => 60,
	'pause_on_hover' => 'yes',
	'nav_tone' => 'light',
	'nav_bullets' => 'yes',
	'nav_arrows' => 'yes',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = $style_class = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

/*Animate */
if ( ! wvc_is_new_animation( $css_animation ) ) {
	$class .= wvc_get_css_animation( $css_animation );
	$inline_style .= wvc_get_css_animation_delay( $css_animation_delay );
}

wp_enqueue_style( 'linea-icons' );
wp_enqueue_style( 'flexslider' );
wp_enqueue_script( 'flexslider' );
wp_enqueue_script( 'wvc-sliders' );

$images = wvc_list_to_array( $images );

$image_size = 'large';

if ( 'default' === $device ) {
	$image_size = 'wvc-XL';
}

if ( 'auto' === $height ) {
	if ( 'custom' === $img_size ) {
		$img_size = esc_attr( $custom_img_size );
	}
	$image_size = $img_size;
}

$class = "wvc-slider-background-$device wvc-slider-nav-font-tone-$nav_tone";

if ( 'auto' === $height ) {
	$class .= " wvc-slider-height-auto";
}

$slider_data = "data-pause-on-hover='$autoplay'
data-autoplay='$autoplay'
data-transition='$transition'
data-slideshow-speed='$slideshow_speed'
data-nav-arrows='$nav_arrows'
data-nav-bullets='$nav_bullets'";

$output = '';

if ( $style_class || $inline_style ) {
	
	$style_class .= ' wvc-element';
	$output .= '<div class="' . wvc_sanitize_html_classes( $style_class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '"';

	$output .= wvc_element_aos_animation_data_attr( $atts );
	$output .= '>';

} else {
	$class .= ' wvc-element';
}

$output .= '<div class="' . wvc_sanitize_html_classes( $class ) . '"';

$output .= wvc_element_aos_animation_data_attr( $atts );

$output .= '>';

$output .= "<div $slider_data class='flexslider wvc-images-slider'>";
$output .= '<ul class="slides">';

foreach ( $images as $image_id ) {

	$output .= '<li class="slide wvc-image-side"><span class="wvc-image-slide-inner"';
	
	if ( $height && 'auto' !== $height ) {
		$output .= ' style="padding-bottom:' . absint( $height ) . 'vh;"';
	}

	$output .= '>';

	if ( wp_attachment_is_image( $image_id ) ) {

		$image = get_post( $image_id );
		$image_caption = $image->post_excerpt;

		$img_class = ( 'auto' === $height ) ? '' : 'wvc-img-cover'; 

		//$output .= wp_get_attachment_image( $image_id, $image_size, false, array( 'class' => $img_class ) );

		$img = wpb_getImageBySize( array(
			'attach_id' => $image_id,
			'thumb_size' => $image_size,
			'class' => $img_class,
		) );

		$output .= $img['thumbnail'];

		if ( $image_caption ) {
			$output .= '<p class="flex-caption">' . sanitize_text_field( $image_caption ) . '</p>';
		}
	} else {
		$output .= wvc_placeholder_img( 'wvc-XL', 'wvc-img-cover' );
		//$output .= '<img src="https:/unsplash.it/1200/700/?random&image=' . rand( 0, 999 ) . '" class="wvc-img-cover">';
	}

	$output .= '</span></li><!--.slide-->';
}

$output .= '</ul><!--.slides-->';
$output .= '</div><!--.wvc-images-slider-->';
$output .= '</div><!--.wvc-images-slider-container-->';

if ( $style_class || $inline_style ) {
	$output .= '</div><!--.vc_styles-->';
}

echo $output;