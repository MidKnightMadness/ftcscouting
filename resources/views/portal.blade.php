@extends('master')

@section('title')
    <title>Welcome</title>
@stop


@section('content')
    <h1 class="text-center">Team 7854 Scouting
        <small>FTC 2015-2016: RES-Q</small>
    </h1>
    <br>
    {!! Html::link(route('index'), 'New Team', array('class'=>'btn btn-success btn-block')) !!}
    {!! Html::link(route('index'), 'View Teams', array('class'=>'btn btn-primary btn-block')) !!}
@stop