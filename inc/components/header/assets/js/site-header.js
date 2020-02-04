jQuery(function($) {
    function addHeaderSpacing(header, elem) {
        var element = $(header),
            headerHeight = verge.rectangle(element).height;
        $(elem).css('padding-top', headerHeight);
    }
    $(window).load(function() {
        addHeaderSpacing('#site-header', '.header-margin');
    });
    $(window).resize(function() {
        addHeaderSpacing('#site-header', '.header-margin');
    });
});
