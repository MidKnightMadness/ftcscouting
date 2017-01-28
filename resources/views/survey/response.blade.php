@extends('layouts.panel')

@section('title', 'View Results '.$survey->name)

@section('body')
    <survey-responses id="{{$survey->id}}" team="{{$team->id}}"><div class="text-center" style="font-size: 3em;"><i class="fa fa-circle-o-notch fa-spin" aria-hidden="true"></i>  Loading...</div></survey-responses>
@endsection