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

    @if(in_array($team, $pending_teams))
        <a href="{{route('teams.teamAcceptInvite', [$team->id])}}" class="btn btn-lg btn-default">Accept Invite</a>
    @endif
    <h3>Members</h3>
    <div class="help-block">The member with a plus sign (+) is the team creator.
        @if(!\Auth::guest() && in_array($team, \Auth::user()->teams()))
            <br/>Members with an asterisk (*) have their membership to this team private and aren't showed to members not in the team.
        @endif
    </div>
    <div class="member-block">
        @foreach($team->members as $member)
            @if($member->pending || !$member->accepted)
                @continue
            @endif
            @if($member->public)
                <div class="col-md-2 col-xs-4 col-sm-4">
                    <div class="member">
                        <div class="member">
                            <img src="{{$member->recUser->profileSmall()}}" class="member-image"/>
                            <div class="member-badge">{{$team->owner == $member->recUser->id? '+' : ''}}{{$member->recUser->name}}</div>
                        </div>
                    </div>
                </div>
            @else
                @if(!\Auth::guest())
                    <div class="col-md-2 col-xs-4 col-sm-4">
                        @if(\Auth::user()->teamInCommon($member->recUser, $team->id))
                            <div class="member-secret">
                                <img src="{{$member->recUser->profileSmall()}}" class="member-image"/>
                                <div class="member-badge">{{$team->owner == $member->recUser->id? '+' : ''}}{{$member->recUser->name}}</div>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        @endforeach
    </div>
@endsection