<?php
/**
 * Images device slider
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Image Slider', 'wolf-visual-composer' ),
		'description' => esc_html__( 'An elegant image slideshow', 'wolf-visual-composer' ),
		'base' => 'wvc_image_device_slider',
		'category' => esc_html__( 'Media' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-laptop',
		'params' => array(
			array(
				'type' => 'attach_images',
				'heading' => esc_html__( 'Images', 'wolf-visual-composer' ),
				'param_name' => 'images',
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Slider Height in Percent', 'wolf-visual-composer' ),
				'param_name' => 'height',
				'placeholder' => 60,
				'description' => esc_html__( 'You can set the height to "auto" and select an image size below.', 'wolf-visual-composer' ),
			),

			array(
				'type' => 'dropdown',
				'heading' => esc_html__( 'Image Size', 'wolf-visual-composer' ),
				'param_name' => 'img_size',
				'value' => wvc_get_image_sizes(),
				'description' => esc_html__( 'You can set the "large", "medium" and "thumbnail" sizes in the WP media settings.', 'wolf-visual-composer' ),
				'admin_label' => true,
			),

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Custom Image Size', 'wolf-visual-composer' ),
				'param_name' => 'custom_img_size',
				'description' => esc_html__( 'Enter size in pixels (Example: 200x100 (Width x Height).', 'wolf-visual-composer' ),
				'dependency' => array( 'element' => 'img_size', 'value' => array( 'custom' ) ),
			),

			array(
				'type' => 'hidden',
				'heading' => esc_html__( 'Layout', 'wolf-visual-composer' ),
				'param_name' => 'device',
				'value' => 'default',
			),

			// array(
			// 	'type' => 'dropdown',
			// 	'heading' => esc_html__( 'Layout', 'wolf-visual-composer' ),
			// 	'param_name' => 'device',
			// 	'value' => array(
			// 		esc_html__( 'None', 'wolf-visual-composer' ) => 'default',
			// 		esc_html__( 'Desktop Screen', 'wolf-visual-composer' ) => 'desktop',
			// 		esc_html__( 'Laptop Screen', 'wolf-visual-composer' ) => 'laptop',
			// 		esc_html__( 'Tablet Screen', 'wolf-visual-composer' ) => 'tablet',
			// 		esc_html__( 'Mobile Screen', 'wolf-visual-composer' ) => 'mobile',
			// 	),
			// 	'description' => esc_html__( 'If you choose a custom layout your image may be cropped.', 'wolf-visual-composer' ),
			// 	'admin_label' => true,
			// ),
		)
	)
);

class WPBakeryShortCode_Wvc_Image_Device_Slider extends WPBakeryShortCode {}