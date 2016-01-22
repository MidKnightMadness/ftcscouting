$(document).ready(function () {
    $("#team_num").focusout(function () {
        var teamNumber = $("#team_num").val();
        if (teamNumber == null || teamNumber == "") {
            disableSubmit("#team_num", "A team number is required");
            return;
        }
        var url = '/ajax/team-info/' + teamNumber;
        $.getJSON(url, function (data) {
            console.log(data);
            console.log(data.team_name);
            if (typeof data.team_name == "undefined") {
                disableSubmit("#team_num", teamNumber + " is not a valid team");
            } else {
                enableSubmit("#team_num");
            }
        });
    });
    $("#matchNum").focusout(function () {
        var teamNumber = $("#team_num").val();
        var matchNum = $("#match_num").val();
        if (teamNumber == null || teamNumber == "") {
            disableSubmit("#match_num", "A team number is required");
            return;
        }
        if (matchNum == null || matchNum == "") {
            disableSubmit("#match_num", "A match number is required");
        }
        var url = '/ajax/match-info/' + teamNumber + '/' + matchNum;
        $.getJSON(url, function (data) {
            if (typeof data.error != "undefined") {
                if (data.error == "MATCH_NO_EXIST"){
                    enableSubmit("#match_num");
                } else if(data.error == "TEAM_NO_EXIST"){
                    disableSubmit("#match_num", "The team "+teamNumber+" does not exist!");
                } else {
                    disableSubmit("#match_num", "An Error Occured: "+data.error);
                }
            } else {
                disableSubmit("#match_num", "An Unknown Error Occurred: " + data.error);
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

function disableSubmit(jquerySelector, msg) {
    console.log("Disabling submit button");
    $("#submit_btn").prop("disabled", true);
    $(jquerySelector + "_help").html(msg);
    $(jquerySelector + "_div").prop("class", "form-group has-error");
}

function enableSubmit(jquerySelector) {
    $("#submit_btn").prop("disabled", false);
    $(jquerySelector + "_help").html("");
    $(jquerySelector + "_div").prop("class", "form-group");
}