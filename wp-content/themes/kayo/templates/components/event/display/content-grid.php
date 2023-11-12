<?php
/**
 * Template part for displaying events with the "grid" display
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

if ( ! function_exists( 'we_get_event_meta' ) ) {
	return;
}

extract(
	wp_parse_args(
		$template_args,
		array(
			'overlay_color'         => 'black',
			'overlay_custom_color'  => '',
			'overlay_opacity'       => 88,
			'event_location'        => 'location',
			'event_timeline'        => 'future',
			'custom_thumbnail_size' => '',
		)
	)
);

extract( we_get_event_meta() );
?>
<article <?php kayo_post_attr(); ?>>
	<meta itemprop="name" content="<?php echo esc_attr( $name ); ?>">
	<meta itemprop="url" content="<?php echo esc_url( $permalink ); ?>">
	<?php if ( $thumbnail_url ) : ?>
		<meta itemprop="image" content="<?php echo esc_url( $thumbnail_url ); ?>">
	<?php endif; ?>
	<meta itemprop="description" content="<?php echo esc_attr( $description ); ?>">
	<div class="entry-box">
		<div class="entry-container">
			<a class="entry-link" href="<?php the_permalink(); ?>">
				<div class="entry-image">
					<?php

					if ( $custom_thumbnail_size ) {

						kayo_resized_thumbnail( $custom_thumbnail_size ); // phpcs:ignore

					} else {

						?>
						<div class="entry-cover">
						<?php

						echo kayo_background_img(
							array(
								'background_img_size' => 'large',
							)
						);

						?>
						</div><!-- entry-cover -->
						<?php
					}
					?>
				</div>
				<div class="entry-inner">
					<?php if ( $soldout ) : ?>
						<span class="sold-out-label"><?php esc_html_e( 'Sold Out', 'kayo' ); ?></span>
					<?php endif; ?>
					<?php if ( $cancelled ) : ?>
						<span class="cancelled-label"><?php esc_html_e( 'Cancelled', 'kayo' ); ?></span>
					<?php endif; ?>
					<?php
						$dominant_color = kayo_get_image_dominant_color( get_post_thumbnail_id() );

					if ( $dominant_color && 'auto' === $overlay_color ) {
						$overlay_custom_color = $dominant_color;
					}

						echo kayo_background_overlay(
							array(
								'overlay_color'        => $overlay_color,
								'overlay_custom_color' => $overlay_custom_color,
								'overlay_opacity'      => $overlay_opacity,
							)
						);
						?>
					<div class="event-info-overlay"></div>
					<div class="entry-summary">
						<div class="event-date">
							<?php if ( $formatted_start_date ) : ?>
								<span class="start-date <?php echo esc_attr( apply_filters( 'kayo_event_grid_entry_date_class', 'wvc-bigtext' ) ); ?>" itemprop="startDate" content="<?php echo esc_attr( $raw_start_date ); ?>">
									<?php echo we_sanitize_date( $formatted_start_date ); ?>
								</span>
							<?php endif; ?>
							<?php if ( $formatted_end_date ) : ?>
								<span class="end-date <?php echo esc_attr( apply_filters( 'kayo_event_grid_entry_date_class', 'wvc-bigtext' ) ); ?>" itemprop="endDate" content="<?php echo esc_attr( $raw_end_date ); ?>">
									<?php echo we_sanitize_date( $formatted_end_date ); ?>
								</span>
							<?php endif; ?>
						</div><!-- .event-date -->
						<div class="event-location" itemprop="location" itemscope itemtype="https://schema.org/<?php echo esc_attr( apply_filters( 'kayo_microdata_event_itemtype_venue', 'MusicVenue' ) ); ?>">
							<span itemprop="address" itemscope itemtype="https://schema.org/PostalAddress">
								<?php if ( $city ) : ?>
									<meta itemprop="addressLocality" content="<?php echo esc_attr( $city ); ?>">
								<?php endif; ?>

								<?php if ( $address ) : ?>
									<meta itemprop="streetAddress" content="<?php echo esc_attr( $address ); ?>">
								<?php endif; ?>

								<?php if ( $state ) : ?>
									<meta itemprop="addressRegion" content="<?php echo esc_attr( $state ); ?>">
								<?php endif; ?>

								<?php if ( $zipcode ) : ?>
									<meta itemprop="postalCode" content="<?php echo esc_attr( $zipcode ); ?>">
								<?php endif; ?>
							</span>
							<h3 class="location-title <?php echo esc_attr( apply_filters( 'kayo_event_grid_entry_title_class', '' ) ); ?>"><span>
																 <?php

																	if ( 'location' === $event_location ) {

																		echo esc_attr( $display_location );

																	} elseif ( 'title' === $event_location ) {

																		the_title();

																	} else {
																		echo esc_attr( $venue );
																	}

																	?>
							</span></h3>
						</div><!-- .event-date -->
					</div><!--  .entry-summary  -->
				</div><!--  .entry-summary-container  -->
			</a>
		</div>
	</div><!-- .entry-container -->
</article>
