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
    <div class="form-group{{$errors->has('team_number')? ' has-error': ''}}">
        <label for="team_number">Team Number</label>
        <input class="form-control" list="teams" type="number" name="team_number" id="team_number">
        <datalist id="teams">
            @foreach($survey->teams() as $team)
                <option value="{{$team}}"></option>
            @endforeach
        </datalist>
        @if($errors->has('team_number'))
            <span class="help-block">
                <strong>{{$errors->first('team_number')}}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{$errors->has('match_number')? 'has-error' : ''}}">
        <label for="match_number">Match Number</label>
        <input type="number" name="match_number" id="match_number" class="form-control">
        @if($errors->has('match_number'))
            <span class="help-block">
                <strong>{{$errors->first('match_number')}}</strong>
            </span>
        @endif
    </div>
    <hr/>
    @include('survey.allQuestions', ['questions'=>$survey->questions])
    <input type="submit" class="btn btn-success form-control" value="Submit!">
    {!! Form::close()!!}
@endsection