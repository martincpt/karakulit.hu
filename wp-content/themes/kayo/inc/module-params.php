<?php
/**
 * Custom Post Types module parameters
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Wolf_Core' ) ) {
	return;
}

/**
 * Common parameters  usedacross post type modules
 */
function kayo_common_module_params( $animation_condition = array(), $post_count_condition = array() ) {

	/**
	 * Filters the common post module parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_common_module_params',
		array(
			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Index ID', 'kayo' ),
				'default'     => 'index-' . wp_rand( 0, 99999 ),
				'param_name'  => 'el_id',
				'description' => esc_html__( 'A unique identifier for the post module (required).', 'kayo' ),
			),
			array(
				'label'       => esc_html__( 'Animation', 'kayo' ),
				'param_name'  => 'item_animation',
				'type'        => 'select',
				'options'     => kayo_get_animations(),
				'default'     => 'none',
				'admin_label' => true,
				'condition'   => $animation_condition,
			),

			array(
				'label'       => esc_html__( 'Number of Posts', 'kayo' ),
				'param_name'  => 'posts_per_page',
				'type'        => 'text',
				'placeholder' => 9,
				'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
				'admin_label' => true,
				'condition'   => $post_count_condition,
			),

			array(
				'type'        => 'text',
				'label'       => esc_html__( 'Offset', 'kayo' ),
				'param_name'  => 'offset',
				'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'kayo' ),
				'group'       => esc_html__( 'Query', 'kayo' ),
				'admin_label' => true,
			),

			array(
				'label'       => esc_html__( 'Quick CSS', 'kayo' ),
				'description' => esc_html__( 'CSS inline style', 'kayo' ),
				'param_name'  => 'inline_style',
				'type'        => 'textarea',
				'group'       => esc_html__( 'Extra', 'kayo' ),
			),
		)
	);
}

/**
 * Overlay appearance parameters used across post type modules
 *
 * @param string $post_type The post type, duh.
 */
function kayo_overlay_module_params( $post_type ) {

	/**
	 * Filters the common post module overlay parameters
	 *
	 * For gallery type post type (gallery, release, work etc.)
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_overlay_module_params',
		array(
			/* Overlay Color for VC */
			array(
				'type'               => 'select',
				'label'              => esc_html__( 'Overlay Color', 'kayo' ),
				'param_name'         => 'overlay_color',
				'options'            => array_merge(
					array( 'auto' => esc_html__( 'Auto', 'kayo' ) ),
					kayo_shared_gradient_colors(),
					kayo_shared_colors(),
					array( 'custom' => esc_html__( 'Custom color', 'kayo' ) )
				),

				/**
				 * Filters the default item overlay color
				 *
				 * @since 1.0.0
				 */
				'default'            => apply_filters( 'wolf_core_default_item_overlay_color', 'black' ),
				'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
				'param_holder_class' => 'wolf_core_colored-select',
				'condition'          => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'page_builder'       => 'vc',
			),

			array(
				'type'         => 'colorpicker',
				'label'        => esc_html__( 'Overlay Custom Color', 'kayo' ),
				'param_name'   => 'overlay_custom_color',
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
					'overlay_color'        => array( 'custom' ),
				),
				'page_builder' => 'vc',
			),

			/* Overlay Color for Elementor */
			array(
				'label'        => esc_html__( 'Overlay Color', 'kayo' ),
				'type'         => 'select',
				'options'      => array_merge(
					array( 'auto' => esc_html__( 'Auto', 'kayo' ) ),
					kayo_shared_colors(),
					array( 'custom' => esc_html__( 'Custom color', 'kayo' ) )
				),
				'param_name'   => 'overlay_color',
				'default'      => 'auto',
				'page_builder' => 'elementor',
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'group'        => esc_html__( 'Style', 'kayo' ),
			),

			array(
				'type'         => 'colorpicker',
				'label'        => esc_html__( 'Overlay Color', 'kayo' ),
				'param_name'   => 'overlay_custom_color',
				'page_builder' => 'elementor',
				'selectors'    => array(
					'{{WRAPPER}} .bg-overlay' => 'background-color: {{VALUE}}!important;',
				),

				'group'        => esc_html__( 'Style', 'kayo' ),
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
					'overlay_color'        => array( 'custom' ),
				),
				'page_builder' => 'elementor',
			),

			/* Overlay Opacity */
			array(
				'type'         => 'slider',
				'label'        => esc_html__( 'Overlay Opacity', 'kayo' ),
				'param_name'   => 'overlay_opacity',
				'min'          => 0,
				'max'          => 1,
				'step'         => 0.01,

				/**
				 * Filters the default item overlay opacity
				 *
				 * @since 1.0.0
				 */
				'default'      => apply_filters( 'wolf_core_default_item_overlay_opacity', 40 ) / 100,
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'selectors'    => array(
					'{{WRAPPER}} .bg-overlay' => 'opacity: {{SIZE}}!important;',
				),
				'group'        => esc_html__( 'Style', 'kayo' ),
				'page_builder' => 'elementor',
			),

			array(
				'type'         => 'slider',
				'label'        => esc_html__( 'Overlay Opacity in Percent', 'kayo' ),
				'param_name'   => 'overlay_opacity',
				'min'          => 0,
				'max'          => 100,
				'step'         => 1,

				/**
				 * Filters the default item overlay opacity
				 *
				 * @since 1.0.0
				 */
				'default'      => apply_filters( 'wolf_core_default_item_overlay_opacity', 40 ),
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'group'        => esc_html__( 'Style', 'kayo' ),
				'page_builder' => 'vc',
			),

			/* Overlay Text Color for VC */
			array(
				'type'               => 'select',
				'label'              => esc_html__( 'Overlay Text Color', 'kayo' ),
				'param_name'         => 'overlay_text_color',
				'options'            => array_merge(
					array( 'auto' => esc_html__( 'Auto', 'kayo' ) ),
					kayo_shared_gradient_colors(),
					kayo_shared_colors(),
					array( 'custom' => esc_html__( 'Custom color', 'kayo' ) )
				),

				/**
				 * Filters the default item overlay color
				 *
				 * @since 1.0.0
				 */
				'default'            => apply_filters( 'wolf_core_default_item_overlay_color', 'black' ),
				'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
				'param_holder_class' => 'wolf_core_colored-select',
				'condition'          => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'page_builder'       => 'vc',
			),

			array(
				'type'         => 'colorpicker',
				'label'        => esc_html__( 'Overlay Custom Text Color', 'kayo' ),
				'param_name'   => 'overlay_text_custom_color',
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
					'overlay_text_color'   => array( 'custom' ),
				),
				'page_builder' => 'vc',
			),

			/* Overlay Text Color for Elementor */
			array(
				'label'        => esc_html__( 'Overlay Text Color', 'kayo' ),
				'type'         => 'hidden',
				'param_name'   => 'overlay_text_color',
				'default'      => 'custom',
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'page_builder' => 'elementor',
			),

			array(
				'type'         => 'colorpicker',
				'label'        => esc_html__( 'Overlay Text Color', 'kayo' ),
				'param_name'   => 'overlay_text_custom_color',
				'page_builder' => 'elementor',
				'selectors'    => array(
					'{{WRAPPER}} .entry-summary' => 'color: {{VALUE}}!important;',
				),
				'condition'    => array(
					$post_type . '_layout' => array( 'overlay' ),
				),
				'group'        => esc_html__( 'Style', 'kayo' ),
				'page_builder' => 'elementor',
			),
		)
	);
}

