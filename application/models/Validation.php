<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Validation extends CI_Model {
    private $id, $user, $type;

    public function method_one($id, $user, $type){
        $this->id = $id;
        $this->user = $user;
        $this->type = $type;

        return $this->init();
    }

    private function init(){

        if($this->type == 'admin'){
            $arr = [
                'id' => $this->id,
                'username' => $this->user
            ];
        }else{
            $arr = [
                'id' => $this->id,
                'id_number' => $this->user
            ];
        }

        $type = ($this->type == 'student' ? 'students' : $this->type);
        $s = $this->db->where($arr)->get($type);
        
        if($s->num_rows() == 0){
            return [
                'status' => FALSE,
                'e' => 'Credential Error'
            ];
        }

        return [
            'status' => TRUE
        ];
    }

}