<?php
/**
 * Kayo customizer blog mods
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Blog mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_post_mods( $mods ) {

	$mods['blog'] = array(
		'id'      => 'blog',
		'icon'    => 'welcome-write-blog',
		'title'   => esc_html__( 'Blog', 'kayo' ),
		'options' => array(

			'post_layout'           => array(
				'id'          => 'post_layout',
				'label'       => esc_html__( 'Blog Archive Layout', 'kayo' ),
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

			'post_display'          => array(
				'id'      => 'post_display',
				'label'   => esc_html__( 'Blog Archive Display', 'kayo' ),
				'type'    => 'select',
				/**
				 * Filters post display options
				 * 
				 * @since Kayo 1.0.0
				 */
				'choices' => apply_filters(
					'kayo_post_display_options',
					array(
						'standard' => esc_html__( 'Standard', 'kayo' ),
					)
				),
			),

			'post_grid_padding'     => array(
				'id'        => 'post_grid_padding',
				'label'     => esc_html__( 'Padding (for grid style display only)', 'kayo' ),
				'type'      => 'select',
				'choices'   => array(
					'yes' => esc_html__( 'Yes', 'kayo' ),
					'no'  => esc_html__( 'No', 'kayo' ),
				),
				'transport' => 'postMessage',
			),

			'date_format'           => array(
				'id'      => 'date_format',
				'label'   => esc_html__( 'Blog Date Format', 'kayo' ),
				'type'    => 'select',
				'choices' => array(
					''           => esc_html__( 'Default', 'kayo' ),
					'human_diff' => esc_html__( '"X Time ago"', 'kayo' ),
				),
			),

			'post_pagination'       => array(
				'id'      => 'post_pagination',
				'label'   => esc_html__( 'Blog Archive Pagination', 'kayo' ),
				'type'    => 'select',
				'choices' => array(
					'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
					'load_more'           => esc_html__( 'Load More Button', 'kayo' ),
				),
			),

			'post_excerpt_type'     => array(
				'id'          => 'post_excerpt_type',
				'label'       => esc_html__( 'Blog Archive Post Excerpt Type', 'kayo' ),
				'type'        => 'select',
				'choices'     => array(
					'auto'   => esc_html__( 'Auto', 'kayo' ),
					'manual' => esc_html__( 'Manual', 'kayo' ),
				),
				'description' => sprintf( kayo_kses(
					/* translators: %s: Codex reference link URL */
					__( 'Only for the "Standard" display type. To split your post manually, you can use the <a href="%s" target="_blank">"read more"</a> tag.', 'kayo' )
				), 'https://codex.wordpress.org/Customizing_the_Read_More' ),
			),

			'post_single_layout'    => array(
				'id'      => 'post_single_layout',
				'label'   => esc_html__( 'Single Post Layout', 'kayo' ),
				'type'    => 'select',
				'choices' => array(
					'sidebar-right' => esc_html__( 'Sidebar Right', 'kayo' ),
					'sidebar-left'  => esc_html__( 'Sidebar Left', 'kayo' ),
					'no-sidebar'    => esc_html__( 'No Sidebar', 'kayo' ),
					'fullwidth'     => esc_html__( 'Full width', 'kayo' ),
				),
			),

			'post_author_box'       => array(
				'id'      => 'post_author_box',
				'label'   => esc_html__( 'Single Post Author Box', 'kayo' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'kayo' ),
					'no'  => esc_html__( 'No', 'kayo' ),
				),
			),

			'post_related_posts'    => array(
				'id'      => 'post_related_posts',
				'label'   => esc_html__( 'Single Post Related Posts', 'kayo' ),
				'type'    => 'select',
				'choices' => array(
					'yes' => esc_html__( 'Yes', 'kayo' ),
					'no'  => esc_html__( 'No', 'kayo' ),
				),
			),

			'post_item_animation'   => array(
				'label'   => esc_html__( 'Blog Archive Item Animation', 'kayo' ),
				'id'      => 'post_item_animation',
				'type'    => 'select',
				'choices' => kayo_get_animations(),
			),

			'post_display_elements' => array(
				'id'          => 'post_display_elements',
				'label'       => esc_html__( 'Elements to show by default', 'kayo' ),
				'type'        => 'group_checkbox',
				'choices'     => array(
					'show_thumbnail'  => esc_html__( 'Thumbnail', 'kayo' ),
					'show_date'       => esc_html__( 'Date', 'kayo' ),
					'show_text'       => esc_html__( 'Text', 'kayo' ),
					'show_category'   => esc_html__( 'Category', 'kayo' ),
					'show_author'     => esc_html__( 'Author', 'kayo' ),
					'show_tags'       => esc_html__( 'Tags', 'kayo' ),
					'show_extra_meta' => esc_html__( 'Extra Meta', 'kayo' ),
				),
				'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'kayo' ),
			),
		),
	);

	if ( class_exists( 'Wolf_Custom_Post_Meta' ) ) {

		$mods['blog']['options'][] = array(
			'label'   => esc_html__( 'Enable Custom Post Meta', 'kayo' ),
			'id'      => 'enable_custom_post_meta',
			'type'    => 'group_checkbox',
			'choices' => array(
				'post_enable_views'        => esc_html__( 'Views', 'kayo' ),
				'post_enable_likes'        => esc_html__( 'Likes', 'kayo' ),
				'post_enable_reading_time' => esc_html__( 'Reading Time', 'kayo' ),
			),
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_post_mods' );
