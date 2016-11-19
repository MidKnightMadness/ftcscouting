<?php


namespace App;


class Scouting {

    public static function getSettingsTabs() {
        $tabs = [
            new Tab('profile', 'Profile', 'profile.edit.profile', 'fa-user'),
            new Tab('security', 'Security', 'profile.edit.security', 'fa-lock'),
            new Tab('oauth', 'OAuth', 'profile.edit.oauth', 'fa-shield')];
        return $tabs;
    }
}