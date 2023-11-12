<?php
/**
 * Kayo events
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Events mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_event_mods( $mods ) {

	if ( class_exists( 'Wolf_Events' ) ) {
		$mods['wolf_events'] = array(
			'priority' => 45,
			'id'       => 'wolf_events',
			'title'    => esc_html__( 'Events', 'kayo' ),
			'icon'     => 'calendar-alt',
			'options'  => array(

				'event_layout'       => array(
					'id'          => 'event_layout',
					'label'       => esc_html__( 'Layout', 'kayo' ),
					'type'        => 'select',
					'choices'     => array(
						'standard'      => esc_html__( 'Standard', 'kayo' ),
						'fullwidth'     => esc_html__( 'Full width', 'kayo' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'kayo' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'kayo' ),
					),
					'transport'   => 'postMessage',
					'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'kayo' ),
				),

				'event_display'      => array(
					'id'      => 'event_display',
					'label'   => esc_html__( 'Display', 'kayo' ),
					'type'    => 'select',
					/**
					 * Filters event post display options
					 * 
					 * @since Kayo 1.0.0
					 */
					'choices' => apply_filters(
						'kayo_list_display_options',
						array(
							'list' => esc_html__( 'List', 'kayo' ),
						)
					),
				),

				'event_grid_padding' => array(
					'id'        => 'event_grid_padding',
					'label'     => esc_html__( 'Padding', 'kayo' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'kayo' ),
						'no'  => esc_html__( 'No', 'kayo' ),
					),
					'transport' => 'postMessage',
				),
			),
		);
	}

	return $mods;

}
add_filter( 'kayo_customizer_mods', 'kayo_set_event_mods' );
