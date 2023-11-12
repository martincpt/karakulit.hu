<?php
/**
 * The sidebar containing the footer widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( is_active_sidebar( 'sidebar-footer' ) ) :
	$kayo_tertiary_widget_area_class  = 'sidebar-footer';
	$kayo_tertiary_widget_area_class .= ' ' .
	/**
	 * The footer widget area HTML class filtered
	 *
	 * @since 1.0.0
	 */
	apply_filters( 'kayo_sidebar_footer_class', '' );
	?>
	<div id="tertiary" class="<?php echo esc_attr( $kayo_tertiary_widget_area_class ); ?>">
		<div class="sidebar-footer-inner wrap">
			<div class="widget-area">
				<?php dynamic_sidebar( 'sidebar-footer' ); ?>
			</div><!-- .widget-area -->
		</div><!-- .sidebar-footer-inner -->
	</div><!-- #tertiary .sidebar-footer -->
<?php endif; ?>
