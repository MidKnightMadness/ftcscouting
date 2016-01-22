function redirect(toOption) {
    window.location = '/team/list?order_by=' + toOption;
}

function redirectDefault(){
    window.location = '/team/list';
}

$(document).ready(function () {
    $("#sort_by").change(function () {
        var type = $("#sort_by").val();
        switch (type) {
            case 'team_number':
                redirectDefault();
                break;
            case 'raw_pin':
                redirect('raw_pin');
                break;
            case 'pin':
                redirect('pin');
                break;
            case 'match_count':
                redirect('match_count');
                break;
            default:
                redirectDefault();
        }
    });
});