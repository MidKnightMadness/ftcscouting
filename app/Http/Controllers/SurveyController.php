<?php

namespace App\Http\Controllers;

use App\Response;
use App\ResponseData;
use App\Survey;
use App\Team;
use Illuminate\Http\Request;

class SurveyController extends Controller {


    public function __construct() {
        $this->middleware('auth')->except(['surveyOverview']);
    }

    public function questions($surveyId) {
        $survey = Survey::findOrFail($surveyId);
        if ($survey == null) {
            return response()->json(['error' => 'Not found.'], 404);
        }
        $questions = $survey->questions;
        return view('survey.allQuestions', compact('questions'));
    }

    public function edit($surveyId) {
        $survey = Survey::findOrFail($surveyId);
        if (\Auth::guest() || !\Auth::user()->can('edit_survey', Team::whereId($survey->team_owner)->first()))
            return back()->with(['message' => 'Error:You cannot respond to this survey', 'message_type' => 'danger']);
        return view('survey.edit', compact('survey'));
    }

    public function showSurvey($survey) {
        $survey = Survey::findOrFail($survey);
        if (\Auth::guest() || !\Auth::user()->can('survey_respond', Team::whereId($survey->team_owner)->first()))
            return back()->with(['message' => 'Error:You cannot respond to this survey', 'message_type' => 'danger']);
        if($survey->archived)
            return back()->with(['message'=>'Error:That survey is archived!', 'message_type'=>'danger']);
        return view('survey.view', compact('survey'));
    }

    public function create() {
        return view('survey.create');
    }

    public function doCreate(Request $request) {
        $this->validate($request, [
            'select_team' => 'required',
            'survey_name' => 'required|max:255'], ['select_team.required'=>'A team must own this survey', 'survey_name.required'=>'Please provide a survey name']);
        $survey = new Survey();
        $survey->name = $request->survey_name;
        $survey->team_owner = $request->select_team;
        $survey->created_by = \Auth::user()->id;
        $survey->template = false;
        $survey->save();
        return redirect(route('survey.edit', ['id'=>$survey->id]));
    }

    public function submitSurvey(Request $request, $survey) {
        \Log::info($request);
        $teamNumber = $request->team_number;
        $response = new Response();
        $response->submitted_by = $request->user()->id;
        $response->survey = $survey;
        $response->team = $teamNumber;
        $response->initial = $request->initial ? $request->initial : 0;
        $response->match_number = !$response->initial ? $request->match_number : -1;
        $response->save();
        $except = $request->except(['_method', '_token']);
        foreach ($except as $k => $v) {
            if (strpos($k, 'question') !== 0)
                continue;
            $k = str_replace('question-', '', $k);
            $response_data = new ResponseData();
            $response_data->question_id = $k;
            $response_data->response_id = $response->id;
            $response_data->response_data = is_array($v) ? $this->concatArray($v) : $v;
            $response_data->save();
        }
        return redirect(route('survey.view', $survey))->with(['message' => 'Response recorded!', 'message_type' => 'success']);
    }

    private function concatArray(array $array) {
        $toReturn = "";
        foreach ($array as $a) {
            $toReturn .= "$a, ";
        }
        return substr($toReturn, 0, strlen($toReturn) - 2);
    }

    public function delete($survey) {
        $survey = Survey::findOrFail($survey);
        if ($survey == null) {
            // TODO: Throw an error or something
        }
        return view('confirmAction')->with(['action' => "Delete Survey \"$survey->name\"",
            'route' => ['survey.doDelete', $survey->id], 'method' => 'delete', 'extra_desc' => ['Deletion of surveys will delete 
            all questions and allResponses associated with it. This action is PERMANENT and cannot be undone']]);
    }

    public function archive($survey){
        $survey = Survey::findOrFail($survey);

        return view('confirmAction')->with(['action'=> "Archive Survey \"$survey->name\"", 'route'=>['survey.doArchive', $survey->id],
        'method'=>'patch', 'extra_desc'=>['Archiving this survey will hide it from the list and it can no longer be responded to. You can
        unarchive it later from the team settings page']]);
    }

    public function doArchive($survey){
        $survey = Survey::findOrFail($survey);

        $team = Team::whereId($survey->id)->first();

        $survey->archived = true;
        $survey->save();
        return redirect()->route('teams.show', $team->team_number);
    }

    public function showResponses(Survey $survey) {
        $team = Team::whereId($survey->team_owner)->first();
        if (\Auth::guest() || !\Auth::user()->can('view_survey', $team))
            return back()->with(['message' => 'Error;You cannot view the results of this survey', 'message_type' => 'danger']);
        return view('survey.response')->with(compact('survey', 'team'));
    }

    public function doDelete($survey) {
        $survey = Survey::findOrFail($survey);
        foreach ($survey->responses as $response) {
            foreach ($response->data as $data) {
                \Log::info("Deleting ResponseData $data->id");
                $data->delete();
            }
            \Log::info("Deleting response $response->id");
            $response->delete();
        }
        foreach ($survey->questions as $question) {
            \Log::info("Deleting question $question->id");
            $question->delete();
        }
        $survey->delete();
        return redirect(route('teams.show', Team::whereId($survey->team_owner)->first()->team_number))->with(['message' => 'Survey Deleted!', 'message_type' => 'success']);
    }

    public function surveyOverview(Survey $survey, $teamNumber){
        $responses = array();
        $initial_response = null;
        $questions = $survey->questions;

        foreach($survey->responses as $response){
            if($response->team == $teamNumber){
                if($response->initial){
                    $initial_response = $response;
                } else {
                    $responses[] = $response;
                }
            }
        }

        array_unshift($responses, $initial_response);

        return view('survey.teamOverview', compact('questions', 'initial_response', 'responses'));
    }
}
