<?php

namespace App\Http\Controllers;

use App\Response;
use App\ResponseData;
use App\Survey;
use App\Team;
use Illuminate\Http\Request;

use App\Http\Requests;

class SurveyController extends Controller
{


    public function __construct() {
        $this->middleware('auth');
    }
    public function questions($surveyId){
        $survey = Survey::findOrFail($surveyId);
        if($survey == null){
            return response()->json(['error'=>'Not found.'], 404);
        }
        $questions = $survey->questions;
        return view('survey.allQuestions', compact('questions'));
    }

    public function edit($surveyId){
        $survey = Survey::findOrFail($surveyId);
        return view('survey.edit', compact('survey'));
    }

    public function showSurvey($survey){
        $survey = Survey::findOrFail($survey);
        return view('survey.view', compact('survey'));
    }

    public function submitSurvey(Request $request, $survey){
        \Log::info($request);
        $teamNumber = $request->team_number;
        $response = new Response();
        $response->submitted_by = $request->user()->id;
        $response->survey = $survey;
        $response->team = $teamNumber;
        $response->save();
        $except = $request->except(['_method', '_token']);
        foreach($except as $k=>$v){
            if(strpos($k, 'question')!==0)
                continue;
            $k = str_replace('question-', '', $k);
            $response_data = new ResponseData();
            $response_data->question_id = $k;
            $response_data->response_id = $response->id;
            $response_data->response_data = $v;
            $response_data->save();
        }
        return redirect(route('survey.view', $survey))->with(['message'=>'Response recorded!', 'message_type'=>'success']);
    }

    public function delete($survey){
        $survey = Survey::findOrFail($survey);
        if($survey == null){
            // TODO: Throw an error or something
        }
        return view('confirmAction')->with(['action'=>"Delete Survey \"$survey->name\"",
            'route'=>['survey.doDelete', $survey->id], 'method'=>'delete', 'extra_desc'=>['Deletion of surveys will delete 
            all questions and responses associated with it. This action is PERMANENT and cannot be undone']]);
    }

    public function doDelete($survey){
        $survey = Survey::findOrFail($survey);
        foreach($survey->responses as $response){
            foreach($response->data as $data){
                \Log::info("Deleting ResponseData $data->id");
                $data->delete();
            }
            \Log::info("Deleting response $response->id");
            $response->delete();
        }
        foreach($survey->questions as $question){
            \Log::info("Deleting question $question->id");
            $question->delete();
        }
        $survey->delete();
        return redirect(route('teams.show', Team::whereId($survey->team_owner)->first()->team_number))->with(['message'=>'Survey Deleted!', 'message_type'=>'success']);
    }
}
