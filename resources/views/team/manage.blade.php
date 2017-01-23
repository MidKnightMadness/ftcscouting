@extends('layouts.reactivedash')

@section('title', 'Manage Team '.$team->team_number)
@section('links')
    <li class="panel-selector active"><a href="#members">Members</a></li>
    <li class="panel-selector"><a href="#roles">Roles</a></li>
    <li class="panel-selector"><a href="#surveys">Surveys</a></li>
@endsection

@section('panels')
    <div class="twopanel" id="members">
        <team-manage-members number={{$team->team_number}} id={{$team->id}}></team-manage-members>
    </div>
    <div class="twopanel" id="roles">
        <team-manage-roles id="{{$team->id}}"></team-manage-roles>
    </div>
    <div class="twopanel" id="surveys">
        <team-manage-surveys number="{{$team->team_number}}"></team-manage-surveys>
    </div>
@endsection