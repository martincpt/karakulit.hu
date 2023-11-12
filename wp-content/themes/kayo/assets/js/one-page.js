/*!
 * One Page
 *
 * Kayo 1.5.1
 */
/* jshint -W062 */
/* global KayoParams */

var KayoOnePage = ( function ($) {
    "use strict";

    return {
        init : function() {

            var menuMarkup, rowName, anchor,
                extensionPrefix = "wvc-",
                scrollLinkClass = "scroll";

            if ( KayoParams.isWolfCore ) {
                extensionPrefix = "wolf-core-";
            }

            if ( KayoParams.fullPageAnimation ) {
                scrollLinkClass = extensionPrefix +"-fp-nav";
            }

        	if ( $( "." + extensionPrefix + "parent-row" ).length ) {

				$( "ul.nav-menu" ).hide();

                    menuMarkup = "<div class='menu-one-page-menu-container'>";
                    menuMarkup += "<ul class='nav-menu'>";

                $( "." + extensionPrefix + "parent-row" ).each( function() {

					if ( $( this ).data( "row-name" ) && ! $( this ).hasClass( "not-one-page-section" ) ) {
                        rowName = $( this ).data( "row-name" );
                        anchor = rowName.replace( " ", "-" ).toLowerCase();
                        menuMarkup += "<li class='menu-item menu-item-type-custom menu-item-object-custom'>";
                        menuMarkup += "<a href='#" + anchor + "' class='menu-link " + scrollLinkClass + "'>";
                        menuMarkup += "<span class='menu-item-inner'>";
                        menuMarkup += "<span class='menu-item-text-container' data-text='" + rowName + "' itemprop='name'>";
                        menuMarkup += rowName;
                        menuMarkup += "</span>";
                        menuMarkup += "</span>";
                        menuMarkup += "</a>";
                        menuMarkup += "</li>";
					}
				} );

				menuMarkup += "</ul>";
				menuMarkup += "</div>";

				$( "#desktop-navigation" ).find(".menu-container").append( menuMarkup );
				$( "#mobile-menu-panel-inner" ).append( menuMarkup );

				$( "#desktop-navigation" ).find( "ul.nav-menu" ).addClass( "nav-menu-desktop" ).attr( "id", "site-navigation-primary-desktop" ).fadeIn();
				$( "#mobile-menu-panel-inner" ).find( "ul.nav-menu" ).addClass( "nav-menu-mobile" ).attr( "id", "site-navigation-primary-mobile" ).fadeIn();

                $( window ).bind( "kayo_one_page_menu_loaded" );
			}
		}
	};

} )( jQuery );

( function ($) {
	"use strict";

	$( document ).ready(function () {
        KayoOnePage.init();
	} );
} )( jQuery );
