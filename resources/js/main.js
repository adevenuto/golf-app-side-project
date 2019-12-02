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

    $(document).on('keypress paste', '.num-only', function(e) {
        event = e || window.event;
        let charCode = event.which || event.keyCode;
        var inp = String.fromCharCode(charCode);
        var isNum = /^[0-9]*$/.test(inp);
        if (!isNum) e.preventDefault();
    });

})