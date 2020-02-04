"use strict";
/** ===========================================================================
 * File:    /build/js/global.js
 * Project: Dana and Associates Website
 * -----
 * Author:    Sam Rankin <sam@maatlegal.com>
 * Copyright: (c) 2019 Maat Legal
 * -----
 * Created Date:  6-10-19
 * Last Modified: 8-4-19 at 6:48 pm
 * Modified By:   Sam Rankin <sam@maatlegal.com>
 * -----
 * HISTORY:
 * Date    	By	Comments
 * --------	--	--------------------------------------------------------------
============================================================================ */
var desktopBP = 1280;
var windowWidth = verge.viewportW();
var windowHeight = verge.viewportH();
jQuery(function ($) {
    window.scrollPosition = function (direction) {
        var el = $(window),
            lastY = el.scrollTop();
        el.on('scroll', function () {
            var currY = el.scrollTop(),
                y = currY > lastY ? 'down' : currY === lastY ? 'none' : 'up';
            lastY = currY;
            direction = y;
        });
    };
    $.fn.extend({
        sameHeight: function sameHeight(options) {
            var settings = $.extend({
                    breakpoint: desktopBP
                }, options),
                elem = $(this);
            var elementHeights = elem.map(function () {
                    return elem.outerHeight();
                }).get(),
                minHeight = Math.max.apply(null, elementHeights);
            if (windowWidth > settings.breakpoint) {
                elem.css('min-height', minHeight);
            }
            $(window).resize(function () {
                var heights = elem.map(function () {
                        return elem.outerHeight();
                    }).get(),
                    min = Math.max.apply(null, heights);
                if (windowWidth > settings.breakpoint) {
                    elem.css('min-height', min);
                } else {
                    elem.css('min-height', '0px');
                }
            });
        },
        makeFullHeight: function makeFullHeight() {
            $(this).css('min-height', windowHeight);
            $(window).on('resize', function () {
                $(this).css('min-height', windowHeight);
            });
        },
        sameWidth: function sameWidth(options) {
            var settings = $.extend({
                    breakpoint: desktopBP
                }, options),
                elem = $(this),
                elementWidths = elem.map(function () {
                    return elem.outerWidth();
                }).get(),
                minWidth = Math.max.apply(null, elementWidths);
            if (windowWidth > settings.breakpoint) {
                elem.css('min-width', minWidth);
            }
            $(window).resize(function () {
                var width = elem.map(function () {
                        return elem.outerWidth();
                    }).get(),
                    min = Math.max.apply(null, width);
                if (windowWidth > settings.breakpoint) {
                    elem.css('min-width', min);
                } else {
                    elem.css('min-width', '0px');
                }
            });
        },
        toTitleCase: function toTitleCase() {
            return $(this).each(function () {
                var ignore = 'and,the,in,with,an,or,at,of,a,to,for'.split(',');
                var theTitle = $(this).text();
                var split = theTitle.split(' ');
                for (var x = 0; x < split.length; x++) {
                    if (x > 0) {
                        if (ignore.indexOf(split[x].toLowerCase()) < 0) {
                            split[x] = split[x].replace(/\w\S*/g, function (txt) {
                                return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                            });
                        }
                    } else {
                        split[x] = split[x].replace(/\w\S*/g, function (txt) {
                            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                        });
                    }
                }
                var title = split.join(' ');
                $(this).text(title);
            });
        }
    });
    
    function themeJS() {
        $('.checkbox').each(function () {
            var check = $(this).find('input[type="checkbox"]');
            $(this).addClass('custom-control').addClass('custom-checkbox').prepend(check);
            $(this).children('input').addClass('custom-control-input');
            $(this).children('label').addClass('custom-control-label');
        });
        $('.mc4wp-checkbox').each(function () {
            var check = $(this).find('input[type="checkbox"]');
            $(this).addClass('custom-control').addClass('custom-checkbox').prepend(check);
            $(this).children('input').addClass('custom-control-input');
            $(this).children('label').addClass('custom-control-label');
        });
        $('.radio').each(function () {
            var radio = $(this).find('input[type="radio"]');
            $(this).addClass('custom-control').addClass('custom-radio').prepend(radio);
            $(this).children('input').addClass('custom-control-input');
            $(this).children('label').addClass('custom-control-label');
        });
        $('.modal').each(function () {
            $(this).appendTo('body');
        });
        $('.custom-control-label').each(function () {
            $(this).wrapInner('<span class="custom-control-label-text"></span>').prepend('<span class="custom-control-icon"></span>');
        });
        $('.section-full-height').makeFullHeight();
        $('.wpcf7-select').select2({
            theme: 'bootstrap4'
        });
        $.fn.select2.defaults.set('theme', 'bootstrap4');
        $('[data-toggle="tooltip"]').tooltip();
        $('[data-toggle="popover"]').popover({
            trigger: 'focus'
        });
        bsCustomFileInput.init();
        $('.collapse-menu .level-2-menu').each(function () {
            $(this).on('hidden.bs.collapse', function () {
                $(this).find('.collapse').collapse('hide');
            });
        });
        $('.full-height-section').makeFullHeight();
        if (windowWidth >= desktopBP) {
            if ($('.sidebar-content').length !== 0) {
                $('.sidebar-content').stick_in_parent({
                    recalc_every: 5
                });
            }
        }
    }
    $(document).ready(function () {
        themeJS();
    });
    $(window).load(function () {
        $('.hover-box-row .hover-box').sameHeight();
    });
    $(window).resize(function () {
        if ($('.sidebar-content').length !== 0) {
            if (windowWidth >= desktopBP) {
                $('.sidebar-content').stick_in_parent({
                    recalc_every: 5
                });
            } else {
                $('.sidebar-content').trigger('sticky_kit:detach');
            }
        }
    });
});

