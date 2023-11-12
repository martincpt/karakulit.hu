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
 * Set artists mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_artist_mods( $mods ) {

	if ( class_exists( 'Wolf_Artists' ) ) {
		$mods['wolf_artists'] = array(
			'priority' => 45,
			'id'       => 'wolf_artists',
			'title'    => esc_html__( 'Artists', 'kayo' ),
			'icon'     => 'admin-users',
			'options'  => array(

				'artist_layout'       => array(
					'id'          => 'artist_layout',
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

				'artist_display'      => array(
					'id'      => 'artist_display',
					'label'   => esc_html__( 'Display', 'kayo' ),
					'type'    => 'select',
					/**
					 * Filters artis post display options
					 * 
					 * @since Kayo 1.0.0
					 */
					'choices' => apply_filters(
						'kayo_artist_display_options',
						array(
							'list' => esc_html__( 'List', 'kayo' ),
						)
					),
				),

				'artist_grid_padding' => array(
					'id'        => 'artist_grid_padding',
					'label'     => esc_html__( 'Padding', 'kayo' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'kayo' ),
						'no'  => esc_html__( 'No', 'kayo' ),
					),
					'transport' => 'postMessage',
				),

				'artist_pagination'   => array(
					'id'          => 'artist_pagination',
					'label'       => esc_html__( 'Artists Archive Pagination', 'kayo' ),
					'type'        => 'select',
					'choices'     => array(
						'none'                => esc_html__( 'None', 'kayo' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
						'load_more'           => esc_html__( 'Load More Button', 'kayo' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'kayo' ),
				),

				'artists_per_page'    => array(
					'label'       => esc_html__( 'Artists per Page', 'kayo' ),
					'id'          => 'artists_per_page',
					'type'        => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_artist_mods' );
