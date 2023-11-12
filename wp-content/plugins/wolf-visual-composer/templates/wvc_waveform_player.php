<?php
/**
 * Waveform Player shortcode template
 *
 * @author WolfThemes
 * @category Core
 * @package WolfWPBakeryPageBuilderExtension/Templates
 * @version 3.2.8
 */

defined( 'ABSPATH' ) || exit;

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );

extract( shortcode_atts( array(
	'title' => '',
	'url' => '',
	'css_animation' => '',
	'css_animation_delay' => '',
	'el_class' => '',
	'css' => '',
	'inline_style' => '',
), $atts ) );

//include( WVC_DIR . '/assets/lib/justwave/JustWave.class.php' );
//include( WVC_DIR . '/assets/lib/justwave/justwave.ajax.php' );

$output = ''; 
ob_start();
?>
<script>
	var wavesurfer = WaveSurfer.create( {
		container: document.querySelector('#wave'),
		waveColor: '#D2EDD4',
		progressColor: '#46B54D'
	} );

	wavesurfer.on( 'ready', function () {
		// code that runs after wavesurfer is ready
		console.log( 'Success' );
	} );

	wavesurfer.load('http://localhost/factory/bronze/wp-content/uploads/sites/15/2020/05/23801389_beautiful-abstract-hiphop_by_cleanmindsounds_preview.mp3');

</script>
<div id="waveform"></div>
<?php

$output .= ob_get_clean();

echo $output;