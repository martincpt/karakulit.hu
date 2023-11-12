/**
 *  Searchable dropdown
 */
 /* global KayoAdminParams */
;( function( $ ) {

	'use strict';

	$( '.kayo-searchable' ).chosen( {
		no_results_text: KayoAdminParams.noResult,
		width: '100%'
	} );

	$( document ).on( 'hover', '#menu-to-edit .pending', function() {
		if ( ! $( this ).find( '.chosen-container' ).length && $( this ).find( '.kayo-searchable' ).length ) {
			$( this ).find( '.kayo-searchable' ).chosen( {
				no_results_text: KayoAdminParams.noResult,
				width: '100%'
			} );
		}
	} );

} )( jQuery );