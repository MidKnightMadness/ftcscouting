<?php


namespace App\Helpers;


use Illuminate\Support\Facades\Facade;

class Random extends Facade {

    private $letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    private $numbers = '0123456789';

    public function letters($length = 5) {
        return $this->randomString($length, $this->letters);
    }

    public function numbers($length = 5) {
        return $this->randomString($length, $this->numbers);
    }

    public function alphaNumeric($length = 5) {
        $toUse = $this->letters;
        $toUse .= $this->numbers;
        return $this->randomString($length, $toUse);
    }

    private function randomString($length, $chars) {
        $string = '';
        for ($i = 0; $i < $length; $i++) {
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $string;
    }

    protected static function getFacadeAccessor() {
        return 'random';
    }
}