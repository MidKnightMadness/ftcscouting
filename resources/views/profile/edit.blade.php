@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="row">
        <div class="col-md-2 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Settings
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills nav-stacked">
                        @foreach($data['tabs'] as $tab)
                            <li class="{{$data['tab'] == $tab->name? 'active' : ''}} panel-selector">
                                <a href="#{{$tab->name}}"><i class="fa {{$tab->icon}}" style="margin-right: 10px"></i>{{$tab->display}}
                                </a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-body">
                    @foreach($data['tabs'] as $tab)
                        <div class="twopanel" id="{{$tab->name}}">
                            <div class="col-md-12">
                                @include($tab->view)
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script type="text/javascript" src="{{asset('js/reactiveDash.js')}}"></script>
@endpush