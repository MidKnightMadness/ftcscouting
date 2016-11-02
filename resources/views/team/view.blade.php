@extends('layouts.panel')

@section('title', 'Team '.$team->team_number)


@section('body')
    <div class="page-header">
        <h1>Team {{$team->team_number}}
            <small>{{$team->name}}</small>
        </h1>
        @if(!Auth::guest())
            @if($team->isOwner(Auth::id()))
                <div class="btn-group">
                    <a href="{{route('teams.manage', [$team->team_number])}}" class="btn btn-sm btn-default" style="float:right">Manage Team</a>
                </div>
            @endif
        @endif
    </div>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#memberlist">Members</a></li>
    </ul>
    <div class="no-panel twopanel">
        The requested panel could not be found
    </div>
    <div class="twopanel" id="memberlist">
        @if(in_array($team, $pending_teams))
            <a href="{{route('teams.teamAcceptInvite', [$team->id])}}" class="btn btn-lg btn-default">Accept Invite</a>
        @endif
        <h3>Members</h3>
        <div class="member-block">
            @if(sizeof($members))
                @foreach($members as $member)
                    <div class="col-md-2 col-xs-4 col-sm-4">
                        <div class="member">
                            <a href="{{route('profile.show', $member->name)}}"><img src="{{$member->profileSmall()}}" class="member-image"/></a>
                            <div class="member-badge">{{$member->name}}</div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <h5>There are no users in this team</h5>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('js')
<script type="text/javascript" src="{{asset('js/reactiveDash.js')}}"></script>
@endpush