<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function data() {
        return $this->hasOne('App\UserData');
    }

    public function invites(){
        return $this->hasMany('App\TeamInvite','receiver','id');
    }
    
    public function teams(){
        $teams = array();
        foreach($this->invites as $invite){
            if($invite->pending)
                continue;
            $teams[] = Team::whereId($invite->team_id)->first();
        }
        return $teams;
    }
    
    public function publicTeams(){
        $teams = array();
        foreach ($this->invites as $invite){
            if($invite->public){
                $teams[] = Team::whereId($invite->team_id)->first();
            }
        }
        return $teams;
    }
    
    public function inTeam($teamId){
        $team = Team::whereId($teamId)->first();
        if($team == null)
            return true;
        foreach($this->invites as $invite){
            if($invite->team_id == $team->id && !$invite->pending && $invite->accepted)
                return true;
        }
        return false;
    }
    
    public function teamInCommon(User $otherUser, $teamId){
        if($this->inTeam($teamId) && $otherUser->inTeam($teamId))
            return true;
        return false;
    }


    public function getProfilePicUrl($size) {
        $image = 'default';
//        dd($this->data);
        if ($this->data->has_profile_photo) {
            if ($this->data->gravatar) {
                $hash = md5(strtolower(trim($this->data->photo_location)));
                return "https://www.gravatar.com/avatar/" . $hash . "?s=" . $size."&d=mm";
            } else {
                $image = $this->data->photo_location;
                if(!file_exists(public_path('img/profile/'.$image.'.png'))){
                    $image = 'default';
                }
                return route('profile.image', ['image'=>$image, 'size'=>$size]);
            }
        } else {
            return route('profile.image', ['image' => $image, 'size' => $size]);
        }
    }

    public function profileLarge() {
        return $this->getProfilePicUrl(150);
    }

    public function profileSmall() {
        return $this->getProfilePicUrl(60);
    }

    public function profileExtraSmall() {
        return $this->getProfilePicUrl(30);
    }

    public function hasProfilePicture() {
        return $this->data->has_profile_photo;
    }
}
