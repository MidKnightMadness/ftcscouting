@extends('layouts.panel')

@section('title', 'Survey '.$survey->name)

@section('body')
    {!! Form::open(['route'=>['survey.submit', $survey->id], 'method'=>'put'])!!}
    <div class="form-group">
        {!! Form::label('team_number', 'Team Number') !!}
        {!! Form::number('team_number', null, ['class' => 'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::label('initial', 'Initial Scouting') !!}
        {!! Form::checkbox('initial') !!}
    </div>
    <div class="form-group">
        {!! Form::label('match_number', 'Match Number') !!}
        {!! Form::number('match_number', null, ['class'=>'form-control']) !!}
    </div>
    <hr/>
    @include('survey.allQuestions', ['questions'=>$survey->questions])
    <input type="submit" class="btn btn-success form-control" value="Submit!">
    {!! Form::close()!!}
@endsection