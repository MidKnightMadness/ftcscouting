@extends('layouts.reactivedash')

@section('title', 'Manage Team '.$team->team_number)
@section('links')
    <li class="panel-selector active"><a href="#members">Members</a></li>
@endsection

@section('panels')
    <div class="twopanel" id="members">
        <team-manage-members number={{$team->team_number}} id={{$team->id}}></team-manage-members>
    </div>
@endsection