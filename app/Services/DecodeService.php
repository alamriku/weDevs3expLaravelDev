<?php

namespace App\Services;

class DecodeService{

    public function decodeJsonData($request){
        return json_decode($request);
    }
}