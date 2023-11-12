<?php
/**
 * Kayo footer_bg
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Footer background mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_footer_bg_mods( $mods ) {

	$mods['footer_bg'] = array(
		'id'         => 'footer_bg',
		'label'      => esc_html__( 'Footer Background', 'kayo' ),
		'background' => true,
		'font_color' => true,
		'icon'       => 'format-image',
	);

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_footer_bg_mods' );
