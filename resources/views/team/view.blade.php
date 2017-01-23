@extends('layouts.panel')

@section('title', 'Team '.$team->team_number)


@section('body')
    <div class="page-header">
        <h1>Team {{$team->team_number}}
            <small>{{$team->name}}</small>
        </h1>
        @can('manage', $team)
            <div class="btn-group">
                <a href="{{route('teams.manage', [$team->team_number])}}" class="btn btn-sm btn-default" style="float:right">Manage Team</a>
            </div>
        @endcan
        @if(in_array($team, $pending_teams))
            <a href="{{route('teams.teamAcceptInvite', [$team->id])}}" class="btn btn-lg btn-default">Accept Invite</a>
        @endif
    </div>

    <ul class="nav nav-tabs nav-justified">
        <li class="panel-selector active"><a href="#memberlist">Members</a></li>
        <li class="panel-selector"><a href="#survey">Surveys</a></li>
    </ul>
    <div class="no-panel twopanel">
        The requested panel could not be found
    </div>
    <div class="twopanel" id="memberlist">
        <h3>Members</h3>
        <div class="member-block">
            @if(sizeof($members))
                @foreach($members as $member)
                    <div class="col-md-2 col-xs-4 col-sm-4">
                        <div class="member">
                            <img src="{{$member->profileSmall()}}" class="member-image"/>
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
    <div class="twopanel" id="survey">
        @can('view_survey', $team)
            @if(sizeof($team->surveys) > 0)
                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <td><b>Name</b></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($team->surveys as $survey)
                        <tr>
                            <td>
                                @can('survey_respond', $team)
                                    <a href="{{route('survey.view', $survey->id)}}">{{$survey->name}}</a>
                                @endcan
                                @cannot('survey_respond', $team)
                                    {{$survey->name}}
                                @endcannot
                            </td>
                            <td>
                                <div class="btn-group">
                                    @can('edit_survey', $team)
                                        <a href="{{route('survey.edit', $survey->id)}}" class="btn btn-info">Edit Survey</a>
                                    @endcan
                                    @can('delete_survey', $team)
                                        <a href="{{route('survey.delete', $survey->id)}}" class="btn btn-danger">Delete Survey</a>
                                    @endcan
                                    @can('survey_modify', $team)
                                        <a href="{{route('survey.archive', $survey->id)}}" class="btn btn-default">Archive Survey</a>
                                    @endcan
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{route('survey.allResponses', $survey->id)}}" class="btn btn-default">Responses ({{sizeof($survey->responses)}})</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <p>No surveys have been created for this team</p>
            @endif
        @endcan
        @cannot('view_survey', $team)
            <p>You cannot view surveys, contact the team owner if this was a mistake</p>
        @endcannot
    </div>
@endsection

@push('js')
<script type="text/javascript" src="{{asset('js/reactiveDash.js')}}"></script>
@endpush