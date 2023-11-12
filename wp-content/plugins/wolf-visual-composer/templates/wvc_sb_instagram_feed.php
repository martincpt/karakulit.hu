<?php
/**
 * Smash Ballon Instagram Feed Container shortcode template
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

	'follow_button' => '',
	'button_text' => '',

	'disable_default_hover' => '',
	
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

$output = '';

$inline_atts = '';
$class = $el_class;
$inline_style = wvc_sanitize_css_field( $inline_style );
$inline_style .= wvc_shortcode_custom_style( $css );

$class .= " wvc-i-follow_button-$follow_button wvc-wolf-gram-shortcode-container wvc-sbif-disable-hover-$disable_default_hover wvc-element";

$output = '<div class="' . wvc_sanitize_html_classes( $class ) . '" style="' . wvc_esc_style_attr( $inline_style ) . '">';

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

$output .= '</div><!-- .wvc-sb-instagram-feed-shortcode-container -->';

echo $output;