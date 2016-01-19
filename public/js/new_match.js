$(document).ready(function(){
    $("#team_num").focusout(function(){
        var teamNumber = $("#team_num").val();
        if(teamNumber == null || teamNumber == "") {
            disableSubmit("A team number is required");
            return;
        }
        var url = '/ajax/team-info/' + teamNumber;
        $.getJSON(url, function ( data ){
            console.log(data);
            console.log(data.team_name);
           if(typeof data.team_name == "undefined"){
               disableSubmit(teamNumber+" is not a valid team");
           } else {
               enableSubmit();
           }
        });
    });

    $("#c_s_a").change(function(){
        if(this.checked){
            var teleop = $("#c_s_t");
            if(!teleop.checked){
                teleop.prop("checked", true);
               teleop.prop("disabled", true);
            }
        } else {
            $("#c_s_t").prop("disabled", false);
        }
    })
});

function disableSubmit(msg){
    console.log("Disabling submit button");
    $("#submit_btn").prop("disabled", true);
    $("#team_num_help").html(msg);
    $("#team_num_div").prop("class", "form-group has-error");
}

function enableSubmit(){
    $("#submit_btn").prop("disabled", false);
    $("#team_num_help").html("");
    $("#team_num_div").prop("class", "form-group");
}