<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('title')
    <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    @yield('js')
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}"/>
    @yield('css')
</head>
<body>
<div class="container">
    <div clas="row">
        <div class="col-xs-12">
            @yield('content')
        </div>
    </div>
</div>
</body>
</html>