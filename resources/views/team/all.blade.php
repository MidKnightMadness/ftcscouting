@extends('layouts.panel')

@section('title')
    Team List
@endsection

@section('body')

    @if(!Auth::guest())
        <h4>My Teams</h4>
        <table class="table table-responsive table-condensed table-striped table-bordered">
            <thead>
            <th>Team Number</th>
            <th>Team Name</th>
            </thead>
            <tbody>
            @foreach($user_teams as $team)
                <tr>
                    <td><a href="{{route('teams.show', [$team->team_number])}}">{{$team->team_number}}</a></td>
                    <td>{{$team->name}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <hr>
        <h4>All Teams</h4>
    @else
        <h4>All Teams</h4>
    @endif
    <table class="table table-responsive table-condensed table-striped table-bordered">
        <thead>
        <th>Team Number</th>
        <th>Team Name</th>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td><a href="{{route('teams.show', [$team->team_number])}}">{{$team->team_number}}</a></td>
                <td>{{$team->name}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection