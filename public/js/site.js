$(function () {
    $(document).scroll(function () {
        var $nav = $("#mainNav");
        var navTrigger = $(".section2");
        var navTriggerHeight = navTrigger.height();
        $nav.toggleClass('scrolled', $(this).scrollTop() > (navTriggerHeight * 150) / 100);
    });
});