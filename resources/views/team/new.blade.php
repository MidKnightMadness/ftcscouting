@extends('master')

@section('title')
    New Team
@stop

@section('js')
    <script type="text/javascript" src="{{asset('js/new_team.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/multi_check.js')}}"></script>
@stop
@section('subtitle')
    Add Team
@stop
@section('content')
    {!! Form::open(array('route'=>'team.save', 'method'=> 'put')) !!}
    @include('team.edit._form')
    {!! Form::close() !!}
@stop