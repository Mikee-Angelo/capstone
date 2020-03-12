<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Headers {
    public function set($origin, $method){
        $set_method = is_array($method) ? implode(', ', $method) : $method;
        
        header("Access-Control-Allow-Origin: ".$origin );
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: ".$set_method);
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization");
    }
}