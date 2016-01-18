@extends('master')

@section('title')
    New Match
@stop

@section('subtitle')
    New Match Results
@stop
@section('content')
    {!! Form::open(['route'=>'match.new', 'method' => 'put']) !!}
    <div class="form-group">
        {!! Form::label('team_number', 'Team Number') !!}
        {!! Form::input('tel', 'team_number', isset($_GET['team'])? $_GET['team'] : null, ['class'=>'form-control']) !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('climbers_scored') !!}
        {!! Form::label('climbers_scored', 'Scored Climbers') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('beacon_scored') !!}
        {!! Form::label('beacon_scored', 'Scored Beacon') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('t_climbers_scored') !!}
        {!! Form::label('t_climbers_scored', 'Scored Climbers (Teleop)') !!}
    </div>
    {!! Form::label('zl', 'Zipline Climbers') !!}
    <div class="form-group", id="zl">
        {!! Form::radio('zl_climbers', '0', true) !!} 0<br/>
        {!! Form::radio('zl_climbers', '1') !!} 1<br/>
        {!! Form::radio('zl_climbers', '2') !!} 2<br/>
        {!! Form::radio('zl_climbers', '3') !!} 3<br/>
    </div>
    {!! Form::label('d', 'Debris Scored') !!}
    <div class="form-group", id="d">
        {!! Form::checkbox('d_none', 1, true) !!} None<br/>
        {!! Form::checkbox('d_fz') !!} Floor Zone<br/>
        {!! Form::checkbox('d_mz') !!} Mid Zone<br/>
        {!! Form::checkbox('d_hz') !!} High Zone<br/>
    </div>
    <div class="form-group">
        {!! Form::checkbox('all_clear') !!}
        {!! Form::label('allClear', 'All Clear Signal') !!}
    </div>
    <div class="form-group">
        {!! Form::checkbox('hang') !!}
        {!! Form::label('hang', 'Hang') !!}
    </div>
    {!! Form::submit('Save', ['class'=> 'btn btn-success btn-block']) !!}
    {!! Form::close() !!}
@stop