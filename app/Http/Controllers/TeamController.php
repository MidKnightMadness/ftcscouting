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

    public function getList() {
        if (isset($_GET['order_by'])) {
            $parts = explode(',', $_GET['order_by']);
            $query = DB::table($this->team->getTable());
            foreach($parts as $part){
                if(strtolower($part) == 'rating'){
                    $query->orderBy($part, 'desc');
                }
                $query->orderBy($part);
            }
            $teams = $query->get();
        }else {
            $teams = $this->team->orderBy('team_name')->get();
        }
        return view('team.viewall', compact('teams'));
    }

    public function getEdit($teamId) {
        $team = $this->team->whereId($teamId)->first();
        if ($team == null) {
            return Redirect::route('team.list');
        } else {
            return view('team.edit', compact('team'));
        }
    }

    public function putSave(Team $team, Request $request) {
        // Validate request
        $this->validate($request, ['submitter_name' => 'required', 'team_number' => 'required|numeric', 'starting_loc' => 'required',
            'auto_zone' => 'required', 'zl_climbers' => 'required']);
        $team->create($request->input());
        return Redirect::route('team.list')->withCookie(cookie('submittersName', $request->submitter_name, 45000))->with(['alert_msg' => 'Saved!', 'alert_msg_type' => 'success']);
    }

    public function patchSave(Request $request) {
        DB::table($this->team->getTable())->where('id', $request->get('teamId'))->update($request->except(['_method', '_token', 'teamId']));
        return Redirect::route('team.list')->with(['alert_msg' => 'Updated successfully!', 'alert_msg_type' => 'success']);
    }
}
