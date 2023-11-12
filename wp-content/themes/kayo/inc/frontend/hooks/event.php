<?php
/**
 * Kayo event hook functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Output microdata
 */
function kayo_output_single_event_microdata( $meta ) {
	extract( $meta );
	?>
	<meta itemprop="name" content="<?php echo esc_attr( $name ); ?>">
	<meta itemprop="url" content="<?php echo esc_url( $permalink ); ?>">
	<?php if ( $thumbnail_url ) : ?>
		<meta itemprop="image" content="<?php echo esc_url( $thumbnail_url ); ?>">
	<?php endif; ?>
	<meta itemprop="description" content="<?php echo esc_attr( $description ); ?>">

	<?php if ( $city || $address || $state || $zipcode ) : ?>
	<span itemprop="location" itemscope itemtype="https://schema.org/<?php echo esc_attr( apply_filters( 'kayo_microdata_event_itemtype_venue', 'MusicVenue' ) ); ?>">
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
		<meta itemprop="name"  content="<?php echo esc_attr( $venue ); ?>">
	</span>
	<?php endif; ?>

	<span itemprop="offers" itemscope="" itemtype="https://schema.org/Offer">
			<?php if ( $ticket_url ) : ?>
		<meta itemprop="url" content="<?php echo esc_url( $ticket_url ); ?>">
		<?php endif; ?>
			<?php if ( $free ) : ?>
				<meta itemprop="price" content="0">
			<?php elseif ( $formatted_price ) : ?>
				<meta itemprop="price" content="<?php echo esc_attr( $formatted_price ); ?>">
			<?php endif; ?>
			<?php if ( apply_filters( 'kayo_event_price_default_currency', $currency ) ) : ?>
				<meta itemprop="priceCurrency" content="<?php echo esc_attr( apply_filters( 'kayo_event_price_default_currency', $currency ) ); ?>">
			<?php endif; ?>
		</span>
	<?php
}
add_action( 'kayo_single_event_microdata', 'kayo_output_single_event_microdata', 10, 1 );

/**
 * Output thumbnail
 */
function kayo_output_single_event_thumbnail() {
	?>
	<div class="event-thumbnail">
		<a class="lightbox" href="<?php echo esc_url( get_the_post_thumbnail_url( '', '%SLUG-XL%' ) ); ?>">
			<?php the_post_thumbnail(); ?>
		</a>
	</div><!-- .event-thumbnail -->
	<?php
}
add_action( 'kayo_single_event_meta', 'kayo_output_single_event_thumbnail', 5 );

/**
 * Output artist name
 */
function kayo_output_single_event_artist( $meta ) {

	$artist = kayo_isset( $meta['artist'] );
	?>
	<?php if ( $artist ) : ?>
		<div class="event-artist">
			<strong><?php echo kayo_kses( $artist ); ?></strong>
		</div><!-- .event-artist -->
	<?php endif; ?>
	<?php
}
add_action( 'kayo_single_event_meta', 'kayo_output_single_event_artist', 10, 1 );

/**
 * Output date
 */
function kayo_output_single_event_date( $meta ) {

	$raw_start_date = kayo_isset( $meta['raw_start_date'] );
	$raw_end_date   = kayo_isset( $meta['raw_end_date'] );
	?>
	<div class="event-date">
		<?php if ( $raw_start_date ) : ?>
			<strong class="start-date" itemprop="startDate" content="<?php echo esc_attr( $raw_start_date ); ?>">
				<?php echo esc_attr( we_nice_date( $raw_start_date ) ); ?>
			</strong>
		<?php endif; ?>
		<?php if ( $raw_end_date ) : ?>
			&mdash;
			<strong class="end-date" itemprop="endDate" content="<?php echo esc_attr( $raw_end_date ); ?>">
				<?php echo esc_attr( we_nice_date( $raw_end_date ) ); ?>
			</strong>
		<?php endif; ?>
	</div><!-- .event-date -->
	<?php
}
add_action( 'kayo_single_event_meta', 'kayo_output_single_event_date', 10, 1 );

/**
 * Output location
 */
function kayo_output_single_event_location( $meta ) {

	$display_location = kayo_isset( $meta['display_location'] );
	?>
	<?php if ( $display_location ) : ?>
		<div class="event-location">
			<strong><?php echo esc_attr( $display_location ); ?></strong>
		</div><!-- .event-location -->
	<?php endif; ?>
	<?php
}
add_action( 'kayo_single_event_meta', 'kayo_output_single_event_location', 10, 1 );

/**
 * Output buttons
 */
