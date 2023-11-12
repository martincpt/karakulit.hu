/*!
 * Vimeo
 *
 * Kayo 1.5.1
 */
/* jshint -W062 */

/* global Vimeo */
var KayoVimeo = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			if ( "undefinined" !== typeof Vimeo ) {
				$( '.vimeo-bg' ).each( function() {
					var iframe = $( this )[0],
						player = new Vimeo.Player( iframe );

					player.setVolume( 0 );
				} );
			}
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		KayoVimeo.init();
	} );

} )( jQuery );
