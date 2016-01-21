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
    <button class="btn btn-danger btn-block" id="slay_beast" style="display: none; transform: rotate(180deg); -webkit-transform: rotate(180deg);" onclick="reset()">Slay the Beast</button>
    {!! Form::open(array('route'=>'team.save', 'method'=> 'put')) !!}
    @include('team.edit._form')
    {!! Form::close() !!}
@stop