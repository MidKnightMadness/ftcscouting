<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>FTC Scouting - @yield('title')</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css"
            integrity="sha256-NuCn4IvuZXdBaFKJOAcsU2Q3ZpwbdFisd5dux4jkQ5w=" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/datatables.min.css"/>
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
    @include('script.global')
</head>
<body id="app-layout">
<div id="app">
    @if(config('app.env') == "local")
        <div class="container">
            <div class="alert alert-danger dev-warning text-center">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i><b> You are currently in a development environment </b>
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
            </div>
        </div>
    @endif
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
                                        <li>
                                            <a href="{{route('teams.acceptInvite', [$invite_id])}}">Team {{$pending_team->team_number}}, {{$pending_team->name}}</a>
                                        </li>
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
                                @if(!env('DISABLE_TEAM_CREATE'))
                                    <li role="separator" class="divider"></li>
                                    <li>
                                        <a href="{{route('teams.create')}}"><i class="fa fa-plus" aria-hidden="true"></i>Create a new team</a>
                                    </li>
                                @endif
                            </ul>
                        </li>
                    @endif
                    <li><a href="{{route('teams.all')}}">Team List</a></li>
                    @if(!Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Surveys<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                @foreach($user_teams as $team)
                                    @if(count($team->surveys) > 0)
                                        @foreach($team->surveys as $survey)
                                            <li>
                                                <a href="{{route('survey.view', ['id'=>$survey->id])}}">{{$team->team_number}}: {{$survey->name}}</a>
                                            </li>
                                        @endforeach
                                        <li role="separator" class="divider"></li>
                                    @else
                                        <li><a>No surveys currently exist</a></li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endif
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
                                <li>
                                    <a href="{{route('profile.edit')}}"><i class="fa fa-address-card" aria-hidden="true"></i>Settings</a>
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
        @if(count(explode(':', Session::get('message'))) == 2)
            <alert title="{{explode(':', Session::get('message'))[0]}}" type="{{Session::has('message_type')? Session::get('message_type'): ''}}">{{explode(':', Session::get('message'))[1]}}</alert>
        @else
            <alert type="{{Session::has('message_type')? Session::get('message_type'): ''}}">{{Session::get('message')}}</alert>
        @endif
    @endif
    @yield('content')
</div>
<!-- JavaScripts -->
<script src="{{mix('js/app.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js"
        integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/dt-1.10.12/r-2.1.0/datatables.min.js"></script>
@stack('js')
</body>
</html>
