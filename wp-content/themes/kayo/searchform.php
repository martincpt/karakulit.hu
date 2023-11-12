<?php
/**
 * The template for displaying search forms
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

?>

<?php $kayo_unique_id = uniqid( 'search-form-' ); ?>

<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label for="<?php echo esc_attr( $kayo_unique_id ); ?>">
		<span class="screen-reader-text"><?php echo esc_attr_x( 'Search for:', 'label', 'kayo' ); ?></span>
	</label>
	<input type="search" id="<?php echo esc_attr( $kayo_unique_id ); ?>" class="search-field" placeholder="
		<?php
			echo esc_attr(
				/**
				 * Filters the search form placeholder text
				 *
				 * @since 1.0.0
				 */
				apply_filters( 'kayo_searchform_placeholder', esc_attr_x( 'Type and hit enter&hellip;', 'placeholder', 'kayo' ) )
			);
			?>
		" value="<?php echo esc_attr( get_search_query() ); ?>" name="s" />
	<button type="submit" class="search-submit"><span class="screen-reader-text"><?php echo esc_attr_x( 'Type and hit enter', 'submit button', 'kayo' ); ?></span></button>
</form>
