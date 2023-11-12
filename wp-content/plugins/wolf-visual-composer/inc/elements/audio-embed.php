<?php
/**
 * Audio Embed
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

// Audio
vc_map(
	array(
		'name' => esc_html__( 'Embed Audio Player', 'wolf-visual-composer' ),
		'base' => 'wvc_audio_embed',
		'description' => esc_html__( 'Supports Mixcloud, ReverbNation, Soundcloud and Spotify', 'wolf-visual-composer' ),
		'icon' => 'fa fa-music',
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'params' => array(

			array(
				'type' => 'wvc_textfield',
				'heading' => esc_html__( 'Player URL', 'wolf-visual-composer' ),
				'param_name' => 'link',
				'placeholder' => 'https://',
				'admin_label' => true,
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Audio_Embed extends WPBakeryShortCode {}