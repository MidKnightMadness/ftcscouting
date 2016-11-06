@extends('layouts.panel')

@section('title', 'Edit Survey '.$survey->name)

@section('body')
    <edit-survey id={{$survey->id}}></edit-survey>
@endsection