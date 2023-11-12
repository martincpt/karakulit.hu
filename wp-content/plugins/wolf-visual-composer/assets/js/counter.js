/*!
 * Counter
 *
 * WPBakery Page Builder Extension 3.2.8
 */
/* jshint -W062 */
/* global Waypoint,
CountUp */
var WVCCounter = function( $ ) {

	'use strict';

	return {

		counters : [],

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;

			$( '.wvc-counter' ).each( function( index ) {
				var $counter = $( this ),
					counter,
					options,
					containerId = $counter.parent().attr( 'id' ),
					couterId = $( this ).attr( 'id' ),
					end = $counter.data( 'end' ) || 1000,
					prefix = $counter.data( 'prefix' ) || '',
					suffix = $counter.data( 'suffix' ) || '',
					duration = $counter.data( 'duration' ) || 2.5;
					//delay = $counter.data( 'delay' ) || 10;

				options = {
					useEasing : false,
					useGrouping : true,
					separator : ',',
					decimal : '.',
					prefix : prefix,
					suffix : suffix
				};

				//var demo = new CountUp("counterupJSElement", setting.start, setting.end, setting.decimals, setting.duration, options);
				counter = new CountUp( couterId, 0, end, 0, duration, options);

				_this.counters[index] = counter;

				new Waypoint( {

					element: document.getElementById( containerId ),

					//handler: function( direction ) {
					handler: function() {

						_this.counters[index].start();

					},
					offset: '88%'
				} );
			} );
		},

		/**
		 * 
		 */
		counter : function () {
			var counter,
				options,
				containerId = $counter.parent().attr( 'id' ),
				couterId = $( this ).attr( 'id' ),
				end = $counter.data( 'end' ) || 1000,
				prefix = $counter.data( 'prefix' ) || '',
				suffix = $counter.data( 'suffix' ) || '',
				duration = $counter.data( 'duration' ) || 2.5;
				//delay = $counter.data( 'delay' ) || 10;

			options = {
				useEasing : false,
				useGrouping : true,
				separator : ',',
				decimal : '.',
				prefix : prefix,
				suffix : suffix
			};

			counter = new CountUp( couterId, 0, end, 0, duration, options);

			new Waypoint( {

					element: document.getElementById( containerId ),

					//handler: function( direction ) {
					handler: function() {

					counter.start();

				},
				offset: '88%'
			} );

			return counter;
		},

		reset : function () {
			$.each( this.counters, function() {
				this.reset();
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCCounter.init();
	} );

} )( jQuery );

