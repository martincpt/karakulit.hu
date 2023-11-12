<?php
/**
 * Kayo background_image
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Backgorund image mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_background_image_mods( $mods ) {

	/* Move background image setting here and rename the seciton title */
	$mods['background_image'] = array(
		'icon'    => 'format-image',
		'id'      => 'background_image',
		'title'   => esc_html__( 'Background Image', 'kayo' ),
		'options' => array(),
	);

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_background_image_mods' );
