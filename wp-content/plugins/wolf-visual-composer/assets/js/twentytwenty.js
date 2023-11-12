/*!
 * Comparison Images Slider
 *
 * WPBakery Page Builder Extension 3.2.8
 */
/* jshint -W062 */
var WVCTwentyTwenty = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {
			$( '.wvc-twentytwenty' ).twentytwenty();
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCTwentyTwenty.init();
	} );

} )( jQuery );