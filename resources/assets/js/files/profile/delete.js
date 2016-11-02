$("#delete-text").on('input', function () {
    updateDeleteButton();
});

$("#delete-checkbox").change(function () {
    updateDeleteButton();
});

$("#delete-account").find(".modal-footer button").click(function(){
    $("#delete-text").val("");
    $("#delete-checkbox")[0].checked = false;
});

function updateDeleteButton() {
    var inputtedText = $("#delete-text").val().toLowerCase();
    var checked = $("#delete-checkbox")[0].checked;
    if (inputtedText == 'delete my account' && checked) {
        $("#delete-btn").prop('disabled', false);
    } else {
        $("#delete-btn").prop('disabled', true);
    }
}