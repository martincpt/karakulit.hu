<?php
/**
 * Kayo loading
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Loading animation mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_loading_mods( $mods ) {

	$mods['loading'] = array(

		'id'      => 'loading',
		'title'   => esc_html__( 'Loading', 'kayo' ),
		'icon'    => 'update',
		'options' => array(

			array(
				'label'   => esc_html__( 'Loading Animation Type', 'kayo' ),
				'id'      => 'loading_animation_type',
				'type'    => 'select',
				'choices' => array(
					'spinner' => esc_html__( 'Spinner', 'kayo' ),
					'none'    => esc_html__( 'None', 'kayo' ),
				),
			),
		),
	);
	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_loading_mods' );
