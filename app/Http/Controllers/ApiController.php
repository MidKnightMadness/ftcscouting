<?php

namespace App\Http\Controllers;

use App\Question;
use App\Survey;
use App\Team;
use App\TeamInvite;
use App\User;
use Illuminate\Http\Request;

class ApiController extends Controller {

    public function getUser($username) {
        $user = User::whereName($username)->first();
        if ($user == null)
            return response()->json(['error' => 'User Not Found'], 404);
        return $this->userJson($user);
    }

    public function getTeam($teamNumber) {
        $team = Team::whereTeamNumber($teamNumber)->first();
        if ($team == null)
            return response()->json(['error' => 'Team Not Found'], 404);
        return response()->json($team);
    }

    public function getTeams() {
        return response()->json(Team::all());
    }

    public function teamMembers($teamNumber, Request $request) {
        $team = Team::whereTeamNumber($teamNumber)->first();
        $user = $request->user();
        $users = array();
        foreach ($team->members as $invite) {
            if (!$invite->pending && !$invite->accepted)
                continue;
            $data = array();
            $data['invite_id'] = $invite->id;
            $data['user'] = $this->userJson($invite->recUser);
            $data['pending'] = $invite->pending;
            if (!$invite->public) {
                if ($invite->recUser->teamInCommon($user, $team->id)) {
                    $data['private'] = 1;
                    $users[] = $data;
                }
            } else {
                $data['private'] = 0;
                $users[] = $data;
            }
        }
        return $users;
    }

    public function sendInvite(Request $request){
        $sendingUser = $request->user();
        $toInvite = $request->username;
        $teamNumber = $request->teamNumber;
        // Check if the user is already on the team
        $team = Team::whereTeamNumber($teamNumber)->first();
        $alreadyOnTeam = false;
        foreach ($team->members as $invite){
            if($invite->recUser->name == $toInvite) {
                if(!$invite->pending && !$invite->accepted)
                    continue;
                $alreadyOnTeam = true;
                break;
            }
        }
        if($alreadyOnTeam){
            return response()->json(['error'=>"$toInvite is already invited!"], 400);
        }

        $inv = new TeamInvite();
        $inv->accepted = false;
        $inv->pending = true;
        $inv->sender = $sendingUser->id;
        $inv->receiver = User::whereName($toInvite)->first()->id;
        $inv->team_id = $team->id;
        $inv->save();
        return response()->json(['status'=>'Invite Sent!']);
    }

    public function cancelInvite(Request $request){
        $invite = TeamInvite::whereId($request->id);
        if($invite == null){
            return response()->json(['error'=>'That invite does not exist!'], 404);
        }
        $invite->delete();
        return response()->json(['status'=>'Deleted!']);
    }

    public function getSurveyQuestions(Request $request, $survey){
        $survey = Survey::whereId($survey)->first();
        if($survey == null){
            return response()->json(['error'=>'Not found.'], 404);
        }
        $questions = $survey->questions;

        $data = array();
        foreach($questions as $question){
            $data[] = $question;
        }
        return response()->json($data);
    }

    public function deleteQuestion($id){
        \Log::info("Deleting question $id");
        $question = Question::whereId($id);
        if($question == null)
            return response()->json(['error'=>'Question not found.'], 404);
        $question->delete();
        return response()->json(['status'=>'Deleted!']);
    }

    public function updateQuestion(Request $request, $id){
        $question_data = $request->data;
        $question_data['extra_data'] = json_encode($question_data['extra_data']);
        $question = Question::whereId($id)->first();
        if($question == null)
            return response()->json(['error'=>'Question not found.'], 404);
        $question->question_name = $question_data['question_name'];
        $question->question_type = $question_data['question_type'];
        $question->extra_data = $question_data['extra_data'];
        $question->order = $question_data['order'];
        $question->save();
        return response()->json(['status'=>'Updated!']);
    }

    public function newSurveyQuestion($survey){
        $survey = Survey::whereId($survey)->first();
        if($survey == null){
            return response()->json(['error'=>'Survey not found'], 404);
        }
        $question = new Question();
        $question->survey_id = $survey->id;
        $question->question_type = 'short_text';
        $question->question_name = 'New Question';
        $question->order = sizeof($survey->questions)+1;
        $question->extra_data = "{\"options\":[]}";
        $question->save();
        return response()->json($question);
    }

    public function getSurveyResponses(Survey $survey){
        return $survey->responses;
    }
    private function userJson(User $user) {
        return ['id' => $user->id,
            'name' => $user->name,
            'created_at' => $user->created_at->toDateTimeString(),
            'data' => [
                'bio' => $user->data->bio,
                'photo_location' => $user->getProfilePicUrl(150)
            ]
        ];
    }
}