/**
 * Post Index
 */
function kayo_post_index_params() {

	/**
	 * Filters the post module parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_post_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Posts', 'kayo' ),
				'description'   => esc_html__( 'Display your posts using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_post_index',
				'el_base'       => 'post-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
			),

			'params'     => array_merge(
				kayo_common_module_params(),
				array(
					array(
						'param_name'  => 'post_display',
						'label'       => esc_html__( 'Post Display', 'kayo' ),
						'type'        => 'select',

						/**
						 * Filters the post display option parameters
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_post_display_options',
							array(
								'standard' => esc_html__( 'Standard', 'kayo' ),
								'grid'     => esc_html__( 'Grid', 'kayo' ),
							)
						),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'post_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'kayo' ),
						'type'        => 'select',
						'options'     => kayo_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'post_display' => array( 'metro_modern_alt', 'metro' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'   => 'post_alternate_thumbnail_position',
						'label'        => esc_html__( 'Alternate thumbnail position', 'kayo' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'no',
						'condition'    => array(
							'post_display' => array( 'lateral' ),
						),
					),

					array(
						'param_name'  => 'post_module',
						'label'       => esc_html__( 'Module', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'kayo' ),
							'carousel' => esc_html__( 'Carousel', 'kayo' ),
						),
						'description' => esc_html__( 'The carousel is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'post_display' => array( 'grid', 'grid_classic', 'grid_modern' ),
						),
					),

					array(
						'param_name' => 'post_excerpt_length',
						'label'      => esc_html__( 'Post Excerpt Lenght', 'kayo' ),
						'type'       => 'select',
						'options'    => array(
							'shorten' => esc_html__( 'Shorten', 'kayo' ),
							'full'    => esc_html__( 'Full', 'kayo' ),
						),
						'default'    => 'shorten',
						'condition'  => array(
							'post_display' => array( 'masonry' ),
						),
					),

					array(
						'param_name'   => 'post_display_elements',
						'label'        => esc_html__( 'Elements', 'kayo' ),
						'type'         => 'group_checkbox',
						'options'      => array(
							'show_thumbnail'  => esc_html__( 'Thumbnail', 'kayo' ),
							'show_date'       => esc_html__( 'Date', 'kayo' ),
							'show_text'       => esc_html__( 'Text', 'kayo' ),
							'show_category'   => esc_html__( 'Category', 'kayo' ),
							'show_author'     => esc_html__( 'Author', 'kayo' ),
							'show_tags'       => esc_html__( 'Tags', 'kayo' ),
							'show_extra_meta' => esc_html__( 'Extra Meta', 'kayo' ),
						),
						'default'      => 'show_thumbnail,show_date,show_text,show_author,show_category',
						'description'  => esc_html__( 'Note that some options may be ignored depending on the post display.', 'kayo' ),
						'admin_label'  => true,
						'page_builder' => 'vc',
					),

					array(
						'param_name'   => 'post_show_thumbnail',
						'label'        => esc_html__( 'Show Thumbnail', 'kayo' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_date',
						'label'        => esc_html__( 'Show Date', 'kayo' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_text',
						'label'        => esc_html__( 'Show Text', 'kayo' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_category',
						'label'        => esc_html__( 'Show Category', 'kayo' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_author',
						'label'        => esc_html__( 'Show Author', 'kayo' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'   => 'post_show_tags',
						'label'        => esc_html__( 'Show Tags', 'kayo' ),
						'type'         => 'checkbox',
						'default'      => 'yes',
						'page_builder' => 'elementor',
					),

					array(
						'param_name'  => 'post_excerpt_type',
						'label'       => esc_html__( 'Post Excerpt Type', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'auto'   => esc_html__( 'Auto', 'kayo' ),
							'manual' => esc_html__( 'Manual', 'kayo' ),
						),
						'default'     => 'auto',
						'description' => sprintf(
							kayo_kses(
								/* translators: %s: WP codex link */
								__( 'When using the manual excerpt, you must split your post using a "More Tag".', 'kayo' )
							),
							esc_url( 'https://en.support.wordpress.com/more-tag/' )
						),
						'condition'   => array(
							'post_display' => array( 'standard', 'standard_modern' ),
						),
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'kayo' ),
							'no'  => esc_html__( 'No', 'kayo' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'post_display' => array( 'grid', 'masonry', 'metro' ),
						),
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'kayo' ),
							'load_more'           => esc_html__( 'Load More', 'kayo' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
							'link_to_blog'        => esc_html__( 'Link to Blog Archives', 'kayo' ),
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'type'         => 'checkbox',
						'label'        => esc_html__( 'Ignore Sticky Posts', 'kayo' ),
						'param_name'   => 'ignore_sticky_posts',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'description'  => esc_html__( 'It will still include the sticky posts but it will not prioritize them in the query.', 'kayo' ),
						'group'        => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'         => 'checkbox',
						'label'        => esc_html__( 'Exclude Sticky Posts', 'kayo' ),
						'description'  => esc_html__( 'It will still exclude the sticky posts.', 'kayo' ),
						'param_name'   => 'exclude_sticky_posts',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'group'        => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Category', 'kayo' ),
						'param_name'  => 'category',
						'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Category by ID', 'kayo' ),
						'param_name'  => 'category_exclude',
						'description' => esc_html__( 'Exclude only one or several categories. Paste category ID(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( '456, 756', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Tags', 'kayo' ),
						'param_name'  => 'tag',
						'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-tag, other-tag', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Tags by ID', 'kayo' ),
						'param_name'  => 'tag_exclude',
						'description' => esc_html__( 'Exclude only one or several tags. Paste tag ID(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( '456, 756', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'kayo' ),
						'param_name'  => 'orderby',
						'options'     => kayo_order_by_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Select how to sort retrieved posts. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'kayo' ),
						'param_name'  => 'order',
						'options'     => kayo_order_way_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Designates the ascending or descending order. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'kayo' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'kayo' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							2 => esc_html__( 'Two', 'kayo' ),
							3 => esc_html__( 'Three', 'kayo' ),
							4 => esc_html__( 'Four', 'kayo' ),
							5 => esc_html__( 'Five', 'kayo' ),
							6 => esc_html__( 'Six', 'kayo' ),
							1 => esc_html__( 'One', 'kayo' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'post_display' => array( 'grid', 'grid_classic', 'masonry', 'masonry_modern' ),
						),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Extra class name', 'kayo' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'kayo' ),
						'group'       => esc_html__( 'Extra', 'kayo' ),
					),
				)
			),
		)
	);
}

