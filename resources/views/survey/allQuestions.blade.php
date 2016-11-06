@foreach($questions as $question)
    <!-- Start {{$question->id}}: {{$question->question_type}} ({{'survey.questions.'.$question->question_type}}) -->
    @include('survey.questions.'.$question->question_type, ['question' => $question, 'question_data' => json_decode($question->extra_data)])
    <!-- End {{$question->id}}: {{$question->question_type}} -->
@endforeach