<?php
/**
 * Kayo discography
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Discography mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_release_mods( $mods ) {

	if ( class_exists( 'Wolf_Discography' ) ) {
		$mods['wolf_discography'] = array(
			'priority' => 45,
			'id'       => 'wolf_discography',
			'title'    => esc_html__( 'Discography', 'kayo' ),
			'icon'     => 'album',
			'options'  => array(
				'release_layout'       => array(
					'id'          => 'release_layout',
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

				'release_display'      => array(
					'id'      => 'release_display',
					'label'   => esc_html__( 'Display', 'kayo' ),
					'type'    => 'select',
					/**
					 * Filters release post display options
					 * 
					 * @since Kayo 1.0.0
					 */
					'choices' => apply_filters(
						'kayo_release_display_options',
						array(
							'grid' => esc_html__( 'Grid', 'kayo' ),
						)
					),
				),

				'release_grid_padding' => array(
					'id'        => 'release_grid_padding',
					'label'     => esc_html__( 'Padding (for grid display)', 'kayo' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'kayo' ),
						'no'  => esc_html__( 'No', 'kayo' ),
					),
					'transport' => 'postMessage',
				),

				'release_pagination'   => array(
					'id'          => 'release_pagination',
					'label'       => esc_html__( 'Discography Archive Pagination', 'kayo' ),
					'type'        => 'select',
					'choices'     => array(
						'none'                => esc_html__( 'None', 'kayo' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
						'load_more'           => esc_html__( 'Load More Button', 'kayo' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'kayo' ),
				),

				'releases_per_page'    => array(
					'label'       => esc_html__( 'Releases per Page', 'kayo' ),
					'id'          => 'releases_per_page',
					'type'        => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;

}
add_filter( 'kayo_customizer_mods', 'kayo_set_release_mods' );
