$("#profile-column").find(".profile-image").hover(function(){
    $("#profile-column").find(".profile-image").popover('show');
}, function(){
    $("#profile-column").find(".profile-image").popover('hide');
});