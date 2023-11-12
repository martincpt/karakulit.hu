<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing divs of the main content and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 * @since Kayo 1.0
 */

?>
						</div><!-- .content-wrapper -->
					</div><!-- .content-inner -->
					<?php
						/**
						 * Hook to add content block
						 * kayo_after_content
						 *
						 * @since Kayo 1.0
						 */
						do_action( 'kayo_before_footer_block' );
					?>
				</div><!-- .site-content -->
			</div><!-- #main -->
		</div><!-- #page-content -->
		<div class="clear"></div>
		<?php
			/**
			 * Before footer hook
			 *
			 * @since Kayo 1.0
			 */
			do_action( 'kayo_footer_before' );

		if ( 'hidden' !== kayo_get_inherit_mod( 'footer_type' ) && is_active_sidebar( 'sidebar-footer' ) ) :
			?>
			<footer id="colophon" class="
			<?php
				/**
				 * Filters footer class
				 *
				 * @since Kayo 1.0
				 */
				echo esc_attr( apply_filters( 'kayo_site_footer_class', '' ) );
			?>
			 site-footer" itemscope="itemscope" itemtype="http://schema.org/WPFooter">
				<div class="footer-inner clearfix">
					<?php get_sidebar( 'footer' ); ?>
				</div><!-- .footer-inner -->
			</footer><!-- footer#colophon .site-footer -->
		<?php endif; ?>
		<?php

			/**
			 * Fires the Kayo bottom bar
			 *
			 * @since Kayo 1.0
			 */
			do_action( 'kayo_bottom_bar' );
		?>
	</div><!-- #page .hfeed .site -->
</div><!-- .site-container -->
<?php
	/**
	 * Fires the Kayo bottom bar
	 *
	 * @since Kayo 1.0
	 */
	do_action( 'kayo_body_end' );
?>
<?php wp_footer(); ?>
</body>
</html>
