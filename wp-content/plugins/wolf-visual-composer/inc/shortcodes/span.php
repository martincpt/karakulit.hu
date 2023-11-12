<?php
/**
 * Span shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Shortcodes
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_span' ) ) {
	/**
	 * Span shortcode
	 *
	 * @param array $atts The shortcode attributes.
	 * @return string
	 */
	function wvc_shortcode_span( $atts, $content = null ) {

		extract(
			shortcode_atts(
				array(
					'id'    => '',
					'class' => '',
					'style' => '',
				),
				$atts
			)
		);

		$output = '<span data-span-text="' . esc_attr( $content ) . '" class="' . wvc_sanitize_html_classes( $class ) . '" style="' . esc_attr( $style ) . '"';

		if ( ! empty( $id ) ) {
			$output .= ' id="' . esc_attr( $id ) . '"';
		}

		$output .= '>' . do_shortcode( $content ) . '</span>';

		return $output;
	}
	add_shortcode( 'wvc_span', 'wvc_shortcode_span' );
}
