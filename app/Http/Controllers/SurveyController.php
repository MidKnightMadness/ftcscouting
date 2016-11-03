<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SurveyController extends Controller
{


    public function __construct() {
        $this->middleware('auth');
    }
}
