$(document).ready(function () {

    $('.sidebar-title').on('click', function (e) {

        var $submenu = $(this).next('.sidebar-submenu');

        if ($('.sidebar-title').hasClass('active')) {
            var $sidebarActive = $('.sidebar-title.active');
            var $submenuActive = $sidebarActive.next('.sidebar-submenu');
            $submenuActive.slideUp();
            $submenuActive.find('.according-menu i').removeClass('ri-arrow-down-s-line').addClass('ri-arrow-right-s-line');

        }

        if ($submenu.length > 0 && $submenu.children().length > 0) {

            e.preventDefault();

            if ($submenu.is(':visible')) {
                $submenu.slideUp();
                $(this).find('.according-menu i').removeClass('ri-arrow-down-s-line').addClass('ri-arrow-right-s-line');
                $(this).removeClass('active');
            } else {
                $submenu.slideDown();
                $(this).find('.according-menu i').removeClass('ri-arrow-right-s-line').addClass('ri-arrow-down-s-line');
            }
        }
    });


});

// toggle sidebar
$nav = $('.sidebar-wrapper');
$header = $('.page-header');
$toggle_nav_top = $('.toggle-sidebar');
$toggle_nav_top.click(function () {
    // $this = $(this);
    // $nav = $('.sidebar-wrapper');
    $nav.toggleClass('close_icon');
    $header.toggleClass('close_icon');
    $(window).trigger('overlay');
});

// $(window).resize(function () {
//     $nav = $('.sidebar-wrapper');
//     $header = $('.page-header');
//     $toggle_nav_top = $('.toggle-sidebar');
//     $toggle_nav_top.click(function () {
//         $this = $(this);
//         $nav = $('.sidebar-wrapper');
//         $nav.toggleClass('close_icon');
//         $header.toggleClass('close_icon');
//     });
// });
$(window).on('overlay', function () {
    $bgOverlay = $(".bg-overlay");
    $isHidden = $nav.hasClass('close_icon');
    if ($(window).width() <= 991 && !$isHidden && $bgOverlay.length === 0) {
        $('<div class="bg-overlay active"></div>').appendTo($('body'));
    }

    if ($isHidden && $bgOverlay.length > 0) {
        $bgOverlay.remove();
    }
});

$('.sidebar-wrapper .back-btn').on('click', function (e) {
    $(".page-header").toggleClass("close_icon");
    $(".sidebar-wrapper").toggleClass("close_icon");
    $(window).trigger('overlay');
});

$("body").on("click", ".bg-overlay", function () {
    $header.addClass("close_icon");
    $nav.addClass("close_icon");
    $(this).remove();
});

/////

$body_part_side = $('.body-part');
$body_part_side.click(function () {
    $toggle_nav_top.attr('checked', false);
    $nav.addClass('close_icon');
    $header.addClass('close_icon');
});

//    responsive sidebar
var $window = $(window);
var widthwindow = $window.width();
(function ($) {
    "use strict";
    if (widthwindow <= 991) {
        $toggle_nav_top.attr('checked', false);
        $nav.addClass("close_icon");
        $header.addClass("close_icon");
    }
})(jQuery);
$(window).resize(function () {
    var widthwindaw = $window.width();
    if (widthwindaw <= 991) {
        $toggle_nav_top.attr('checked', false);
        $nav.addClass("close_icon");
        $header.addClass("close_icon");
    } else {
        $toggle_nav_top.attr('checked', true);
        $nav.removeClass("close_icon");
        $header.removeClass("close_icon");
    }
});

// horizontal arrows
var view = $("#sidebar-menu");
var move = "500px";
var leftsideLimit = -500

// var Windowwidth = jQuery(window).width();
// get wrapper width
var getMenuWrapperSize = function () {
    return $('.sidebar-wrapper').innerWidth();
}
var menuWrapperSize = getMenuWrapperSize();

if ((menuWrapperSize) >= '1660') {
    var sliderLimit = -3000

} else if ((menuWrapperSize) >= '1440') {
    var sliderLimit = -3600
} else {
    var sliderLimit = -4200
}

