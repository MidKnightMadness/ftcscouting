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
        $order_by = 'team_number';
        if (isset($_GET['order_by'])) {
            switch ($_GET['order_by']) {
                case 'pin':
                    $order_by = 'pin';
                    break;
                case 'raw_pin':
                    $order_by = 'raw_pin';
                    break;
            }
        }
        $teams = $this->team->orderBy($order_by)->get();
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
        return Redirect::route('team.new')->withCookie(cookie('submittersName', $request->submitter_name, 45000))->with(['alert_msg' => 'Saved!', 'alert_msg_type' => 'success']);
    }

    public function patchSave(Request $request) {
        DB::table($this->team->getTable())->where('id', $request->get('teamId'))->update($request->except(['_method', '_token', 'teamId']));
        return Redirect::route('team.list')->with(['alert_msg' => 'Updated successfully!', 'alert_msg_type' => 'success']);
    }
}
