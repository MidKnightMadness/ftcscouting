@extends('layouts.panel')

@section('title', 'Confirm '.$action)

@section('body')
    <div style="text-align: center;">
        <p>Are you sure you want to perform the following action:</p>
        <p><strong>{{$action}}</strong></p>
        @if(isset($extra_desc))
            @foreach($extra_desc as $e)
                <p>{{$e}}</p>
            @endforeach
        @endif
        <form method="post" action="{{is_array($route)? route($route[0], array_slice($route, 1)) : route($route)}}">
            {{ csrf_field() }}
            @if(isset($method))
                {{method_field($method)}}
            @endif
            @if(isset($data))
                @foreach($data as $item=>$value)
                    <input type="hidden" name="{{$item}}" id="{{$item}}" value="{{$value}}">
                @endforeach
            @endif
            <button type="submit" class="btn btn-success" id="submit" disabled>Confirm</button>
            <a href="{{URL::previous('/')}}" class="btn btn-danger">Cancel</a>
        </form>
    </div>
@endsection

@push('js')
    <script type="text/javascript">
        $(document).ready(function(){
            setTimeout(function(){
                enableButton();
            }, 2500);
        });

        function enableButton(){
            $("#submit").prop('disabled', false);
        }
    </script>
@endpush