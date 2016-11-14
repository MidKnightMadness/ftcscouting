<?php


namespace App\Facades;


use Illuminate\Support\Facades\Facade;

class PinFacade extends Facade {

    protected static function getFacadeAccessor() {
        return 'pnumber';
    }
}