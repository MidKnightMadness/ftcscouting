<?php

namespace App\Http\Controllers;

use App\AboutUser;
use App\Helpers\TeamHelper;
use App\Http\Requests;
use App\User;
use App\UserData;
use Illuminate\Http\Request;
use Validator;

class ProfileController extends Controller {

    public function __construct() {
        $this->middleware('auth', ['except' => 'profile']);
    }

    public function profile($userName, TeamHelper $teamHelper) {
        $user = User::whereName($userName)->first();
        $part_of = $teamHelper->getTeamsForUser($user);
        $bio = $user->data;
        return view('profile.profile', compact('user', 'part_of', 'bio'));
    }

    public function edit() {
        return view('profile.edit');
    }

    public function update(Request $request) {
        Validator::replacer('max', function ($message, $attribute, $rule, $parameters) {
            if ($attribute == 'bio') {
                return "Your bio cannot contain more than " . $parameters[0] . " characters";
            }
            return str_replace(':max', $message, $parameters[0]);
        });
        Validator::replacer('takenEmail', function ($message, $attribute, $rule, $parameters) {
            return "That email is already taken";
        });
        Validator::extend('takenEmail', function ($attribute, $value, $parameters) {
            if (\Auth::guest())
                return false;
            $user = \Auth::user();
            if ($user->email == $value) {
                return true;
            } else {
                return count(User::whereEmail($value)->get()) == 0;
            }
        });
        $this->validate($request, [
            'email' => 'required|email|takenEmail',
            'bio' => 'present|max:250'
        ]);
        $user = \Auth::user();
        $user->update($request->except('name'));

        $userData = $user->data;
        $userData->bio = $request->get('bio');
        $userData->save();

        return redirect()->route('profile.show', ['number' => \Auth::user()->name]);
    }

    public function delete(Request $request) {
        // Verify the user actually inputted stuff, and hasn't somehow bypassed the checks
        if (\Auth::guest()) {
            return redirect('/')->with(['message' => 'Delete:Tried to delete an account you did not own. Aborting']);
        }
        if (strtolower($request->get('confirmDelete')) != "delete my account" || !$request->get('delete')) {
            return redirect()->route('profile.show', ['number' => \Auth::user()->name])->with(['message_type' => 'success', 'message' => 'Delete:Deletion of account canceled as'
                . ' all the requirements were not satisfied']);
        } else {
            \Auth::logout();
//            User::whereId(\Auth::user()->id)->delete();
            return redirect('/');
        }
    }
}
