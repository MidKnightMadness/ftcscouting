<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FTC Scouting - @yield('title')</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" crossorigin="anonymous"></script>
    @yield('js')
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    @yield('css')

    @if(Session::has('alert_msg'))
        <script type="text/javascript">
            window.setTimeout(function () {
                $("#info-alert").fadeTo(2000, 500).slideUp(500, function () {
                    $("#info-alert").alert('close');
                })
            }, 5000);
        </script>
    @endif
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="page-header">
                <h1>Team 7854 Scouting
                    <small>@yield('subtitle')</small>
                </h1>
            </div>
            @if(Session::has('alert_msg'))
                <div class="alert alert-{{Session::has('alert_msg_type')? Session::get('alert_msg_type') : 'info'}} alert-dismissible"
                     id="info-alert" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <div class="text-center">{{Session::get('alert_msg')}}</div>
                </div>
            @endif
            @yield('content')
        </div>
    </div>
    <br/>
    <div class="footer">
        @if($_SERVER['REQUEST_URI'] != "/")
            {!! Html::link(route('index'), 'Home', ['class'=>'btn btn-default btn-block']) !!}
        @endif
    </div>
</div>
</body>
</html>