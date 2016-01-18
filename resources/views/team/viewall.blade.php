@extends('master')

@section('title')
    All Teams
@stop
@section('subtitle')
    Team Overview
@stop
@section('content')
    <table class="table table-responsive table-condensed table-striped">
        <thead>
        <tr>
            <th>Team Number</th>
            <th>Starting Location</th>
            <th>Climbers Scored (Autonomous)</th>
            <th>Rescue Beacon</th>
            <th>Autonomous Parking Location</th>
            <th>Climbers Scored (Teleop)</th>
            <th>Zipline Climbers Scored</th>
            <th>Debris Locations</th>
            <th>All Clear Signal</th>
            <th>Hang</th>
            <th>Endgame Parking Location</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        @foreach($teams as $team)
            <tr>
                <td>{{$team->teamNumber}}</td>
                <td>{{$team->startingLoc}}</td>

                @if($team->climbersScored)
                    <td class="success">Yes</td>
                @else
                    <td class="danger">No</td>
                @endif

                @if($team->beaconScored)
                    <td class="success">Yes</td>
                @else
                    <td class="danger">No</td>
                @endif

                @if($team->autoZone == 0)
                    <td>N/A</td>
                @elseif($team->autoZone == 1)
                    <td>Repair Zone/Floor Goal</td>
                @elseif($team->autoZone == 2)
                    <td>Low Zone</td>
                @elseif($team->autoZone == 3)
                    <td>Mid Zone</td>
                @elseif($team->autoZone == 4)
                    <td>High Zone</td>
                @endif

                @if($team->climbersScored)
                    <td class="success">From Auto</td>
                @elseif($team->t_climberScored)
                    <td class="success">Yes</td>
                @else
                    <td class="danger">No</td>
                @endif

                @if($team->zl_climbers == 3)
                    <td>Low, Mid, High</td>
                @elseif($team->zl_climbers == 2)
                    <td>Low, Mid</td>
                @elseif($team->zl_climbers == 1)
                    <td>Low</td>
                @else
                    <td>None</td>
                @endif

                <td>
                    @if($team->d_fz)
                        F,
                    @endif
                    @if($team->d_lz)
                        L,
                    @endif
                    @if($team->d_mz)
                        M,
                    @endif
                    @if($team->d_hz)
                        H
                    @endif
                </td>

                @if($team->allClear)
                    <td class="success">Yes</td>
                @else
                    <td class="danger">No</td>
                @endif

                @if($team->hang)
                    <td class="success">Yes</td>
                @else
                    <td class="danger">No</td>
                @endif
                <td>
                    @if($team->lz_f)
                        F,
                    @endif
                    @if($team->lz)
                        L,
                    @endif
                    @if($team->mz)
                        M,
                    @endif
                    @if($team->hz)
                        H
                    @endif
                </td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                </td>
            </tr>
        </tbody>
        @endforeach
    </table>
@stop