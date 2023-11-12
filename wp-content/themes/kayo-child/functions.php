<?php
/**
 * This is the Kayo child theme functions.php file.
 * You can use this file to overwrite existing functions, filter and actions to customize the parent theme.
 * https://wolfthemes.ticksy.com/article/11659/
 *
 * @package WordPress
 * @subpackage %NAME%
 */

 // add js scripts to footer
add_action('wp_footer', function(){ 
	?>
		<!-- Google tag (gtag.js) -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=G-F1ZFG53EYJ"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'G-F1ZFG53EYJ');
		</script>
	<?php 
	});

// rewrite work type taxonomy slug 
add_filter( 'register_taxonomy_args', function( $args, $taxonomy, $object_type ) {
    if( $taxonomy !== 'work_type') return $args;
    // $args['show_admin_column'] = true;
    $args['rewrite']['slug'] = 'program-tipus';
    return $args;
}, 10, 3);

add_action( 'kayo_work_meta', function(){
	kayo_work_meta_before_ticket_button();
	$id = get_the_ID();
	$key = "ticket_url";
	$url = trim(get_post_meta($id, $key, true));
	if ($url === "") return;
	$title = "Jegyvásárlás";
	$shortcode = '[vc_button title="'.$title.'" align="left" i_align="right" i_type="dripicons" i_icon_dripicons="dripicons-ticket" font_weight="700" add_icon="true" link="url:'.urlencode($url).'|target:_blank"]';
	echo do_shortcode($shortcode);
}, 11);

// remove the original meta generators
add_action( 'after_setup_theme', function(){
	remove_action( 'kayo_work_meta', 'kayo_ouput_work_meta', 10 );
});

// override original kayo_the_work_meta
// function so it does not print anything
// ...
// the action added within an anonymous function
// so just could not figure out how to remove that
// ...
// it's easier to just override like this.
function kayo_the_work_meta(){}

function kayo_work_meta_before_ticket_button() {
	$excluded_meta = array(
		'ticket_url',
		'slide_template',
		'wv_video_id',
		'total_sales',
		'rs_page_bg_color',
		'nav_overlay_left_block_id',
		'nav_overlay_right_block_id',
	);

	$keys = get_post_custom_keys();

	if ( $keys ) {
		echo '<ul>';
		foreach ( (array) $keys as $key ) {
			$keyt = trim( $key );
			if ( is_protected_meta( $keyt, 'post' ) || in_array( $keyt, $excluded_meta, true ) ) {
					continue;
			}
				$values = array_map( 'trim', get_post_custom_values( $key ) );
				$value  = implode( ', ', $values );
			?>
			<li class="work-meta work-<?php echo esc_attr( sanitize_title_with_dashes( $key ) ); ?>">
				<span class="work-meta-label"><?php echo esc_attr( sanitize_text_field( $key ) ); ?>: </span>
				<span class="work-meta-value"><?php echo esc_attr( sanitize_text_field( $value ) ); ?></span>
			</li>
			<?php
		}
		echo '</ul>';
	}
}