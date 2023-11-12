<?php
/**
 * Template part for displaying single release content
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> <?php kayo_post_attr(); ?>>
	<div class="release-content clearfix">
		<?php
			/**
			 * The post content
			 */
			the_content();

		if ( function_exists( 'wd_release_buttons' ) ) {

			/**
			 * Buy Buttons
			 */
			wd_release_buttons();
		}
		?>
	</div><!-- .release-content -->
	<div class="release-info-container clearfix">
		<div class="release-thumbnail">
			<a class="lightbox" href="<?php echo esc_url( get_the_post_thumbnail_url( '', '%SLUG-XL%' ) ); ?>">
				<?php

					$img_id      = get_post_thumbnail_id();
					$cd_size     = apply_filters( 'kayo_release_img_size', '400x400' );
					$cd_big_size = apply_filters( 'kayo_release_img_big_size', '1000x1000' );

					$img_size = ( 'wide' === get_post_meta( get_the_ID(), '_post_width', true ) ) ? $cd_big_size : $cd_size;

					kayo_resized_thumbnail( $img_size );
				?>
			</a>
		</div>
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		<div class="release-meta-container">
		<?php
				/**
				 * Release Meta Hook
				 */
				do_action( 'kayo_release_meta' );
		?>
			</div><!-- .release-meta-container -->
		<?php if ( has_excerpt() ) : ?>
			<div class="release-excerpt-container">
				<?php
					/**
					 * The excerpt
					 */
					the_excerpt();
				?>
			</div><!-- .release-excerpt-container -->
		<?php endif; ?>
		<?php

			/**
			 * Share buttons
			 */
			do_action( 'kayo_share' );
		?>
	<div><!-- .release-info -->
</article><!-- #post-## -->
