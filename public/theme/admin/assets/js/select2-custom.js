"use strict";
setTimeout(function () {
    (function ($) {
        "use strict";
        // Single Search Select
        $(".select2").select2({
            width: "100%",
            templateResult: formatOption,
            templateSelection: formatOption,
            search: false,
        });
    })(jQuery);
}, 350);

function formatOption(option) {
    if ($(option.element).data('type')) {
        const type = $(option.element).data('type');
        const icon = type === 'parent' ? '📂' : type === 'child' ? '&nbsp;&nbsp;📄' : '&nbsp;&nbsp;🏠';
        return $('<span>' + icon + ' ' + option.text + '</span>');
    }
    
    return option.text;
}
