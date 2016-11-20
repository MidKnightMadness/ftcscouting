<table class="table table-responsive table-borderless table-striped">
    <thead>
    <tr>
        <th>Match Number</th>
        @foreach($questions as $question)
            <th>{{$question->question_name}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($responses as $response)
        @if($response != null)
            <tr>
                <td>{{$response->initial? 'N/A' : $response->match_number}}</td>
                @foreach($response->data as $data)
                    <td>{{$data->response_data}}</td>
                @endforeach
            </tr>
        @endif
    @endforeach
    </tbody>
</table>