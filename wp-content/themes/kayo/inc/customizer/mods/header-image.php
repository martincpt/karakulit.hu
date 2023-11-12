<?php
/**
 * Kayo header_image
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Header image mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_header_image_mods( $mods ) {

	/* Move header image setting here and rename the section title */
	$mods['header_image'] = array(
		'id'      => 'header_image',
		'title'   => esc_html__( 'Header Image', 'kayo' ),
		'icon'    => 'format-image',
		'options' => array(),
	);

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_header_image_mods' );
