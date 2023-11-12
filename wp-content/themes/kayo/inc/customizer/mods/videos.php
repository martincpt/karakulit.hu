<?php
/**
 * Kayo videos
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Video mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_video_mods( $mods ) {

	if ( class_exists( 'Wolf_Videos' ) ) {
		$mods['wolf_videos'] = array(
			'id'      => 'wolf_videos',
			'title'   => esc_html__( 'Videos', 'kayo' ),
			'icon'    => 'editor-video',
			'options' => array(

				'video_layout'         => array(
					'id'          => 'video_layout',
					'label'       => esc_html__( 'Layout', 'kayo' ),
					'type'        => 'select',
					'choices'     => array(
						'standard'      => esc_html__( 'Standard', 'kayo' ),
						'fullwidth'     => esc_html__( 'Full width', 'kayo' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'kayo' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'kayo' ),
					),
					'description' => esc_html__( 'For "Sidebar" layouts, the sidebar will be visible if it contains widgets.', 'kayo' ),
				),

				'video_grid_padding'   => array(
					'id'        => 'video_grid_padding',
					'label'     => esc_html__( 'Padding', 'kayo' ),
					'type'      => 'select',
					'choices'   => array(
						'yes' => esc_html__( 'Yes', 'kayo' ),
						'no'  => esc_html__( 'No', 'kayo' ),
					),
					'transport' => 'postMessage',
				),

				'video_display'        => array(
					'id'      => 'video_display',
					'label'   => esc_html__( 'Display', 'kayo' ),
					'type'    => 'select',
					/**
					 * Filters video post display options
					 *
					 * @since 1.0.0
					 */
					'choices' => apply_filters(
						'kayo_video_display_options',
						array(
							'grid' => esc_html__( 'Grid', 'kayo' ),
						)
					),
				),

				'video_item_animation' => array(
					'label'   => esc_html__( 'Video Archive Item Animation', 'kayo' ),
					'id'      => 'video_item_animation',
					'type'    => 'select',
					'choices' => kayo_get_animations(),
				),

				'video_onclick'        => array(
					'label'   => esc_html__( 'On Click', 'kayo' ),
					'id'      => 'video_onclick',
					'type'    => 'select',
					/**
					 * Filters video "on click" option
					 *
					 * @since 1.0.0
					 */
					'choices' => apply_filters(
						'kayo_video_onclick',
						array(
							'lightbox' => esc_html__( 'Open Video in Lightbox', 'kayo' ),
							'default'  => esc_html__( 'Go to the Video Page', 'kayo' ),
						)
					),
				),

				'video_pagination'     => array(
					'id'          => 'video_pagination',
					'label'       => esc_html__( 'Video Archive Pagination', 'kayo' ),
					'type'        => 'select',
					'choices'     => array(
						'none'                => esc_html__( 'None', 'kayo' ),
						'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
						'load_more'           => esc_html__( 'Load More Button', 'kayo' ),
					),
					'description' => esc_html__( 'You must set a number of posts per page below. The category filter will not be disabled.', 'kayo' ),
				),

				'videos_per_page'      => array(
					'label'       => esc_html__( 'Videos per Page', 'kayo' ),
					'id'          => 'videos_per_page',
					'type'        => 'text',
					'placeholder' => 6,
				),

				'video_single_layout'  => array(
					'id'      => 'video_single_layout',
					'label'   => esc_html__( 'Single Post Layout', 'kayo' ),
					'type'    => 'select',
					'choices' => array(
						'sidebar-right' => esc_html__( 'Sidebar Right', 'kayo' ),
						'sidebar-left'  => esc_html__( 'Sidebar Left', 'kayo' ),
						'no-sidebar'    => esc_html__( 'No Sidebar', 'kayo' ),
						'fullwidth'     => esc_html__( 'Full width', 'kayo' ),
					),
				),

				/*
				'video_columns' => [
					'id' => 'video_columns',
					'label' => esc_html__( 'Columns', 'kayo' ),
					'type' => 'select',
					'choices' => [
						3 => 3,
						2 => 2,
						4 => 4,
						5 => 5,
						6 => 6,
					),
					'transport' => 'postMessage',
				),*/
			),
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_video_mods' );
