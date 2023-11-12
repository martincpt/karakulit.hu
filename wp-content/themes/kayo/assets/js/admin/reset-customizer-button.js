/**
 *  Reset theme mods button
 */
 /* global KayoAdminParams,
 confirm, console */
;( function( $ ) {

	'use strict';

	if ( ! KayoAdminParams.customizerResetButton ) {
		return;
	}

	var $container = $( '#customize-header-actions' ),
		$button = $( '<button id="kayo-mods-reset" class="button-secondary button">' )
		.text( KayoAdminParams.resetModsText )
		.css( {
		'float': 'right',
		'margin-right': '10px',
		'margin-left': '10px'
	} );

	$button.on( 'click', function ( event ) {

		event.preventDefault();

		var r = confirm( KayoAdminParams.confirm ),
			data = {
				wp_customize: 'on',
				action: 'kayo_ajax_customizer_reset',
				nonce: KayoAdminParams.nonce.reset
			};

		if ( ! r ) {
			return;
		}

		$button.attr( 'disabled', 'disabled' );

		$.post( KayoAdminParams.ajaxUrl, data, function ( response ) {

			if ( 'OK' === response ) {
				wp.customize.state( 'saved' ).set( true );
				location.reload();
			} else {
				$button.removeAttr( 'disabled' );
				console.log( response );
			}
		} );
	} );

	$button.insertAfter( $container.find( '.button-primary.save' ) );
} )( jQuery );
