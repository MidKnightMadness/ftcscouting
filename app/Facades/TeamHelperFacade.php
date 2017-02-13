<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class TeamHelperFacade extends Facade {
    protected static function getFacadeAccessor() {
        return 'teamhelper';
    }
}