$("#left-arrow").addClass("disabled");
$("#right-arrow").click(function () {
    var currentPosition = parseInt(view.css("marginLeft"));
    if (currentPosition >= sliderLimit) {
        $("#left-arrow").removeClass("disabled");
        view.stop(false, true).animate({
            marginLeft: "-=" + move
        }, {
            duration: 400
        })
        if (currentPosition == sliderLimit) {
            $(this).addClass("disabled");
            console.log("sliderLimit", sliderLimit);
        }
    }
});

$("#left-arrow").click(function () {
    var currentPosition = parseInt(view.css("marginLeft"));
    if (currentPosition < 0) {
        view.stop(false, true).animate({
            marginLeft: "+=" + move
        }, {
            duration: 400
        })
        $("#right-arrow").removeClass("disabled");
        $("#left-arrow").removeClass("disabled");
        if (currentPosition >= leftsideLimit) {
            $(this).addClass("disabled");
        }
    }

});

// page active

if ($('#pageWrapper').hasClass('compact-wrapper')) {
    // $(".sidebar-wrapper nav #sidebar-menu .simplebar-wrapper .simplebar-content-wrapper .simplebar-content").find("a").removeClass("active");
    // $(".sidebar-wrapper nav #sidebar-menu .simplebar-wrapper .simplebar-content-wrapper .simplebar-content").find("li").removeClass("active");

    var current = window.location.pathname
    $(".sidebar-wrapper nav #sidebar-menu ul .simplebar-mask li a").filter(function () {

        var link = $(this).attr("href");
        if (link) {
            if (current.indexOf(link) != -1) {
                $(this).parents().children('a').addClass('active');
                $(this).parents().parents().children('ul').css('display', 'block');
                $(this).addClass('active');
                $(this).parent().parent().parent().children('a').find('div').replaceWith('<div class="according-menu"><i class="ri-arrow-down-s-line"></i></div>');
                $(this).parent().parent().parent().parent().parent().children('a').find('div').replaceWith('<div class="according-menu"><i class="ri-arrow-down-s-line"></i></div>');
                return false;
            }
        }
    });
}

$('.left-header .mega-menu .nav-link').on('click', function (event) {
    event.stopPropagation();
    $(this).parent().children('.mega-menu-container').toggleClass("show");
});

$('.left-header .level-menu .nav-link').on('click', function (event) {
    event.stopPropagation();
    $(this).parent().children('.header-level-menu').toggleClass("show");
});

$(document).click(function () {
    $('.mega-menu-container').removeClass("show");
    $('.header-level-menu').removeClass("show");
});

$(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll >= 50) {
        $('.mega-menu-container').removeClass('show');
        $('.header-level-menu').removeClass('show');
    }
});

$('.left-header .level-menu .nav-link').click(function () {
    if ($('.mega-menu-container').hasClass("show")) {
        $('.mega-menu-container').removeClass("show");
    }
});

$('.left-header .mega-menu .nav-link').click(function () {
    if ($('.header-level-menu').hasClass("show")) {
        $('.header-level-menu').removeClass("show");
    }
});


$(document).ready(function () {
    $(".outside").click(function () {
        $(this).find(".menu-to-be-close").slideToggle("fast");
    });
});

$(document).on("click", function (event) {
    var $trigger = $(".outside");
    if ($trigger !== event.target && !$trigger.has(event.target).length) {
        $(".menu-to-be-close").slideUp("fast");
    }
});


$('.left-header .link-section > div').on('click', function (e) {
    if ($(window).width() <= 1199) {
        $(".left-header .link-section > div").removeClass("active");
        $(this).toggleClass("active");
        $(this).parent().children('ul').toggleClass("d-block").slideToggle();
    }
});

if ($(window).width() <= 1199) {
    $(".left-header .link-section").children('ul').css('display', 'none');
    $(this).parent().children('ul').toggleClass("d-block").slideToggle();
}

if ($(window).width() <= 991) {
    $('.sidebar-wrapper .back-btn').on('click', function (e) {
        $(".page-header").toggleClass("close_icon");
        $(".sidebar-wrapper").toggleClass("close_icon");
    });
}

if ($('#sidebar-menu .simplebar-content-wrapper').hasClass('a.sidebar-link.sidebar-title.active')) {
    $('#sidebar-menu .simplebar-content-wrapper').animate({
        scrollTop: $('a.sidebar-link.sidebar-title.active').offset().top - 200
    }, 1000);
}
