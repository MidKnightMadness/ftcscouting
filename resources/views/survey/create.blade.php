@extends('layouts.panel')

@section('title', 'Create Survey')

@section('body')
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    {!! Form::open(['route'=>'survey.doCreate'])!!}
    <div class="form-group">
        {!! Form::label('select_team', 'Team Owner') !!}
        <?php
        // Build an array of teams
        $teams = array();
        foreach (TeamHelper::teams() as $team) {
            $teams[$team->id] = $team->team_number . ": " . $team->name;
        }
        ?>
        {!! Form::select('select_team', $teams, null, ['class'=>'form-control'])!!}
    </div>
    <div class="form-group">
        {!! Form::label('survey_name', 'Survey Name') !!}
        {!! Form::text('survey_name', null, ['class' => 'form-control']) !!}
    </div>
    <toggle visible="false" name="clone" display="Clone From Existing">
        <div class="form-group">
            {!! Form::label('clone_from', 'Survey') !!}
            <select class="form-control" id="clone_from" name="clone_from">
                <option value="-1">None</option>
                @foreach(TeamHelper::teams() as $team)
                    @foreach($team->surveysWithArchived as $survey)
                        <option value="{{$survey->id}}">Team {{$team->team_number}}: {{$survey->name}} {{$survey->archived? '(Archived)' : ''}}</option>
                    @endforeach
                @endforeach
            </select>
        </div>
    </toggle>
    <div class="form-group">
        {!! Form::submit('Create', ['class'=>'btn btn-success form-control']) !!}
    </div>
    {!!  Form::close() !!}
@endsection