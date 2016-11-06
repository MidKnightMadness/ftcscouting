<?php

namespace App\Http\Controllers;

use App\Survey;
use Illuminate\Http\Request;

use App\Http\Requests;

class SurveyController extends Controller
{


    public function __construct() {
        $this->middleware('auth');
    }
    public function questions($surveyId){
        $survey = Survey::whereId($surveyId)->first();
        if($survey == null){
            return response()->json(['error'=>'Not found.'], 404);
        }
        $questions = $survey->questions;
        return view('survey.allQuestions', compact('questions'));
    }

    public function edit($surveyId){
        $survey = Survey::whereId($surveyId)->first();
        return view('survey.edit', compact('survey'));
    }
}
