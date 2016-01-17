@extends('master')

@section('title')
    Welcome
@stop

@section('subtitle')
    Welcome
@stop
@section('content')
    {!! Html::link(route('index'), 'New Team', array('class'=>'btn btn-success btn-block')) !!}
    {!! Html::link(route('index'), 'View Teams', array('class'=>'btn btn-primary btn-block')) !!}
@stop