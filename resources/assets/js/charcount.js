$(document).ready(function () {
    var charCounts = document.getElementsByClassName("character-count");
    for (var i = 0; i < charCounts.length; i++) {
        updateCharCount($(charCounts[i]));
    }
});
$(".character-count").keyup(function () {
    updateCharCount($(this));
});

function updateCharCount(element) {
    var maxChars = element.attr('maxlength');
    if(typeof(maxChars) == "undefined"){
        return;
    }
    var currentChars = element.val().length;
    var feedbacks = document.getElementsByClassName(element.data('count-feedback'));
    for (var j = 0; j < feedbacks.length; j++) {
        var feedback = $(feedbacks[j]);
        feedback.text(currentChars + "/" + maxChars);
    }
}