<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Team;
use DB;
use Illuminate\Http\Request;
use Redirect;

class TeamController extends Controller {

    private $team;

    public function __construct(Team $team) {
        $this->team = $team;
    }

    public function getIndex() {
        return Redirect::route('team.new');
    }

    public function getNew() {
        return view('team.new');
    }

    public function getList(){
        $teams = $this->team->orderBy('team_number')->get();
        return view('team.viewall', compact('teams'));
    }

    public function getEdit($teamId) {
        $team = $this->team->whereId($teamId)->first();
        if($team == null){
            // TODO: Redirect to team overview
        } else {
            return view('team.edit', compact('team'))->with('edit', 'true');
        }
    }

    public function putSave(Team $team, Request $request) {
        $team->create($request->input());
        $team->save();
        return Redirect::route('team.new')->withCookie(cookie('submittersName', $request->submitter_name, 45000))->with(['alert_msg' => 'Saved!', 'alert_msg_type' => 'success']);
    }

    public function patchSave(Request $request) {
        DB::table($this->team->getTable())->where('id', $request->get('teamId'))->update($request->except(['_method', '_token', 'teamId']));
        return Redirect::route('team.new')->with(['alert_msg' => 'Updated successfully!', 'alert_msg_type' => 'success']);
    }
}
