@extends('layouts.panel')

@section('title', 'Survey '.$survey->name)

@section('body')
    {!! Form::open(['route'=>['survey.submit', $survey->id], 'method'=>'put'])!!}
    <div class="form-group">
        {!! Form::label('team_number', 'Team Number') !!}
        {!! Form::number('team_number', null, ['class' => 'form-control']) !!}
    </div>
    @include('survey.allQuestions', ['questions'=>$survey->questions])
    <input type="submit" class="btn btn-success form-control" value="Submit!">
    {!! Form::close()!!}
@endsection