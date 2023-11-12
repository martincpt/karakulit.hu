<?php
/**
 * The category filter for release posts
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

// Get template vars
extract( wp_parse_args( $filter_args, array(
	'band_include' => '',
	'band_exclude' => '',
	'release_category_filter_text_alignment' => 'center',
) ) );

/* Term query args */
$terms_args = array(
	'taxonomy' => 'band',
	'hide_empty' => true,
);

/* If release types are defined, add them to the arguments */
if ( $band_include ) {

	$bands_ids = array();
	$bands_array = kayo_list_to_array( $band_include );

	if ( array() !== $bands_array ) {
		foreach ( $bands_array as $slug ) {

			$term = get_term_by( 'slug', $slug, 'band' );

			if ( is_object( $term ) ) {
				$bands_ids[] = $term->term_id;
			}
		}
	}

	$terms_args['include'] = $bands_ids;
}

/* If exlucded release types are defined, add them to the arguments */
if ( $band_exclude ) {

	$bands_ids = array();
	$bands_array = kayo_list_to_array( $band_exclude );

	if ( array() !== $bands_array ) {
		foreach ( $bands_array as $slug ) {

			$term = get_term_by( 'slug', $slug, 'band' );

			if ( is_object( $term ) ) {
				$bands_ids[] = $term->term_id;
			}
		}
	}

	$terms_args['exclude'] = $bands_ids;
}

// Get terms
$terms = get_terms( $terms_args );

if ( array() === $terms ) {
	return;
}

$filter_class = 'category-filter category-filter-release';

$filter_class .= " category-filter-text-align-$release_category_filter_text_alignment";

$releases_url = ( wolf_discography_get_page_link() ) ? wolf_discography_get_page_link() : home_url();

$all_active_class = ( ! is_tax( 'band' ) ) ? 'active' : '';
?>
<div class="<?php echo kayo_sanitize_html_classes( $filter_class ); ?>">
	<ul>
		<li><a class="filter-link <?php echo esc_attr( $all_active_class ); ?>" href="<?php echo esc_url( $releases_url  ); ?>" data-filter="release"><?php esc_html_e( 'All', 'kayo' ) ?></a></li>
		<?php foreach ( $terms as $term ) :
			$term_active_class = ( $term->slug === get_query_var( 'band' ) ) ? 'active' : '';
		?>
			<li>
				<a class="filter-link <?php echo esc_attr( $term_active_class ); ?>" data-filter="band-<?php echo sanitize_title( $term->slug ); ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo sanitize_text_field( $term->name ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div><!-- .category-filter -->