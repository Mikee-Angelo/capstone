<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sanitizer {
    private $ci;

    public function __construct(){
        $this->ci =& get_instance();   
    }

    public function xss($data){
        return !in_array(false, array_map(array($this, 'map'), $data));
    }

    private function map($data){
        if($this->ci->security->xss_clean($data, TRUE) === FALSE){
            return FALSE;
        }

        return TRUE;
    }
}