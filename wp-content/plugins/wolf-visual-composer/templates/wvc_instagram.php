<?php
/**
 * Instagram shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Templates
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'sb_instagram_feed_init' ) ) {
	echo sprintf( wvc_kses( __( '<p>Please install <a href="%s" target="_blank">%s</a> plugin to display this element.</p>', 'wolf-visual-composer' ) ),
		'https://wordpress.org/plugins/instagram-feed/',
		'Smash Balloon Instagram Feed'
	);
	return;
}

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(

	'num' => 18,
	'cols' => 6,
	'username' => '',
	'accesstoken' => '',
	'imagepadding' => '',
	'showheader' => 'false',
	'showbio' => 'false',
	'showbutton' => 'false',
	'showfollow' => 'false',

	'count' => '',
	'columns' => '',
	'username' => '',
	'api_key' => '',
	'tag' => '',
	'follow_button' => '',
	'button_text' => '',
	'hide_meta' => '',
	'add_padding' => '', 
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$inline_atts = '';
$output = '';

$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$class .= " wvc-i-follow_button-$follow_button wvc-i-padding-$add_padding wvc-i-hide_meta-$hide_meta wvc-wolf-gram-shortcode-container wvc-element";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

if ( function_exists( 'sb_instagram_feed_init' ) ) {

	if ( $follow_button ) {

		$button_text = ( ! $button_text ) ? sprintf( esc_html__( 'Instagram @%s', 'wolf-visual-composer' ), $username ) : $button_text;

		$button_link = 'https://instagram.com/' . $username;
		$button_text = apply_filters( 'wolf_gram_button_text', $button_text );
		$button_link = apply_filters( 'wolf_gram_button_link', $button_link );

		ob_start();
		?>
		<a class="wolf-gram-follow-button" href="<?php echo esc_url( $button_link ); ?>" target="_blank">
			<?php echo sanitize_text_field( $button_text ); ?>
		</a>
		<?php
		$output .= ob_get_clean();
	}

	$atts['num'] = $count;
	$atts['cols'] = $columns;

	if ( $add_padding ) {
		$atts['imagepadding'] = '5px';

	} elseif ( $imagepadding ) {
		
		$atts['imagepadding'] = '5px';
	
	} else {
		$atts['imagepadding'] = '0px';
	}

	$atts['showheader'] = isset( $atts['showheader'] ) ? $atts['showheader'] : 'false';
	$atts['showbio'] = isset( $atts['showbio'] ) ? $atts['showbio'] : 'false';
	$atts['showbutton'] = isset( $atts['showbutton'] ) ? $atts['showbutton'] : 'false';
	$atts['showfollow'] = isset( $atts['showfollow'] ) ? $atts['showfollow'] : 'false';

	foreach ( $atts as $key => $value ) {

		if ( 'showheader' === $key ) {
			if ( '' === $value ) {
				$value = 'false';
			}
		}

		if ( 'showbio' === $key ) {
			if ( '' === $value ) {
				$value = 'false';
			}
		}

		if ( 'showbutton' === $key ) {
			if ( '' === $value ) {
				$value = 'false';
			}
		}

		if ( 'showfollow' === $key ) {
			if ( '' === $value ) {
				$value = 'false';
			}
		}

		if ( $value ) {
			$inline_atts .= ' ' . $key . '="' . $value . '"';
		}
	}

//debug( $atts );
//debug( $inline_atts );

$output .= apply_filters( 'wvc_sb_instagram_feed_shortcode', do_shortcode( '[instagram-feed ' . $inline_atts . ']' ) );


} else {

	$output .= apply_filters( 'wvc_instagram_shortcode', do_shortcode( '[wolf_instagram_gallery count="' . $count . '" columns="' . $columns . '" button="' . $follow_button . '" button_text="' . $button_text . '" username="' . $username . '" api_key="' . $api_key . '" tag="' . $tag . '"]' ) );

}

$output .= '</div><!-- .wvc-wolf-gram-shortcode-container -->';


echo $output;