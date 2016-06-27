@extends('layouts.panel')

@section('title', 'Create a Team')

@section('body')
    {!! Form::open(['route'=>'teams.doCreate', 'method'=>'put']) !!}
    <h3>Create a Team</h3>
    <hr/>
    <div class="form-group {{$errors->has('team-name')? 'has-error' : ''}}">
        {!! Form::label('team-name', 'Team Name') !!}
        {!! Form::text('team-name', null, ['class'=>'form-control']) !!}
        @if($errors->has('team-name'))
            <span class="help-block">
                <strong>{{$errors->first('team-name')}}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{$errors->has('team-number')? 'has-error' : ''}}">
        {!! Form::label('team-number', 'Team Number') !!}
        {!! Form::number('team-number', null, ['class'=>'form-control']) !!}
        @if($errors->has('team-number'))
            <span class="help-block">
                <strong>{{$errors->first('team-number')}}</strong>
            </span>
        @endif
    </div>
    {!! Form::submit('Create', ['class'=>'btn btn-block btn-success']) !!}
    {!! Form::close() !!}
@endsection