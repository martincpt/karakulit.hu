<?php
/**
 * Template part for displaying the author box
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */
if ( ! get_the_author_meta( 'description' ) ) {
	return;
}
$author_link = get_author_posts_url( get_the_author_meta( 'ID' ) );
?>
<section class="author-box-container entry-section">
	<div class="author-box clearfix">
		<div class="author-avatar">
			<a itemprop="url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php
				echo get_avatar(
					get_the_author_meta( 'user_email' ),
					/**
					 * Filters the author avatar size
					 *
					 * @since 1.0.0
					 */
					apply_filters( 'kayo_author_box_avatar_size', 80 )
				);
				?>
			</a>
		</div><!-- .author-avatar -->
		<div class="author-description" itemprop="author" itemscope itemtype="https://schema.org/Person">
			<?php
			/**
			 * Author box description start hook
			 *
			 * @since 1.0.0
			 */
			do_action( 'kayo_author_box_description_start' );
			?>
			<h5 class="author-name"><a itemprop="url" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author"><span class="vcard author author_name"><span class="fn" itemprop="name"><?php the_author_meta( 'display_name' ); ?></span></span></a></h5>
			<p>
				<?php the_author_meta( 'description' ); ?>
			</p>
		</div><!-- .author-description -->
	</div><!-- .author-box -->
</section><!-- .author-box-container -->
