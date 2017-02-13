<?php


namespace App\Helpers;


use App\PIN;
use App\Question;
use App\Response;
use App\ResponseData;

class PinHelper {


    public function getPinData(Question $question) {
        $rawJson = PIN::firstOrCreate(['question_id' => $question->id])->pin_data;
        $object = json_decode($rawJson);
        return $object;
    }

    public function setPinData(Question $question, $data) {
        PIN::updateOrCreate(['question_id' => $question->id], ['pin_data' => json_encode($data)]);
    }

    public function calculatePinForResponseData(ResponseData $data) {
        $question = $data->question;
        if($question->question_type == 'checkbox'){
            return $this->getCheckboxPin($data);
        }
        return $this->getPin($question, $data->response_data);
    }

    public function calculatePinForResponse(Response $response) {
        $totalPin = 0;
        foreach($response->data as $data){
            $pin = $this->calculatePinForResponseData($data);
            if($pin != null)
                $totalPin += $pin;
        }
        return $totalPin;
    }

    public function setPin(Question $question, array $options) {
        $pinData = $this->getPinData($question);
        $pinData->options = $options;
        $this->setPinData($question, $pinData);
    }

    public function getPin(Question $question, $value){
        $pinData = $this->getPinData($question);
        if(!isset($pinData) || $pinData == json_decode("{}")){
            return null;
        }
        foreach($pinData as $k=>$v){
            if(strtolower($k) == strtolower($value))
                return $v;
        }
        return null;
    }

    private function getCheckboxPin(ResponseData $data){
        $options = explode(',', $data->response_data);
        $pin = 0;
        foreach($options as $option){
            $option = trim($option);
            $pin += $this->getPin($data->question, trim($option));
        }
        return $pin;
    }
}