/**
 * Release Index
 */
function kayo_release_index_params() {

	/**
	 * Filters the release post module parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_release_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Releases', 'kayo' ),
				'description'   => esc_html__( 'Display your releases using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_release_index',
				'el_base'       => 'release-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
			),

			'params'     => array_merge(
				kayo_common_module_params(
					/**
					 * Filters the release post animation condition
					 *
					 * Can the release post can be animated or not depending on its layout/display
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_release_animation_condition', array( 'release_display' => array( 'metro', 'grid', 'animated-panel' ) ) ),
					/**
					 * Filters the release post count condition
					 *
					 * Should we display the post count setting if the layout has a fix post count and don't allow it
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_release_post_count_condition', array( 'release_display' => array( 'metro', 'grid', 'animated-panel' ) ) )
				),
				array(
					array(
						'param_name'  => 'release_display',
						'label'       => esc_html__( 'Release Display', 'kayo' ),
						'type'        => 'select',

						/**
						 * Filters the release post display option
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_release_display_options',
							array(
								'grid' => esc_html__( 'Grid', 'kayo' ),
							)
						),
						'description' => esc_html__( 'The metro layout is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'release_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'kayo' ),
						'type'        => 'select',
						'options'     => kayo_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'release_display' => array( 'metro' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'   => 'release_alternate_thumbnail_position',
						'label'        => esc_html__( 'Alternate thumbnail position', 'kayo' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'condition'    => array(
							'release_display' => array( 'lateral' ),
						),
					),

					array(
						'param_name'  => 'release_layout',
						'label'       => esc_html__( 'Layout', 'kayo' ),
						'type'        => 'select',

						/**
						 * Filters the release post layout option
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_release_layout_options',
							array(
								'standard' => esc_html__( 'Classic', 'kayo' ),
								'overlay'  => esc_html__( 'Overlay', 'kayo' ),
							)
						),
						'default'     => 'standard',
						'admin_label' => true,
						'condition'   => array(
							'release_display' => array( 'grid', 'metro', 'masonry' ),
						),
					),

					array(
						'param_name'  => 'release_module',
						'label'       => esc_html__( 'Module', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'kayo' ),
							'carousel' => esc_html__( 'Carousel', 'kayo' ),
						),
						'description' => esc_html__( 'The carousel is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'release_display' => array( 'grid', 'animated_cover' ),
						),
					),

					array(
						'param_name'  => 'release_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '450x450',
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'kayo' ),
							'no'  => esc_html__( 'No', 'kayo' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'release_layout' => array( 'standard', 'overlay', 'label' ),
						),
					),
				),
				kayo_overlay_module_params( 'release' ),
				array(
					array(
						'label'        => esc_html__( 'Category Filter', 'kayo' ),
						'param_name'   => 'release_category_filter',
						'description'  => esc_html__( 'The pagination will be disabled.', 'kayo' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'admin_label'  => true,
						'condition'    => array(
							'release_display' => array( 'grid', 'animated_cover' ),
						),
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'release_category_filter_text_alignment',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'kayo' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'kayo' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'kayo' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'condition'    => array(
							'release_category_filter' => 'yes',
						),
						'selectors'    => array(
							'{{WRAPPER}} .category-filter-release ul' => 'text-align:{{VALUE}};',
						),
						'page_builder' => 'elementor',
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'release_category_filter_text_alignment',
						'type'         => 'select',
						'options'      => array(
							'center' => esc_html__( 'Center', 'kayo' ),
							'left'   => esc_html__( 'Left', 'kayo' ),
							'right'  => esc_html__( 'Right', 'kayo' ),
						),
						'condition'    => array(
							'release_category_filter' => 'yes',
						),
						'page_builder' => 'vc',
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'kayo' ),
							'load_more'           => esc_html__( 'Load More', 'kayo' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
							'link_to_discography' => esc_html__( 'Link to Discography', 'kayo' ),
						),
						'condition'   => array(
							'release_category_filter' => '',
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Band', 'kayo' ),
						'param_name'  => 'band_include',
						'description' => esc_html__( 'Enter one or several bands. Paste band slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-band, other-band', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Band', 'kayo' ),
						'param_name'  => 'band_exclude',
						'description' => esc_html__( 'Enter one or several bands. Paste band slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-band, other-band', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Type', 'kayo' ),
						'param_name'  => 'label_include',
						'description' => esc_html__( 'Enter one or several release types (from release tags). Paste type slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-type, other-type', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Type', 'kayo' ),
						'param_name'  => 'label_exclude',
						'description' => esc_html__( 'Enter one or several release types (from release tags). Paste type slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-type, other-type', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'kayo' ),
						'param_name'  => 'orderby',
						'options'     => kayo_order_by_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Select how to sort retrieved posts. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'kayo' ),
						'param_name'  => 'order',
						'options'     => kayo_order_way_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Designates the ascending or descending order. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'kayo' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'kayo' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'kayo' ),
							2         => esc_html__( 'Two', 'kayo' ),
							3         => esc_html__( 'Three', 'kayo' ),
							4         => esc_html__( 'Four', 'kayo' ),
							5         => esc_html__( 'Five', 'kayo' ),
							6         => esc_html__( 'Six', 'kayo' ),
							1         => esc_html__( 'One', 'kayo' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'release_display' => array( 'grid', 'animated_cover' ),
						),
					),
				)
			),
		)
	);
}

/**
 * Work Index
 */
function kayo_work_index_params() {

	/**
	 * Filters the work post parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_work_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Works', 'kayo' ),
				'description'   => esc_html__( 'Display your works using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_work_index',
				'el_base'       => 'work-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
				'scripts'       => array( 'inview' ),
			),

			'params'     => array_merge(
				kayo_common_module_params(
					/**
					 * Filters the work post animation condition
					 *
					 * Can the work post can be animated or not depending on its layout/display
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_work_animation_condition', array( 'work_display' => array( 'metro', 'grid', 'masonry' ) ) ),
					/**
					 * Filters the work post animation condition
					 *
					 * Can the work post can be animated or not depending on its layout/display
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_work_post_count_condition', array( 'work_display' => array( 'metro', 'grid', 'masonry' ) ) )
				),
				array(
					array(
						'param_name'  => 'work_display',
						'label'       => esc_html__( 'Work Display', 'kayo' ),
						'type'        => 'select',
						/**
						 * Work display option filtered
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_work_display_options',
							array(
								'grid' => esc_html__( 'Grid', 'kayo' ),
							)
						),
						'description' => esc_html__( 'The metro layout is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'work_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'kayo' ),
						'type'        => 'select',
						'options'     => kayo_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'work_display' => array( 'metro' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'   => 'work_alternate_thumbnail_position',
						'label'        => esc_html__( 'Alternate thumbnail position', 'kayo' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'condition'    => array(
							'work_display' => array( 'lateral' ),
						),
					),

					array(
						'param_name'  => 'work_layout',
						'label'       => esc_html__( 'Layout', 'kayo' ),
						'type'        => 'select',
						/**
						 * Filters the work post layout option
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_work_layout_options',
							array(
								'standard' => esc_html__( 'Classic', 'kayo' ),
								'overlay'  => esc_html__( 'Overlay', 'kayo' ),
							)
						),
						'default'     => 'standard',
						'admin_label' => true,
						'condition'   => array(
							'work_display' => array( 'grid', 'metro', 'masonry' ),
						),
					),

					array(
						'param_name'  => 'work_module',
						'label'       => esc_html__( 'Module', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'kayo' ),
							'carousel' => esc_html__( 'Carousel', 'kayo' ),
						),
						'description' => esc_html__( 'The carousel is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'work_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'work_thumbnail_size',
						'label'       => esc_html__( 'Thumbnail Size', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'standard'  => esc_html__( 'Default Thumbnail', 'kayo' ),
							'landscape' => esc_html__( 'Landscape', 'kayo' ),
							'square'    => esc_html__( 'Square', 'kayo' ),
							'portrait'  => esc_html__( 'Portrait', 'kayo' ),
							'custom'    => esc_html__( 'Custom', 'kayo' ),
						),
						'default'     => 'standard',
						'admin_label' => true,
						'condition'   => array(
							'work_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'work_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '450x450',
						'condition'   => array(
							'work_thumbnail_size' => array( 'custom' ),
						),
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'kayo' ),
							'no'  => esc_html__( 'No', 'kayo' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'work_display' => array( 'grid', 'metro', 'masonry' ),
						),
					),
					/*
					array(
						'param_name' => 'grid_padding_value',
						'label'      => esc_html__( 'Padding', 'kayo' ),
						'type'       => 'slider',
						'default'    => array(
							'unit' => array( 'px', '%' ),
							'size' => '20',
						),
						'selectors'   => array(
							'{{WRAPPER}} .entry-work' => 'padding:{{VALUE}};',
						),
						'size_units' => 'px',
						'condition'  => array(
							'grid_padding' => array( 'yes' ),
						),
					),
					*/
				),
				kayo_overlay_module_params( 'work' ),
				array(
					array(
						'label'        => esc_html__( 'Category Filter', 'kayo' ),
						'param_name'   => 'work_category_filter',
						'description'  => esc_html__( 'The pagination will be disabled.', 'kayo' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'admin_label'  => true,
						'condition'    => array(
							'work_display' => array( 'grid', 'masonry' ),
						),
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'work_category_filter_text_alignment',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'kayo' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'kayo' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'kayo' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'condition'    => array(
							'work_category_filter' => 'yes',
						),
						'selectors'    => array(
							'{{WRAPPER}} .category-filter-work ul' => 'text-align:{{VALUE}};',
						),
						'page_builder' => 'elementor',
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'work_category_filter_text_alignment',
						'type'         => 'select',
						'options'      => array(
							'center' => esc_html__( 'Center', 'kayo' ),
							'left'   => esc_html__( 'Left', 'kayo' ),
							'right'  => esc_html__( 'Right', 'kayo' ),
						),
						'condition'    => array(
							'work_category_filter' => 'yes',
						),
						'page_builder' => 'vc',
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'kayo' ),
							'load_more'           => esc_html__( 'Load More', 'kayo' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
							'link_to_portfolio'   => esc_html__( 'Link to Portfolio', 'kayo' ),
						),
						'condition'   => array(
							'work_category_filter' => '',
							'work_display'         => array( 'grid', 'masonry', 'metro' ),
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Category', 'kayo' ),
						'param_name'  => 'work_type_include',
						'description' => esc_html__( 'Enter one or several work categories (from work tags). Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'category'    => 'text',
						'label'       => esc_html__( 'Exclude Category', 'kayo' ),
						'param_name'  => 'work_type_exclude',
						'description' => esc_html__( 'Enter one or several work categories (from work tags). Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Format', 'kayo' ),
						'param_name'  => 'work_post_format_include',
						'description' => esc_html__( 'Enter one or several post format. Paste slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'gallery, video', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'category'    => 'text',
						'label'       => esc_html__( 'Exclude Format', 'kayo' ),
						'param_name'  => 'work_post_format_exclude',
						'description' => esc_html__( 'Enter one or several post format. Paste slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'gallery, video', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'kayo' ),
						'param_name'  => 'orderby',
						'options'     => kayo_order_by_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Select how to sort retrieved posts. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'kayo' ),
						'param_name'  => 'order',
						'options'     => kayo_order_way_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Designates the ascending or descending order. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'kayo' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'kayo' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'kayo' ),
							2         => esc_html__( 'Two', 'kayo' ),
							3         => esc_html__( 'Three', 'kayo' ),
							4         => esc_html__( 'Four', 'kayo' ),
							5         => esc_html__( 'Five', 'kayo' ),
							6         => esc_html__( 'Six', 'kayo' ),
							1         => esc_html__( 'One', 'kayo' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'work_display' => array( 'grid', 'masonry' ),
						),
					),
				)
			),
		)
	);
}


