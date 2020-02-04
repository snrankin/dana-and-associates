jQuery(function($) {
    function toProperCase(elem) {
        var ignore = 'and,the,in,with,an,or,at,of,a,to,for'.split(',');
        var theTitle = elem;
        var split = theTitle.split(' ');

        for (var x = 0; x < split.length; x++) {
            if (x > 0) {
                if (ignore.indexOf(split[x].toLowerCase()) < 0) {
                    split[x] = split[x].replace(/\w\S*/g, function(txt) {
                        return (
                            txt.charAt(0).toUpperCase() +
                            txt.substr(1).toLowerCase()
                        );
                    });
                }
            } else {
                split[x] = split[x].replace(/\w\S*/g, function(txt) {
                    return (
                        txt.charAt(0).toUpperCase() +
                        txt.substr(1).toLowerCase()
                    );
                });
            }
        }
        var title = split.join(' ');
        return title;
    }

    function validURL(str) {
        var pattern = new RegExp(
            '^(https?:\\/\\/)?' + // protocol
            '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
            '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
            '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
            '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
                '(\\#[-a-z\\d_]*)?$',
            'i'
        ); // fragment locator
        return !!pattern.test(str);
    }
    const windowURL = new URL(window.location.href),
        windowPath = windowURL.pathname;
    function addPopovertoFAQLink() {
        $('.main-content a').each(function() {
            var href = $(this).attr('href');
            if (validURL(href) == true) {
                var url = new URL(href),
                    urlString = url.toString();
                if (urlString.includes('faqs')) {
                    var hash = url.hash,
                        path = url.pathname,
                        item = '';
                    if (typeof hash === undefined || hash === '') {
                        var newpath = path.split('/'),
                            filtered = newpath.filter(function(el) {
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
                        template:
                            '<div class="popover" role="tooltip"><div class="arrow"></div><h5 class="popover-header"></h5><div class="popover-body"></div><div class="popover-footer">Click to Learn More <i class="fas fa-external-link-square-alt"></i></div></div>'
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
    $(document).ready(function() {
        addPopovertoFAQLink();
    });
});
