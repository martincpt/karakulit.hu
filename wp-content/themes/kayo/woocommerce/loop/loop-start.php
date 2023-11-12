<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     3.3.0
 */
$class = apply_filters( 'kayo_product_loop_container_class', 'products grid items grid-padding-yes clearfix' );
$tag   = apply_filters( 'kayo_product_loop_container_html_tag', 'div' );

if ( is_product() ) { // related products on single product page

	if ( kayo_get_theme_mod( 'related_products_carousel' ) ) {
		wp_enqueue_script( 'flickity' );
		wp_enqueue_script( 'kayo-carousel' );

		$class .= ' module-carousel product-module-carousel';
	}
}

$container_id = '';

if ( ! is_cart() ) {
	$container_id = 'shop-index';
}
?>
<div class="clear"></div>
<<?php echo esc_attr( $tag ); ?> id="<?php echo esc_attr( $container_id ); ?>" class="<?php echo kayo_sanitize_html_classes( $class ); ?>">
