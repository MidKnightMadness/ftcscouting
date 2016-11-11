@extends('layouts.panel')

@section('title')
    Under Maintenance
@endsection

@section('body')
    <h3 class="text-center">Service Unavailable</h3>
    <?php
    $json = json_decode(file_get_contents(storage_path('framework/down')), true);
    $message = $json['message'];
    $retry_after = $json['retry'];
    ?>
    <p class="text-center">
        @if($message)
            <code>{{$message}}</code>
        @else
            Down for maintenance
        @endif
        @if($retry_after)
            <br>
            Come back {{\Carbon\Carbon::now()->addSeconds($retry_after)->diffForHumans()}}
        @endif
    </p>
@endsection
