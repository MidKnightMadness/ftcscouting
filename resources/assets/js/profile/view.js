$(".profile-image").hover(function(){
    $(".profile-image").popover('show');
}, function(){
    $(".profile-image").popover('hide');
});