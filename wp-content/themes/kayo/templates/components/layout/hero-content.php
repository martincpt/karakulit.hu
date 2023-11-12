<?php
/**
 * Displays hero content
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<div id="hero">
	<?php
		/**
		 * Hero background hook
		 *
		 * @see kayo_output_hero_background function
		 * @since 1.0.0
		 */
		do_action( 'kayo_hero_background' );
	?>
	<div id="hero-inner">
		<div id="hero-content">
			<div class="post-title-container hero-section">
			<?php
				/**
				 * Hero title hook
				 *
				 * @see kayo_output_post_title function
				 * @since 1.0.0
				 */
				do_action( 'kayo_hero_title' );
			?>
			</div><!-- .post-title-container -->
			<div class="post-meta-container hero-section">
			<?php
				/**
				 * Hero meta hook
				 *
				 * @see inc/frontend/hooks.php
				 * @since 1.0.0
				 */
				do_action( 'kayo_hero_meta' );
			?>
			</div><!-- .post-meta-container -->
			<div class="post-secondary-meta-container hero-section">
			<?php
				/**
				 * Hero secondary meta hook
				 *
				 * @see inc/frontend/hooks.php
				 * @since 1.0.0
				 */
				do_action( 'kayo_hero_secondary_meta' );
			?>
			</div><!-- .post-meta-container -->
		</div><!-- #hero-content -->
	</div><!-- #hero-inner -->
</div><!-- #hero-container -->