function kayo_output_single_event_buttons( $meta ) {

	$cancelled       = kayo_isset( $meta['cancelled'] );
	$soldout         = kayo_isset( $meta['soldout'] );
	$free            = kayo_isset( $meta['free'] );
	$ticket_url      = kayo_isset( $meta['ticket_url'] );
	$price           = kayo_isset( $meta['price'] );
	$facebook_url    = kayo_isset( $meta['facebook_url'] );
	$bandsintown_url = kayo_isset( $meta['bandsintown_url'] );
	?>
	<div class="event-buttons">
		<?php if ( $cancelled ) : ?>
			<strong class="event-status"><?php esc_html_e( 'Cancelled', 'kayo' ); ?></strong>
		<?php elseif ( $soldout ) : ?>
			<strong class="event-status"><?php esc_html_e( 'Sold Out', 'kayo' ); ?></strong>
		<?php elseif ( $free ) : ?>
			<strong class="event-status"><?php esc_html_e( 'Free', 'kayo' ); ?></strong>
		<?php elseif ( $ticket_url ) : ?>
			<a target="_blank" class="<?php echo esc_attr( apply_filters( 'kayo_single_event_buy_ticket_button_class', 'button' ) ); ?>" href="<?php echo esc_url( $ticket_url ); ?>"><span class="fa fa-shopping-cart"></span>
			<?php esc_html_e( 'Get Tickets', 'kayo' ); ?>
			<?php echo ( $price ) ? ' - ' . esc_attr( $price ) : ''; ?>
		</a>
		<?php endif; ?>
		<?php if ( $facebook_url ) : ?>
			<a target="_blank" class="<?php echo esc_attr( apply_filters( 'kayo_single_event_fb_button_class', 'button fb-button' ) ); ?>" href="<?php echo esc_url( $facebook_url ); ?>"><span class="fab fa-facebook"></span><?php esc_html_e( 'Facebook event', 'kayo' ); ?></a>
		<?php endif; ?>
		<?php if ( $bandsintown_url ) : ?>
			<a target="_blank" class="<?php echo esc_attr( apply_filters( 'kayo_single_event_bit_button_class', 'button single-bit-button' ) ); ?>" href="<?php echo esc_url( $bandsintown_url ); ?>"><span class="fa wolficon-bandsintown"></span><?php esc_html_e( 'Bandsintown', 'kayo' ); ?></a>
		<?php endif; ?>
	</div>
	<?php
}
add_action( 'kayo_single_event_meta', 'kayo_output_single_event_buttons', 15, 1 );

/**
 * Output map
 */
function kayo_output_single_event_map( $meta ) {

	$map = kayo_isset( $meta['map'] );
	?>
	<div class="event-map">
		<?php echo kayo_kses( we_get_iframe( $map ) ); ?>
	</div><!-- .event-map -->
	<?php
}
add_action( 'kayo_single_event_content', 'kayo_output_single_event_map', 5, 1 );

/**
 * Output details
 */
function kayo_output_single_event_details( $meta ) {

	extract( $meta );
	?>
	<div class="event-details">
		<?php if ( $time && '00:00' !== $time ) : ?>
			<div class="event-time">
				<strong><?php esc_html_e( 'Time:', 'kayo' ); ?></strong> <?php echo esc_attr( $time ); ?>
			</div><!-- .event-time -->
		<?php endif; ?>
		<?php if ( $venue ) : ?>
			<div class="event-venue">
				<strong><?php esc_html_e( 'Venue:', 'kayo' ); ?></strong> <?php echo esc_attr( $venue ); ?>
			</div><!-- .event-venue -->
		<?php endif; ?>
		<?php if ( $address ) : ?>
			<div class="event-address">
				<strong><?php esc_html_e( 'Address:', 'kayo' ); ?></strong> <?php echo esc_attr( $address ); ?>
			</div><!-- .event-address -->
		<?php endif; ?>
		<?php if ( $zipcode ) : ?>
			<div class="event-zipcode">
				<strong><?php esc_html_e( 'Zipcode:', 'kayo' ); ?></strong> <?php echo esc_attr( $zipcode ); ?>
			</div><!-- .event-zipcode -->
		<?php endif; ?>
		<?php if ( $state ) : ?>
			<div class="event-state">
				<strong><?php esc_html_e( 'State:', 'kayo' ); ?></strong> <?php echo esc_attr( $state ); ?>
			</div><!-- .event-state -->
		<?php endif; ?>
		<?php if ( $country ) : ?>
			<div class="event-country">
				<strong><?php esc_html_e( 'Country:', 'kayo' ); ?></strong> <?php echo esc_attr( $country ); ?>
			</div><!-- .event-country -->
		<?php endif; ?>
		<?php if ( $phone ) : ?>
			<div class="event-phone">
				<strong><?php esc_html_e( 'Phone:', 'kayo' ); ?></strong> <?php echo esc_attr( $phone ); ?>
			</div><!-- .event-phone -->
		<?php endif; ?>
		<?php if ( $email ) : ?>
			<div class="event-email">
				<strong><?php esc_html_e( 'Email:', 'kayo' ); ?></strong> <a href="mailto:<?php echo esc_attr( sanitize_email( $email ) ); ?>"><?php echo esc_attr( sanitize_email( $email ) ); ?></a>
			</div><!-- .event-email -->
		<?php endif; ?>
		<?php if ( $website ) : ?>
			<div class="event-website">
				<strong><?php esc_html_e( 'Website:', 'kayo' ); ?></strong> <a href="<?php echo esc_url( $website ); ?>" target="_blank"><?php echo esc_url( $website ); ?></a>
			</div><!-- .event-website -->
		<?php endif; ?>
	</div><!-- .event-details -->
	<?php
}
add_action( 'kayo_single_event_content', 'kayo_output_single_event_details', 10, 1 );

/**
 * Output details
 */
function kayo_output_single_event_content( $meta ) {

	the_content();
}
add_action( 'kayo_single_event_content', 'kayo_output_single_event_content', 15 );

/**
 * Output details
 */
function kayo_output_single_event_share( $meta ) {

	do_action( 'kayo_share' ); // phpcs:ignore
}
add_action( 'kayo_single_event_content', 'kayo_output_single_event_share', 20 );
