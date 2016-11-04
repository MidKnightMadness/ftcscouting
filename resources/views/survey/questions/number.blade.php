<div class="form-group" data-question="{{$question->id}}" data-question_type="{{$question->question_type}}">
    {!! Form::label('question-'.$question->id, $question->question_name) !!}
    @if(isset($question_data->help_text))
        <p class="help-block">{{$question_data->help_text}}</p>
    @endif
    {!! Form::number('question-'.$question->id, null, ['class'=>'form-control']) !!}
</div>