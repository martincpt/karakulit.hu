<?php
/**
 * Testimonial slide shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Templates
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'name' => '',
	'avatar' => '',
	'text' => '',
	'link' => '',
	'rating' => '',
	'el_class' => '',
), $atts ) );

$output = $inline_style = '';

$class = $el_class;

// link
$link = vc_build_link( $link );
$link_url = ( isset( $link['url'] ) ) ? esc_url( $link['url'] ) : '#';
$link_target = ( isset( $link['target'] ) ) ? esc_attr( trim( $link['target'] ) ) : '_self';
$link_title = ( isset( $link['title'] ) ) ? esc_attr( $link['title'] ) : '';
$nofollow = ( isset( $link['rel'] ) && 'nofollow' === $link['rel'] ) ? 'rel="nofollow"' : '';

$cite = '<cite class="wvc-testimonial-cite">';

if ( $avatar ) {

	$avatar = wvc_get_url_from_attachment_id( absint( $avatar ), apply_filters( 'wvc_testimonial_slide_avatar_size', 'thumbnail' ) );
}

if ( $name && $link_url ) {

	$link_url = esc_url( $link_url );
	$cite .= "<a $nofollow href='$link_url' target='_blank'>$name</a>";

} elseif ( $name ) {
	$cite .= sanitize_text_field( $name );
}

$cite .= '</cite>';

$output .= "<div class='wvc-testimonal-slide'><div class='wvc-testimonal-container'>";

if ( $avatar ) {
	$output .= '<span class="wvc-testimonial-avatar"><img src="' . esc_url( $avatar ) . '" alt="testimonial-avatar"></span>';
}

$output .= "<blockquote class='wvc-testimonial-content'><p>";
$output .= $text;
$output .= $cite;

if ( '-1' !== $rating && -1 !== $rating && '' !== $rating && function_exists( 'wc_get_star_rating_html' ) ) {
	$output .= '<div class="star-rating"><span style="width:' . esc_attr( $rating * 20 ) . '%">' . sprintf( esc_html__( '%s out of 5', 'wolf-visual-composer' ), esc_html( $rating ) ) . '</span></div>';
}

$output .= '<p></blockquote>';

$output .= '</div>
</div>';

echo $output;
