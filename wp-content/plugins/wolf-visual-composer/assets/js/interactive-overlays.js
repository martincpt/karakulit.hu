/*!
 * Interactive Overlays
 *
 * WPBakery Page Builder Extension 3.2.8
 */
/* jshint -W062 */

/* global WVC, WVCParams, WOW, Vimeo, $f */
var WVCInteractiveOverlays = (function ($) {
	"use strict";

	return {
		/**
		 * Init UI
		 */
		init: function () {
			this.setOverlays();
			this.interaction();
		},

		/**
		 * Built overlays structure
		 */
		setOverlays: function () {
			$(".wvc-interactive-overlays").each(function () {
				var $container = $(this);

				$container.closest(".wvc-column").addClass("wvc-column-has-io");
				$container
					.find(".wvc-interactive-overlay-item:first-child")
					.addClass("wvc-io-active");

				$container
					.find(".wvc-interactive-overlay-item")
					.each(function (index) {
						var src = $(this).data("bg-src");

						$(this).data("index", index);

						$container
							.find(".wvc-interactive-overlays-image-holder")
							.append(
								'<div class="wvc-io-bg" data-bg-index="' +
									index +
									'" style="background-image:url(' +
									src +
									')" />'
							);

						$(this)
							.find(".wvc-io-item-content")
							.attr("id", "wvc-io-item-content-" + index)
							.data("index", index)
							.prepend(
								'<span class="wvc-io-item-content-close">&times;</span>'
							)
							.detach()
							.appendTo("body");
					});

				$container
					.find(
						".wvc-interactive-overlays-image-holder .wvc-io-bg:first-child"
					)
					.addClass("wvc-io-bg-active");

				$container.find(".wvc-io-item-link").each(function (index) {
					var $content = $("#wvc-io-item-content-" + index);

					if ($content.data("revslider-id")) {
						$(this).attr(
							"data-revslider-id",
							$content.data("revslider-id")
						);
					}
				});
			});
		},

		/**
		 * Interaction on mouse hover
		 */
		interaction: function () {
			var _this = this;

			$(document).on("mouseover", ".wvc-io-item-link", function () {
				var $overlay = $(this),
					$item = $overlay.parent(),
					item = document.getElementById($item.attr("id")),
					$container = $item.closest(
						".wvc-interactive-overlays-container"
					),
					index = $container
						.find(".wvc-interactive-overlay-item")
						.index(item);

				if ($item.hasClass(".wvc-io-active")) {
					return;
				}

				$container
					.find(".wvc-interactive-overlay-item")
					.removeClass("wvc-io-active");
				$item.addClass("wvc-io-active");

				$container.find(".wvc-io-bg").removeClass("wvc-io-bg-active");
				$container
					.find(".wvc-io-bg")
					.eq(index)
					.addClass("wvc-io-bg-active");
			});

			$(document).on("click", ".wvc-io-item-link", function (event) {
				event.preventDefault();
				event.stopPropagation();

				var index = $(this).parent().data("index"),
					$content = $("#wvc-io-item-content-" + index);

				$(".wvc-io-item-content").removeClass("wvc-io-content-active");
				$content.addClass("wvc-io-content-active");

				// do wow
				$content.one(WVC.transitionEventEnd(), function () {
					WVC.doWow(index);
					WVC.doAOS();
				});

				// Start or resume revslider if any
				if ($(this).data("revslider-id")) {
					if (!$(this).hasClass("wvc-io-link-revslider-started")) {
						window[
							"revapi" + $(this).data("revslider-id")
						].revstart();
						$(".wvc-io-item-link").addClass(
							"wvc-io-link-revslider-started"
						);

						console.log("start");

						// Force video play
						_this.startCurrentVideo($(".active-revslide"));
					} else {
						window[
							"revapi" + $(this).data("revslider-id")
						].revredraw();
						//window['revapi' + $( this ).data( 'revslider-id' )].revresume();
						//window['revapi' + $( this ).data( 'revslider-id' )].revshowslide( 1 );

						console.log("redraw");
					}

					//_this.setSlideIdOnSlideChange( $( this ).data( 'revslider-id' ) );
				}
			});

			$(document).on("click", ".wvc-io-item-content-close", function (
				event
			) {
				event.preventDefault();
				event.stopPropagation();

				var $closeButton = $(this);

				$(".wvc-io-item-content").removeClass("wvc-io-content-active");
				$("body").removeClass("wvc-io-open");

				$(this)
					.parent()
					.one(WVC.transitionEventEnd(), function () {
						$(".wvc-io-item-content").find(".wvc-delayed-wow").css({
							visibility: "hidden",
						});

						// Stop revslider if any
						if ($closeButton.parent().data("revslider-id")) {
							WVC.pausePlayers();
							_this.pauseRevSlider(
								$closeButton.parent().data("revslider-id")
							);
						}

						// Reset AOS animation
						WVC.resetAOS(".wvc-io-item-content");
					});
			});
		},

		/**
		 * Stop revslider and videos in it when closing overlay
		 */
		pauseRevSlider: function (revSliderId) {
			// Pause video
			if ($(".active-revslide").find(".tp-videolayer")) {
				var $videoContainer = $(".active-revslide").find(
					".tp-videolayer"
				);

				// case YT
				if ($videoContainer.data("ytid")) {
					$videoContainer.data("player").pauseVideo();

					// case Vimeo
				} else if ($videoContainer.data("vimeoid")) {
					var iframe = $videoContainer.find("iframe"),
						player = $f(iframe[0]);

					player.api("pause");

					// case HTML5
				} else if ($videoContainer.find("> .html5vid").length) {
					$videoContainer.find("> .html5vid > video").get(0).pause();
				}
			}

			// Pause Player
			window["revapi" + revSliderId].revpause();
		},

		/**
		 * Stop an iframe or HTML5 <video> from playing
		 * @param  {Element} element The element that contains the video
		 */
		stopVideo: function (element) {
			var iframe = element.querySelector("iframe"),
				video = element.querySelector("video");

			if (iframe) {
				var iframeSrc = iframe.src;
				iframe.src = iframeSrc;
			}

			if (video) {
				video.pause();
			}
		},

		/**
		 * Set current slide on slide change
		 */
		setSlideIdOnSlideChange: function (revSliderId) {
			window["revapi" + revSliderId].bind(
				"revolution.slide.onafterswap",
				function (e, data) {
					$(
						'.wvc-io-item-link[data-revslider-id="' +
							revSliderId +
							'"]'
					).attr("data-current-revslide-id", data.slideIndex);
				}
			);
		},

		/**
		 * Start active video background
		 *
		 * disabled
		 */
		startCurrentVideo: function ($container) {
			var $iframe = $container.find("iframe"),
				YTPlayerId = $iframe.parent().data("yt-bg-element-id"),
				VimeoPlayerId = $iframe.data("vimeo-bg-element-id"),
				$video = $container.find("video");

			if ($iframe.length) {
				if ($iframe.hasClass("wvc-youtube-bg")) {
					if (
						"undefined" !== typeof WVCYTVideoBg &&
						WVCYTVideoBg.players[YTPlayerId]
					) {
						WVCYTVideoBg.players[YTPlayerId].playVideo();
					}
				} else if ($iframe.hasClass("wvc-vimeo-bg")) {
					if (
						"undefined" !== typeof WVCVimeo &&
						WVCVimeo.players[VimeoPlayerId]
					) {
						WVCVimeo.players[VimeoPlayerId].play();
					}
				}
			} else if ($video.length) {
				$video.trigger("play");
			}
		},

		/**
		 * Pause all videos
		 */
		pauseAllVideos: function ($container) {
			var _this = this,
				VimeoPlayerId,
				$video;

			/* Pause all HTML videos */
			if ($container.find(".wvc-video-bg").length) {
				$container.find(".wvc-video-bg").each(function () {
					$video = $(this);
					$video.get(0).pause();
				});
			}

			/* Pause all YT videos */
			$container.find(".wvc-yt-video-bg-pause").trigger("click");

			/* Pause all Vimeo  videos */
			$container
				.find(".wvc-vimeo-video-bg-container > iframe")
				.each(function () {
					VimeoPlayerId = $(this).data("vimeo-bg-element-id");
					if (
						"undefined" !== typeof WVCVimeo &&
						WVCVimeo.players[VimeoPlayerId]
					) {
						WVCVimeo.players[VimeoPlayerId].pause();
					}
				});
		},

		/**
		 * Delay anim n page load
		 */
		pageLoad: function () {
			setTimeout(function () {
				WVC.delayWow(".wvc-io-item-content");
				WVC.resetAOS(".wvc-io-item-content");
			}, 1000);
		},
	};
})(jQuery);

(function ($) {
	"use strict";

	$(document).ready(function () {
		WVCInteractiveOverlays.init();
	});

	$(window).load(function () {
		WVCInteractiveOverlays.pageLoad();
	});
})(jQuery);
