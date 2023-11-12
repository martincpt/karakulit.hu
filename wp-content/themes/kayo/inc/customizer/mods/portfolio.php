<?php
/**
 * Kayo customizer work mods
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Portoflio mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_work_mods( $mods ) {

	if ( class_exists( 'Wolf_Portfolio' ) ) {

		$mods['portfolio'] = array(
			'id'      => 'portfolio',
			'icon'    => 'portfolio',
			'title'   => esc_html__( 'Portfolio', 'kayo' ),
			'options' => array(

				'work_layout'         => array(
					'id'      => 'work_layout',
					'label'   => esc_html__( 'Portfolio Layout', 'kayo' ),
					'type'    => 'select',
					'choices' => array(
						'standard'  => esc_html__( 'Standard', 'kayo' ),
						'fullwidth' => esc_html__( 'Full width', 'kayo' ),
					),
				),

				'work_display'        => array(
					'id'      => 'work_display',
					'label'   => esc_html__( 'Portfolio Display', 'kayo' ),
					'type'    => 'select',
					/**
					 * Filters work post display options
					 *
					 * @since 1.0.0
					 */
					'choices' => apply_filters(
						'kayo_work_display_options',
						array(
							'grid' => esc_html__( 'Grid', 'kayo' ),
						)
					),
				),

				'work_grid_padding'   => array(
					'id'        => 'work_grid_padding',
					'label'     => esc_html__( 'Padding (for grid style display only)', 'kayo' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'kayo' ),
						'no'  => esc_html__( 'No', 'kayo' ),
					),
					'transport' => 'postMessage',
				),

				'work_item_animation' => array(
					'label'   => esc_html__( 'Portfolio Post Animation', 'kayo' ),
					'id'      => 'work_item_animation',
					'type'    => 'select',
					'choices' => kayo_get_animations(),
				),

				'work_pagination'     => array(
					'id'          => 'work_pagination',
					'label'       => esc_html__( 'Portfolio Archive Pagination', 'kayo' ),
					'type'        => 'select',
					'choices'     => array(
						'none'                => esc_html__( 'None', 'kayo' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
						'load_more'           => esc_html__( 'Load More Button', 'kayo' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'kayo' ),
				),

				'works_per_page'      => array(
					'label'       => esc_html__( 'Works per Page', 'kayo' ),
					'id'          => 'works_per_page',
					'type'        => 'text',
					'placeholder' => 6,
				),
			),
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_work_mods' );
