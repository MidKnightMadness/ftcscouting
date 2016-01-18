@extends('master')

@section('title')
    Welcome
@stop

@section('subtitle')
    Welcome
@stop
@section('content')
    {!! Html::link(route('team.new'), 'New Team', array('class'=>'btn btn-success btn-block')) !!}
    {!! Html::link(route('match.add'), 'New Match Result', array('class'=>'btn btn-danger btn-block')) !!}
    {!! Html::link(route('team.list'), 'View Teams', array('class'=>'btn btn-primary btn-block')) !!}
@stop