<?php
/**
 * Kayo metaboxes
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Register metaboxes
 *
 * Pass a metabox array to generate metabox with the  Wolf Metaboxes plugin
 */
function kayo_register_metabox() {

	$body_metaboxes = array(
		'site_settings' => array(
			'title' => esc_html__( 'General', 'kayo' ),
			'page' => apply_filters( 'kayo_site_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist', 'mp-event' ) ),

			'metafields' => array(

				array(
					'label'	=> '',
					'id'	=> '_post_subheading',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Accent Color', 'kayo' ),
					'id'	=> '_post_accent_color',
					'type'	=> 'colorpicker',
				),

				array(
					'label'	=> esc_html__( 'Content Background Color', 'kayo' ),
					'id'	=> '_post_content_inner_bg_color',
					'type'	=> 'colorpicker',
					'desc' => esc_html__( 'If you use the page builder and set your row background setting to "no background", you may want to change the overall content background color.', 'kayo' ),
				),

				array(
					'label' => esc_html__( 'Loading Animation Type', 'kayo' ),
					'id' => '_post_loading_animation_type',
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'overlay' => esc_html__( 'Overlay', 'kayo' ),
		 				'kayo' => esc_html__( 'Overlay with animation', 'kayo' ),
		 				'none' => esc_html__( 'None', 'kayo' ),
					),
				),
			),
		),
	);

	$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'None', 'kayo' ) . ' &mdash;',
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && class_exists( 'Wolf_Vc_Content_Block' ) && defined( 'WPB_VC_VERSION' ) ) {
		// Content block option
		$content_block_posts = get_posts( 'post_type="wvc_content_block"&numberposts=-1' );

		$content_blocks = array(
			'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
			'none' => esc_html__( 'None', 'kayo' ),
		);
		if ( $content_block_posts ) {
			foreach ( $content_block_posts as $content_block_options ) {
				$content_blocks[ $content_block_options->ID ] = $content_block_options->post_title;
			}
		} else {
			$content_blocks[0] = esc_html__( 'No Content Block Yet', 'kayo' );
		}

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'	=> esc_html__( 'Post-header Block', 'kayo' ),
			'id'	=> '_post_after_header_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
		);

		$body_metaboxes['site_settings']['metafields'][] = array(
			'label'	=> esc_html__( 'Pre-footer Block', 'kayo' ),
			'id'	=> '_post_before_footer_block',
			'type'	=> 'select',
			'choices' => $content_blocks,
		);

	}

	$header_metaboxes = array(
		'header_settings' => array(
			'title' => esc_html__( 'Header', 'kayo' ),
			'page' => apply_filters( 'kayo_header_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist', 'mp-event' ) ),

			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Header Layout', 'kayo' ),
					'id'	=> '_post_hero_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'standard' => esc_html__( 'Standard', 'kayo' ),
						'big' => esc_html__( 'Big', 'kayo' ),
						'small' => esc_html__( 'Small', 'kayo' ),
						'fullheight' => esc_html__( 'Full Height', 'kayo' ),
						'none' => esc_html__( 'No Header', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Title Font Family', 'kayo' ),
					'id'	=> '_post_hero_title_font_family',
					'type'	=> 'font_family',
				),

				array(
					'label'	=> esc_html__( 'Font Transform', 'kayo' ),
					'id'	=> '_post_hero_title_font_transform',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'uppercase' => esc_html__( 'Uppercase', 'kayo' ),
						'none' => esc_html__( 'None', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Big Text', 'kayo' ),
					'id'	=> '_post_hero_title_bigtext',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Enable "Big Text" for the title?', 'kayo' ),
				),

				array(
					'label'	=> esc_html__( 'Font Tone', 'kayo' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'kayo' ),
						'dark' => esc_html__( 'Dark', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Background Type', 'kayo' ),
					'id'	=> '_post_hero_background_type',
					'type'	=> 'select',
					'choices' => array(
						'featured-image' => esc_html__( 'Featured Image', 'kayo' ),
						'image' => esc_html__( 'Image', 'kayo' ),
						'video' => esc_html__( 'Video', 'kayo' ),
						'slideshow' => esc_html__( 'Slideshow', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Slideshow Images', 'kayo' ),
					'id'	=> '_post_hero_slideshow_ids',
					'type'	=> 'multiple_images',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'slideshow' ) ),
				),

				array(
					'label'	=> esc_html__( 'Background', 'kayo' ),
					'id'	=> '_post_hero_background',
					'type'	=> 'background',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'image' ) ),
				),

				array(
					'label'	=> esc_html__( 'Background Effect', 'kayo' ),
					'id'	=> '_post_hero_background_effect',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'zoomin' => esc_html__( 'Zoom', 'kayo' ),
						'parallax' => esc_html__( 'Parallax', 'kayo' ),
						'none' => esc_html__( 'None', 'kayo' ),
					),
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'image' ) ),
				),

				array(
					'label'	=> esc_html__( 'Video URL', 'kayo' ),
					'id'	=> '_post_hero_background_video_url',
					'type'	=> 'video',
					'dependency' => array( 'element' => '_post_hero_background_type', 'value' => array( 'video' ) ),
					'desc' => esc_html__( 'A mp4 or YouTube URL. The featured image will be used as image fallback when the video cannot be displayed.', 'kayo' ),
				),

				array(
					'label'	=> esc_html__( 'Overlay', 'kayo' ),
					'id'	=> '_post_hero_overlay',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'custom' => esc_html__( 'Custom', 'kayo' ),
						'none' => esc_html__( 'None', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Overlay Color', 'kayo' ),
					'id'	=> '_post_hero_overlay_color',
					'type'	=> 'colorpicker',
					//'value' 	=> '#000000',
					'dependency' => array( 'element' => '_post_hero_overlay', 'value' => array( 'custom' ) ),
				),

				array(
					'label'	=> esc_html__( 'Overlay Opacity (in percent)', 'kayo' ),
					'id'	=> '_post_hero_overlay_opacity',
					'desc'	=> esc_html__( 'Adapt the header overlay opacity if needed', 'kayo' ),
					'type'	=> 'int',
					'placeholder'	=> 40,
					'dependency' => array( 'element' => '_post_hero_overlay', 'value' => array( 'custom' ) ),
				),

			),
		),
	);

	$menu_metaboxes = array(
			'menu_settings' => array(
				'title' => esc_html__( 'Menu', 'kayo' ),
				'page' => apply_filters( 'kayo_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event', 'artist', 'mp-event' ) ),

			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Menu Layout', 'kayo' ),
					'id'	=> '_post_menu_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'top-right' => esc_html__( 'Top Right', 'kayo' ),
						'top-justify' => esc_html__( 'Top Justify', 'kayo' ),
						'top-justify-left' => esc_html__( 'Top Justify Left', 'kayo' ),
						'centered-logo' => esc_html__( 'Centered', 'kayo' ),
						'top-left' => esc_html__( 'Top Left', 'kayo' ),
						//'offcanvas' => esc_html__( 'Off Canvas', 'kayo' ),
						//'overlay' => esc_html__( 'Overlay', 'kayo' ),
						'lateral' => esc_html__( 'Lateral', 'kayo' ),
						'none' => esc_html__( 'No Menu', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Width', 'kayo' ),
					'id'	=> '_post_menu_width',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'wide' => esc_html__( 'Wide', 'kayo' ),
						'boxed' => esc_html__( 'Boxed', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Menu Style', 'kayo' ),
					'id'	=> '_post_menu_style',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'solid' => esc_html__( 'Solid', 'kayo' ),
						'semi-transparent-white' => esc_html__( 'Semi-transparent White', 'kayo' ),
						'semi-transparent-black' => esc_html__( 'Semi-transparent Black', 'kayo' ),
						'transparent' => esc_html__( 'Transparent', 'kayo' ),
						//'none' => esc_html__( 'No Menu', 'kayo' ),
					),
				),

				/*array(
					'label'	=> esc_html__( 'Menu Skin', 'kayo' ),
					'id'	=> '_post_menu_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'kayo' ),
						'dark' => esc_html__( 'Dark', 'kayo' ),
						//'none' => esc_html__( 'No Menu', 'kayo' ),
					),
				),*/

				'menu_sticky_type' => array(
					'id' =>'_post_menu_sticky_type',
					'label' => esc_html__( 'Sticky Menu', 'kayo' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'none' => esc_html__( 'Disabled', 'kayo' ),
						'soft' => esc_html__( 'Sticky on scroll up', 'kayo' ),
						'hard' => esc_html__( 'Always sticky', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Sticky Menu Skin', 'kayo' ),
					'id'	=> '_post_menu_skin',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'kayo' ),
						'dark' => esc_html__( 'Dark', 'kayo' ),
						//'none' => esc_html__( 'No Menu', 'kayo' ),
					),
				),

				array(
					'id' => '_post_menu_cta_content_type',
					'label' => esc_html__( 'Additional Content', 'kayo' ),
					'type' => 'select',
					'default' => 'icons',
					'choices' => array_merge(
						array(
							'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						),
						apply_filters( 'kayo_menu_cta_content_type_options', array(
							'search_icon' => esc_html__( 'Search Icon', 'kayo' ),
							'secondary-menu' => esc_html__( 'Secondary Menu', 'kayo' ),
						) ),
						array( 'none' => esc_html__( 'None', 'kayo' ) )
					),
				),

				array(
					'id' => '_post_show_nav_player',
					'label' => esc_html__( 'Show Navigation Player', 'kayo' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'kayo' ),
						'no' => esc_html__( 'No', 'kayo' ),
					),
				),

				array(
					'id' => '_post_side_panel_position',
					'label' => esc_html__( 'Side Panel', 'kayo' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'none' => esc_html__( 'None', 'kayo' ),
						'right' => esc_html__( 'At Right', 'kayo' ),
						'left' => esc_html__( 'At Left', 'kayo' ),
					),
					'desc' => esc_html__( 'Note that it will be disable with a vertical menu layout (overlay, offcanvas etc...).', 'kayo' ),
				),

				array(
					'id' => '_post_logo_visibility',
					'label' => esc_html__( 'Logo Visibility', 'kayo' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'always' => esc_html__( 'Always', 'kayo' ),
						'sticky_menu' => esc_html__( 'When menu is sticky only', 'kayo' ),
						'hidden' => esc_html__( 'Hidden', 'kayo' ),
					),
				),

				array(
					'id' => '_post_menu_items_visibility',
					'label' => esc_html__( 'Menu Items Visibility', 'kayo' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'show' => esc_html__( 'Visible', 'kayo' ),
						'hidden' => esc_html__( 'Hidden', 'kayo' ),
					),
					'desc' => esc_html__( 'If, for some reason, you need to hide the menu items but leave the logo, additional content and side panel.', 'kayo' ),
				),

				'menu_breakpoint' => array(
					'id' =>'_post_menu_breakpoint',
					'label' => esc_html__( 'Mobile Menu Breakpoint', 'kayo' ),
					'type' => 'text',
					'desc' => esc_html__( 'Use this field if you want to overwrite the mobile menu breakpoint.', 'kayo' ),
				),
			),
		)
	);

	$footer_metaboxes = array(
		'footer_settings' => array(
				'title' => esc_html__( 'Footer', 'kayo' ),
				'page' => apply_filters( 'kayo_menu_settings_post_types', array( 'post', 'page', 'plugin', 'video', 'product', 'gallery', 'theme', 'work', 'show', 'release', 'wpm_playlist', 'event' ) ),

			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Page Footer', 'kayo' ),
					'id'	=> '_post_footer_type',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'hidden' => esc_html__( 'No Footer', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Hide Bottom Bar', 'kayo' ),
					'id'	=> '_post_bottom_bar_hidden',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'kayo' ),
						'yes' => esc_html__( 'Yes', 'kayo' ),
					),
				),
			),
		)
	);

	/************** Post options ******************/

	$product_options = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'kayo' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {

			$product_options[] = esc_html__( 'Not linked', 'kayo' );

			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'kayo' ) ] = 0;
		}
	}

	$post_metaboxes = array(
		'post_settings' => array(
			'title' => esc_html__( 'Post', 'kayo' ),
			'page' => array( 'post' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Post Layout', 'kayo' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'sidebar-right' => esc_html__( 'Sidebar Right', 'kayo' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'kayo' ),
						'no-sidebar' => esc_html__( 'No Sidebar', 'kayo' ),
						'fullwidth' => esc_html__( 'Full width', 'kayo' ),
					),
				),

				// array(
				// 	'label'	=> esc_html__( 'Feature a Product', 'kayo' ),
				// 	'id'	=> '_post_wc_product_id',
				// 	'type'	=> 'select',
				// 	'choices' => $product_options,
				// 	'desc'	=> esc_html__( 'A "Shop Now" buton will be displayed in the metro layout.', 'kayo' ),
				// ),

				array(
					'label'	=> esc_html__( 'Featured', 'kayo' ),
					'id'	=> '_post_featured',
					'type'	=> 'checkbox',
					'desc'	=> esc_html__( 'Will be displayed bigger in the "metro" layout (auto pattern).', 'kayo' ),
				),
			),
		),
	);

	/************** Product options ******************/
	$product_metaboxes = array(

		'product_options' => array(
			'title' => esc_html__( 'Product', 'kayo' ),
			'page' => array( 'product' ),
			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Label', 'kayo' ),
					'id'	=> '_post_product_label',
					'type'	=> 'text',
					'placeholder' => esc_html__( '-30%', 'kayo' ),
				),

				array(
					'label'	=> esc_html__( 'Layout', 'kayo' ),
					'id'	=> '_post_product_single_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'standard' => esc_html__( 'Standard', 'kayo' ),
						'sidebar-right' => esc_html__( 'Sidebar Right', 'kayo' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'kayo' ),
						'fullwidth' => esc_html__( 'Full Width', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'MP3', 'kayo' ),
					'id'	=> '_post_product_mp3',
					'type'	=> 'file',
					'desc' => esc_html__( 'If you want to display a player for a song you want to sell, paste the mp3 URL here.', 'kayo' ),
				),

				array(
					'label'	=> esc_html__( 'Size Chart Image', 'kayo' ),
					'id'	=> '_post_wc_product_size_chart_img',
					'type'	=> 'image',
					'desc' => esc_html__( 'You can set a size chart image in the product category options. You can overwrite the category size chart for this product by uploading another image here.', 'kayo' ),
				),

				array(
					'label'	=> esc_html__( 'Hide Size Chart Image', 'kayo' ),
					'id'	=> '_post_wc_product_hide_size_chart_img',
					'type'	=> 'checkbox',
				),

				array(
					'label'	=> esc_html__( 'Menu Font Tone', 'kayo' ),
					'id'	=> '_post_hero_font_tone',
					'type'	=> 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'light' => esc_html__( 'Light', 'kayo' ),
						'dark' => esc_html__( 'Dark', 'kayo' ),
					),
					'desc' => esc_html__( 'By default the menu style is set to "solid" on single product page. If you change the menu style, you may need to adujst the menu color tone here.', 'kayo' ),
				),

				'menu_sticky_type' => array(
					'id' =>'_post_product_sticky',
					'label' => esc_html__( 'Stacked Images', 'kayo' ),
					'type' => 'select',
					'choices' => array(
						'' => '&mdash; ' . esc_html__( 'Default', 'kayo' ) . ' &mdash;',
						'yes' => esc_html__( 'Yes', 'kayo' ),
						'no' => esc_html__( 'No', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Disable Image Zoom', 'kayo' ),
					'id'	=> '_post_product_disable_easyzoom',
					'type'	=> 'checkbox',
					'desc' => esc_html__( 'Disable image zoom on this product if it\'s enabled in the customizer.', 'kayo' ),
				),
			),
		),
	);

	/************** Product options ******************/

	$product_options = array();
	$product_options[] = esc_html__( 'WooCommerce not installed', 'kayo' );

	if ( class_exists( 'WooCommerce' ) ) {
		$product_posts = get_posts( 'post_type="product"&numberposts=-1' );

		$product_options = array();
		if ( $product_posts ) {

			$product_options[] = esc_html__( 'Not linked', 'kayo' );

			foreach ( $product_posts as $product ) {
				$product_options[ $product->ID ] = $product->post_title;
			}
		} else {
			$product_options[ esc_html__( 'No product yet', 'kayo' ) ] = 0;
		}
	}

	// if ( class_exists( 'Wolf_Playlist_Manager' ) ) {
	// 	// Player option
	// 	$playlist_posts = get_posts( 'post_type="wpm_playlist"&numberposts=-1' );

	// 	$playlist = array( '' => esc_html__( 'None', 'kayo' ) );
	// 	if ( $playlist_posts ) {
	// 		foreach ( $playlist_posts as $playlist_options ) {
	// 			$playlist[ $playlist_options->ID ] = $playlist_options->post_title;
	// 		}
	// 	} else {
	// 		$playlist[0] = esc_html__( 'No Playlist Yet', 'kayo' );
	// 	}

	// 	$product_metaboxes['product_options']['metafields'][] = array(
	// 		'label'	=> esc_html__( 'Playlist', 'kayo' ),
	// 		'id'	=> '_post_product_playlist_id',
	// 		'type'	=> 'select',
	// 		'choices' => $playlist,
	// 		'desc' => esc_html__( 'It will overwrite the single player.', 'kayo' ),
	// 	);

	// 	$product_metaboxes['product_options']['metafields'][] = array(
	// 		'label'	=> esc_html__( 'Playlist Skin', 'kayo' ),
	// 		'id'	=> '_post_product_playlist_skin',
	// 		'type'	=> 'select',
	// 		'choices' => array(
	// 			'dark' => esc_html__( 'Dark', 'kayo' ),
	// 			'light' => esc_html__( 'Light', 'kayo' ),
	// 		),
	// 	);
	// }

	/************** Portfolio options ******************/
	$work_metaboxes = array(

		'work_options' => array(
			'title' => esc_html__( 'Work', 'kayo' ),
			'page' => array( 'work' ),
			'metafields' => array(

				array(
					'label'	=> esc_html__( 'Client', 'kayo' ),
					'id'	=> '_work_client',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Link', 'kayo' ),
					'id'		=> '_work_link',
					'type'	=> 'text',
				),

				array(
					'label'	=> esc_html__( 'Width', 'kayo' ),
					'id'	=> '_post_width',
					'type'	=> 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'kayo' ),
						'wide' => esc_html__( 'Wide', 'kayo' ),
						'fullwidth' => esc_html__( 'Full Width', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Layout', 'kayo' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'centered' => esc_html__( 'Centered', 'kayo' ),
						'sidebar-right' => esc_html__( 'Excerpt & Info at Right', 'kayo' ),
						'sidebar-left' => esc_html__( 'Excerpt & Info at Left', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Excerpt & Info Position', 'kayo' ),
					'id'	=> '_post_work_info_position',
					'type'	=> 'select',
					'choices' => array(
						'after' => esc_html__( 'After Content', 'kayo' ),
						'before' => esc_html__( 'Before Content', 'kayo' ),
						'none' => esc_html__( 'Hidden', 'kayo' ),
					),
				),

				// array(
				// 	'label'	=> esc_html__( 'Featured', 'kayo' ),
				// 	'id'	=> '_post_featured',
				// 	'type'	=> 'checkbox',
				// 	'desc'	=> esc_html__( 'The featured image will be display bigger in the "metro" layout.', 'kayo' ),
				// ),
			),
		),
	);

	/************** One pager options ******************/
	$one_page_metaboxes = array(
		'one_page_settings' => array(
			'title' => esc_html__( 'One-Page', 'kayo' ),
			'page' => array( 'post', 'page', 'work', 'product', 'release' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'One-Page Navigation', 'kayo' ),
					'id'	=> '_post_one_page_menu',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'No', 'kayo' ),
						'replace_main_nav' => esc_html__( 'Yes', 'kayo' ),
					),
					'desc'	=> kayo_kses( __( 'Activate to replace the main menu by a one-page scroll navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'kayo' ) ),
				),
				array(
					'label'	=> esc_html__( 'One-Page Bullet Navigation', 'kayo' ),
					'id'	=> '_post_scroller',
					'type'	=> 'checkbox',
					'desc'	=> kayo_kses( __( 'Activate to create a section scroller navigation. <strong>NB: Every row must have a unique name set in the row settings "Advanced" tab.</strong>', 'kayo' ) ),
				),
				// array(
				// 	'label'	=> sprintf( esc_html__( 'Enable %s animations', 'kayo' ), 'fullPage' ),
				// 	'id'	=> '_post_fullpage',
				// 	'type'	=> 'select',
				// 	'choices' => array(
				// 		'' => esc_html__( 'No', 'kayo' ),
				// 		'yes' => esc_html__( 'Yes', 'kayo' ),
				// 	),
				// 	'desc' => esc_html__( 'Activate to enable advanced scroll animations between sections. Some of your row setting may be disabled to suit the global page design.', 'kayo' ),
				// ),

				// array(
				// 	'label'	=> sprintf( esc_html__( '%s animation transition', 'kayo' ), 'fullPage' ),
				// 	'id'	=> '_post_fullpage_transition',
				// 	'type'	=> 'select',
				// 	'choices' => array(
				// 		'mix' => esc_html__( 'Special', 'kayo' ),
				// 		'parallax' => esc_html__( 'Parallax', 'kayo' ),
				// 		'fade' => esc_html__( 'Fade', 'kayo' ),
				// 		'zoom' => esc_html__( 'Zoom', 'kayo' ),
				// 		'curtain' => esc_html__( 'Curtain', 'kayo' ),
				// 		'slide' => esc_html__( 'Slide', 'kayo' ),
				// 	),
				// 	'dependency' => array( 'element' => '_post_fullpage', 'value' => array( 'yes' ) ),
				//),

				// array(
				// 	'label'	=> sprintf( esc_html__( '%s animation duration', 'kayo' ), 'fullPage' ),
				// 	'id'	=> '_post_fullpage_animtime',
				// 	'type'	=> 'text',
				// 	'placeholder' => 1000,
				// 	'dependency' => array( 'element' => '_post_fullpage', 'value' => array( 'yes' ) ),
				// ),
			),
		),
	);

	$release_metaboxes = array(
		'release_options' => array(
			'title' => esc_html__( 'Release', 'kayo' ),
			'page' => array( 'release' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Release Width', 'kayo' ),
					'id'	=> '_post_width',
					'type'	=> 'select',
					'choices' => array(
						'standard' => esc_html__( 'Standard', 'kayo' ),
						'wide' => esc_html__( 'Wide', 'kayo' ),
						//'fullwidth' => esc_html__( 'Full Width', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'Release Layout', 'kayo' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'sidebar-left' => esc_html__( 'Content Right', 'kayo' ),
						'sidebar-right' => esc_html__( 'Content Left', 'kayo' ),
						//'centered' => esc_html__( 'Centered', 'kayo' ),
					),
				),

				array(
					'label'	=> esc_html__( 'WooCommerce Product ID', 'kayo' ),
					'id'	=> '_post_wc_product_id',
					'type'	=> 'select',
					'choices' => $product_options,
					'desc'	=> esc_html__( 'You can link this release to a WooCommerce product to add an "Add to cart" button.', 'kayo' ),
				),

				array(
					'label'	=> esc_html__( 'Featured', 'kayo' ),
					'id'	=> '_post_featured',
					'type'	=> 'checkbox',
					'desc'	=> esc_html__( 'May be used depending on layout option.', 'kayo' ),
				),
			),
		),
	);

	/************** Video options ******************/
	$video_metaboxes = array(
		'video_settings' => array(
			'title' => esc_html__( 'Video', 'kayo' ),
			'page' => array( 'video' ),
			'metafields' => array(
				array(
					'label'	=> esc_html__( 'Layout', 'kayo' ),
					'id'	=> '_post_layout',
					'type'	=> 'select',
					'choices' => array(
						'' => esc_html__( 'Default', 'kayo' ),
						'standard' => esc_html__( 'Standard', 'kayo' ),
						'sidebar-right' => esc_html__( 'Sidebar Right', 'kayo' ),
						'sidebar-left' => esc_html__( 'Sidebar Left', 'kayo' ),
						'fullwidth' => esc_html__( 'Full Width', 'kayo' ),
					),
				),
			),
		),
	);

	$all_metaboxes = array_merge(
		apply_filters( 'kayo_body_metaboxes', $body_metaboxes ),
		apply_filters( 'kayo_post_metaboxes', $post_metaboxes ),
		apply_filters( 'kayo_product_metaboxes', $product_metaboxes ),
		apply_filters( 'kayo_release_metaboxes', $release_metaboxes ),
		apply_filters( 'kayo_work_metaboxes', $work_metaboxes ),
		apply_filters( 'kayo_video_metaboxes',  $video_metaboxes ),
		apply_filters( 'kayo_header_metaboxes', $header_metaboxes ),
		apply_filters( 'kayo_menu_metaboxes', $menu_metaboxes ),
		apply_filters( 'kayo_footer_metaboxes', $footer_metaboxes )
	);

	if ( class_exists( 'Wolf_Visual_Composer' ) && defined( 'WPB_VC_VERSION' ) ) {
		$all_metaboxes = $all_metaboxes + apply_filters( 'kayo_one_page_metaboxes', $one_page_metaboxes );
	}

	if ( class_exists( 'Wolf_Metaboxes' ) ) {
		new Wolf_Metaboxes( apply_filters( 'kayo_metaboxes', $all_metaboxes ) );
	}
}
kayo_register_metabox();
