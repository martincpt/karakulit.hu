<?php
/**
 * Video opener
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

// Video opener
vc_map(
	array(
		'name' => esc_html__( 'Video Opener', 'wolf-visual-composer' ),
		'base' => 'wvc_video_opener',
		'description' => esc_html__( 'Open a video in a lightbox', 'wolf-visual-composer' ),
		'icon' => 'fa fa-play-circle-o',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Custom Play Button', 'wolf-visual-composer' ),
				'param_name' => 'custom_play_button',
				'value' => array(
					esc_html__( 'No', 'wolf-visual-composer' ) => '',
					esc_html__( 'Yes', 'wolf-visual-composer' ) => 'yes',
				),
			),

			array(
				'type' => 'attach_image',
				'heading' => esc_html__( 'Button Image', 'wolf-visual-composer' ),
				'param_name' => 'button_image',
				'dependency' => array( 'element' => 'custom_play_button', 'value' => array( 'yes' ) ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Alignment', 'wolf-visual-composer' ),
				'param_name' => 'alignment',
				'value' => array(
					esc_html__( 'center', 'wolf-visual-composer' ) => 'center',
					esc_html__( 'left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'right', 'wolf-visual-composer' ) => 'right',
				),
			),

			// array(
			// 	'type' => 'wvc_textfield',
			// 	'heading' => esc_html__( 'Video URL', 'wolf-visual-composer' ),
			// 	'param_name' => 'video_url',
			// 	'placeholder' => 'https://vimeo.com/124894010',
			// 	'description' => sprintf(
			// 		esc_html__( 'Support %1$s and %2$s', 'wolf-visual-composer' ),
			// 		'YouTube',
			// 		'Vimeo'
			// 	),
			// 	'admin_label' => true,
			// ),

			array(
				'type' => 'wvc_video_url',
				'heading' => esc_html__( 'Video URL', 'wolf-visual-composer' ),
				'param_name' => 'video_url',
				'description' => esc_html__( 'A YouTube, Vimeo, or mp4 URL.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Caption Position', 'wolf-visual-composer' ),
				'param_name' => 'caption_position',
				'value' => array(
					esc_html__( 'None', 'wolf-visual-composer' ) => 'none',
					esc_html__( 'Bottom', 'wolf-visual-composer' ) => 'bottom',
					esc_html__( 'Right', 'wolf-visual-composer' ) => 'right',
					esc_html__( 'Left', 'wolf-visual-composer' ) => 'left',
					esc_html__( 'Top', 'wolf-visual-composer' ) => 'top',
				),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Caption', 'wolf-visual-composer' ),
				'param_name' => 'caption',
				'placeholder' => esc_html__( 'Watch "My Video Title"', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'caption_position', 'value_not_equal_to' => array( 'none' ) ),
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Duration', 'wolf-visual-composer' ),
				'param_name' => 'duration',
				'dependency' => array( 'element' => 'caption_position', 'value_not_equal_to' => array( 'none' ) ),
			),

			// array(
			// 	'type' => 'dropdown',
			// 	'heading' => esc_html__( 'Background color', 'wolf-visual-composer' ),
			// 	'param_name' => 'background_color',
			// 	'value' => array_merge( wvc_get_shared_colors(), array(
			// 			esc_html__( 'Custom color', 'wolf-visual-composer' ) => 'custom',
			// 		)
			// 	),
			// 	'description' => esc_html__( 'Select background color for icon.', 'wolf-visual-composer' ),
			// 	'param_holder_class' => 'wvc_colored-dropdown',
			// ),
			// array(
			// 	'type' => 'colorpicker',
			// 	'heading' => esc_html__( 'Custom background color', 'wolf-visual-composer' ),
			// 	'param_name' => 'custom_background_color',
			// 	'description' => esc_html__( 'Select custom icon background color.', 'wolf-visual-composer' ),
			// 	'dependency' => array(
			// 		'element' => 'background_color',
			// 		'value' => 'custom',
			// 	),
			// ),

			// array(
			// 	'type' => 'checkbox',
			// 	'heading' => esc_html__( 'Attention seeker', 'wolf-visual-composer' ),
			// 	'param_name' => 'attention_seeker',
			// 	'description' => esc_html__( 'Add a animation effect to grab visitor attention', 'wolf-visual-composer' ),
			// ),
		),
	)
);
class WPBakeryShortCode_Wvc_Video_Opener extends WPBakeryShortCode {}