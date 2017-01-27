@extends('layouts.panel')

@section('title', 'Error')

@section('body')
    <p class="text-center">
        <img src="https://http.cat/500" width="375" height="300"/><br/>
        <b style="margin-top: 10px;">Whoops! It looks like we've hit a snag!</b></p>
    <p class="text-center">
        It looks like you've encountered an error. Don't worry. We're working to get it fixed as soon as possible. If this
        issue persists, try again later.
    </p>
    <p class="text-center">
        <a href="{{URL::previous('/')}}" class="btn btn-info">Return to the previous page you were on</a>
    </p>
@endsection