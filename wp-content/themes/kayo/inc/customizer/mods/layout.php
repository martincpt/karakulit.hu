<?php
/**
 * Kayo layout
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Site layout mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_layout_mods( $mods ) {

	$mods['layout'] = array(

		'id'      => 'layout',
		'title'   => esc_html__( 'Layout', 'kayo' ),
		'icon'    => 'layout',
		'options' => array(

			'site_layout'  => array(
				'id'        => 'site_layout',
				'label'     => esc_html__( 'General', 'kayo' ),
				'type'      => 'radio_images',
				'default'   => 'wide',
				'choices'   => array(
					array(
						'key'   => 'wide',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/wide.png' ),
						'text'  => esc_html__( 'Wide', 'kayo' ),
					),

					array(
						'key'   => 'boxed',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/boxed.png' ),
						'text'  => esc_html__( 'Boxed', 'kayo' ),
					),

					array(
						'key'   => 'frame',
						'image' => get_parent_theme_file_uri( 'assets/img/customizer/site-layout/frame.png' ),
						'text'  => esc_html__( 'Frame', 'kayo' ),
					),
				),
				'transport' => 'postMessage',
			),

			'button_style' => array(
				'id'        => 'button_style',
				'label'     => esc_html__( 'Button Shape', 'kayo' ),
				'type'      => 'select',
				'choices'   => array(
					'standard' => esc_html__( 'Standard', 'kayo' ),
					'square'   => esc_html__( 'Square', 'kayo' ),
					'round'    => esc_html__( 'Round', 'kayo' ),
				),
				'transport' => 'postMessage',
			),
		),
	);

	if ( class_exists( 'Wolf_Vc_Content_Block' ) || class_exists( 'Wolf_Core' ) ) {

		$content_block_post_slug = ( class_exists( 'Wolf_Core' ) ) ? 'wolf_content_block' : 'wvc_content_block';

		$content_block_posts = get_posts( 'post_type="' . $content_block_post_slug . '"&numberposts=-1' );

		$content_blocks = array( '' => esc_html__( 'None', 'kayo' ) );
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'kayo' );
		}

		/*
		$mods['layout']['options']['top_bar_block_id'] = [
			'label'	=> esc_html__( 'Top Bar Block', 'kayo' ),
			'id'	=> 'top_bar_block_id',
			'type'	=> 'select',
			'choices' => $content_blocks,
			'description' => esc_html__( 'A block to display above the navigation.', 'kayo' ),
		);
		*/

		$mods['layout']['options']['after_header_block'] = array(
			'label'       => esc_html__( 'Post-header Block', 'kayo' ),
			'id'          => 'after_header_block',
			'type'        => 'select',
			'choices'     => $content_blocks,
			'description' => esc_html__( 'A block to display below to header or in replacement of the header.', 'kayo' ),
		);

		$mods['layout']['options']['before_footer_block'] = array(
			'label'       => esc_html__( 'Pre-footer Block', 'kayo' ),
			'id'          => 'before_footer_block',
			'type'        => 'select',
			'choices'     => $content_blocks,
			'description' => esc_html__( 'A block to display above to footer or in replacement of the footer.', 'kayo' ),
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_layout_mods' );
