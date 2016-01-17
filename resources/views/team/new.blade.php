@extends('master')

@section('title')
    New Team
@stop

@section('subtitle')
    Add Team
@stop
@section('content')
    {!! Form::open(array('route'=>'team.save', 'method'=> 'put')) !!}
    @include('team.edit._form')
    {!! Form::close() !!}
@stop