$(document).ready(function(){
    $("#mcheck_default").change(function(){
        if(this.checked){
            $(".mcheck_o").prop('checked', false);
        }
    });
    $(".mcheck_o").change(function(){
        if(this.checked){
            $("#mcheck_default").prop('checked', false);
        }
    })
});