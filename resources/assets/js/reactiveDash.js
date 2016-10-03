var dash_displayed;

/**
 * Registers initial handlers for showing the div the user requested
 */
$(document).ready(function () {
    if(window.location.hash != ""){
        var hash = window.location.hash.substr(1);
        dash_showDiv(hash);
    } else {
        $(".panel-selector").each(function(){
            if($(this).hasClass("active")){
                $(this).children().each(function() {
                    var hash = $(this).attr('href').substr(1);
                    dash_showDiv(hash);
                    $(this).parent().addClass("active");
                });
            }
        });
    }
});

/**
 * Shows the div with the provided id. Will replace the currenly shown div
 * @param toShow The div to show
 */
function dash_showDiv(toShow){
    var selector = '#'+toShow;
    var elem = $(selector);
    if(elem.length){
        dash_swapDisplayed(elem);
    } else {
       dash_swapDisplayed($('.no-panel'));
    }
    dash_updatePills();
}

/**
 * Swaps the currently displayed div with the given div
 * @param newDiv The div to show
 */
function dash_swapDisplayed(newDiv){
    if(typeof dash_displayed != "undefined"){
        dash_displayed.fadeOut(250, function(){
            dash_displayed = newDiv;
            dash_displayed.fadeIn(250);
        })
    } else {
        dash_displayed = newDiv;
        dash_displayed.fadeIn(250);
    }
}

/**
 * Updates the navbar pills, so that the active tab is shown
 */
function dash_updatePills(){
    $(".panel-selector a").each(function(){
        if($(this).attr('href') == window.location.hash){
            $(this).parent().addClass("active");
        } else {
            $(this).parent().removeClass("active");
        }
    })
}
/**
 * Registers events for properly handling hash changes
 */
if(("onhashchange" in window)){
    $(window).bind('hashchange', function(){
        dash_showDiv(window.location.hash.substr(1));
    });
} else {
    $(".panel-selector").click(function(){
        location.reload();
    })
}