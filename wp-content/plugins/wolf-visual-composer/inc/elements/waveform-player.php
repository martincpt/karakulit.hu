<?php
/**
 * Waveform Player
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Elements
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

vc_map(
	array(
		'name' => esc_html__( 'Waveform Player', 'wolf-visual-composer' ),
		'base' => 'wvc_waveform_player',
		'description' => esc_html__( 'Waveform Player', 'wolf-visual-composer' ),
		'category' => esc_html__( 'Music' , 'wolf-visual-composer' ),
		'icon' => 'fa fa-music',
		'params' => array(

			array(
				'type' => 'wvc_audio_url',
				'heading' => esc_html__( 'Mp3 URL', 'wolf-visual-composer' ),
				'param_name' => 'mp3',
				'admin_label' => true,
			),
		),
	)
);

class WPBakeryShortCode_Wvc_Wavform_Player_Gallery extends WPBakeryShortCode {}