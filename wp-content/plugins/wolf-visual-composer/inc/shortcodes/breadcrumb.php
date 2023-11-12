<?php
/**
 * Breadcrump shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Shortcodes
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

// if ( ! function_exists( 'wvc_shortcode_breadcrumb' ) ) {
// 	/**
// 	 * Breadcrump shortcode
// 	 *
// 	 * @param array $atts
// 	 * @return string
// 	 */
// 	function wvc_shortcode_breadcrumb( $atts ) {

// 		extract( shortcode_atts( array(
// 			'align' => '',
// 		), $atts ) );

// 		$output = '';

// 		$output .= '<div class="wvc-breadcrumb wvc-text-' . esc_attr( $align ) . '">';

// 		$output .= wvc_breadcrumb();

// 		$output .= '</div><!--.wvc-breadcrumb-->';

// 		return $output;
// 	}
// 	add_shortcode( 'wvc_breadcrumb', 'wvc_shortcode_breadcrumb' );
// }