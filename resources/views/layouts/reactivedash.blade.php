@extends('layouts.dashboard')

@section('menu')
    <ul class="nav nav-pills nav-stacked">
        @yield('links')
    </ul>
@endsection

@section('panelContent')
    <noscript>
        <div class="alert alert-danger">
            Please enable JavaScript to take advantage of this page
        </div>
    </noscript>
    @yield('panels')
    <div class="no-panel twopanel">
        The requested panel could not be found
    </div>
@endsection

@push('js')
    <script type="text/javascript" src="{{asset('js/reactiveDash.js')}}"></script>
@endpush