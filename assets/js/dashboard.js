$(function () {
        $('.grid-stack').gridstack({
            width: 12
        });
});

.$(function() {
    $('.directory-add').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $($anchor.attr('href')).offset().top
        }, 1500, 'easeInOutExpo');
        event.preventDefault();
    });
});