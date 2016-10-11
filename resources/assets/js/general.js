$(".hover-popover").hover(function(){
    $(this).popover('show');
}, function () {
    $(this).popover('hide');
});