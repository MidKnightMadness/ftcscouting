$(document).ready(function(){
    $("#team_number").focusout(function(){
        var teamNumber = $("#team_number").val();
        if(teamNumber == null || teamNumber == "")
            return;
        alert(teamNumber);
        var url = '/ajax/team-info/'+ teamNumber;
        $.getJSON(url, function ( data ){
            if(typeof data.team_name != "undefined") {
                $("#tn_exist").html("Team "+teamNumber+" has already been submitted by "+data.submitter);
                $("#submit_button").prop("disabled", true);
                $("#tn_div").prop("class", "form-group has-error");
            } else {
                $("#submit_button").prop("disabled", false);
                $("#tn_div").prop("class", "form-group");
                $("#tn_exist").html("");
            }
        });
    });
});