<?php
/**
 * The product content displayed in the loop for the "grid overlay" display
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
$classes = array();

/* Related product default class */
if ( is_singular( 'product' ) ) {
	$classes = array( 'entry-product-grid_overlay', 'entry-columns-default' );
} else {
	$columns = kayo_get_theme_mod( 'product_columns', 'default' );
	$classes = array( $columns );
}
?>
<article <?php kayo_post_attr( $classes ); ?>>
	<div class="product-thumbnail-container">
		<div class="product-thumbnail-inner">
			<?php do_action( 'kayo_product_minimal_player' ); ?>
			<?php woocommerce_show_product_loop_sale_flash(); ?>
			
			<?php woocommerce_template_loop_product_thumbnail(); ?>
			<?php kayo_woocommerce_second_product_thumbnail(); ?>

			<div class="product-overlay">
				<a class="entry-link-mask" href="<?php the_permalink(); ?>"></a>
				<div class="product-overlay-table">
					<div class="product-overlay-table-cell">
						<div class="product-actions">
							<?php woocommerce_template_loop_add_to_cart(); ?>
							<?php kayo_add_to_wishlist(); ?>
						</div><!-- .product-actions -->
					</div><!-- .product-overlay-table-cell -->
				</div><!-- .product-overlay-table -->
			</div><!-- .product-overlay -->
		</div><!-- .product-thumbnail-inner -->
	</div><!-- .product-thumbnail-container -->

	<div class="product-summary clearfix">
		<?php woocommerce_template_loop_product_link_open(); ?>
			<?php woocommerce_template_loop_product_title(); ?>
			<?php woocommerce_template_loop_price(); ?>
		<?php woocommerce_template_loop_product_link_close(); ?>
	</div><!-- .product-summary -->
</article><!-- #post-## -->