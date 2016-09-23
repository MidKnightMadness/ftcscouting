<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FTC Scouting - @yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"
            integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/datatables.min.css"/>
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>
<body id="app-layout">
<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                FTC Scouting
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                {{-- Only show the dashboard link if the user is logged in--}}
                @if(!Auth::guest())
                    <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">My Teams
                            <span class="badge">{{count($pending_teams) == 0? '' : count($pending_teams)}}</span><span class="caret"></span></a>
                        <ul class="dropdown-menu" role="menu">
                            @if(count($pending_teams) != 0)
                                <li class="dropdown-header">Pending team invites. Click to accept</li>
                                @foreach($pending_teams as $invite_id => $pending_team)
                                    {{--TODO: Add team accept URL--}}
                                    <li><a href="{{route('teams.acceptInvite', [$invite_id])}}">Team {{$pending_team->team_number}}, {{$pending_team->name}}</a></li>
                                @endforeach
                                <li role="separator" class="divider"></li>
                            @endif
                            @if(count($user_teams) == 0)
                                <li><a>You are not a member of any team</a></li>
                            @else
                                @foreach($user_teams as $team)
                                    <li>
                                        <a href="{{route('teams.show', [$team->team_number])}}">Team {{$team->team_number}}, {{$team->name}}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </li>
                @endif
                <li><a href="{{route('teams.all')}}">Team List</a></li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if (Auth::guest())
                    <li><a href="{{ url('/login') }}">Login</a></li>
                    <li><a href="{{ url('/register') }}">Register</a></li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown" role="button" aria-expanded="false">
                            <img src="{{\Auth::user()->profileExtraSmall()}}" class="img-circle"> {{ Auth::user()->name }}
                            <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            @if(\Auth::user()->data->superadmin)
                                <li><a href="{{url('/admin')}}"><i class="fa fa-btn fa-cogs"></i>Admin</a></li>
                            @endif
                            <li><a href="{{url('/profile/'.Auth::user()->name)}}"><i class="fa fa-btn fa-user"></i>Profile</a>
                            </li>
                            <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </div>
</nav>
@if(Session::has('message'))
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="alert alert-{{Session::has('message_type')? Session::get('message_type') : 'info'}}" id="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                @if(count(explode(':', Session::get('message'))) == 2)
                    <strong>{{explode(':', Session::get('message'))[0]}}: </strong>{{explode(':', Session::get('message'))[1]}}
                @else
                    {{Session::get('message')}}
                @endif
            </div>
        </div>
    </div>
@endif

@yield('content')

<!-- JavaScripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"
integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb"
crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/datatables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"
integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS"
crossorigin="anonymous"></script>
<script src="{{asset('js/all.js')}}"></script>
@yield('bottom')
</body>
</html>
