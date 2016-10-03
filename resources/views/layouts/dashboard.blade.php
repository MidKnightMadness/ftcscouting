@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-body">
                    @yield('menu')
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="panel panel-default">
                <div class="panel-body">
                    @yield('panelContent')
                </div>
            </div>
        </div>
    </div>
@endsection