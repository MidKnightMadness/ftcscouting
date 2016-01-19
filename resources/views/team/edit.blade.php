@extends('master')

@section('title')
    Edit Team {{$team->teamNumber}}
@stop

@section('js')
    <script type="text/javascript" src="{{asset('js/multi_check.js')}}"></script>
@stop
@section('subtitle')
    Edit Team {{$team->teamNumber}}
@stop
@section('content')
    {!! Form::model($team, ['route'=>'team.save', 'method'=>'patch']) !!}
    @include('team.edit._form')
    {!! Form::hidden('teamId', $team->id) !!}
    {!! Form::close() !!}
@stop