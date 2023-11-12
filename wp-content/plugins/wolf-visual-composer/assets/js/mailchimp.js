/*!
 * Mailchimp
 *
 * WPBakery Page Builder Extension 3.2.8
 */
/* jshint -W062 */
/* global WVCMailchimpParams */

var WVCMailchimp = function( $ ) {

	'use strict';

	return {

		/**
		 * Init UI
		 */
		init : function () {

			var _this = this;

			this.submitButton();

			$(window)
                .resize(function () {
					_this.sizeClasses();
			});
		},

		submitButton : function () {
			$( '.wvc-mailchimp-submit' ).on( 'click', function( event ) {
				event.preventDefault();

				var message = '',
					$submit = $( this ),
					$form = $submit.parents( '.wvc-mailchimp-form' ),
					$result = $form.find( '.wvc-mailchimp-result' ),
					list_id = $form.find( '.wvc-mailchimp-list' ).val(),
					firstName = $form.find( '.wvc-mailchimp-f-name' ).val(),
					lastName = $form.find( '.wvc-mailchimp-l-name' ).val(),
					hasName = $form.find( '.wvc-mailchimp-has-name' ).val(),
					email = $form.find( '.wvc-mailchimp-email' ).val(),
					data = {

						action : 'wvc_mailchimp_ajax',
						list_id : list_id,
						firstName : firstName,
						lastName : lastName,
						email : email,
						hasName : hasName
					};

				$result.animate( { 'opacity' : 0 } );

				$.post( WVCMailchimpParams.ajaxUrl, data, function( response ) {

					if ( response ) {

						message = response;

						if ( 'OK' === response ) {

							message = WVCMailchimpParams.subscriptionSuccessfulMessage;

							/* Use to track subscription event */
							$( window ).trigger( 'wvc_mc_subscribe' );
						}

					} else {

						message = WVCMailchimpParams.unknownError;
					}

					$result.html( message ).animate( { 'opacity' : 1 } );

					setTimeout( function() {
						$result.animate( { 'opacity' : 0 } );
					}, 3000 );
				} );
			} );
		},

		sizeClasses : function () {

			$( '.wvc-mailchimp-show-name-yes.wvc-mailchimp-size-large' ).each( function() {
				if ( 600 > $( this ).width() ) {
					$( this ).addClass( 'wvc-mailchimp-smaller' );
				} else {
					$( this ).removeClass( 'wvc-mailchimp-smaller' );
				}
			} );
		}
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		WVCMailchimp.init();
	} );

} )( jQuery );
