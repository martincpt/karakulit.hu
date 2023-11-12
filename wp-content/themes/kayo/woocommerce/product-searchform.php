<?php
/**
 * The template for displaying product search form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/product-searchform.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 7.0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$s = ( isset( $_GET['s'] ) ) ? esc_attr( $_GET['s'] ) : '';
?>

<form role="search" method="get" class="woocommerce-product-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo apply_filters( 'kayo_product_searchform_placeholder', esc_attr_x( 'Search Products&hellip;', 'placeholder', 'kayo' ) ); ?>" value="<?php echo esc_attr( $s ); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'kayo' ); ?>" />
	<?php
	if ( apply_filters( 'kayo_product_search_form_submit_button_tag', false ) ) {
		?>
		<button type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'kayo' ); ?>"><?php echo esc_html_x( 'Search', 'submit button', 'kayo' ); ?></button>
		<?php
	} else {
		?>
		<input type="submit" class="search-submit" value="<?php echo esc_attr_x( 'Search', 'submit button', 'kayo' ); ?>" />
		<?php
	}
	?>
	<input type="hidden" name="post_type" value="product" />
</form>
