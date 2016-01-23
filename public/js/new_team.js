function disableForm(reason) {
    $("#tn_exist").html(reason);
    $("#submit_button").prop("disabled", true);
    $("#tn_div").prop("class", "form-group has-error");
}
function reenableForm() {
    $("#submit_button").prop("disabled", false);
    return false
}
function reset(){
    $(document.body).css('background', 'white');
    $(document.body).css('-ms-transform', 'rotate(0)');
    $(document.body).css('-webkit-transform', 'rotate(0)');
    $(document.body).css('transform', 'rotate(0)');
    $("#slay_beast").fadeOut();
}
function the_beast(){
    $(document.body).css('background', 'red');
    $(document.body).css('-ms-transform', 'rotate(180deg)');
    $(document.body).css('-webkit-transform', 'rotate(180deg)');
    $(document.body).css('transform', 'rotate(180deg)');
    $("#slay_beast").fadeIn();
}
$(document).ready(function () {
    $("#team_number").focusout(function () {
        var teamNumber = $("#team_number").val();
        if (teamNumber == null || teamNumber == "")
            return;
        if (teamNumber === "7854") {
            var submitterName = $("input[name=submitter_name]").val();
            disableForm("I'm sorry, " + submitterName + ", I can't let you do that. <br>If you really want to do that, click <a href=\"#\" onclick='reenableForm()'> here</a>.");
            return;
        }
        if(teamNumber === "666"){
            the_beast();
        } else {
            reset();
        }
        if (isNaN(teamNumber)) {
            disableForm("\"" + teamNumber + "\" is not a number in this world. It may be in your world, but not in this one. However, if you ask Brian, he may think it is. ");
            return;
        }
        var url = '/ajax/team-info/' + teamNumber;
        $.getJSON(url, function (data) {
            if (typeof data.team_name != "undefined") {
                disableForm("Team " + teamNumber + " has already been submitted by " + data.submitter + "<br/> Click <a href='/team/edit/" + data.id + "'> Here</a> to edit the team");
            } else {
                $("#submit_button").prop("disabled", false);
                $("#tn_div").prop("class", "form-group");
                $("#tn_exist").html("");
            }
        });
    });
    $("#c_s_a").change(function () {
        if (this.checked) {
            var teleop = $("#c_s_t");
            if (!teleop.checked) {
                teleop.prop("checked", true);
                teleop.prop("disabled", true);
            }
        } else {
            $("#c_s_t").prop("disabled", false);
        }
    })
});