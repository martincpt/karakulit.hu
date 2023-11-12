<?php
/**
 * Kayo customizer fonts preview functions
 *
 * @package WordPress
 * @subpackage Kayo
 * @version 1.5.1
 */

defined( 'ABSPATH' ) || exit;

/**
 * Returns CSS for the layout.
 *
 * @param array $values Fonts family.
 * @return string
 */
function kayo_get_layout_css( $values ) {

	$values = wp_parse_args(
		$values,
		array(
			'site_width'                   => '',
			'menu_item_horizontal_padding' => '',
			'logo_max_width'               => '',
		)
	);

	extract( $values );

	$layout_css = '';

	if ( $logo_max_width ) {
		$layout_css .= '
			.logo{
				max-width:' . $logo_max_width . ';
			}
		';
	}

	if ( $menu_item_horizontal_padding ) {
		$layout_css .= '
			.nav-menu-desktop li a{
				padding: 0 ' . $menu_item_horizontal_padding . 'px;
			}
		';
	}

	/* make "hot" & "new" menu label translatable */
	$layout_css .= '
		.nav-menu li.hot > a .menu-item-text-container:before{
			content : "' . esc_html__( 'hot', 'kayo' ) . '";
		}

		.nav-menu li.new > a .menu-item-text-container:before{
			content : "' . esc_html__( 'new', 'kayo' ) . '";
		}

		.nav-menu li.sale > a .menu-item-text-container:before{
			content : "' . esc_html__( 'sale', 'kayo' ) . '";
		}
	';
	
	/**
	 * Filters layout CSS output
	 * 
	 * @since Kayo 1.0.0
	 */
	return apply_filters( 'kayo_layout_css_output', $layout_css, $values );
}

/**
 * Get array of layout values of the Underscore template
 *
 * @return array $values
 */
function kayo_get_template_layout() {

	$values = array(
		'site_width',
		'logo_max_width',
	);

	foreach ( $values as $id ) {
		$values[ $id ] = '{{ data.' . $id . ' }}';
	}

	return $values;
}

/**
 * Outputs an Underscore template for generating CSS for the layout.
 *
 * The template generates the css dynamically for instant display in the
 * Customizer preview.
 */
function kayo_layout_css_template() {
	$layout = kayo_get_template_layout();
	?>
	<script type="text/html" id="tmpl-kayo-layout">
		<?php echo wp_kses_data( kayo_get_layout_css( $layout ) ); ?>
	</script>
	<?php
}
add_action( 'customize_controls_print_footer_scripts', 'kayo_layout_css_template' );