function logElementEvent(eventName, element) {
    console.log(Date.now(), eventName, element.getAttribute('data-src'));
}
var callback_enter = function callback_enter(element) {
    logElementEvent('🔑 ENTERED', element);
};
var callback_exit = function callback_exit(element) {
    logElementEvent('🚪 EXITED', element);
};
var callback_reveal = function callback_reveal(element) {
    logElementEvent('👁️ REVEALED', element);
};
var callback_loaded = function callback_loaded(element) {
    logElementEvent('👍 LOADED', element);
};
var callback_error = function callback_error(element) {
    logElementEvent('💀 ERROR', element);
    element.src = 'https://via.placeholder.com/440x560/?text=Error+Placeholder';
};
var callback_finish = function callback_finish() {
    logElementEvent('✔️ FINISHED', document.documentElement);
};
window.lazyLoadOptions = {
    elements_selector: '.lazyload',
    threshold: 0,
    // Assign the callbacks defined above
    callback_enter: callback_enter,
    callback_exit: callback_exit,
    callback_reveal: callback_reveal,
    callback_loaded: callback_loaded,
    callback_error: callback_error,
    callback_finish: callback_finish,
    use_native: true
};
window.addEventListener('LazyLoad::Initialized', function (event) {
    window.lazyLoadInstance = event.detail.instance;
}, false);
"use strict";
jQuery(function ($) {
    $(document).ready(function () {
        $('.owl-carousel').each(function () {
            var owl = $(this);
            var optionsJSON = $(this).data('owlcarousel'),
                args = jQuery.parseJSON(JSON.stringify(optionsJSON));
            args.slideBy = 'page';
            args.navText = ['<i class="dana dana-angle-left" aria-hidden="true" role="presentation"></i> <span class="sr-only">Previous</span>', '<i class="dana dana-angle-right" aria-hidden="true" role="presentation"></i> <span class="sr-only">Next</span>'];
            
            function navButtons(event) {
                var element = '#' + event.target.id,
                    carousel = document.getElementById(event.target.id),
                    prevBtn = $(element).find('.owl-prev'),
                    nextBtn = $(element).find('.owl-next'),
                    carouselHeight = verge.rectangle(carousel).height;
                $(element).prepend(prevBtn);
                $(prevBtn).addClass('owl-btn').css('top', carouselHeight / 2);
                $(nextBtn).addClass('owl-btn').css('top', carouselHeight / 2).insertBefore($(element).find('.owl-dots'));
            }
            args.onInitialized = navButtons;
            owl.owlCarousel(args);
        });
    });
});
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
    function toProperCase(elem) {
        var ignore = 'and,the,in,with,an,or,at,of,a,to,for'.split(',');
        var theTitle = elem;
        var split = theTitle.split(' ');
        for (var x = 0; x < split.length; x++) {
            if (x > 0) {
                if (ignore.indexOf(split[x].toLowerCase()) < 0) {
                    split[x] = split[x].replace(/\w\S*/g, function (txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
                }
            } else {
                split[x] = split[x].replace(/\w\S*/g, function (txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
            }
        }
        var title = split.join(' ');
        return title;
    }
    
    function validURL(str) {
        var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
            '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
        return !!pattern.test(str);
    }
    var windowURL = new URL(window.location.href),
        windowPath = windowURL.pathname;
    
    function addPopovertoFAQLink() {
        $('.main-content a').each(function () {
            var href = $(this).attr('href');
            if (validURL(href) == true) {
                var url = new URL(href),
                    urlString = url.toString();
                if (urlString.includes('faqs')) {
                    var hash = url.hash,
                        path = url.pathname,
                        item = '';
                    if (_typeof(hash) === undefined || hash === '') {
                        var newpath = path.split('/'),
                            filtered = newpath.filter(function (el) {
                                return el != '';
                            });
                        item = filtered.slice(-1)[0];
                    } else {
                        item = hash.toString();
                    }
                    var title = item.split('-').join(' '),
                        text = toProperCase(title);
                    var popoverContent = 'FAQ: ' + text + '?';
                    $(this).popover({
                        container: 'body',
                        content: popoverContent,
                        placement: 'top',
                        trigger: 'hover',
                        template: '<div class="popover" role="tooltip"><div class="arrow"></div><h5 class="popover-header"></h5><div class="popover-body"></div><div class="popover-footer">Click to Learn More <i class="fas fa-external-link-square-alt"></i></div></div>'
                    });
                    if (!windowPath.includes('faqs')) {
                        $(this).attr('href', url.origin + '/faqs#' + item);
                    } else {
                        $(this).attr('href', '#' + item);
                    }
                }
            }
        });
    }
    $(document).ready(function () {
        addPopovertoFAQLink();
    });
});
"use strict";
jQuery(function ($) {
    function addHeaderSpacing(header, elem) {
        var element = $(header),
            headerHeight = verge.rectangle(element).height;
        $(elem).css('padding-top', headerHeight);
    }
    $(window).load(function () {
        addHeaderSpacing('#site-header', '.header-margin');
    });
    $(window).resize(function () {
        addHeaderSpacing('#site-header', '.header-margin');
    });
});
"use strict";
"use strict";
"use strict";