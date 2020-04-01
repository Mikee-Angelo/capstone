<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Arrayutils {

    public function permittedKeys($target, $source){
        $s = array_flip($source);
        $a = array_intersect_key($target, $s);

        return $a;
    }

}