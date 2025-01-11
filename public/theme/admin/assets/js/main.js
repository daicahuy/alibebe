
$(document).ready(function () {
    var $body = $('body');
    var $btnMode = $('.mode');
    var $iconImages = $('.icon-image');

    $btnMode.on('click', function (e) {
        if ($body.hasClass('light-only')) {
            $body.removeClass('light-only')
            $body.addClass('dark-only')
        }
        else {
            $body.addClass('light-only')
            $body.removeClass('dark-only')
        }

        $iconImages.each((index, iconImage) => {
            if ($body.hasClass('light-only')) {
                $(iconImage).removeClass('colorwhite-icon');
                $(iconImage).addClass('colordark-icon');
            }
            else {
                $(iconImage).addClass('colorwhite-icon');
                $(iconImage).removeClass('colordark-icon');
            }
        })

    })
})
