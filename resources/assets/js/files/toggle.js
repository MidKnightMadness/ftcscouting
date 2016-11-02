$(".toggle").click(function () {
    var element = $(this).data('toggle');
    toggleElement(element);
});
function toggleElement(clazz) {
    var toToggle = document.getElementsByClassName(clazz);
    for (var i = 0; i < toToggle.length; i++) {
        doToggle(toToggle[i]);
    }
}
$(document).ready(function () {
    var allToHide = document.querySelectorAll("[data-hidden=true]");
    for (var i = 0; i < allToHide.length; i++) {
        var element = $(allToHide[i]);
        var hidden = element.data('hidden');
        element.data('hidden', true);
        element.hide();
    }
});

function doToggle(element) {
    element = $(element);
    if (!element.attr('data-hidden')) {
        element.attr('data-hidden', false);
    }
    var hidden = element.data('hidden');
    if (hidden) {
        element.data('hidden', false);
        element.fadeIn(500);
    } else {
        element.data('hidden', true);
        element.fadeOut(500);
    }
}