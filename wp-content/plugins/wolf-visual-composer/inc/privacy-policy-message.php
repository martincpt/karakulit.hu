<?php
/**
 * Output Privacy Policy Message
 *
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Frontend
 * @version 3.2.8
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

function wvc_privacy_policy_message( $atts = array() ) {

	$atts = apply_filters( 'wvc_privacy_policy_message_atts', wp_parse_args( $atts, array(
		'status' => wolf_vc_get_option( 'privacy_policy_message', 'status' ),
		'privacy_policy_message' => wolf_vc_get_option( 'privacy_policy_message', 'privacy_policy_message' ),
		'privacy_policy_page' => wolf_vc_get_option( 'privacy_policy_message', 'privacy_policy_page' ),
		'link_text' =>  wolf_vc_get_option( 'privacy_policy_message', 'link_text', esc_html__( 'Read more', 'wolf-visual-composer' ) ),
		'bg_color' =>  wolf_vc_get_option( 'privacy_policy_message', 'bg_color' ),
		'font_color' =>  wolf_vc_get_option( 'privacy_policy_message', 'font_color' ),
	) ) );

	extract( $atts );

	$enabled = apply_filters( 'wvc_enable_privacy_policy_message', ( 'enabled' === $status ) );

	if ( ! $status || '' === $status || 'disabled' === $status || ! $enabled ) {
		return;
	}

	if ( 'enabled_eu' === $status ) {

		$country_code = wvc_get_user_country_code();

		if ( $country_code && ! wvc_user_country_code_is_in_eu( $country_code ) ) {
			return;
		}
	}

	if ( is_404() ) {
		return;
	}

	$inline_style = '';

	if ( $bg_color ) {
		$inline_style .= 'background-color:' . wvc_sanitize_color( $bg_color ) . ';';
	}

	if ( $font_color ) {
		$inline_style .= 'color:' . wvc_sanitize_color( $font_color ) . ';';
	}

	wp_enqueue_script( 'js-cookie' );
	wp_enqueue_script( 'wvc-privacy-policy-message' );

	ob_start();
	?>
	<div id="wvc-privacy-policy-message-container">
		<div id="wvc-privacy-policy-message-content" style="<?php echo wvc_esc_style_attr( $inline_style ); ?>">
			<a href="#" id="wvc-privacy-policy-message-close" class="wvc-privacy-policy-message-close">X</a>
			<div id="wvc-privacy-policy-message-inner">
				<div id="wvc-privacy-policy-message" >
					<?php echo wvc_kses( $privacy_policy_message ); ?>
					<?php if ( $privacy_policy_page ) : ?>
						&nbsp;<a href="<?php echo get_permalink( absint( $privacy_policy_page ) ); ?>"><?php esc_attr_e( $link_text ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
	<?php
	echo apply_filters( 'wvc_privacy_policy_message_output', ob_get_clean(), $atts );
}
add_action( 'wolf_body_start', 'wvc_privacy_policy_message' );
