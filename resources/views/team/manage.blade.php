@extends('layouts.reactivedash')

@section('title', 'Manage Team '.$team->team_number)
@section('links')
    <li class="panel-selector active"><a href="#members">Members</a></li>
@endsection

@section('panels')
    <div class="twopanel" id="members">
        <h3>Members ({{$team->members->count()}})</h3>
        <div class="member-block">
            @foreach($team->members as $member)
                <div class="col-md-2 col-xs-4 col-sm-4">
                    <a href="#user-{{$member->recUser->id}}">
                        <div class="member">
                            <img src="{{$member->recUser->profileSmall()}}" class="member-image"/>
                            <div class="member-badge">{{$member->recUser->name}}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
    {{-- User management panels --}}
    @foreach($team->members as $member)
        <div class="twopanel" id="user-{{$member->recUser->id}}">
            <img src="{{$member->recUser->profileLarge()}}"/>
            <h3>{{$member->recUser->name}}</h3>
            <div class="btn-group" style="margin-bottom: 5px">
                <a href="#" class="btn btn-danger hover-popover" data-container="body" data-toggle="popover" data-placement="top" data-content="Remove the user from the repository">Remove User</a>
                <a href="#" class="btn btn-default hover-popover" data-container="body" data-toggle="popover" data-placement="top" data-content="Transfers the ownership of this team to the given user">Transfer Ownership</a>
            </div>
            <div class="dash-userinfo">
                <h4>User Information</h4>
                <strong>Joined Site:</strong> {{date("D F j, Y", strtotime($member->recUser->created_at))}}
                <br/>
                <strong>Joined Team:</strong> {{date("D F j, Y", strtotime($member->created_at))}}
                <br/>
            </div>
            <hr/>
            {{-- User Information --}}
            <a href="#members" class="btn btn-default btn-sm">Return</a>
        </div>
    @endforeach
@endsection