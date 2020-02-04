"use strict";
/** ===========================================================================
 * File:    /inc/pages/home/build/js/home.js
 * Project: Dana and Associates Website
 * -----
 * Author:    Sam Rankin <sam@maatlegal.com>
 * Copyright: (c) 2019 Maat Legal
 * -----
 * Created Date:  8-4-19
 * Last Modified: 8-7-19 at 6:25 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date    	By	Comments
 * --------	--	--------------------------------------------------------------
============================================================================ */
jQuery(function ($) {
    var blogItems = 0;
    
    function sameWidth(elem, breakpoint) {
        var windowWidth = window.innerWidth,
            elementWidths = $(elem).map(function () {
                return $(elem).outerWidth();
            }).get(),
            minWidth = Math.max.apply(null, elementWidths);
        if (windowWidth > breakpoint) {
            $(elem).css('min-width', minWidth);
        }
        $(window).resize(function () {
            var width = $(elem).map(function () {
                    return $(elem).outerWidth();
                }).get(),
                min = Math.max.apply(null, width);
            if (windowWidth > breakpoint) {
                $(elem).css('min-width', min);
            } else {
                $(elem).css('min-width', '0px');
            }
        });
    }
    $(document).ready(function () {
        sameWidth('#home-header-buttons .btn', 720);
        $('#featured-post .blog-info').children('.item-height').each(function () {
            var itemHeight = $(this).outerHeight(true);
            blogItems = blogItems + itemHeight;
        });
        $('#featured-post .blog-info').css('min-height', blogItems);
    });
});