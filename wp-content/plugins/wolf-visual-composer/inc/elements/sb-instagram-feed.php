<?php
/**
 * Instagram element
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Instagram Feed (Smash Balloon)', 'wolf-visual-composer' ),
		'base' => 'wvc_sb_instagram_feed',
		'description' => esc_html__( 'Your last instagram photos', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Social' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-instagram',
		'params' => array(
			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Image Count', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Note that the instagram API may limit the number of image to display.', 'wolf-visual-composer' ),
				'param_name' => 'num',
				'value' => 18,
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Columns', 'wolf-visual-composer' ),
				'param_name' => 'cols',
				'value' => array( 6, 4, 3, 2 ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'User', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Your Instagram User Name. This must be from a connected account on the "Configure" tab.', 'wolf-visual-composer' ),
				'param_name' => 'username',
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'API key (optional)', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Leave empty to use the default API key set in the plugin settings.', 'wolf-visual-composer' ),
				'param_name' => 'accesstoken',
				'admin_label' => true,
			),

			// array(
			// 	'type' => 'wvc_textfield',
			// 	'heading' => esc_html__( 'Hashtag', 'wolf-visual-composer' ),
			// 	'description' => esc_html__( 'Only one hashtag allowed', 'wolf-visual-composer' ),
			// 	'param_name' => 'tag',
			// 	'admin_label' => true,
			// ),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Display follow button (theme style)', 'wolf-visual-composer' ),
				'param_name' => 'follow_button',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Button Text (theme style)', 'wolf-visual-composer' ),
				'param_name' => 'button_text',
				'dependency' => array( 'element' => 'follow_button', 'value' => array( 'true' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Padding', 'wolf-visual-composer' ),
				'param_name' => 'imagepadding',
			),

			/*array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Hide icon', 'wolf-visual-composer' ),
				'param_name' => 'hide_meta',
			),*/

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show Header', 'wolf-visual-composer' ),
				'param_name' => 'showheader',
				'description' => esc_html__( 'Whether to show the feed Header.', 'wolf-visual-composer' ),
			),

			// array(
			// 	'type' => 'checkbox',
			// 	'heading' => esc_html__( 'Show Bio', 'wolf-visual-composer' ),
			// 	'param_name' => 'showbio',
			// 	'description' => esc_html__( 'Display the bio in the header.', 'wolf-visual-composer' ),
			// ),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show "Follow" button', 'wolf-visual-composer' ),
				'param_name' => 'showfollow',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Show "Load More" button', 'wolf-visual-composer' ),
				'param_name' => 'showbutton',
			),

			array(
				'type' => 'checkbox',
				'heading' => esc_html__( 'Disable Default Hover Effect', 'wolf-visual-composer' ),
				'description' => esc_html__( 'Check this option to set your own hover effect if you have the pro version of the Instagram Feed plugin.', 'wolf-visual-composer' ),
				'param_name' => 'disable_default_hover',
			),
		)
	)
);

class WPBakeryShortCode_Instagram_Feed extends WPBakeryShortCode {}