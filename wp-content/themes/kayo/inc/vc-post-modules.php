<?php // phpcs:ignore
/**
 * WPBakery Page Builder post modules (old version for Wolf Visual Composer plugin)
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( ! defined( 'ABSPATH' ) || ! class_exists( 'Wolf_Visual_Composer' ) || ! defined( 'WPB_VC_VERSION' ) ) {
	return;
}

$order_by_values = array(
	'',
	esc_html__( 'Date', 'kayo' )          => 'date',
	esc_html__( 'ID', 'kayo' )            => 'ID',
	esc_html__( 'Author', 'kayo' )        => 'author',
	esc_html__( 'Title', 'kayo' )         => 'title',
	esc_html__( 'Modified', 'kayo' )      => 'modified',
	esc_html__( 'Random', 'kayo' )        => 'rand',
	esc_html__( 'Comment count', 'kayo' ) => 'comment_count',
	esc_html__( 'Menu order', 'kayo' )    => 'menu_order',
);

$order_way_values = array(
	'',
	esc_html__( 'Descending', 'kayo' ) => 'DESC',
	esc_html__( 'Ascending', 'kayo' )  => 'ASC',
);

$shared_gradient_colors = ( function_exists( 'wvc_get_shared_gradient_colors' ) ) ? wvc_get_shared_gradient_colors() : array();
$shared_colors          = ( function_exists( 'wvc_get_shared_colors' ) ) ? wvc_get_shared_colors() : array();

if ( ! class_exists( 'WPBakeryShortCode_Wvc_Post_Index' ) ) {
	/**
	 * Post Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Posts', 'kayo' ),
			'description' => esc_html__( 'Display your posts using the theme layouts', 'kayo' ),
			'base'        => 'wvc_post_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 999,
			'params'      => array(

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Index ID', 'kayo' ),
					'value'       => 'index-' . wp_rand( 0, 99999 ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'kayo' ),
				),

				array(
					'param_name'  => 'post_display',
					'heading'     => esc_html__( 'Post Display', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip(
						apply_filters(
							'kayo_post_display_options',
							array(
								'standard' => esc_html__( 'Standard', 'kayo' ),
							)
						)
					),
					'std'         => 'grid',
					'admin_label' => true,
				),

				array(
					'param_name'  => 'post_metro_pattern',
					'heading'     => esc_html__( 'Metro Pattern', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_metro_patterns() ),
					'std'         => 'auto',
					'dependency'  => array(
						'element' => 'post_display',
						'value'   => array( 'metro_modern_alt', 'metro' ),
					),
					'admin_label' => true,
				),

				array(
					'param_name' => 'post_alternate_thumbnail_position',
					'heading'    => esc_html__( 'Alternate thumbnail position', 'kayo' ),
					'type'       => 'checkbox',
					'dependency' => array(
						'element' => 'post_display',
						'value'   => array( 'lateral' ),
					),
				),

				array(
					'param_name'  => 'post_module',
					'heading'     => esc_html__( 'Module', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Grid', 'kayo' ) => 'grid',
						esc_html__( 'Carousel', 'kayo' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'post_display',
						'value'   => array( 'grid', 'grid_classic', 'grid_modern' ),
					),
				),

				array(
					'param_name' => 'post_excerpt_length',
					'heading'    => esc_html__( 'Post Excerpt Lenght', 'kayo' ),
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Shorten', 'kayo' ) => 'shorten',
						esc_html__( 'Full', 'kayo' ) => 'full',
					),
					'dependency' => array(
						'element' => 'post_display',
						'value'   => array( 'masonry' ),
					),
				),

				array(
					'param_name'  => 'post_display_elements',
					'heading'     => esc_html__( 'Elements', 'kayo' ),
					'type'        => 'checkbox',
					'value'       => array(
						esc_html__( 'Thumbnail', 'kayo' ) => 'show_thumbnail',
						esc_html__( 'Date', 'kayo' ) => 'show_date',
						esc_html__( 'Text', 'kayo' ) => 'show_text',
						esc_html__( 'Category', 'kayo' ) => 'show_category',
						esc_html__( 'Author', 'kayo' ) => 'show_author',
						esc_html__( 'Tags', 'kayo' ) => 'show_tags',
						esc_html__( 'Extra Meta', 'kayo' ) => 'show_extra_meta',
					),
					'std'         => 'show_thumbnail,show_date,show_text,show_author,show_category',

					'description' => esc_html__( 'Note that some options may be ignored depending on the post display.', 'kayo' ),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'post_excerpt_type',
					'heading'     => esc_html__( 'Post Excerpt Type', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Auto', 'kayo' ) => 'auto',
						esc_html__( 'Manual', 'kayo' ) => 'manual',
					),
					'description' => sprintf(
						kayo_kses( __( 'When using the manual excerpt, you must split your post using a "<a href="%s">More Tag</a>".', 'kayo' ) ),
						esc_url( 'https://en.support.wordpress.com/more-tag/' )
					),
					'dependency'  => array(
						'element' => 'post_display',
						'value'   => array( 'standard', 'standard_modern' ),
					),
				),

				array(
					'param_name'  => 'grid_padding',
					'heading'     => esc_html__( 'Padding', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Yes', 'kayo' ) => 'yes',
						esc_html__( 'No', 'kayo' ) => 'no',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element'            => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern', 'masonry_modern', 'offgrid' ),
					),
				),

				array(
					'param_name'  => 'pagination',
					'heading'     => esc_html__( 'Pagination', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'None', 'kayo' ) => 'none',
						esc_html__( 'Load More', 'kayo' ) => 'load_more',
						esc_html__( 'Numeric Pagination', 'kayo' ) => 'standard_pagination',
						esc_html__( 'Link to Blog Archives', 'kayo' ) => 'link_to_blog',
					),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Animation', 'kayo' ),
					'param_name'  => 'item_animation',
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Posts Per Page', 'kayo' ),
					'param_name'  => 'posts_per_page',
					'type'        => 'wvc_textfield',
					'value'       => get_option( 'posts_per_page' ),
					'admin_label' => true,
				),

				array(
					'heading'    => esc_html__( 'Additional CSS inline style', 'kayo' ),
					'param_name' => 'inline_style',
					'type'       => 'wvc_textfield',
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Offset', 'kayo' ),
					'param_name'  => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
					'admin_label' => true,
				),

				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Ignore Sticky Posts', 'kayo' ),
					'param_name'  => 'ignore_sticky_posts',
					'description' => esc_html__( 'It will still include the sticky posts but it will not prioritize them in the query.', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Exclude Sticky Posts', 'kayo' ),
					'description' => esc_html__( 'It will still exclude the sticky posts.', 'kayo' ),
					'param_name'  => 'exclude_sticky_posts',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Category', 'kayo' ),
					'param_name'  => 'category',
					'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Category by ID', 'kayo' ),
					'param_name'  => 'category_exclude',
					'description' => esc_html__( 'Exclude only one or several categories. Paste category ID(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( '456, 756', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Tags', 'kayo' ),
					'param_name'  => 'tag',
					'description' => esc_html__( 'Include only one or several tags. Paste tag slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-tag, other-tag', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Tags by ID', 'kayo' ),
					'param_name'  => 'tag_exclude',
					'description' => esc_html__( 'Exclude only one or several tags. Paste tag ID(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( '456, 756', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order by', 'kayo' ),
					'param_name'  => 'orderby',
					'value'       => $order_by_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Select how to sort retrieved posts. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Sort order', 'kayo' ),
					'param_name'  => 'order',
					'value'       => $order_way_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Designates the ascending or descending order. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Post IDs', 'kayo' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'include_ids',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Post IDs', 'kayo' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'exclude_ids',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'param_name'  => 'columns',
					'heading'     => esc_html__( 'Columns', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Auto', 'kayo' ) => 'default',
						esc_html__( 'Two', 'kayo' ) => 2,
						esc_html__( 'Three', 'kayo' ) => 3,
						esc_html__( 'Four', 'kayo' ) => 4,
						esc_html__( 'Five', 'kayo' ) => 5,
						esc_html__( 'Six', 'kayo' ) => 6,
						esc_html__( 'One', 'kayo' ) => 1,
					),
					'std'         => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
					'dependency'  => array(
						'element'            => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern', 'lateral', 'list' ),
					),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Extra class name', 'kayo' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'kayo' ),
					'group'       => esc_html__( 'Extra', 'kayo' ),
				),
			),
		)
	);
	class WPBakeryShortCode_Wvc_Post_Index extends WPBakeryShortCode {} // phpcs:ignore
}

if ( class_exists( 'Wolf_Discography' ) && ! class_exists( 'WPBakeryShortCode_Wvc_Release_Index' ) ) {
	/**
	 * Discography Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Releases', 'kayo' ),
			'description' => esc_html__( 'Display your releases using the theme layouts', 'kayo' ),
			'base'        => 'wvc_release_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 999,
			'params'      =>
				array(
					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Index ID', 'kayo' ),
						'value'       => 'index-' . wp_rand( 0, 99999 ),
						'param_name'  => 'el_id',
						'description' => esc_html__( 'A unique identifier for the post module (required).', 'kayo' ),
					),

					array(
						'param_name'  => 'release_display',
						'heading'     => esc_html__( 'Release Display', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array_flip(
							apply_filters(
								'kayo_release_display_options',
								array(
									'grid' => esc_html__( 'Grid', 'kayo' ),
								)
							)
						),
						'admin_label' => true,
					),

					array(
						'param_name' => 'release_alternate_thumbnail_position',
						'heading'    => esc_html__( 'Alternate thumbnail position', 'kayo' ),
						'type'       => 'checkbox',
						'dependency' => array(
							'element' => 'release_display',
							'value'   => array( 'lateral' ),
						),
					),

					array(
						'param_name'  => 'release_layout',
						'heading'     => esc_html__( 'Layout', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Classic', 'kayo' ) => 'standard',
							esc_html__( 'Overlay', 'kayo' ) => 'overlay',
						),
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'release_display',
							'value'   => array( 'grid', 'metro', 'masonry' ),
						),
					),

					array(
						'param_name'  => 'release_module',
						'heading'     => esc_html__( 'Module', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Grid', 'kayo' ) => 'grid',
							esc_html__( 'Carousel', 'kayo' ) => 'carousel',
						),
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'release_display',
							'value'   => array( 'grid' ),
						),
					),

					array(
						'param_name'  => 'release_custom_thumbnail_size',
						'heading'     => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
						'type'        => 'wvc_textfield',
						'admin_label' => true,
						'placeholder' => '450x450',
					),

					array(
						'param_name'  => 'grid_padding',
						'heading'     => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Yes', 'kayo' ) => 'yes',
							esc_html__( 'No', 'kayo' ) => 'no',
						),
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'release_layout',
							'value'   => array( 'overlay', 'flip-box' ),
						),
					),

					array(
						'type'               => 'dropdown',
						'heading'            => esc_html__( 'Overlay Color', 'kayo' ),
						'param_name'         => 'overlay_color',
						'value'              => array_merge(
							array( esc_html__( 'Auto', 'kayo' ) => 'auto' ),
							$shared_gradient_colors,
							$shared_colors,
							array( esc_html__( 'Custom color', 'kayo' ) => 'custom' )
						),
						'std'                => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
						'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
						'param_holder_class' => 'wvc_colored-dropdown',
						'dependency'         => array(
							'element' => 'release_layout',
							'value'   => array( 'overlay', 'flip-box' ),
						),
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Overlay Custom Color', 'kayo' ),
						'param_name' => 'overlay_custom_color',
						'dependency' => array(
							'element' => 'overlay_color',
							'value'   => array( 'custom' ),
						),
					),
					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Overlay Opacity in Percent', 'kayo' ),
						'param_name'  => 'overlay_opacity',
						'description' => '',
						'value'       => 40,
						'std'         => apply_filters( 'wvc_default_item_overlay_opacity', 40 ),
						'dependency'  => array(
							'element' => 'release_layout',
							'value'   => array( 'overlay', 'flip-box' ),
						),
					),
					array(
						'type'               => 'dropdown',
						'heading'            => esc_html__( 'Overlay Text Color', 'kayo' ),
						'param_name'         => 'overlay_text_color',
						'value'              => array_merge(
							$shared_colors,
							$shared_gradient_colors,
							array( esc_html__( 'Custom color', 'kayo' ) => 'custom' )
						),
						'std'                => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
						'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
						'param_holder_class' => 'wvc_colored-dropdown',
						'dependency'         => array(
							'element' => 'release_layout',
							'value'   => array( 'overlay', 'flip-box' ),
						),
					),

					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__( 'Overlay Custom Text Color', 'kayo' ),
						'param_name' => 'overlay_text_custom_color',
						'dependency' => array(
							'element' => 'overlay_text_color',
							'value'   => array( 'custom' ),
						),
					),

					array(
						'param_name'  => 'pagination',
						'heading'     => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'None', 'kayo' ) => 'none',
							esc_html__( 'Load More', 'kayo' ) => 'load_more',
							esc_html__( 'Numeric Pagination', 'kayo' ) => 'standard_pagination',
							esc_html__( 'Link to Discography', 'kayo' ) => 'link_to_discography',
						),
						'admin_label' => true,
					),

					array(
						'heading'     => esc_html__( 'Category Filter', 'kayo' ),
						'param_name'  => 'release_category_filter',
						'type'        => 'checkbox',
						'description' => esc_html__( 'The pagination will be disabled.', 'kayo' ),
						'admin_label' => true,
						'dependency'  => array(
							'element'            => 'release_display',
							'value_not_equal_to' => array( 'list_minimal' ),
						),
					),

					array(
						'heading'    => esc_html__( 'Filter Text Alignement', 'kayo' ),
						'param_name' => 'release_category_filter_text_alignment',
						'type'       => 'dropdown',
						'value'      => array(
							esc_html__( 'Center', 'kayo' ) => 'center',
							esc_html__( 'Left', 'kayo' ) => 'left',
							esc_html__( 'Right', 'kayo' ) => 'right',
						),
						'dependency' => array(
							'element' => 'release_category_filter',
							'value'   => array( 'true' ),
						),
					),

					array(
						'heading'     => esc_html__( 'Animation', 'kayo' ),
						'param_name'  => 'item_animation',
						'type'        => 'dropdown',
						'value'       => array_flip( kayo_get_animations() ),
						'admin_label' => true,
					),

					array(
						'heading'     => esc_html__( 'Number of Posts', 'kayo' ),
						'param_name'  => 'posts_per_page',
						'type'        => 'wvc_textfield',
						'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
						'admin_label' => true,
					),

					array(
						'heading'    => esc_html__( 'Additional CSS inline style', 'kayo' ),
						'param_name' => 'inline_style',
						'type'       => 'wvc_textfield',
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Include Band', 'kayo' ),
						'param_name'  => 'band_include',
						'description' => esc_html__( 'Enter one or several bands. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Exclude Band', 'kayo' ),
						'param_name'  => 'band_exclude',
						'description' => esc_html__( 'Enter one or several bands. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Include Type', 'kayo' ),
						'param_name'  => 'label_include',
						'description' => esc_html__( 'Enter one or several release types (from release tags). Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Exclude Type', 'kayo' ),
						'param_name'  => 'label_exclude',
						'description' => esc_html__( 'Enter one or several release types (from release tags). Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Offset', 'kayo' ),
						'description' => esc_html__( '.', 'kayo' ),
						'param_name'  => 'offset',
						'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query.', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order by', 'kayo' ),
						'param_name'  => 'orderby',
						'value'       => $order_by_values,
						'save_always' => true,
						'description' => sprintf( kayo_kses( __( 'Select how to sort retrieved posts. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ), // WCS XSS ok.
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Sort order', 'kayo' ),
						'param_name'  => 'order',
						'value'       => $order_way_values,
						'save_always' => true,
						'description' => sprintf( kayo_kses( __( 'Designates the ascending or descending order. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Post IDs', 'kayo' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Exclude Post IDs', 'kayo' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'columns',
						'heading'     => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Auto', 'kayo' ) => 'default',
							esc_html__( 'Two', 'kayo' ) => 2,
							esc_html__( 'Three', 'kayo' ) => 3,
							esc_html__( 'Four', 'kayo' ) => 4,
							esc_html__( 'Five', 'kayo' ) => 5,
							esc_html__( 'Six', 'kayo' ) => 6,
							esc_html__( 'One', 'kayo' ) => 1,
						),
						'std'         => 'default',
						'admin_label' => true,
						'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
						'dependency'  => array(
							'element'            => 'post_display',
							'value_not_equal_to' => array( 'standard', 'standard_modern', 'lateral' ),
						),
					),
				),
		)
	);

	class WPBakeryShortCode_Wvc_Release_Index extends WPBakeryShortCode {} // phpcs:ignore
} // end Discography plugin check

if ( class_exists( 'WooCommerce' ) && ! class_exists( 'WPBakeryShortCode_Wvc_Product_Index' ) ) {

	/**
	 * Product Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Products', 'kayo' ),
			'description' => esc_html__( 'Display your pages using the theme layouts', 'kayo' ),
			'base'        => 'wvc_product_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 999,
			'params'      =>
				array(

					array(
						'type'       => 'wvc_textfield',
						'heading'    => esc_html__( 'ID', 'kayo' ),
						'value'      => 'items-' . wp_rand( 0, 99999 ),
						'param_name' => 'el_id',
					),

					array(
						'param_name'  => 'product_display',
						'heading'     => esc_html__( 'Product Display', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array_flip(
							apply_filters(
								'kayo_product_display_options',
								array(
									'grid_classic' => esc_html__( 'Classic', 'kayo' ),
								)
							)
						),
						'std'         => 'grid_classic',
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_metro_pattern',
						'heading'     => esc_html__( 'Metro Pattern', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array_flip( kayo_get_metro_patterns() ),
						'std'         => 'pattern-1',
						'dependency'  => array(
							'element' => 'product_display',
							'value'   => array( 'metro', 'metro_overlay_quickview' ),
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_text_align',
						'heading'     => esc_html__( 'Product Text Alignement', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							'' => '',
							esc_html__( 'Center', 'kayo' ) => 'center',
							esc_html__( 'Left', 'kayo' ) => 'left',
							esc_html__( 'Right', 'kayo' ) => 'right',
						),
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'product_display',
							'value'   => array( 'grid_classic' ),
						),
					),

					array(
						'param_name'  => 'product_meta',
						'heading'     => esc_html__( 'Type', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'All', 'kayo' ) => 'all',
							esc_html__( 'Featured', 'kayo' ) => 'featured',
							esc_html__( 'On Sale', 'kayo' ) => 'onsale',
							esc_html__( 'Best Selling', 'kayo' ) => 'best_selling',
							esc_html__( 'Top Rated', 'kayo' ) => 'top_rated',
						),
						'admin_label' => true,
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Category', 'kayo' ),
						'param_name'  => 'product_cat',
						'description' => esc_html__( 'Include only one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
						'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'product_module',
						'heading'     => esc_html__( 'Module', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Grid', 'kayo' ) => 'grid',
							esc_html__( 'Carousel', 'kayo' ) => 'carousel',
						),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'grid_padding',
						'heading'     => esc_html__( 'Padding', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Yes', 'kayo' ) => 'yes',
							esc_html__( 'No', 'kayo' ) => 'no',
						),
						'admin_label' => true,
					),

					array(
						'heading'     => esc_html__( 'Animation', 'kayo' ),
						'param_name'  => 'item_animation',
						'type'        => 'dropdown',
						'value'       => array_flip( kayo_get_animations() ),
						'admin_label' => true,
					),

					array(
						'heading'     => esc_html__( 'Posts Per Page', 'kayo' ),
						'param_name'  => 'posts_per_page',
						'type'        => 'wvc_textfield',
						'placeholder' => get_option( 'posts_per_page' ),
						'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
						'std'         => get_option( 'posts_per_page' ),
						'admin_label' => true,
					),

					array(
						'param_name'  => 'pagination',
						'heading'     => esc_html__( 'Pagination', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'None', 'kayo' ) => 'none',
							esc_html__( 'Load More', 'kayo' ) => 'load_more',
							esc_html__( 'Numeric Pagination', 'kayo' ) => 'standard_pagination',
							esc_html__( 'Link to Category', 'kayo' ) => 'link_to_shop_category',
							esc_html__( 'Link to Shop Archive', 'kayo' ) => 'link_to_shop',
						),
						'admin_label' => true,
						'dependency'  => array(
							'element' => 'product_module',
							'value'   => array( 'grid', 'metro' ),
						),
					),

					array(
						'param_name'  => 'product_category_link_id',
						'heading'     => esc_html__( 'Category', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array_flip( kayo_get_product_cat_dropdown_options() ),
						'dependency'  => array(
							'element' => 'pagination',
							'value'   => array( 'link_to_shop_category' ),
						),
						'admin_label' => true,
					),

					array(
						'heading'    => esc_html__( 'Additional CSS inline style', 'kayo' ),
						'param_name' => 'inline_style',
						'type'       => 'wvc_textfield',
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Offset', 'kayo' ),
						'param_name'  => 'offset',
						'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query. If an offset is set, sticky posts will be ignored.', 'kayo' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
						'admin_label' => true,
					),

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Order by', 'kayo' ),
						'param_name'  => 'orderby',
						'value'       => $order_by_values,
						'save_always' => true,
						'description' => sprintf( kayo_kses( __( 'Select how to sort retrieved products. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Sort order', 'kayo' ),
						'param_name'  => 'order',
						'value'       => $order_way_values,
						'save_always' => true,
						'description' => sprintf( kayo_kses( __( 'Designates the ascending or descending order. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Post IDs', 'kayo' ),
						'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'include_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Exclude Post IDs', 'kayo' ),
						'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
						'param_name'  => 'exclude_ids',
						'group'       => esc_html__( 'Query', 'kayo' ),
					),

					array(
						'param_name'  => 'columns',
						'heading'     => esc_html__( 'Columns', 'kayo' ),
						'type'        => 'dropdown',
						'value'       => array(
							esc_html__( 'Auto', 'kayo' ) => 'default',
							esc_html__( 'Two', 'kayo' ) => 2,
							esc_html__( 'Three', 'kayo' ) => 3,
							esc_html__( 'Four', 'kayo' ) => 4,
							esc_html__( 'Five', 'kayo' ) => 5,
							esc_html__( 'Six', 'kayo' ) => 6,
							esc_html__( 'One', 'kayo' ) => 1,
						),
						'std'         => 'default',
						'admin_label' => true,
						'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
						'dependency'  => array(
							'element'            => 'product_display',
							'value_not_equal_to' => array( 'metro_overlay_quickview' ),
						),
					),

					array(
						'type'        => 'wvc_textfield',
						'heading'     => esc_html__( 'Extra class name', 'kayo' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'kayo' ),
						'group'       => esc_html__( 'Extra', 'kayo' ),
					),
				),

		)
	);

	class WPBakeryShortCode_Wvc_Product_Index extends WPBakeryShortCode {} // phpcs:ignore

} // end WC check

if ( class_exists( 'Wolf_Artists' ) && ! class_exists( 'WPBakeryShortCode_Wvc_Artist_Index' ) ) {

	/**
	 * Work Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Artists', 'kayo' ),
			'description' => esc_html__( 'Display your artists using the theme layouts', 'kayo' ),
			'base'        => 'wvc_artist_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 999,
			'params'      => array(

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Index ID', 'kayo' ),
					'value'       => 'index-' . wp_rand( 0, 99999 ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'kayo' ),
				),

				array(
					'param_name'  => 'artist_display',
					'heading'     => esc_html__( 'Artist Display', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip(
						apply_filters(
							'kayo_artist_display_options',
							array(
								'list' => esc_html__( 'List', 'kayo' ),
							)
						)
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'artist_metro_pattern',
					'heading'     => esc_html__( 'Metro Pattern', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_metro_patterns() ),
					'std'         => 'auto',
					'dependency'  => array(
						'element' => 'artist_display',
						'value'   => array( 'metro' ),
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'artist_module',
					'heading'     => esc_html__( 'Module', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Grid', 'kayo' ) => 'grid',
						esc_html__( 'Carousel', 'kayo' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'artist_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'artist_thumbnail_size',
					'heading'     => esc_html__( 'Thumbnail Size', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Default Thumbnail', 'kayo' ) => 'standard',
						esc_html__( 'Landscape', 'kayo' ) => 'landscape',
						esc_html__( 'Square', 'kayo' ) => 'square',
						esc_html__( 'Portrait', 'kayo' ) => 'portrait',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'artist_display',
						'value'   => array( 'grid', 'offgrid' ),
					),
				),

				/*
				array(
					'param_name' => 'artist_custom_thumbnail_size',
					'heading' => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
					'type' => 'wvc_textfield',
					'admin_label' => true,
					'placeholder' => '415x230',
				),*/

				array(
					'param_name'  => 'artist_layout',
					'heading'     => esc_html__( 'Layout', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Classic', 'kayo' ) => 'standard',
						esc_html__( 'Overlay', 'kayo' ) => 'overlay',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element'            => 'artist_display',
						'value_not_equal_to' => array( 'list', 'metro' ),
					),
				),

				array(
					'param_name'  => 'grid_padding',
					'heading'     => esc_html__( 'Padding', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Yes', 'kayo' ) => 'yes',
						esc_html__( 'No', 'kayo' ) => 'no',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'artist_layout',
						'value'   => array( 'overlay', 'flip-box' ),
					),
				),

				array(
					'heading'    => esc_html__( 'Caption Text Alignement', 'kayo' ),
					'param_name' => 'caption_text_alignment',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Center', 'kayo' ) => 'center',
						esc_html__( 'Left', 'kayo' ) => 'left',
						esc_html__( 'Right', 'kayo' ) => 'right',
					),
					'dependency' => array(
						'element'            => 'artist_display',
						'value_not_equal_to' => array( 'list_minimal' ),
					),
				),

				array(
					'heading'    => esc_html__( 'Caption Vertical Alignement', 'kayo' ),
					'param_name' => 'caption_v_align',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Middle', 'kayo' ) => 'middle',
						esc_html__( 'Bottom', 'kayo' ) => 'bottom',
						esc_html__( 'Top', 'kayo' ) => 'top',
					),
					'dependency' => array(
						'element'            => 'artist_display',
						'value_not_equal_to' => array( 'list_minimal' ),
					),
				),

				array(
					'type'               => 'dropdown',
					'heading'            => esc_html__( 'Overlay Color', 'kayo' ),
					'param_name'         => 'overlay_color',
					'value'              => array_merge(
						array( esc_html__( 'Auto', 'kayo' ) => 'auto' ),
						$shared_gradient_colors,
						$shared_colors,
						array( esc_html__( 'Custom color', 'kayo' ) => 'custom' )
					),
					'std'                => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
					'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency'         => array(
						'element' => 'artist_layout',
						'value'   => array( 'overlay', 'flip-box' ),
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Overlay Custom Color', 'kayo' ),
					'param_name' => 'overlay_custom_color',
					'dependency' => array(
						'element' => 'overlay_color',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Overlay Opacity in Percent', 'kayo' ),
					'param_name'  => 'overlay_opacity',
					'description' => '',
					'value'       => 40,
					'std'         => apply_filters( 'wvc_default_item_overlay_opacity', 40 ),
					'dependency'  => array(
						'element' => 'artist_layout',
						'value'   => array( 'overlay', 'flip-box' ),
					),
				),

				array(
					'type'               => 'dropdown',
					'heading'            => esc_html__( 'Overlay Text Color', 'kayo' ),
					'param_name'         => 'overlay_text_color',
					'value'              => array_merge(
						$shared_colors,
						$shared_gradient_colors,
						array( esc_html__( 'Custom color', 'kayo' ) => 'custom' )
					),
					'std'                => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
					'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency'         => array(
						'element' => 'artist_layout',
						'value'   => array( 'overlay', 'flip-box' ),
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Overlay Custom Text Color', 'kayo' ),
					'param_name' => 'overlay_text_custom_color',
					'dependency' => array(
						'element' => 'overlay_text_color',
						'value'   => array( 'custom' ),
					),
				),

				array(
					'heading'     => esc_html__( 'Category Filter', 'kayo' ),
					'param_name'  => 'artist_category_filter',
					'type'        => 'checkbox',
					'description' => esc_html__( 'The pagination will be disabled.', 'kayo' ),
					'admin_label' => true,
					'dependency'  => array(
						'element'            => 'artist_display',
						'value_not_equal_to' => array( 'list_minimal' ),
					),
				),

				array(
					'heading'    => esc_html__( 'Filter Text Alignement', 'kayo' ),
					'param_name' => 'artist_category_filter_text_alignment',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Center', 'kayo' ) => 'center',
						esc_html__( 'Left', 'kayo' ) => 'left',
						esc_html__( 'Right', 'kayo' ) => 'right',
					),
					'dependency' => array(
						'element' => 'artist_category_filter',
						'value'   => array( 'true' ),
					),
				),

				array(
					'heading'     => esc_html__( 'Animation', 'kayo' ),
					'param_name'  => 'item_animation',
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Number of Posts', 'kayo' ),
					'param_name'  => 'posts_per_page',
					'type'        => 'wvc_textfield',
					'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'pagination',
					'heading'     => esc_html__( 'Pagination', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'None', 'kayo' ) => 'none',
						esc_html__( 'Load More', 'kayo' ) => 'load_more',
						esc_html__( 'Numeric Pagination', 'kayo' ) => 'standard_pagination',
						esc_html__( 'Link to Archives', 'kayo' ) => 'link_to_artists',
					),
					'admin_label' => true,
				),

				array(
					'heading'    => esc_html__( 'Additional CSS inline style', 'kayo' ),
					'param_name' => 'inline_style',
					'type'       => 'wvc_textfield',
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Include Category', 'kayo' ),
					'param_name'  => 'artist_genre_include',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Category', 'kayo' ),
					'param_name'  => 'artist_genre_exclude',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Offset', 'kayo' ),
					'description' => esc_html__( '.', 'kayo' ),
					'param_name'  => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query.', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order by', 'kayo' ),
					'param_name'  => 'orderby',
					'value'       => $order_by_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Select how to sort retrieved posts. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Sort order', 'kayo' ),
					'param_name'  => 'order',
					'value'       => $order_way_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Designates the ascending or descending order. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Post IDs', 'kayo' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'include_ids',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Post IDs', 'kayo' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'exclude_ids',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'param_name'  => 'columns',
					'heading'     => esc_html__( 'Columns', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Auto', 'kayo' ) => 'default',
						esc_html__( 'Two', 'kayo' ) => 2,
						esc_html__( 'Three', 'kayo' ) => 3,
						esc_html__( 'Four', 'kayo' ) => 4,
						esc_html__( 'Five', 'kayo' ) => 5,
						esc_html__( 'Six', 'kayo' ) => 6,
						esc_html__( 'One', 'kayo' ) => 1,
					),
					'std'         => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
					'dependency'  => array(
						'element'            => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
				),
			),
		)
	);

	class WPBakeryShortCode_Wvc_Artist_Index extends WPBakeryShortCode {} // phpcs:ignore
} // end Artist plugin check

