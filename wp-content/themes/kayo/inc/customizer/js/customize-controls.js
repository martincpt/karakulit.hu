;( function( $ ) {

	'use strict';

	$( document ).on( 'load ready', function() {

		/* === Checkbox Multiple Control === */

		$( document ).on(
			'change', '.customize-control-group_checkbox input[type="checkbox"]',
			function() {

				var checkbox_values = $( this ).parents( '.customize-control' ).find( 'input[type="checkbox"]:checked' ).map(
					function() {
						return this.value;
					}
				).get().join( ',' );

				$( this ).parents( '.customize-control' ).find( 'input[type="hidden"]' ).val( checkbox_values ).trigger( 'change' );
			}
		);
	} );

} )( jQuery );
