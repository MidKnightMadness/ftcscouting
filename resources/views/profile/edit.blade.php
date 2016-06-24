@extends('layouts.panel')

@section('title', 'Edit Profile')

@section('body')
    {!! Form::model(Auth::user(), ['route'=>'profile.update', 'method'=>'patch'])!!}
    <div class="form-group">
        {!! Form::label('name', 'Username') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'disabled']) !!}
    </div>
    <div class="form-group {{$errors->has('email')? 'has-error' : ''}}">
        {!! Form::label('email', 'Email Address') !!}
        {!! Form::text('email', null, ['class' => 'form-control']) !!}
        <p class="help-block"><strong>WARNING:</strong> This will change the email address you sign in with</p>
        @if($errors->has('email'))
            <span class="help-block">
                <strong>{{$errors->first('email')}}</strong>
            </span>
        @endif
    </div>
    <div class="form-group {{$errors->has('bio')? 'has-error': ''}}">
        {!! Form::label('bio',  'Bio') !!}
        <p class="help-block">250 characters max</p>
        @if($errors->has('bio'))
            <span class="help-block">
                <strong>{{$errors->first('bio')}}</strong>
            </span>
        @endif
        {!! Form::textarea('bio', Auth::user()->data->bio, ['class'=> 'form-control']) !!}
    </div>

    <div class="form-group">
        <div class="btn-group">
            <a href="{{url('profile/'.Auth::user()->name)}}" class="btn btn-default">Cancel</a>
            {!! Form::submit('Update', ['class'=>'btn btn-success']) !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection