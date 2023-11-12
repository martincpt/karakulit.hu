/*!
 * Additional Theme Methods
 *
 * Kayo 1.5.1
 */
/* jshint -W062 */

/* global KayoParams, KayoUi, WVC, Cookies, Event, WVCParams, CountUp */
var Kayo = function( $ ) {

	'use strict';

	return {
		initFlag : false,
		isEdge : ( navigator.userAgent.match( /(Edge)/i ) ) ? true : false,
		isWVC : 'undefined' !== typeof WVC,
		isMobile : ( navigator.userAgent.match( /(iPad)|(iPhone)|(iPod)|(Android)|(PlayBook)|(BB10)|(BlackBerry)|(Opera Mini)|(IEMobile)|(webOS)|(MeeGo)/i ) ) ? true : false,
		loaded : false,

		/**
		 * Init all functions
		 */
		init : function () {

			if ( this.initFlag ) {
				return;
			}

			var _this = this;

			//this.wcLiveSearch();
			this.quickView();
			this.loginPopup();
			this.stickyProductDetails();
			this.transitionCosmetic();
			//this.cursor();
			//this.offGridReleasesParallax();
			this.cursorFollowingTitle();
			this.WCQuantity();

			this.isMobile = KayoParams.isMobile;

			if ( this.isWVC ) {

			}

			$( window ).on( 'wwcq_product_quickview_loaded', function( event ) {

			} );

			$( window ).scroll( function() {
				var scrollTop = $( window ).scrollTop();
				_this.backToTopSkin( scrollTop );
			} );

			this.initFlag = true;
		},

		setCursorTitles : function() {

			if ( this.isMobile ) {
				return;
			}

			$( '.hover-effect-cursor .entry' ).each( function() {

				var $item = $( this ),
					$title = $item.find( '.entry-summary' );

				$title.addClass( 'entry-summary-cursor' ).detach().prependTo( 'body' );

				$title.find( 'a' ).contents().unwrap(); // strip tags
			} );
		},

		/**
		 * Title following cursor effect
		 */
		cursorFollowingTitle : function () {

			if ( this.isMobile ) {
				return;
			}

			$( '.hover-effect-cursor .entry' ).each( function() {

				var $item = $( this ),
					$title = $item.find( '.entry-summary' );

				$title.addClass( 'entry-summary-cursor' ).detach().prependTo( 'body' );

				$title.find( 'a' ).contents().unwrap(); // strip tags

				$item.on( 'mousemove', function( e ) {
					$title.css( {
						top: e.clientY,
						left: e.clientX
					} );
				} );

				$item.on( 'mouseenter', function() {
					$title.addClass( 'tip-is-active' );

				} ).on( 'mouseleave', function() {
					$title.removeClass( 'tip-is-active' );
				} );

				$( window ).scroll( function() {
					if ( $title.hasClass( 'tip-is-active' ) && ( $title.offset().top < $item.offset().top || $title.offset().top > $item.offset().top + $item.outerHeight() ) ) {
						$title.removeClass( 'tip-is-active' );
					}
				} );
			} );
		},

		// cursor : function() {

		// 	if ( this.isMobile || ! $( 'body' ).hasClass( 'custom-cursor-enabled' ) ) {
		// 		return;
		// 	}

		// 	$( 'body.custom-cursor-enabled' ).append( '<div id="hyperbent-cursor-dot-holder"><span id="hyperbent-cursor-dot"></span></div>' );

		// 	var $dotHolder = $( '#hyperbent-cursor-dot-holder' ),
		// 		$dot = $( '#hyperbent-cursor-dot' );

		// 	$dotHolder.css( {
		// 		transform: 'matrix(1, 0, 0, 1, ' + $( window ).width() / 2 + ', ' + $( window ).height() / 2 + ')'
		// 	} );

		// 	$( document ).on( 'mousemove', function( e ) {

		// 		//transform: matrix(1, 0, 0, 1, 9, 213);
		// 		$dotHolder.css( {
		// 			//left:  e.pageX,
		// 			//top:   e.pageY
		// 			transform: 'matrix(1, 0, 0, 1, ' + e.clientX + ', ' + e.clientY + ')'
		// 		} );

		// 	} ).on( 'mouseleave', function() {

		// 		$dot.hasClass( 'h-block' ) || $dot.addClass( 'h-fade-cursor' );

		// 	} ).on( 'mouseenter', function() {

		// 		$dot.hasClass( 'h-block' ) || $dot.removeClass( 'h-fade-cursor' );
		// 	} );

		// 	$( 'a' ).on( 'mouseenter', function() {
		// 		$dot.hasClass( 'h-block' ) || $dotHolder.addClass('h-hovering');
		// 	} ).on('mouseleave', function() {
		// 		$dot.hasClass( 'h-block' ) || $dotHolder.removeClass('h-hovering');
		// 	} );
		// },

		/**
		 * WC live search
		 */
		wcLiveSearch : function () {
			$( '.wvc-wc-search-form' ).addClass( 'live-search-form' ).append( '<span style="display:none" class="fa search-form-loader fa-circle-o-notch fa-spin hide"></span>' );

			KayoUi.liveSearch();
		},

		/**
		 * Product quickview
		 */
		quickView : function () {

			$( document ).on( 'added_to_cart', function( event, fragments, cart_hash, $button ) {
				if ( $button.hasClass( 'product-add-to-cart' ) ) {
					//console.log( 'good?' );
					$button.attr( 'href', KayoParams.WooCommerceCartUrl );
					$button.find( 'span' ).attr( 'title', KayoParams.l10n.viewCart );
					$button.removeClass( 'ajax_add_to_cart' );
				}
			} );
		},

		/**
		 * Sticky product layout
		 */
		stickyProductDetails : function() {
			if ( $.isFunction( $.fn.stick_in_parent ) ) {
				if ( $( 'body' ).hasClass( 'sticky-product-details' ) ) {
					$( '.entry-single-product .summary' ).stick_in_parent( {
						offset_top : parseInt( KayoParams.portfolioSidebarOffsetTop, 10 ) + 40
					} );
				}
			}
		},

		/**
		 * Check back to top color
		 */
		backToTopSkin : function( scrollTop ) {

			if ( scrollTop < 550 ) {
				return;
			}

			$( '.wvc-row' ).each( function() {

				if ( $( this ).hasClass( 'wvc-font-light' ) && ! $( this ).hasClass( 'wvc-row-bg-transparent' ) ) {

						var $button = $( '#back-to-top' ),
						buttonOffset = $button.position().top + $button.width() / 2 ,
						sectionTop = $( this ).offset().top - scrollTop,
						sectionBottom = sectionTop + $( this ).outerHeight();

					if ( sectionTop < buttonOffset && sectionBottom > buttonOffset ) {
						$button.addClass( 'back-to-top-light' );
					} else {
						$button.removeClass( 'back-to-top-light' );
					}
				}
			} );
		},

		/**
		 * WC login popup
		 */
		loginPopup: function () {
			var $body = $("body"),
				clicked = false;

			$(document).on(
				"click",
				".account-item-icon-user-not-logged-in, .close-loginform-button",
				function (event) {
					event.preventDefault();

					if ($body.hasClass("loginform-popup-toggle")) {

						$body.removeClass("loginform-popup-toggle");

					} else {

						$body.removeClass("overlay-menu-toggle");

						if ( $(".wvc-login-form").length || $(".wolf-core-login-form").length ) {

							$body.addClass("loginform-popup-toggle");

						} else if ( ! clicked ) {
							/* AJAX call */
							$.post(
								KayoParams.ajaxUrl,
								{ action: "kayo_ajax_get_wc_login_form" },
								function (response) {
									//console.log(response);

									if (response) {
										$("#loginform-overlay-content").append(
											response
										);

										$body.addClass(
											"loginform-popup-toggle"
										);
									}
								}
							);
						}
					}
				}
			);

			if (!this.isMobile) {
				$(document).mouseup(function (event) {
					if (1 !== event.which) {
						return;
					}

					var $container = $("#loginform-overlay-content");

					if (
						!$container.is(event.target) &&
						$container.has(event.target).length === 0
					) {
						$body.removeClass("loginform-popup-toggle");
					}
				});
			}
		},

		/**
		 * https://stackoverflow.com/questions/48953897/create-a-custom-quantity-field-in-woocommerce
		 */
		WCQuantity : function () {

			$( document ).on( 'click', '.wt-quantity-minus', function( event ) {

				event.preventDefault();
				var $input = $( this ).parent().find( 'input.qty' ),
					val = parseInt( $input.val(), 10 ),
					step = $input.attr( 'step' );
				step = 'undefined' !== typeof( step ) ? parseInt( step ) : 1;

				if ( val > 1 ) {
					$input.val( val - step ).change();
				}
			} );

			$( document ).on( 'click', '.wt-quantity-plus', function( event ) {
				event.preventDefault();

				var $input = $( this ).parent().find( 'input.qty' ),
					val = parseInt( $input.val(), 10),
					step = $input.attr( 'step' );
				step = 'undefined' !== typeof( step ) ? parseInt( step ) : 1;
				$input.val( val + step ).change();
			} );
		},

		 /**
		 * Overlay transition
		 */
		transitionCosmetic : function() {

			var _this = this;

			$( document ).on( 'click', '.internal-link:not(.disabled)', function( event ) {

				if ( ! event.ctrlKey ) {

					event.preventDefault();

					var $link = $( this );

					$( 'body' ).removeClass( 'mobile-menu-toggle overlay-menu-toggle offcanvas-menu-toggle loginform-popup-toggle lateral-menu-toggle' );
					$( 'body' ).addClass( 'loading transitioning' );

					Cookies.set( KayoParams.themeSlug + '_session_loaded', true, { expires: null } );

					if ( $( '#kayo-loader-overlay-panel' ).length ) {

						$( '#kayo-loader-overlay-panel' ).one( KayoUi.transitionEventEnd(), function() {
							Cookies.remove( KayoParams.themeSlug + '_session_loaded' );
							window.location = $link.attr( 'href' );
						} );

					} else if ( $( '.kayo-loading-overlay' ).length && ! $( '#kayo-loader-overlay-panel' ).length ) {

						$( '.kayo-loading-overlay' ).one( KayoUi.transitionEventEnd(), function() {
							Cookies.remove( KayoParams.themeSlug + '_session_loaded' );
							window.location = $link.attr( 'href' );
						} );

					} else {
						window.location = $link.attr( 'href' );
					}
				}
			} );
		},

                /**
                 * Page Load
                 */
                loadingAnimation : function () {

                	var _this = this,
                		delay = 50;

                	if ( $( '.kayo-loading-line' ).length ) {
                		delay = 1000;
                	}

			setTimeout( function() {

				$( 'body' ).addClass( 'loaded' );

				$( '.kayo-loading-line-aux' ).css( {
					'width' : $( window ).width() - $( '#kayo-loading-line-1' ).width()
				} );

				if ( $( '.kayo-loading-line-aux' ).length ) {

					$( '.kayo-loading-line-aux' ).one( KayoUi.transitionEventEnd(), function() {

						$( 'body' ).addClass( 'progress-bar-full' );

						$( '.kayo-loading-block' ).css( {
							'height' : '100%'
						} );

						$( '#kayo-loading-before' ).one( KayoUi.transitionEventEnd(), function() {

							$( 'body' ).addClass( 'reveal' );

							$( '.kayo-loader-overlay' ).one( KayoUi.transitionEventEnd(), function() {

								_this.fireContent();

								$( 'body' ).addClass( 'one-sec-loaded' );

								setTimeout( function() {

									$( '.kayo-loading-line-aux' ).removeAttr( 'style' );
									$( '#kayo-loading-before' ).removeAttr( 'style' );
									$( '#kayo-loading-after' ).removeAttr( 'style' );

									KayoUi.videoThumbnailPlayOnHover();
								}, 100 );
							} );
						} );
					} );

				} else if ( $( '.kayo-loader-overlay' ).length ) {

					$( 'body' ).addClass( 'reveal' );

					$( '.kayo-loader-overlay' ).one( KayoUi.transitionEventEnd(), function() {

						_this.fireContent();

						setTimeout( function() {

							$( 'body' ).addClass( 'one-sec-loaded' );

							KayoUi.videoThumbnailPlayOnHover();
						}, 100 );
					} );
				} else {

					$( 'body' ).addClass( 'reveal' );

					_this.fireContent();

					setTimeout( function() {

						$( 'body' ).addClass( 'one-sec-loaded' );

						KayoUi.videoThumbnailPlayOnHover();
					}, 100 );
				}
			}, delay );
                },

                fireContent : function () {
			// Animate
			$( window ).trigger( 'page_loaded' );
			KayoUi.wowAnimate();
			window.dispatchEvent( new Event( 'resize' ) );
			window.dispatchEvent( new Event( 'scroll' ) ); // Force WOW effect
			$( window ).trigger( 'just_loaded' );
			$( 'body' ).addClass( 'one-sec-loaded' );
                }
	};

}( jQuery );

( function( $ ) {

	'use strict';

	$( document ).ready( function() {
		Kayo.init();
	} );

	$( window ).load( function() {
		Kayo.loadingAnimation();
	} );

	$( window ).on( 'wolf_ajax_loaded', function() {
		Kayo.loadingAnimation();
	} );

} )( jQuery );
