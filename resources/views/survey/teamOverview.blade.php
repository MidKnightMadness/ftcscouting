<table class="table table-responsive table-borderless table-striped">
    <thead>
    <tr>
        @foreach($questions as $question)
            <th>{{$question->question_name}}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach($responses as $response)
        <tr>
            @foreach($response->data as $data)
                <td>{{$data->response_data}}</td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>