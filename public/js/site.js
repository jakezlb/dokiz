$(function () {
    $(document).scroll(function () {
        var $nav = $("#mainNav");
        var section2 = $("#section2");
        var section3 = $("#section3");
        var section4 = $("#section4");
        var navTrigger2 = $(".section2");
        var navTriggerHeight2 = navTrigger2.height();
        $nav.toggleClass('scrolled', $(this).scrollTop() > (navTriggerHeight2 * 120) / 100);
        section2.toggleClass('btnNavActive', $(this).scrollTop() > (navTriggerHeight2 * 120) / 100 && $(this).scrollTop() < (navTriggerHeight2*230) / 100);
        section3.toggleClass('btnNavActive', $(this).scrollTop() > (navTriggerHeight2 * 230) / 100 && $(this).scrollTop() < (navTriggerHeight2*280) / 100);
        section4.toggleClass('btnNavActive', $(this).scrollTop() > (navTriggerHeight2 * 280) / 100);

        $('#topSection').scrollTop(0);
    });

    $('#username').hover(function() {
        $('.item1').toggle();
    });
});

