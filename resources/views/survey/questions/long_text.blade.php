<div class="form-group" data-question="{{$question->question_id}}" data-question_type="{{$question->question_type}}">
    {!! Form::label('question-'.$question->question_id, $question->question_name) !!}
    @if(isset($question_data->help_text))
        <p class="help-block">{{$question_data->help_text}}</p>
    @endif
    {!! Form::textarea('question-'.$question->question_id, null, ['rows'=>'4', 'class'=>'form-control']) !!}
</div>
