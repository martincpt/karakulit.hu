<?php
/**
 * Icon shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Shortcodes
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'wvc_shortcode_icon' ) ) {
	/**
	 * Icon shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wvc_shortcode_icon( $atts ) {

		extract( shortcode_atts( array(
			'type' => '',
			'icon' => '',
		), $atts ) );

		vc_icon_element_fonts_enqueue( $type );

		//$icon = ( isset( $atts["icon_$type"] ) ) ? $atts["icon_$type"] : '';

		return '<i class="fa ' . esc_attr( $icon ) . '"></i>';
	}
	add_shortcode( 'wvc_icon', 'wvc_shortcode_icon' );
}