<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RandomFacade extends Facade {


    protected static function getFacadeAccessor() {
        return 'random';
    }
}