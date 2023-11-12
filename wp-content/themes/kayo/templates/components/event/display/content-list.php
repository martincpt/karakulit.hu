<?php
/**
 * Template part for displaying events with the "list" display
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
			'event_timeline' => 'future',
		)
	)
);

extract( we_get_event_meta() );
$do_link = we_get_option( 'single_page' );
?>
<li <?php kayo_post_attr(); ?>>
	<meta itemprop="name" content="<?php echo esc_attr( $name ); ?>">
	<meta itemprop="url" content="<?php echo esc_url( $permalink ); ?>">
	<?php if ( $thumbnail_url ) : ?>
		<meta itemprop="image" content="<?php echo esc_url( $thumbnail_url ); ?>">
	<?php endif; ?>
	<meta itemprop="description" content="<?php echo esc_attr( $description ); ?>">
	<span class="event-table-cell event-date">
		<?php if ( $formatted_start_date ) : ?>
			<span class="start-date" itemprop="startDate" content="<?php echo esc_attr( $raw_start_date ); ?>">
				<?php echo we_sanitize_date( $formatted_start_date ); ?>
			</span>
		<?php endif; ?>
		<?php if ( $formatted_end_date ) : ?>
			<span class="end-date" itemprop="endDate" content="<?php echo esc_attr( $raw_end_date ); ?>">
				<?php echo we_sanitize_date( $formatted_end_date ); ?>
			</span>
		<?php endif; ?>
	</span><!-- .event-date -->
	<span class="event-table-cell event-location">
		<?php if ( $do_link ) : ?>
			<a rel="bookmark" class="event-link-mask" href="<?php the_permalink(); ?>"></a>
		<?php endif; ?>
		<span class="location"><?php echo esc_attr( $display_location ); ?></span>
	</span>
	<span class="event-table-cell event-venue" itemprop="location" itemscope itemtype="https://schema.org/<?php echo esc_attr( apply_filters( 'kayo_microdata_event_itemtype_venue', 'MusicVenue' ) ); ?>">
		<?php if ( $do_link ) : ?>
			<a rel="bookmark" class="event-link-mask" href="<?php the_permalink(); ?>"></a>
		<?php endif; ?>
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
		<span class="venue" itemprop="name"><?php echo esc_attr( $venue ); ?></span>
	</span><!-- .event-location -->
	<span itemprop="offers" itemscope="" itemtype="https://schema.org/Offer">
		<?php if ( $ticket_url ) : ?>
			<meta itemprop="url" content="<?php echo esc_url( $ticket_url ); ?>">
		<?php endif; ?>
		<?php if ( $free ) : ?>
			<meta itemprop="price" content="0">
		<?php elseif ( get_post_meta( get_the_ID(), '_wolf_event_price', true ) ) : ?>
			<meta itemprop="price" content="<?php echo absint( get_post_meta( get_the_ID(), '_wolf_event_price', true ) ); ?>">
		<?php endif; ?>
		<?php // if ( get_post_meta( get_the_ID(), '_wolf_event_price', true ) ) : ?>
			<!-- <meta itemprop="priceCurrency" content="USD"> -->
		<?php // endif; ?>
		</span>
	<span class="event-table-cell event-action">
		<?php if ( $action && 'future' === $event_timeline ) : ?>
			<?php echo we_sanitize_action( $action ); ?>
		<?php endif; ?>
	</span><!-- .event-action -->
	<?php if ( is_user_logged_in() ) : ?>
		<span class="event-table-cell event-edit-cell">
			<?php kayo_edit_post_link(); ?>
		</span>
	<?php endif; ?>
</li><!-- .event-list-event -->