/**
 * Product Index
 */
function kayo_product_index_params() {
	/**
	 * Filters the product post parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_product_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Products', 'kayo' ),
				'description'   => esc_html__( 'Display your products using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_product_index',
				'el_base'       => 'product-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
			),

			'params'     => array_merge(
				kayo_common_module_params(),
				array(
					array(
						'param_name'  => 'product_display',
						'label'       => esc_html__( 'Post Display', 'kayo' ),
						'type'        => 'select',
						/**
						 * Filters the product post display option
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_product_display_options',
							array(
								'grid' => esc_html__( 'Grid', 'kayo' ),
							)
						),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'kayo' ),
						'type'        => 'select',
						'options'     => kayo_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'product_display' => array( 'metro' ),
						),
						'admin_label' => true,
					),

					/*
					array(
						'label'        => esc_html__( 'Product Text Alignement', 'kayo' ),
						'param_name'   => 'product_text_align',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'kayo' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'kayo' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'kayo' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'selectors'    => array(
							'{{WRAPPER}} .entry-product' => 'margin-{{VALUE}}: 0;',
						),
						'page_builder' => 'elementor',
					),*/

					/*
					array(
						'type'         => 'select',
						'label'        => esc_html__( 'Product Text Alignement', 'kayo' ),
						'param_name'   => 'product_text_align',
						'options'      => array(
							'center' => esc_html__( 'Center', 'kayo' ),
							'left'   => esc_html__( 'Left', 'kayo' ),
							'right'  => esc_html__( 'Right', 'kayo' ),
						),
						'page_builder' => 'vc',
					),*/

					array(
						'param_name'  => 'product_meta',
						'label'       => esc_html__( 'Type', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'all'          => esc_html__( 'All', 'kayo' ),
							'featured'     => esc_html__( 'Featured', 'kayo' ),
							'onsale'       => esc_html__( 'On Sale', 'kayo' ),
							'best_selling' => esc_html__( 'Best Selling', 'kayo' ),
							'top_rated'    => esc_html__( 'Top Rated', 'kayo' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_module',
						'label'       => esc_html__( 'Module', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'kayo' ),
							'carousel' => esc_html__( 'Carousel', 'kayo' ),
						),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'product_display' => array( 'grid', 'grid_classic', 'grid_modern', 'disc', 'gallery' ),
						),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'kayo' ),
							2         => esc_html__( 'Two', 'kayo' ),
							3         => esc_html__( 'Three', 'kayo' ),
							4         => esc_html__( 'Four', 'kayo' ),
							5         => esc_html__( 'Five', 'kayo' ),
							6         => esc_html__( 'Six', 'kayo' ),
							1         => esc_html__( 'One', 'kayo' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'product_display' => array( 'grid', 'disc', 'gallery' ),
						),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Category', 'kayo' ),
						'param_name'  => 'product_cat',
						'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'kayo' ),
							'no'  => esc_html__( 'No', 'kayo' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'product_display' => array( 'grid', 'masonry', 'metro', 'disc', 'gallery' ),
						),
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'none'                  => esc_html__( 'None', 'kayo' ),
							'load_more'             => esc_html__( 'Load More', 'kayo' ),
							'standard_pagination'   => esc_html__( 'Numeric Pagination', 'kayo' ),
							'link_to_shop_category' => esc_html__( 'Link to Category', 'kayo' ),
							'link_to_shop'          => esc_html__( 'Link to Shop Archive', 'kayo' ),
						),
						'default'     => 'none',
						'admin_label' => true,

					),

					array(
						'param_name'  => 'view_more_text',
						'label'       => esc_html__( '"View more" Pagination Text', 'kayo' ),
						'type'        => 'text',
						'default'     => '',
						'condition'   => array(
							'pagination' => array( 'link_to_shop_category', 'link_to_shop' ),
						),
						'placeholder' => esc_html__( 'View more products', 'kayo' ),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_category_link_id',
						'label'       => esc_html__( 'Category Link', 'kayo' ),
						'type'        => 'select',
						'options'     => kayo_get_product_cat_dropdown_options(),
						'condition'   => array(
							'pagination' => array( 'link_to_shop_category' ),
						),
						'admin_label' => true,
					),
				)
			),
		)
	);
}

