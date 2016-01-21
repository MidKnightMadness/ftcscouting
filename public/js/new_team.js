function disableForm(reason){
    $("#tn_exist").html(reason);
    $("#submit_button").prop("disabled", true);
    $("#tn_div").prop("class", "form-group has-error");
}
var validateRegex = new RegExp("[0-9]+");
$(document).ready(function(){
    $("#team_number").focusout(function(){
        var teamNumber = $("#team_number").val();
        if(teamNumber == null || teamNumber == "")
            return;
        if(!validateRegex.test(teamNumber)){
            disableForm(teamNumber+" is not a number in this world. It may be in your world, but not in this one");
            return;
        }
        var url = '/ajax/team-info/'+ teamNumber;
        $.getJSON(url, function ( data ){
            if(typeof data.team_name != "undefined") {

            } else {
                $("#submit_button").prop("disabled", false);
                $("#tn_div").prop("class", "form-group");
                $("#tn_exist").html("");
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