if ( class_exists( 'Wolf_Albums' ) && ! class_exists( 'WPBakeryShortCode_Wvc_Gallery_Index' ) ) {

	/**
	 * Albums Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Albums', 'kayo' ),
			'description' => esc_html__( 'Display your albums using the theme layouts', 'kayo' ),
			'base'        => 'wvc_gallery_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 999,
			'params'      => array(

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Index ID', 'kayo' ),
					'value'       => 'index-' . wp_rand( 0, 99999 ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'kayo' ),
				),

				array(
					'param_name'  => 'gallery_display',
					'heading'     => esc_html__( 'Album Display', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip(
						apply_filters(
							'kayo_gallery_display_options',
							array(
								'grid' => esc_html__( 'Grid', 'kayo' ),
							)
						)
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'gallery_module',
					'heading'     => esc_html__( 'Module', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Grid', 'kayo' ) => 'grid',
						esc_html__( 'Carousel', 'kayo' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'gallery_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'grid_padding',
					'heading'     => esc_html__( 'Padding', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Yes', 'kayo' ) => 'yes',
						esc_html__( 'No', 'kayo' ) => 'no',
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'gallery_thumbnail_size',
					'heading'     => esc_html__( 'Thumbnail Size', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Default Thumbnail', 'kayo' ) => 'standard',
						esc_html__( 'Landscape', 'kayo' ) => 'landscape',
						esc_html__( 'Square', 'kayo' ) => 'square',
						esc_html__( 'Portrait', 'kayo' ) => 'portrait',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'gallery_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'gallery_layout',
					'heading'     => esc_html__( 'Layout', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Classic', 'kayo' ) => 'standard',
						esc_html__( 'Overlay', 'kayo' ) => 'overlay',
					),
					'admin_label' => true,
				),

				array(
					'heading'    => esc_html__( 'Text Alignement', 'kayo' ),
					'param_name' => 'caption_text_alignment',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Center', 'kayo' ) => 'center',
						esc_html__( 'Left', 'kayo' ) => 'left',
						esc_html__( 'Right', 'kayo' ) => 'right',
					),
				),

				array(
					'type'               => 'dropdown',
					'heading'            => esc_html__( 'Overlay Color', 'kayo' ),
					'param_name'         => 'overlay_color',
					'value'              => array_merge(
						array( esc_html__( 'Auto', 'kayo' ) => 'auto' ),
						$shared_gradient_colors,
						$shared_colors,
						array( esc_html__( 'Custom color', 'kayo' ) => 'custom' )
					),
					'std'                => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
					'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency'         => array(
						'element' => 'gallery_layout',
						'value'   => array( 'overlay' ),
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Overlay Custom Color', 'kayo' ),
					'param_name' => 'overlay_custom_color',
					'dependency' => array(
						'element' => 'overlay_color',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Overlay Opacity in Percent', 'kayo' ),
					'param_name'  => 'overlay_opacity',
					'description' => '',
					'value'       => 40,
					'std'         => apply_filters( 'wvc_default_item_overlay_opacity', 40 ),
					'dependency'  => array(
						'element' => 'gallery_layout',
						'value'   => array( 'overlay' ),
					),
				),

				array(
					'type'               => 'dropdown',
					'heading'            => esc_html__( 'Overlay Text Color', 'kayo' ),
					'param_name'         => 'overlay_text_color',
					'value'              => array_merge(
						$shared_colors,
						$shared_gradient_colors,
						array( esc_html__( 'Custom color', 'kayo' ) => 'custom' )
					),
					'std'                => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
					'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency'         => array(
						'element' => 'gallery_layout',
						'value'   => array( 'overlay' ),
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Overlay Custom Text Color', 'kayo' ),
					'param_name' => 'overlay_text_custom_color',
					'dependency' => array(
						'element' => 'overlay_text_color',
						'value'   => array( 'custom' ),
					),
				),

				array(
					'heading'     => esc_html__( 'Animation', 'kayo' ),
					'param_name'  => 'item_animation',
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Category Filter', 'kayo' ),
					'param_name'  => 'gallery_category_filter',
					'type'        => 'checkbox',
					'description' => esc_html__( 'The pagination will be disabled.', 'kayo' ),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'pagination',
					'heading'     => esc_html__( 'Pagination', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'None', 'kayo' ) => 'none',
						esc_html__( 'Load More', 'kayo' ) => 'load_more',
						esc_html__( 'Numeric Pagination', 'kayo' ) => 'standard_pagination',
						esc_html__( 'Link to Album Archives', 'kayo' ) => 'link_to_albums',
					),
					'admin_label' => true,
				),

				array(
					'heading'    => esc_html__( 'Filter Text Alignement', 'kayo' ),
					'param_name' => 'gallery_category_filter_text_alignment',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Center', 'kayo' ) => 'center',
						esc_html__( 'Left', 'kayo' ) => 'left',
						esc_html__( 'Right', 'kayo' ) => 'right',
					),
					'dependency' => array(
						'element' => 'gallery_category_filter',
						'value'   => array( 'true' ),
					),
				),

				array(
					'heading'     => esc_html__( 'Number of Posts', 'kayo' ),
					'param_name'  => 'posts_per_page',
					'type'        => 'wvc_textfield',
					'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
					'admin_label' => true,
				),

				array(
					'heading'    => esc_html__( 'Additional CSS inline style', 'kayo' ),
					'param_name' => 'inline_style',
					'type'       => 'wvc_textfield',
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Include Category', 'kayo' ),
					'param_name'  => 'gallery_type_include',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Category', 'kayo' ),
					'param_name'  => 'gallery_type_exclude',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Offset', 'kayo' ),
					'description' => esc_html__( '.', 'kayo' ),
					'param_name'  => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query.', 'kayo' ),
					'group'       => esc_html( 'Query', 'kayo' ),
				),

				array(
					'param_name'  => 'columns',
					'heading'     => esc_html__( 'Columns', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Auto', 'kayo' ) => 'default',
						esc_html__( 'Two', 'kayo' ) => 2,
						esc_html__( 'Three', 'kayo' ) => 3,
						esc_html__( 'Four', 'kayo' ) => 4,
						esc_html__( 'Six', 'kayo' ) => 6,
						esc_html__( 'One', 'kayo' ) => 1,
					),
					'std'         => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
					'dependency'  => array(
						'element'            => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
					'group'       => esc_html__( 'Extra', 'kayo' ),
				),
			),

		)
	);

	class WPBakeryShortCode_Wvc_Gallery_Index extends WPBakeryShortCode {} // phpcs:ignore
} // end Gallery plugin check.

if ( class_exists( 'Wolf_Videos' ) && ! class_exists( 'WPBakeryShortCode_Wvc_Video_Index' ) ) {
	/**
	 * Videos Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Videos', 'kayo' ),
			'description' => esc_html__( 'Display your videos using the theme layouts', 'kayo' ),
			'base'        => 'wvc_video_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 999,
			'params'      => array(

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Index ID', 'kayo' ),
					'value'       => 'index-' . wp_rand( 0, 99999 ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'kayo' ),
				),

				array(
					'heading'     => esc_html__( 'Show video on hover', 'kayo' ),
					'param_name'  => 'video_preview',
					'type'        => 'checkbox',
					'admin_label' => true,
					'value'       => 'yes',
					'dependency'  => array(
						'element' => 'video_module',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'video_module',
					'heading'     => esc_html__( 'Module', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Grid', 'kayo' ) => 'grid',
						esc_html__( 'Carousel', 'kayo' ) => 'carousel',
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'video_custom_thumbnail_size',
					'heading'     => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
					'type'        => 'wvc_textfield',
					'admin_label' => true,
					'placeholder' => '415x230',
				),

				array(
					'param_name'  => 'grid_padding',
					'heading'     => esc_html__( 'Padding', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Yes', 'kayo' ) => 'yes',
						esc_html__( 'No', 'kayo' ) => 'no',
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'video_onclick',
					'heading'     => esc_html__( 'On Click', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Open Video in Lightbox', 'kayo' ) => 'lightbox',
						esc_html__( 'Go to the Video Page', 'kayo' ) => 'default',
					),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Category Filter', 'kayo' ),
					'param_name'  => 'video_category_filter',
					'type'        => 'checkbox',
					'admin_label' => true,
					'description' => esc_html__( 'The pagination will be disabled.', 'kayo' ),
					'dependency'  => array(
						'element' => 'video_module',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'heading'    => esc_html__( 'Filter Text Alignement', 'kayo' ),
					'param_name' => 'video_category_filter_text_alignment',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Center', 'kayo' ) => 'center',
						esc_html__( 'Left', 'kayo' ) => 'left',
						esc_html__( 'Right', 'kayo' ) => 'right',
					),
					'dependency' => array(
						'element' => 'video_category_filter',
						'value'   => array( 'true' ),
					),
				),

				array(
					'heading'     => esc_html__( 'Animation', 'kayo' ),
					'param_name'  => 'item_animation',
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Number of Posts', 'kayo' ),
					'param_name'  => 'posts_per_page',
					'type'        => 'wvc_textfield',
					'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'pagination',
					'heading'     => esc_html__( 'Pagination', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'None', 'kayo' ) => 'none',
						esc_html__( 'Load More', 'kayo' ) => 'load_more',
						esc_html__( 'Numeric Pagination', 'kayo' ) => 'standard_pagination',
						esc_html__( 'Link to Video Archives', 'kayo' ) => 'link_to_videos',
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'video_category_link_id',
					'heading'     => esc_html__( 'Category', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_video_cat_dropdown_options() ),
					'dependency'  => array(
						'element' => 'pagination',
						'value'   => array( 'link_to_video_category' ),
					),
					'admin_label' => true,
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Include Category', 'kayo' ),
					'param_name'  => 'video_type_include',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Category', 'kayo' ),
					'param_name'  => 'video_type_exclude',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Include Tag', 'kayo' ),
					'param_name'  => 'video_tag_include',
					'description' => esc_html__( 'Enter one or several tags. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-tag, other-tag', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Tag', 'kayo' ),
					'param_name'  => 'video_tag_exclude',
					'description' => esc_html__( 'Enter one or several tags. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-tag, other-tag', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Offset', 'kayo' ),
					'description' => esc_html__( '.', 'kayo' ),
					'param_name'  => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query.', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order by', 'kayo' ),
					'param_name'  => 'orderby',
					'value'       => $order_by_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Select how to sort retrieved posts. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Sort order', 'kayo' ),
					'param_name'  => 'order',
					'value'       => $order_way_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Designates the ascending or descending order. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Post IDs', 'kayo' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'include_ids',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Post IDs', 'kayo' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'exclude_ids',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'param_name'  => 'columns',
					'heading'     => esc_html__( 'Columns', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Auto', 'kayo' ) => 'default',
						esc_html__( 'Two', 'kayo' ) => 2,
						esc_html__( 'Three', 'kayo' ) => 3,
						esc_html__( 'Four', 'kayo' ) => 4,
						esc_html__( 'Five', 'kayo' ) => 5,
						esc_html__( 'Six', 'kayo' ) => 6,
						esc_html__( 'One', 'kayo' ) => 1,
					),
					'std'         => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
					'dependency'  => array(
						'element'            => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
				),
			),
		)
	);

	class WPBakeryShortCode_Wvc_Video_Index extends WPBakeryShortCode {} // phpcs:ignore
} // end Videos plugin check.

if ( class_exists( 'Wolf_Events' ) && ! class_exists( 'WPBakeryShortCode_Wvc_Event_Index' ) ) {
	/**
	 * Events Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Events', 'kayo' ),
			'description' => esc_html__( 'Display your events using the theme layouts', 'kayo' ),
			'base'        => 'wvc_event_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 999,
			'params'      => array(

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Index ID', 'kayo' ),
					'value'       => 'index-' . wp_rand( 0, 99999 ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'kayo' ),
				),

				array(
					'param_name'  => 'event_display',
					'heading'     => esc_html__( 'Event Display', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip(
						apply_filters(
							'kayo_event_display_options',
							array(
								'list' => esc_html__( 'List', 'kayo' ),
							)
						)
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'event_module',
					'heading'     => esc_html__( 'Module', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Grid', 'kayo' ) => 'grid',
						esc_html__( 'Carousel', 'kayo' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'event_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'event_location',
					'heading'     => esc_html__( 'Location', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Location', 'kayo' ) => 'location',
						esc_html__( 'Venue', 'kayo' ) => 'venue',
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'grid_padding',
					'heading'     => esc_html__( 'Padding', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Yes', 'kayo' ) => 'yes',
						esc_html__( 'No', 'kayo' ) => 'no',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'event_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'event_thumbnail_size',
					'heading'     => esc_html__( 'Thumbnail Size', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Default Thumbnail', 'kayo' ) => 'standard',
						esc_html__( 'Landscape', 'kayo' ) => 'landscape',
						esc_html__( 'Square', 'kayo' ) => 'square',
						esc_html__( 'Portrait', 'kayo' ) => 'portrait',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'event_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'event_custom_thumbnail_size',
					'heading'     => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
					'type'        => 'wvc_textfield',
					'admin_label' => true,
					'placeholder' => '450x450',
				),

				array(
					'type'               => 'dropdown',
					'heading'            => esc_html__( 'Overlay Color', 'kayo' ),
					'param_name'         => 'overlay_color',
					'value'              => array_merge(
						array( esc_html__( 'Auto', 'kayo' ) => 'auto' ),
						$shared_gradient_colors,
						$shared_colors,
						array( esc_html__( 'Custom color', 'kayo' ) => 'custom' )
					),
					'std'                => apply_filters( 'wvc_default_item_overlay_color', 'black' ),
					'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency'         => array(
						'element' => 'event_display',
						'value'   => array( 'grid' ),
					),
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Overlay Custom Color', 'kayo' ),
					'param_name' => 'overlay_custom_color',
					'dependency' => array(
						'element' => 'overlay_color',
						'value'   => array( 'custom' ),
					),
				),
				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Overlay Opacity in Percent', 'kayo' ),
					'param_name'  => 'overlay_opacity',
					'description' => '',
					'value'       => 40,
					'std'         => apply_filters( 'wvc_default_item_overlay_opacity', 40 ),
					'dependency'  => array(
						'element' => 'event_display',
						'value'   => array( 'grid' ),
					),
				),
				array(
					'type'               => 'dropdown',
					'heading'            => esc_html__( 'Overlay Text Color', 'kayo' ),
					'param_name'         => 'overlay_text_color',
					'value'              => array_merge(
						$shared_colors,
						$shared_gradient_colors,
						array( esc_html__( 'Custom color', 'kayo' ) => 'custom' )
					),
					'std'                => apply_filters( 'wvc_default_item_overlay_text_color', 'white' ),
					'description'        => esc_html__( 'Select an overlay color.', 'kayo' ),
					'param_holder_class' => 'wvc_colored-dropdown',
					'dependency'         => array(
						'element' => 'event_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Overlay Custom Text Color', 'kayo' ),
					'param_name' => 'overlay_text_custom_color',
					'dependency' => array(
						'element' => 'overlay_text_color',
						'value'   => array( 'custom' ),
					),
				),

				array(
					'param_name'  => 'pagination',
					'heading'     => esc_html__( 'Pagination', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'None', 'kayo' ) => 'none',
						esc_html__( 'Link to Event Archives', 'kayo' ) => 'link_to_events',
					),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Animation', 'kayo' ),
					'param_name'  => 'item_animation',
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Number of Posts', 'kayo' ),
					'param_name'  => 'posts_per_page',
					'type'        => 'wvc_textfield',
					'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
					'admin_label' => true,
				),

				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Timeline', 'kayo' ),
					'param_name' => 'timeline',
					'value'      => array(
						esc_html__( 'Future', 'kayo' ) => 'future',
						esc_html__( 'Past', 'kayo' ) => 'past',
					),
					'group'      => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Include Artist', 'kayo' ),
					'param_name'  => 'artist_include',
					'description' => esc_html__( 'Enter one or several bands. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Artist', 'kayo' ),
					'param_name'  => 'artist_exclude',
					'description' => esc_html__( 'Enter one or several bands. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Offset', 'kayo' ),
					'description' => esc_html__( '.', 'kayo' ),
					'param_name'  => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query.', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'param_name'  => 'columns',
					'heading'     => esc_html__( 'Columns', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Auto', 'kayo' ) => 'default',
						esc_html__( 'Two', 'kayo' ) => 2,
						esc_html__( 'Three', 'kayo' ) => 3,
						esc_html__( 'Four', 'kayo' ) => 4,
						esc_html__( 'Five', 'kayo' ) => 5,
						esc_html__( 'Six', 'kayo' ) => 6,
						esc_html__( 'One', 'kayo' ) => 1,
					),
					'std'         => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
					'dependency'  => array(
						'element'            => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
				),
			),
		)
	);

	class WPBakeryShortCode_Wvc_Event_Index extends WPBakeryShortCode {} // phpcs:ignore
} // end Events plugin check.


if ( class_exists( 'Wolf_Portfolio' ) && ! class_exists( 'WPBakeryShortCode_Wvc_Work_Index' ) ) {

	/**
	 * Work Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Works', 'kayo' ),
			'description' => esc_html__( 'Display your works using the theme layouts', 'kayo' ),
			'base'        => 'wvc_work_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 999,
			'params'      => apply_filters('wvc_work_index_params', array(

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Index ID', 'kayo' ),
					'value'       => 'index-' . wp_rand( 0, 99999 ),
					'param_name'  => 'el_id',
					'description' => esc_html__( 'A unique identifier for the post module (required).', 'kayo' ),
				),

				array(
					'param_name'  => 'work_display',
					'heading'     => esc_html__( 'Work Display', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip(
						apply_filters(
							'kayo_work_display_options',
							array(
								'grid' => esc_html__( 'Grid', 'kayo' ),
							)
						)
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'work_metro_pattern',
					'heading'     => esc_html__( 'Metro Pattern', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_metro_patterns() ),
					'std'         => 'auto',
					'dependency'  => array(
						'element' => 'work_display',
						'value'   => array( 'metro' ),
					),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'work_module',
					'heading'     => esc_html__( 'Module', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Grid', 'kayo' ) => 'grid',
						esc_html__( 'Carousel', 'kayo' ) => 'carousel',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'work_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'work_thumbnail_size',
					'heading'     => esc_html__( 'Thumbnail Size', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Default Thumbnail', 'kayo' ) => 'standard',
						esc_html__( 'Landscape', 'kayo' ) => 'landscape',
						esc_html__( 'Square', 'kayo' ) => 'square',
						esc_html__( 'Portrait', 'kayo' ) => 'portrait',
						esc_html__( 'Custom', 'kayo' ) => 'custom',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'work_display',
						'value'   => array( 'grid' ),
					),
				),

				array(
					'param_name'  => 'work_custom_thumbnail_size',
					'heading'     => esc_html__( 'Custom Thumbnail Size', 'kayo' ),
					'type'        => 'wvc_textfield',
					'admin_label' => true,
					'placeholder' => '450x450',
					'dependency'  => array(
						'element' => 'work_thumbnail_size',
						'value'   => array( 'custom' ),
					),
				),

				array(
					'param_name'  => 'work_layout',
					'heading'     => esc_html__( 'Layout', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Classic', 'kayo' ) => 'standard',
						esc_html__( 'Overlay', 'kayo' ) => 'overlay',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element'            => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background', 'parallax' ),
					),
				),

				array(
					'param_name'  => 'grid_padding',
					'heading'     => esc_html__( 'Padding', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Yes', 'kayo' ) => 'yes',
						esc_html__( 'No', 'kayo' ) => 'no',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'work_layout',
						'value'   => array( 'overlay', 'flip-box' ),
					),
				),

				array(
					'heading'     => esc_html__( 'Category Filter', 'kayo' ),
					'param_name'  => 'work_category_filter',
					'type'        => 'checkbox',
					'description' => esc_html__( 'The pagination will be disabled.', 'kayo' ),
					'admin_label' => true,
					'dependency'  => array(
						'element'            => 'work_display',
						'value_not_equal_to' => array( 'list_minimal', 'text-background', 'parallax' ),
					),
				),

				array(
					'heading'    => esc_html__( 'Filter Text Alignement', 'kayo' ),
					'param_name' => 'work_category_filter_text_alignment',
					'type'       => 'dropdown',
					'value'      => array(
						esc_html__( 'Center', 'kayo' ) => 'center',
						esc_html__( 'Left', 'kayo' ) => 'left',
						esc_html__( 'Right', 'kayo' ) => 'right',
					),
					'dependency' => array(
						'element' => 'work_category_filter',
						'value'   => array( 'true' ),
					),
				),

				array(
					'heading'     => esc_html__( 'Animation', 'kayo' ),
					'param_name'  => 'item_animation',
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Number of Posts', 'kayo' ),
					'param_name'  => 'posts_per_page',
					'type'        => 'wvc_textfield',
					'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
					'admin_label' => true,
				),

				array(
					'param_name'  => 'pagination',
					'heading'     => esc_html__( 'Pagination', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'None', 'kayo' ) => 'none',
						esc_html__( 'Load More', 'kayo' ) => 'load_more',
						esc_html__( 'Link to Portfolio', 'kayo' ) => 'link_to_portfolio',
					),
					'admin_label' => true,
					'dependency'  => array(
						'element' => 'work_display',
						'value'   => array( 'grid', 'masonry' ),
					),
				),

				array(
					'heading'    => esc_html__( 'Additional CSS inline style', 'kayo' ),
					'param_name' => 'inline_style',
					'type'       => 'wvc_textfield',
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Include Category', 'kayo' ),
					'param_name'  => 'work_type_include',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Category', 'kayo' ),
					'param_name'  => 'work_type_exclude',
					'description' => esc_html__( 'Enter one or several categories. Paste category slug(s) separated by a comma', 'kayo' ),
					'placeholder' => esc_html__( 'my-category, other-category', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Offset', 'kayo' ),
					'description' => esc_html__( '.', 'kayo' ),
					'param_name'  => 'offset',
					'description' => esc_html__( 'The amount of posts that should be skipped in the beginning of the query.', 'kayo' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order by', 'kayo' ),
					'param_name'  => 'orderby',
					'value'       => $order_by_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Select how to sort retrieved posts. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Sort order', 'kayo' ),
					'param_name'  => 'order',
					'value'       => $order_way_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Designates the ascending or descending order. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Post IDs', 'kayo' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'include_ids',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Post IDs', 'kayo' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'exclude_ids',
					'group'       => esc_html__( 'Query', 'kayo' ),
				),

				array(
					'param_name'  => 'columns',
					'heading'     => esc_html__( 'Columns', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Auto', 'kayo' ) => 'default',
						esc_html__( 'Two', 'kayo' ) => 2,
						esc_html__( 'Three', 'kayo' ) => 3,
						esc_html__( 'Four', 'kayo' ) => 4,
						esc_html__( 'Five', 'kayo' ) => 5,
						esc_html__( 'Six', 'kayo' ) => 6,
						esc_html__( 'One', 'kayo' ) => 1,
					),
					'std'         => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
					'dependency'  => array(
						'element'            => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Extra class name', 'kayo' ),
					'param_name'  => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'kayo' ),
					'group'       => esc_html__( 'Extra', 'kayo' ),
				),
			) ),
		)
	);

	class WPBakeryShortCode_Wvc_Work_Index extends WPBakeryShortCode {} // phpcs:ignore
} // end Portfolio plugin check.

if ( ! class_exists( 'WPBakeryShortCode_Wvc_Page_Index' ) ) {

	$parent_pages = array( esc_html__( 'No', 'kayo' ) => '' );
	$all_pages    = get_pages();

	foreach ( $all_pages as $p ) {

		if ( 0 < count(
			get_posts(
				array(
					'post_parent' => $p->ID,
					'post_type'   => 'page',
				)
			)
		) ) {
			$parent_pages[ $p->post_title ] = $p->ID;
		}
	}

	/**
	 * Page Loop Module
	 */
	vc_map(
		array(
			'name'        => esc_html__( 'Pages', 'kayo' ),
			'description' => esc_html__( 'Display your pages using the theme layouts', 'kayo' ),
			'base'        => 'wvc_page_index',
			'category'    => esc_html__( 'Content', 'kayo' ),
			'icon'        => 'fa fa-th',
			'weight'      => 0,
			'params'      => array(

				array(
					'type'       => 'hidden',
					'heading'    => esc_html__( 'ID', 'kayo' ),
					'value'      => 'items-' . wp_rand( 0, 99999 ),
					'param_name' => 'el_id',
				),

				array(
					'param_name'  => 'page_display',
					'heading'     => esc_html__( 'Page Display', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array_flip(
						apply_filters(
							'kayo_page_display_options',
							array(
								'grid' => esc_html__( 'Image Grid', 'kayo' ),
							)
						)
					),
					'admin_label' => true,
				),


				array(
					'heading'     => esc_html__( 'Animation', 'kayo' ),
					'param_name'  => 'item_animation',
					'type'        => 'dropdown',
					'value'       => array_flip( kayo_get_animations() ),
					'admin_label' => true,
				),

				array(
					'heading'     => esc_html__( 'Number of Page to display', 'kayo' ),
					'param_name'  => 'posts_per_page',
					'type'        => 'wvc_textfield',
					'placeholder' => get_option( 'posts_per_page' ),
					'description' => esc_html__( 'Leave empty to display all post at once.', 'kayo' ),
					'std'         => get_option( 'posts_per_page' ),
					'admin_label' => true,
				),

				array(
					'heading'    => esc_html__( 'Additional CSS inline style', 'kayo' ),
					'param_name' => 'inline_style',
					'type'       => 'wvc_textfield',
				),

				array(
					'param_name' => 'page_by_parent',
					'heading'    => esc_html__( 'Pages By Parent', 'kayo' ),
					'type'       => 'dropdown',
					'value'      => $parent_pages,
					'group'      => esc_html( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Post IDs', 'kayo' ),
					'description' => esc_html__( 'By default, your last posts will be displayed. You can choose the posts you want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'include_ids',
					'group'       => esc_html( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'wvc_textfield',
					'heading'     => esc_html__( 'Exclude Post IDs', 'kayo' ),
					'description' => esc_html__( 'You can choose the posts you don\'t want to display by entering a list of IDs separated by a comma.', 'kayo' ),
					'param_name'  => 'exclude_ids',
					'group'       => esc_html( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Order by', 'kayo' ),
					'param_name'  => 'orderby',
					'value'       => $order_by_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Select how to sort retrieved pages. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html( 'Query', 'kayo' ),
				),

				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Sort order', 'kayo' ),
					'param_name'  => 'order',
					'value'       => $order_way_values,
					'save_always' => true,
					'description' => sprintf( kayo_kses( __( 'Designates the ascending or descending order. More at %s.', 'kayo' ) ), '<a href="http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters" target="_blank">WordPress codex page</a>' ),
					'group'       => esc_html( 'Query', 'kayo' ),
				),

				array(
					'param_name'  => 'columns',
					'heading'     => esc_html__( 'Columns', 'kayo' ),
					'type'        => 'dropdown',
					'value'       => array(
						esc_html__( 'Auto', 'kayo' ) => 'default',
						esc_html__( 'Two', 'kayo' ) => 2,
						esc_html__( 'Three', 'kayo' ) => 3,
						esc_html__( 'Four', 'kayo' ) => 4,
						esc_html__( 'Six', 'kayo' ) => 6,
						esc_html__( 'One', 'kayo' ) => 1,
					),
					'std'         => 'default',
					'admin_label' => true,
					'description' => esc_html__( 'By default, columns are set automatically depending on the container\'s width. Set a column count here to overwrite the default behavior.', 'kayo' ),
					'dependency'  => array(
						'element'            => 'post_display',
						'value_not_equal_to' => array( 'standard', 'standard_modern' ),
					),
					'group'       => esc_html__( 'Extra', 'kayo' ),
				),
			),
		)
	);

	class WPBakeryShortCode_Wvc_Page_Index extends WPBakeryShortCode {} // phpcs:ignore
}
