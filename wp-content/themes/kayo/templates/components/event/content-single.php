<?php
/**
 * Template part for displaying single event content
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

$event_meta = we_get_event_meta();
extract( $event_meta );
?>
<article <?php kayo_post_attr(); ?>>
	<?php
		/**
		 * Single event microdata hook
	     *
		 * @since 1.0.0
		 */
		do_action( 'kayo_single_event_microdata', $event_meta );
	?>
	<div class="row">
		<div class="col col-3">
			<?php
				/**
				 * Single event meta hook
				 *
				 * @hooked kayo_output_single_event_thumbnail 5
				 * @hooked kayo_output_single_event_artist 10
				 * @hooked kayo_output_single_event_date 10
				 * @hooked kayo_output_single_event_location 10
				 * @hooked kayo_output_single_event_buttons 10
				 *
				 * @since 1.0.0
				 */
				do_action( 'kayo_single_event_meta', $event_meta );
			?>
		</div>
		<div class="col col-9 event-container">
			<?php
				/**
				 * Single event content hook
				 *
				 * @hooked kayo_output_single_event_map 5
				 * @hooked kayo_output_single_event_details 10
				 * @hooked kayo_output_single_event_content 15
				 *
				 * @since 1.0.0
				 */
				do_action( 'kayo_single_event_content', $event_meta );
			?>

		</div>
	</div>
</article><!-- #post-## -->
