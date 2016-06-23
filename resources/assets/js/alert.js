$(document).ready(function(){
    $("#alert").fadeTo(5000, 500).fadeOut(500, function(){
        $("#alert").alert('close');
    });
});