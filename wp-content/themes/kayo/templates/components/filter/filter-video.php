<?php
/**
 * The category filter for video posts
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

// Get template vars
extract( wp_parse_args( $filter_args, array(
	'video_type_include' => '',
	'video_type_exclude' => '',
	'video_category_filter_text_alignment' => 'center',
) ) );

/* Term query args */
$terms_args = array(
	'taxonomy' => 'video_type',
	'hide_empty' => true,
);

/* If video types are defined, add them to the arguments */
if ( $video_type_include ) {

	$video_types_ids = array();
	$video_types_array = kayo_list_to_array( $video_type_include );

	if ( array() !== $video_types_array ) {
		foreach ( $video_types_array as $slug ) {

			$term = get_term_by( 'slug', $slug, 'video_type' );

			if ( is_object( $term ) ) {
				$video_types_ids[] = $term->term_id;
			}
		}
	}

	$terms_args['include'] = $video_types_ids;
}

/* If exlucded video types are defined, add them to the arguments */
if ( $video_type_exclude ) {

	$video_types_ids = array();
	$video_types_array = kayo_list_to_array( $video_type_exclude );

	if ( array() !== $video_types_array ) {
		foreach ( $video_types_array as $slug ) {

			$term = get_term_by( 'slug', $slug, 'video_type' );

			if ( is_object( $term ) ) {
				$video_types_ids[] = $term->term_id;
			}
		}
	}

	$terms_args['exclude'] = $video_types_ids;
}

// Get terms
$terms = get_terms( $terms_args );

if ( array() === $terms ) {
	return;
}

$filter_class = 'category-filter category-filter-video';

$filter_class .= " category-filter-text-align-$video_category_filter_text_alignment";

$videos_url = ( kayo_get_videos_url() ) ? kayo_get_videos_url() : home_url();

$all_active_class = ( ! is_tax( 'video_type' ) ) ? 'active' : '';
?>
<div class="<?php echo kayo_sanitize_html_classes( $filter_class ); ?>">
	<ul>
		<li><a class="filter-link <?php echo esc_attr( $all_active_class ); ?>" href="<?php echo esc_url( $videos_url  ); ?>" data-filter="video"><?php esc_html_e( 'All', 'kayo' ) ?></a></li>
		<?php foreach ( $terms as $term ) :
			$term_active_class = ( $term->slug === get_query_var( 'video_type' ) ) ? 'active' : '';
		?>
			<li>
				<a class="filter-link <?php echo esc_attr( $term_active_class ); ?>" data-filter="video_type-<?php echo sanitize_title( $term->slug ); ?>" href="<?php echo esc_url( get_term_link( $term ) ); ?>"><?php echo sanitize_text_field( $term->name ); ?></a>
			</li>
		<?php endforeach; ?>
	</ul>
</div><!-- .category-filter -->