/**
 * Artist Index
 */
function kayo_artist_index_params() {
	/**
	 * Filters the artist post parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_artist_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Artists', 'kayo' ),
				'description'   => esc_html__( 'Display your artists using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_artist_index',
				'el_base'       => 'artist-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
			),

			'params'     => array_merge(
				kayo_common_module_params(
					/**
					 * Filters the artist post animation condition
					 *
					 * Can the artist post can be animated or not depending on its layout/display
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_artist_animation_condition', array( 'artist_display' => array( 'metro', 'grid', 'masonry' ) ) ),
					/**
					 * Filters the artist post animation condition
					 *
					 * Can the artist post can be animated or not depending on its layout/display
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_artist_post_count_condition', array( 'artist_display' => array( 'metro', 'grid', 'masonry' ) ) )
				),
				array(

					array(
						'param_name'  => 'artist_display',
						'label'       => esc_html__( 'Artist Display', 'kayo' ),
						'type'        => 'select',
						/**
						 * Filters the artist display options
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_artist_display_options',
							array(
								'list' => esc_html__( 'List', 'kayo' ),
							)
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'artist_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'kayo' ),
						'type'        => 'select',
						'options'     => kayo_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'artist_display' => 'metro',
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'artist_module',
						'label'       => esc_html__( 'Module', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'kayo' ),
							'carousel' => esc_html__( 'Carousel', 'kayo' ),
						),
						'description' => esc_html__( 'The carousel is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'artist_display' => array( 'grid' ),
						),
					),

					'artist_thumbnail_size' => array(
						'param_name'  => 'artist_thumbnail_size',
						'label'       => esc_html__( 'Thumbnail Size', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'standard'  => esc_html__( 'Default Thumbnail', 'kayo' ),
							'landscape' => esc_html__( 'Landscape', 'kayo' ),
							'square'    => esc_html__( 'Square', 'kayo' ),
							'portrait'  => esc_html__( 'Portrait', 'kayo' ),
							'custom'    => esc_html__( 'Custom', 'kayo' ),
						),
						'admin_label' => true,
						'condition'   => array(
							'artist_display' => array( 'grid', 'offgrid', ),
						),
					),

					array(
						'param_name'  => 'artist_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '415x230',
						'condition'   => array(
							'artist_thumbnail_size' => 'custom',
						),
					),

					array(
						'param_name'  => 'artist_layout',
						'label'       => esc_html__( 'Layout', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'standard' => esc_html__( 'Classic', 'kayo' ),
							'overlay'  => esc_html__( 'Overlay', 'kayo' ),
						),
						'admin_label' => true,
						'condition'   => array(
							'artist_display' => array( 'grid', 'masonry', 'metro' ),
						),
						'description' => esc_html__( 'The metro layout is not visible in preview mode yet.', 'kayo' ),
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'kayo' ),
							'no'  => esc_html__( 'No', 'kayo' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'artist_display!' => array( 'interactive-link' ),
						),
					),

					array(
						'label'      => esc_html__( 'Caption Text Alignement', 'kayo' ),
						'param_name' => 'caption_text_alignment',
						'type'       => 'select',
						'options'    => array(
							esc_html__( 'Center', 'kayo' ) => 'center',
							esc_html__( 'Left', 'kayo' ) => 'left',
							esc_html__( 'Right', 'kayo' ) => 'right',
						),
						'condition'  => array(
							'element'            => 'artist_display',
							'value_not_equal_to' => array( 'list_minimal' ),
						),
					),

					array(
						'label'      => esc_html__( 'Caption Vertical Alignement', 'kayo' ),
						'param_name' => 'caption_v_align',
						'type'       => 'select',
						'options'    => array(
							esc_html__( 'Middle', 'kayo' ) => 'middle',
							esc_html__( 'Bottom', 'kayo' ) => 'bottom',
							esc_html__( 'Top', 'kayo' ) => 'top',
						),
						'condition'  => array(
							'element'            => 'artist_display',
							'value_not_equal_to' => array( 'list_minimal' ),
						),
					),

				),
				kayo_overlay_module_params( 'artist' ),
				array(
					array(
						'label'        => esc_html__( 'Category Filter', 'kayo' ),
						'param_name'   => 'artist_category_filter',
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'no',
						'admin_label'  => true,
						'description'  => esc_html__( 'The pagination will be disabled.', 'kayo' ),
						'condition'    => array(
							'artist_display!' => apply_filters( 'kayo_artist_category_filter_exclude_condition', array( 'interactive-link' ) ),
						),
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'artist_category_filter_text_alignment',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'kayo' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'kayo' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'kayo' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'selectors'    => array(
							'{{WRAPPER}} .category-filter-artist ul' => 'text-align:{{VALUE}};',
						),
						'condition'    => array(
							'artist_category_filter' => 'yes',
						),
						'page_builder' => 'elementor',
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'artist_category_filter_text_alignment',
						'type'         => 'select',
						'options'      => array(
							'center' => esc_html__( 'Center', 'kayo' ),
							'left'   => esc_html__( 'Left', 'kayo' ),
							'right'  => esc_html__( 'Right', 'kayo' ),
						),
						'condition'    => array(
							'artist_category_filter' => 'yes',
						),
						'page_builder' => 'vc',
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'kayo' ),
							'load_more'           => esc_html__( 'Load More', 'kayo' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
							'link_to_artists'     => esc_html__( 'Link to Archives', 'kayo' ),
						),

						'condition'   => array(
							'artist_category_filter' => '',
							'artist_display!' => apply_filters( 'kayo_artist_pagination_exclude_condition', array( 'interactive-link' ) ),
						),
						'admin_label' => true,
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Category', 'kayo' ),
						'param_name'  => 'artist_genre_include',
						'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Category', 'kayo' ),
						'param_name'  => 'artist_genre_exclude',
						'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'kayo' ),
						'param_name'  => 'orderby',
						'options'     => kayo_order_by_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Select how to sort retrieved posts. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'kayo' ),
						'param_name'  => 'order',
						'options'     => kayo_order_way_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Designates the ascending or descending order. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'kayo' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'kayo' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'kayo' ),
							2         => esc_html__( 'Two', 'kayo' ),
							3         => esc_html__( 'Three', 'kayo' ),
							4         => esc_html__( 'Four', 'kayo' ),
							5         => esc_html__( 'Five', 'kayo' ),
							6         => esc_html__( 'Six', 'kayo' ),
							1         => esc_html__( 'One', 'kayo' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'artist_display' => array( 'grid', 'masonry' ),
						),
					),
				)
			),
		)
	);
}

/**
 * Photo Album Index
 */
function kayo_album_index_params() {
	/**
	 * Filters the gallery/albums parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_album_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Photo Albums', 'kayo' ),
				'description'   => esc_html__( 'Display your albums using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_album_index',
				'el_base'       => 'album-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
			),

			'params'     => array_merge(
				kayo_common_module_params(),
				array()
			),
		)
	);
}

/**
 * Video Index
 */
function kayo_video_index_params() {
	/**
	 * Filters the video parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_video_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Videos', 'kayo' ),
				'description'   => esc_html__( 'Display your videos using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_video_index',
				'el_base'       => 'video-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
			),

			'params'     => array_merge(
				kayo_common_module_params(),
				array(

					array(
						'label'        => esc_html__( 'Show video on hover', 'kayo' ),
						'description'  => esc_html__( 'It is recommended to set upload a video sample mp4 file in your video post options below the text editor.', 'kayo' ),
						'param_name'   => 'video_preview',
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'admin_label'  => true,
					),

					array(
						'param_name'  => 'video_module',
						'label'       => esc_html__( 'Module', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'kayo' ),
							'carousel' => esc_html__( 'Carousel', 'kayo' ),
						),
						'description' => esc_html__( 'The carousel is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'video_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '415x230',
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'kayo' ),
							'no'  => esc_html__( 'No', 'kayo' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'video_onclick',
						'label'       => esc_html__( 'On Click', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'lightbox' => esc_html__( 'Open Video in Lightbox', 'kayo' ),
							'default'  => esc_html__( 'Go to the Video Page', 'kayo' ),
						),
						'default'     => 'lightbox',
						'admin_label' => true,
					),

					array(
						'label'        => esc_html__( 'Category Filter', 'kayo' ),
						'param_name'   => 'video_category_filter',
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'admin_label'  => true,
						'description'  => esc_html__( 'The pagination will be disabled.', 'kayo' ),
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'video_category_filter_text_alignment',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'kayo' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'kayo' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'kayo' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'selectors'    => array(
							'{{WRAPPER}} .category-filter-video ul' => 'text-align:{{VALUE}};',
						),
						'condition'    => array(
							'video_category_filter' => 'yes',
						),
						'page_builder' => 'elementor',
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'video_category_filter_text_alignment',
						'type'         => 'select',
						'options'      => array(
							'center' => esc_html__( 'Center', 'kayo' ),
							'left'   => esc_html__( 'Left', 'kayo' ),
							'right'  => esc_html__( 'Right', 'kayo' ),
						),
						'condition'    => array(
							'video_category_filter' => 'yes',
						),
						'page_builder' => 'vc',
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'kayo' ),
							'load_more'           => esc_html__( 'Load More', 'kayo' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
							'link_to_videos'      => esc_html__( 'Link to Video Archives', 'kayo' ),
						),
						'condition'   => array(
							'video_category_filter' => '',
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'video_category_link_id',
						'label'       => esc_html__( 'Category', 'kayo' ),
						'type'        => 'select',
						'options'     => kayo_get_video_cat_dropdown_options(),
						'condition'   => array(
							'pagination' => 'link_to_video_category',
						),
						'admin_label' => true,
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Category', 'kayo' ),
						'param_name'  => 'video_type_include',
						'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Category', 'kayo' ),
						'param_name'  => 'video_type_exclude',
						'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Tag', 'kayo' ),
						'param_name'  => 'video_tag_include',
						'description' => esc_html__( 'Enter one or several tags. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-tag, other-tag', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Tag', 'kayo' ),
						'param_name'  => 'video_tag_exclude',
						'description' => esc_html__( 'Enter one or several tags. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-tag, other-tag', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'kayo' ),
						'param_name'  => 'orderby',
						'options'     => kayo_order_by_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Select how to sort retrieved posts. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'kayo' ),
						'param_name'  => 'order',
						'options'     => kayo_order_way_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Designates the ascending or descending order. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'kayo' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'kayo' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'kayo' ),
							2         => esc_html__( 'Two', 'kayo' ),
							3         => esc_html__( 'Three', 'kayo' ),
							4         => esc_html__( 'Four', 'kayo' ),
							5         => esc_html__( 'Five', 'kayo' ),
							6         => esc_html__( 'Six', 'kayo' ),
							1         => esc_html__( 'One', 'kayo' ),
						),
						'default'     => 3,
						'admin_label' => true,
					),
				)
			),
		)
	);
}

/**
 * Event Index
 */
function kayo_event_index_params() {
	/**
	 * Filters the event parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_event_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Events', 'kayo' ),
				'description'   => esc_html__( 'Display your events using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_event_index',
				'el_base'       => 'event-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
			),

			'params'     => array_merge(
				kayo_common_module_params(),
				array(
					array(
						'param_name'  => 'event_display',
						'label'       => esc_html__( 'Event Display', 'kayo' ),
						'type'        => 'select',
						/**
						 * Filters the event display option
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_event_display_options',
							array(
								'list' => esc_html__( 'List', 'kayo' ),
							)
						),
						'default'     => 'list',
						'admin_label' => true,
					),

					array(
						'param_name' => 'event_layout',
						'label'      => esc_html__( 'Event Layout', 'kayo' ),
						'type'       => 'hidden',
						'default'    => 'overlay',
					),

					array(
						'param_name'  => 'event_module',
						'label'       => esc_html__( 'Module', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'kayo' ),
							'carousel' => esc_html__( 'Carousel', 'kayo' ),
						),
						'description' => esc_html__( 'The carousel is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'event_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'event_thumbnail_size',
						'label'       => esc_html__( 'Thumbnail Size', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'standard'  => esc_html__( 'Default Thumbnail', 'kayo' ),
							'landscape' => esc_html__( 'Landscape', 'kayo' ),
							'square'    => esc_html__( 'Square', 'kayo' ),
							'portrait'  => esc_html__( 'Portrait', 'kayo' ),
							'custom'    => esc_html__( 'Custom', 'kayo' ),
						),
						'default'     => 'standard',
						'admin_label' => true,
						'condition'   => array(
							'event_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'event_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '415x230',
						'condition'   => array(
							'event_thumbnail_size' => 'custom',
						),
					),
				),
				kayo_overlay_module_params( 'event' ),
				array(
					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'kayo' ),
							'no'  => esc_html__( 'No', 'kayo' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'event_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'kayo' ),
							2         => esc_html__( 'Two', 'kayo' ),
							3         => esc_html__( 'Three', 'kayo' ),
							4         => esc_html__( 'Four', 'kayo' ),
							5         => esc_html__( 'Five', 'kayo' ),
							6         => esc_html__( 'Six', 'kayo' ),
							1         => esc_html__( 'One', 'kayo' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'event_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'event_location',
						'label'       => esc_html__( 'Location', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'location' => esc_html__( 'Location', 'kayo' ),
							'venue'    => esc_html__( 'Venue', 'kayo' ),
						),
						'default'     => 'location',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'none'           => esc_html__( 'None', 'kayo' ),
							'link_to_events' => esc_html__( 'Link to Event Archives', 'kayo' ),
						),
						'default'     => 'link_to_events',
						'admin_label' => true,
					),

					array(
						'type'       => 'select',
						'label'      => esc_html__( 'Timeline', 'kayo' ),
						'param_name' => 'timeline',
						'options'    => array(
							'future' => esc_html__( 'Future', 'kayo' ),
							'past'   => esc_html__( 'Past', 'kayo' ),
						),
						'default'    => 'future',
						'group'      => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Artist', 'kayo' ),
						'param_name'  => 'artist_include',
						'description' => esc_html__( 'Enter one or several bands. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Artist', 'kayo' ),
						'param_name'  => 'artist_exclude',
						'description' => esc_html__( 'Enter one or several bands. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),
				)
			),
		)
	);
}


/**
 * Gallery Index
 */
function kayo_gallery_index_params() {

	/**
	 * Filters the gallery post parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_gallery_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Gallery', 'kayo' ),
				'description'   => esc_html__( 'Display your gallerys using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_gallery_index',
				'el_base'       => 'gallery-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
				'scripts'       => array( 'inview' ),
			),

			'params'     => array_merge(
				kayo_common_module_params(
					/**
					 * Filters the gallery post animation condition
					 *
					 * Can the gallery post can be animated or not depending on its layout/display
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_gallery_animation_condition', array( 'gallery_display' => array( 'metro', 'grid', 'masonry' ) ) ),
					/**
					 * Filters the gallery post animation condition
					 *
					 * Can the gallery post can be animated or not depending on its layout/display
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_gallery_post_count_condition', array( 'gallery_display' => array( 'metro', 'grid', 'masonry' ) ) )
				),
				array(
					array(
						'param_name'  => 'gallery_display',
						'label'       => esc_html__( 'Gallery Display', 'kayo' ),
						'type'        => 'select',
						/**
						 * Gallery display option filtered
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_gallery_display_options',
							array(
								'grid' => esc_html__( 'Grid', 'kayo' ),
								'masonry' => esc_html__( 'Metro', 'kayo' ),
							)
						),
						'description' => esc_html__( 'The metro layout is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'gallery_metro_pattern',
						'label'       => esc_html__( 'Metro Pattern', 'kayo' ),
						'type'        => 'select',
						'options'     => kayo_get_metro_patterns(),
						'default'     => 'auto',
						'condition'   => array(
							'gallery_display' => array( 'metro' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'gallery_layout',
						'label'       => esc_html__( 'Layout', 'kayo' ),
						'type'        => 'select',
						/**
						 * Filters the gallery post layout option
						 *
						 * @since 1.0.0
						 */
						'options'     => apply_filters(
							'kayo_gallery_layout_options',
							array(
								'standard' => esc_html__( 'Classic', 'kayo' ),
								'overlay'  => esc_html__( 'Overlay', 'kayo' ),
							)
						),
						'default'     => 'standard',
						'admin_label' => true,
						'condition'   => array(
							'gallery_display' => array( 'grid', 'metro', 'masonry' ),
						),
					),

					array(
						'param_name'  => 'gallery_module',
						'label'       => esc_html__( 'Module', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'grid'     => esc_html__( 'Grid', 'kayo' ),
							'carousel' => esc_html__( 'Carousel', 'kayo' ),
						),
						'description' => esc_html__( 'The carousel is not visible in preview mode yet.', 'kayo' ),
						'default'     => 'grid',
						'admin_label' => true,
						'condition'   => array(
							'gallery_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'gallery_thumbnail_size',
						'label'       => esc_html__( 'Thumbnail Size', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'standard'  => esc_html__( 'Default Thumbnail', 'kayo' ),
							'landscape' => esc_html__( 'Landscape', 'kayo' ),
							'square'    => esc_html__( 'Square', 'kayo' ),
							'portrait'  => esc_html__( 'Portrait', 'kayo' ),
							'custom'    => esc_html__( 'Custom', 'kayo' ),
						),
						'default'     => 'standard',
						'admin_label' => true,
						'condition'   => array(
							'gallery_display' => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'gallery_custom_thumbnail_size',
						'label'       => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
						'type'        => 'text',
						'admin_label' => true,
						'placeholder' => '450x450',
						'condition'   => array(
							'gallery_thumbnail_size' => array( 'custom' ),
						),
					),

					array(
						'param_name'  => 'grid_padding',
						'label'       => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'yes' => esc_html__( 'Yes', 'kayo' ),
							'no'  => esc_html__( 'No', 'kayo' ),
						),
						'default'     => 'yes',
						'admin_label' => true,
						'condition'   => array(
							'gallery_display' => array( 'grid', 'metro', 'masonry' ),
						),
					),
					/*
					array(
						'param_name' => 'grid_padding_value',
						'label'      => esc_html__( 'Padding', 'kayo' ),
						'type'       => 'slider',
						'default'    => array(
							'unit' => array( 'px', '%' ),
							'size' => '20',
						),
						'selectors'   => array(
							'{{WRAPPER}} .entry-gallery' => 'padding:{{VALUE}};',
						),
						'size_units' => 'px',
						'condition'  => array(
							'grid_padding' => array( 'yes' ),
						),
					),
					*/
				),
				kayo_overlay_module_params( 'gallery' ),
				array(
					array(
						'label'        => esc_html__( 'Category Filter', 'kayo' ),
						'param_name'   => 'gallery_category_filter',
						'description'  => esc_html__( 'The pagination will be disabled.', 'kayo' ),
						'type'         => 'checkbox',
						'label_on'     => esc_html__( 'Yes', 'kayo' ),
						'label_off'    => esc_html__( 'No', 'kayo' ),
						'return_value' => 'yes',
						'admin_label'  => true,
						'condition'    => array(
							'gallery_display' => array( 'grid', 'masonry' ),
						),
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'gallery_category_filter_text_alignment',
						'type'         => 'choose',
						'options'      => array(
							'left'   => array(
								'title' => esc_html__( 'Left', 'kayo' ),
								'icon'  => 'eicon-text-align-left',
							),
							'center' => array(
								'title' => esc_html__( 'Center', 'kayo' ),
								'icon'  => 'eicon-text-align-center',
							),
							'right'  => array(
								'title' => esc_html__( 'Right', 'kayo' ),
								'icon'  => 'eicon-text-align-right',
							),
						),
						'condition'    => array(
							'gallery_category_filter' => 'yes',
						),
						'selectors'    => array(
							'{{WRAPPER}} .category-filter-gallery ul' => 'text-align:{{VALUE}};',
						),
						'page_builder' => 'elementor',
					),

					array(
						'label'        => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name'   => 'gallery_category_filter_text_alignment',
						'type'         => 'select',
						'options'      => array(
							'center' => esc_html__( 'Center', 'kayo' ),
							'left'   => esc_html__( 'Left', 'kayo' ),
							'right'  => esc_html__( 'Right', 'kayo' ),
						),
						'condition'    => array(
							'gallery_category_filter' => 'yes',
						),
						'page_builder' => 'vc',
					),

					array(
						'param_name'  => 'pagination',
						'label'       => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'none'                => esc_html__( 'None', 'kayo' ),
							'load_more'           => esc_html__( 'Load More', 'kayo' ),
							'standard_pagination' => esc_html__( 'Numeric Pagination', 'kayo' ),
							'link_to_portfolio'   => esc_html__( 'Link to Portfolio', 'kayo' ),
						),
						'condition'   => array(
							'gallery_category_filter' => '',
							'gallery_display'         => array( 'grid', 'masonry', 'metro' ),
						),
						'default'     => 'none',
						'admin_label' => true,
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Category', 'kayo' ),
						'param_name'  => 'gallery_type_include',
						'description' => esc_html__( 'Enter one or several gallery categories (from gallery tags). Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'category'    => 'text',
						'label'       => esc_html__( 'Exclude Category', 'kayo' ),
						'param_name'  => 'gallery_type_exclude',
						'description' => esc_html__( 'Enter one or several gallery categories (from gallery tags). Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Include Format', 'kayo' ),
						'param_name'  => 'gallery_post_format_include',
						'description' => esc_html__( 'Enter one or several post format. Paste slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'gallery, video', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'category'    => 'text',
						'label'       => esc_html__( 'Exclude Format', 'kayo' ),
						'param_name'  => 'gallery_post_format_exclude',
						'description' => esc_html__( 'Enter one or several post format. Paste slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'gallery, video', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Order by', 'kayo' ),
						'param_name'  => 'orderby',
						'options'     => kayo_order_by_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Select how to sort retrieved posts. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'select',
						'label'       => esc_html__( 'Sort order', 'kayo' ),
						'param_name'  => 'order',
						'options'     => kayo_order_way_values(),
						'save_always' => true,
						'description' => sprintf(
							kayo_kses(
							/* translators: %s: WP codex page title */
								__( 'Designates the ascending or descending order. More at %s.', 'kayo' )
							),
							'WordPress codex page'
						),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Post IDs', 'kayo' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'text',
						'label'       => esc_html__( 'Exclude Post IDs', 'kayo' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'columns',
						'label'       => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'select',
						'options'     => array(
							'default' => esc_html__( 'Auto', 'kayo' ),
							2         => esc_html__( 'Two', 'kayo' ),
							3         => esc_html__( 'Three', 'kayo' ),
							4         => esc_html__( 'Four', 'kayo' ),
							5         => esc_html__( 'Five', 'kayo' ),
							6         => esc_html__( 'Six', 'kayo' ),
							1         => esc_html__( 'One', 'kayo' ),
						),
						'default'     => 3,
						'admin_label' => true,
						'condition'   => array(
							'gallery_display' => array( 'grid', 'masonry' ),
						),
					),
				)
			),
		)
	);
}

/**
 * Page Index
 */
function kayo_page_index_params() {
	/**
	 * Filters the page parameters
	 *
	 * @since 1.0.0
	 */
	return apply_filters(
		'kayo_page_index_params',
		array(
			'properties' => array(
				'name'          => esc_html__( 'Pages', 'kayo' ),
				'description'   => esc_html__( 'Display your pages using the theme layouts', 'kayo' ),
				'vc_base'       => 'wolf_core_page_index',
				'el_base'       => 'page-index',
				'vc_category'   => esc_html__( 'Content', 'kayo' ),
				'el_categories' => array( 'post-modules' ),
				'icon'          => 'linea-arrows linea-arrows-squares',
				'weight'        => 999,
			),

			'params'     => array_merge(
				kayo_common_module_params(),
				array()
			),
		)
	);
}
