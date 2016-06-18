@extends('layouts.panel')

@section('title')
    404: Not Found
@endsection

@section('body')
    <p>The page you were looking for was not found. Please check the URL and try again</p>
    <a href="{{url('/')}}">Return to the homepage</a>
@endsection