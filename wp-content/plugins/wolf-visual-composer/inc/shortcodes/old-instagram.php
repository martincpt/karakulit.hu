<?php
/**
 * Anchor shortcode
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Shortcodes
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wofl_Gram' ) ) {
	/**
	 * Anchor shortcode
	 *
	 * @param array $atts
	 * @return string
	 */
	function wolf_instagram_gallery_backup( $atts ) {

		$inline_atts = '';
		foreach ( $atts   as $key => $value) {
			$inline_atts .= ' ' . $key . '="' . $value . '"';
		}
		return do_shortcode( '[wvc_instagram_gallery ' . $inline_atts . ']' );
	}
	add_shortcode( 'wolf_instagram_gallery', 'wolf_instagram_gallery_backup' );
}