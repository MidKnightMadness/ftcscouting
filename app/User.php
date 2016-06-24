<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
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

    public function getProfilePicUrl($size) {
        $image = 'default';
        if ($this->data->has_profile_photo) {
            if ($this->data->gravatar) {
                $hash = md5(strtolower(trim($this->data->photo_location)));
                return "https://www.gravatar.com/avatar/" . $hash . "?s=" . $size;
            } else {
                $image = $this->data->photo_location;
                if(!file_exists(public_path('img/profile/'.$image))){
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
