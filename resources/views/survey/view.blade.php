@extends('layouts.panel')

@section('title', 'Survey '.$survey->name)

@section('body')
    <div class="btn-group btn-group-justified">
        @can('edit_survey', $team)
            <a href="{{route('survey.edit', $survey->id)}}" class="btn btn-default">Edit Survey</a>
        @endcan
        <a href="{{route('survey.allResponses', $survey->id)}}" class="btn btn-info">Responses</a>
    </div>
    {!! Form::open(['route'=>['survey.submit', $survey->id], 'method'=>'put'])!!}
    <div class="form-group">
        <label for="team_number">Team Number</label>
        <input class="form-control" list="teams" type="number" name="team_number" id="team_number">
        <datalist id="teams">
            @foreach($survey->teams() as $team)
                <option value="{{$team}}"></option>
            @endforeach
        </datalist>
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