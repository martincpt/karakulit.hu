/*!
 * Particles
 *
 * WPBakery Page Builder Extension 3.2.8
 */
/* jshint -W062 */

/* global particlesJS, WVCParams */
var WVCParticles = function( $ ) {

	'use strict';

	return {

		isMobile : false,

		/**
		 * Init UI
		 */
		init : function () {

			this.isMobile = WVCParams.isMobile;

			if ( this.isMobile ) {
				return;
			}

			$( '.wvc-particles' ).each( function() {
				var $container = $( this ),
					id = $container.attr( 'id' ),
					type = $container.data( 'particles-type' ) || 'default';

				particlesJS.load( id, WVCParams.WvcUrl + '/assets/js/particles/' + type + '.json', function() {
					//console.log('callback - particles.js config loaded');
				} );
			} );

		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCParticles.init();
	} );

} )( jQuery );