<?php
/**
 * Kayo shop
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Shop mods
 *
 * @param array $mods Array of mods.
 * @return array
 */
function kayo_set_product_mods( $mods ) {

	if ( class_exists( 'WooCommerce' ) ) {
		$mods['shop'] = array(
			'id'      => 'shop',
			'title'   => esc_html__( 'Shop', 'kayo' ),
			'icon'    => 'cart',
			'options' => array(

				'product_layout'            => array(
					'id'        => 'product_layout',
					'label'     => esc_html__( 'Products Layout', 'kayo' ),
					'type'      => 'select',
					'choices'   => array(
						'standard'      => esc_html__( 'Standard', 'kayo' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'kayo' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'kayo' ),
						'fullwidth'     => esc_html__( 'Full width', 'kayo' ),
					),
					'transport' => 'postMessage',
				),

				'product_display'           => array(
					'id'      => 'product_display',
					'label'   => esc_html__( 'Products Archive Display', 'kayo' ),
					'type'    => 'select',
					/**
					 * Filters product post display options
					 *
					 * @since 1.0.0
					 */
					'choices' => apply_filters(
						'kayo_product_display_options',
						array(
							'grid_classic' => esc_html__( 'Grid', 'kayo' ),
						)
					),
				),
				'product_single_layout'     => array(
					'id'        => 'product_single_layout',
					'label'     => esc_html__( 'Single Product Layout', 'kayo' ),
					'type'      => 'select',
					'choices'   => array(
						'standard'      => esc_html__( 'Standard', 'kayo' ),
						'sidebar-right' => esc_html__( 'Sidebar at right', 'kayo' ),
						'sidebar-left'  => esc_html__( 'Sidebar at left', 'kayo' ),
						'fullwidth'     => esc_html__( 'Full Width', 'kayo' ),
					),
					'transport' => 'postMessage',
				),

				'product_columns'           => array(
					'id'      => 'product_columns',
					'label'   => esc_html__( 'Columns', 'kayo' ),
					'type'    => 'select',
					'choices' => array(
						'default' => esc_html__( 'Auto', 'kayo' ),
						3         => 3,
						2         => 2,
						4         => 4,
						6         => 6,
					),
				),

				'product_item_animation'    => array(
					'label'   => esc_html__( 'Shop Archive Item Animation', 'kayo' ),
					'id'      => 'product_item_animation',
					'type'    => 'select',
					'choices' => kayo_get_animations(),
				),

				'product_zoom'              => array(
					'label' => esc_html__( 'Single Product Zoom', 'kayo' ),
					'id'    => 'product_zoom',
					'type'  => 'checkbox',
				),

				'related_products_carousel' => array(
					'label' => esc_html__( 'Related Products Carousel', 'kayo' ),
					'id'    => 'related_products_carousel',
					'type'  => 'checkbox',
				),

				'cart_menu_item'            => array(
					'label' => esc_html__( 'Add a "Cart" Menu Item', 'kayo' ),
					'id'    => 'cart_menu_item',
					'type'  => 'checkbox',
				),

				'account_menu_item'         => array(
					'label' => esc_html__( 'Add a "Account" Menu Item', 'kayo' ),
					'id'    => 'account_menu_item',
					'type'  => 'checkbox',
				),

				'shop_search_menu_item'     => array(
					'label' => esc_html__( 'Search Menu Item', 'kayo' ),
					'id'    => 'shop_search_menu_item',
					'type'  => 'checkbox',
				),

				'products_per_page'         => array(
					'label'       => esc_html__( 'Products per Page', 'kayo' ),
					'id'          => 'products_per_page',
					'type'        => 'text',
					'placeholder' => 12,
				),
			),
		);
	}

	if ( class_exists( 'Wolf_WooCommerce_Currency_Switcher' ) || defined( 'WOOCS_VERSION' ) ) {
		$mods['shop']['options']['currency_switcher'] = array(
			'label' => esc_html__( 'Add Currency Switcher to Menu', 'kayo' ),
			'id'    => 'currency_switcher',
			'type'  => 'checkbox',
		);
	}

	if ( class_exists( 'Wolf_WooCommerce_Wishlist' ) && class_exists( 'WooCommerce' ) ) {
		$mods['shop']['options']['wishlist_menu_item'] = array(
			'label' => esc_html__( 'Wishlist Menu Item', 'kayo' ),
			'id'    => 'wishlist_menu_item',
			'type'  => 'checkbox',
		);
	}

	return $mods;
}
add_filter( 'kayo_customizer_mods', 'kayo_set_product_mods' );
