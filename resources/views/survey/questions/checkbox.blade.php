{!! Form::label('d-question-'.$question->id, $question->question_name) !!}
<div class="form-group" id="d-question-{{$question->id}}" data-question="{{$question->id}}" data-question_type="{{$question->question_type}}">
    @if(isset($question_data->help_text))
        <p class="help-block">{{$question_data->help_text}}</p>
    @endif
    @foreach($question_data->options as $option)
        {!! Form::checkbox('question-'.$question->id, $option->name, $option->checked) !!} {{$option->name}}<br/>
    @endforeach
</div>