<?php
/**
 * Kayo extra
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Extra mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_extra_mods( $mods ) {

	$mods['extra'] = array(

		'id'      => 'extra',
		'title'   => esc_html__( 'Extra', 'kayo' ),
		'icon'    => 'plus-alt',
		'options' => array(
			array(
				'label' => esc_html__( 'Enable Scroll Animations on Mobile (not recommended)', 'kayo' ),
				'id'    => 'enable_mobile_animations',
				'type'  => 'checkbox',
			),
			array(
				'label' => esc_html__( 'Enable Parallax on Mobile (not recommended)', 'kayo' ),
				'id'    => 'enable_mobile_parallax',
				'type'  => 'checkbox',
			),
		),
	);
	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_extra_mods' );
