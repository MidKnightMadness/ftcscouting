<?php

namespace App\Http\Controllers;

use App;
use App\User;
use App\UserData;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Intervention\Image\Facades\Image;
use Random;
use Storage;
use Validator;

class ProfileController extends Controller {


    public function __construct() {
        $this->middleware('auth', ['except' => 'profile', 'image']);
    }

    public function profile($userName) {
        $user = User::whereName($userName)->firstOrFail();
        $bio = $user->data;
        $part_of = $user->teams();
        if (\Auth::guest() || \Auth::user()->name != $userName) {
            $part_of = $user->publicTeams();
        }
        return view('profile.profile', compact('user', 'part_of', 'bio'));
    }

    public function edit() {
        $data = ['tab' => 'profile',
            'tabs' => App\Scouting::getSettingsTabs()];
        return view('profile.edit', compact('data'));
    }
    

    public function saveProfile(Request $request) {
        $userData = \Auth::user()->data;
        $profilePicture = $request->file('file-upload');
        if ($profilePicture != null) {
            if ($profilePicture != null)
                $this->processNewProfilePicture($userData, $profilePicture);
        } else {
            $userData->has_profile_photo = true;
            $userData->gravatar = true;
            if ($request->get('gravatar-email') == null || $request->get('gravatar-email') == '') {
                $userData->photo_location = \Auth::user()->email;
            } else {
                $userData->photo_location = $request->get('gravatar-email');
            }
        }
        $userData->save();
        return back()->with(['message'=>'Profile Updated!', 'message_type'=>'success']);
    }

    public function changePassword(Request $request){
        $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
        // Check the hash
        if(!\Hash::check($request->current_password, \Auth::user()->password)){
            return response()->json(['current_password'=>'The password you provided is incorrect'], 422);
        }
        \Auth::user()->password = \Hash::make($request->password);

        \Auth::user()->save();
    }

    public function updateProfile(Request $request) {
        $this->validate($request, [
            'name' => 'required|alpha_num|max:255',
            'email' => 'required|email',
        ]);

        $errors = [];
        \Log::info($request);
        $userWithEmail = User::whereEmail($request->email)->first();
        if($userWithEmail != null){
            \Log::info("Found user $userWithEmail->id with the same email as ".Auth::id());
            if($userWithEmail->id !=  Auth::id())
                $errors['email'] = 'This email is already in use';
        }
        $userWithName = User::whereName($request->name)->first();
        if($userWithName != null){
            if($userWithName->id !=  Auth::id())
                $errors['name'] = 'This username is taken';
        }
        if(!empty($errors))
            return response()->json($errors, 422);
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
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

        return redirect()->route('profile.show', ['number' => \Auth::user()->name])->with(['message' => 'Your profile has been updated!', 'message_type' => 'success']);
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

    public function image($image, $size) {
        $img = Image::make(Storage::disk('public')->get("profile/$image"));
        $img->resize($size, $size);
        return $img->response('png');
    }

    private function processNewProfilePicture(UserData $userData, UploadedFile $file) {
        $userData->has_profile_photo = true;
        $userData->gravatar = false;
        $fileName = Random::letters(30) . "." . $file->getClientOriginalExtension();

        if (Storage::disk('public')->exists("profile/$fileName")) {
            $this->processNewProfilePicture($userData, $file);
        } else {
            $file->storeAs("profile", $fileName, 'public');
        }
        $userData->photo_location = $fileName;
    }
}
