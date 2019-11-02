$(function() {
    $('body').on('click', function(e) {
        let target = $(e.target);
        let menuBtn = $('.navbar-toggler');
        let menuOpen = menuBtn.hasClass('menu-open');
        let clickInNav = target.closest('.navbar').length;
        if (!clickInNav && menuOpen) {
            menuBtn.click();
        }
    })
})