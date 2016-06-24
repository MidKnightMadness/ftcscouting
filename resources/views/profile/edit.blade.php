@extends('layouts.panel')

@section('title', 'Edit Profile')

@section('body')
    {!! Form::model(Auth::user(), ['route'=>'profile.update', 'method'=>'patch', 'files'=>true])!!}
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
    <hr>
    <div class="picture-setting" data-hidden="false">
        <div class="form-group">
            @if(\Auth::user()->hasProfilePicture())
                <img class="image-preview" src="{{\Auth::user()->profileSmall()}}"/>
            @endif
            {!! Form::label('profile', 'Change Profile Picture') !!}
            {!! Form::file('profile') !!}
        </div>
        <div class="form-group">
            {!! Form::label('gravatar', 'Use Gravatar') !!}
            {!! Form::checkbox('gravatar', 1, \Auth::user()->data->gravatar) !!}<br>
            {!! Form::label('gravatar-email', 'Gravatar Email') !!}
            {!! Form::text('gravatar-email', \Auth::user()->data->gravatar? Auth::user()->email == Auth::user()->data->photo_location? '' : \Auth::user()->data->photo_location : '', ['class'=>'form-control']) !!}
            <p class="help-block">If lefet blank, your email address will be used</p>
        </div>
    </div>
    {!! Form::label("remove-picture", "Remove Profile Picture") !!}
    {!! Form::checkbox('remove-picture', 1, false, ['class'=>'toggle', 'data-toggle'=>'picture-setting']) !!}
    <hr>
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
    <!-- Delete Account modal -->
    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete-account">Delete Account
    </button>
    <div id="delete-account" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Your Account</h4>
                </div>
                <div class="modal-body">
                    <div class="delete-account">
                        <div class="alert alert-danger">
                            Are you sure you wish to perform this action?<br>
                            Deleting your account is permanent and <strong>CANNOT</strong> be undone
                        </div>
                        <label>To confirm you want to do this, type the following in the box below:
                            <span>Delete my account</span></label>
                        {!! Form::open(['route'=>'profile.update', 'method'=>'delete']) !!}
                        {!! Form::text('confirmDelete', null, ['class'=>'form-control', 'id'=>'delete-text']) !!}<br>
                        {!! Form::label('delete', 'Check to confirm deletion') !!}
                        {!! Form::checkbox('delete', 1, false, ['id'=>'delete-checkbox']) !!}<br>
                        {!! Form::submit("DELETE", ['disabled', 'class'=>'btn btn-danger btn-block', 'id'=>'delete-btn']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
@endsection