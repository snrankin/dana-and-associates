"use strict";

function _typeof(obj) {
    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
        _typeof = function _typeof(obj) {
            return typeof obj;
        };
    } else {
        _typeof = function _typeof(obj) {
            return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
        };
    }
    return _typeof(obj);
}
jQuery(function ($) {
    $(document).ready(function () {
        var el = $(window),
            lastY = el.scrollTop(),
            scrollY = 'none';
        el.on('scroll', function () {
            var currY = el.scrollTop(),
                y = currY > lastY ? 'down' : currY === lastY ? 'none' : 'up';
            scrollY = y;
            lastY = currY;
        });
        $('body').scrollspy({
            target: '.menu-faqs'
        });
        $('#mobile-faqs-nav-wrapper').stick_in_parent();
        $('#mobile-faqs-nav').select2({
            placeholder: 'FAQs Navigation',
            allowClear: true,
            dropdownParent: '#mobile-faqs-nav-wrapper'
        });
        $(window).scroll(function () {
            $(window).on('activate.bs.scrollspy', function (e, obj) {
                var item = '.menu-faqs a[href="' + obj.relatedTarget + '"]',
                    level = $(item).data('level');
                if (_typeof(level) === undefined) {
                    level = 1;
                }
                $(item).parent().siblings().children('.menu-container').collapse('hide');
                $(item).siblings('.menu-container').collapse('show');
                if (scrollY === 'up' && level !== 1) {
                    $(item).closest('.level-1-menu-item').siblings().find('.menu-container').collapse('hide');
                    $(item).parents('.nav-item').children('.menu-container').collapse('show');
                }
            });
        });
        $('.page-title').waypoint(function (direction) {
            if (direction === 'up') {
                $('.menu-faqs').find('.menu-container').collapse('hide');
            }
        });
        $('.cta').waypoint(function (direction) {
            if (direction === 'down') {
                $('.menu-faqs').find('.menu-container').collapse('hide');
            }
        });
    });
});