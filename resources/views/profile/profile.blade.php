@extends('layouts.app')
@section('title', $user->name)

@section('content')
    <!-- Profile Column -->
    <div class="col-md-2 col-md-offset-3" id="profile-column">
        <div class="panel panel-default">
            <div class="panel-body">
                <img class="profile-image" src="http://placehold.it/150x150" width="100%">
                @if(!Auth::guest() && $user->name === Auth::user()->name)
                    <a href="{{route('profile.edit')}}" class="btn btn-block btn-default edit-profile">Edit Profile</a>
                @endif
                <div class="profile-text">{{$user->name}}</div>
                <hr>
                Joined: {{date("D F j, Y", strtotime($user->created_at))}}
            </div>
        </div>
    </div>
    <!-- End Profile Column -->
    <!-- Main Content -->
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-body">
                @if($bio != null && $bio->bio != '')
                    <h4>Bio</h4>
                    {{$bio->bio}}
                    <hr>
                @endif
                <h3>Teams</h3>
                @if(count($part_of) == 0)
                    <p>{{$user->name}} is not a member of any teams</p>
                @elseif(count($part_of) == 1)
                    <p>{{$user->name}} is a member of <code>Team {{$part_of[0]->team_number}}
                            , {{$part_of[0]->name}}</code>
                    </p>
                @else
                    <p>{{$user->name}} is a member of the following teams: </p>
                    <ul>
                        @foreach($part_of as $team)
                            <li><code>Team {{$team->team_number}}, {{$team->name}}</code></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
    <!-- End Main Content -->
@endsection