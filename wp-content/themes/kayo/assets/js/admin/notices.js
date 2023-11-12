/**
 *  Theme update notice
 */
/* global Cookies */
(function ($) {
	'use strict';

	$(document).on('click', '.kayo-dismiss-admin-notice', function (
		event
	) {
		event.preventDefault();

		var cookieID = $(this).attr('id');

		Cookies.set(cookieID, 'hide', { path: '/', expires: 730 });
		$(this).parents('.notice-info, .notice-warning').slideUp();
	});
})(jQuery);
