@extends('layouts.panel')

@section('title', 'Team Surveys')

@section('body')
    @foreach($user_teams as $team)
        <h2>Surveys for Team {{$team->team_number}}, {{$team->name}}</h2>
        @if(sizeof($team->surveys) > 0)
            <table class="table table-borderless">
                <thead>
                <tr>
                    <td><b>Name</b></td>
                    <td><b>Responses</b></td>
                </tr>
                </thead>
                <tbody>
                @foreach($team->surveys as $survey)
                    <tr>
                        <td>
                            <a href="{{url('/survey/'.$survey->survey_id)}}">{{$survey->name}}</a>
                        </td>
                        <td>Soon&trade;</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No surveys have been created for this team</p>
        @endif
    @endforeach
@endsection