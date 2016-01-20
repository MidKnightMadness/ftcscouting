@extends('master')

@section('title')
    Team {{$team->teamNumber}}
@stop

@section('subtitle')
    Team {{$team->teamNumber}}
@stop
@section('content')
    {!! Form::open() !!}
    <div class="form-group">
        {!! Form::label('teamName', 'Team Name: ') !!}
        <p class="form-control-static" id="teamName">{{$team->team_name}}</p>
        {!! Form::label('raw_pin', 'Raw PIN:') !!}
        <p class="form-control-static" id="raw_pin">{{$team->raw_pin}}</p>
        {!! Form::label('pin', 'Pin:') !!}
        <p class="form-control-static" id="pin">{{$team->pin}}</p>
        <div class="form-group">
            {!! Form::label('otherInfo', 'Other Information') !!}
            {!! Form::textarea('otherInfo', $team->other_info, ['class'=> 'form-control', 'rows'=>'4', 'readonly']) !!}
        </div>
    </div>
    {!! Form::close() !!}
    {!! Html::link(route('match.add').'?team='.$team->team_number, 'New Match', ['class'=>'btn btn-small btn-primary']) !!}
    <p>Boxes in red indicate that they did not perform to what they said they could do</p>
    <table class="table table-striped table-responsive">
        <tr>
            <th>Scored Climbers</th>
            <th>Rescue Beacon</th>
            <th>Autonomous Park Loc</th>
            <th>Teleop Climbers Scored</th>
            <th>Zipline Climbers</th>
            <th>No Debris Scored</th>
            <th>Floor Zone Debris</th>
            <th>Low Zone Debris</th>
            <th>Mid Zone Debris</th>
            <th>High Zone Debris</th>
            <th>Teleop Park Loc</th>
            <th>All Clear</th>
            <th>Performance Number</th>
        </tr>
        @foreach($matches as $match)
            <tr>
                {!! $match !!}
            </tr>
        @endforeach
    </table>
@stop