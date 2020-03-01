<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Civilstatus extends RestController {

    public function index_get(){
        /**
         * CHECKING TOKEN
         */
        $token = $this->token->validate();

        if($token['status'] != TRUE){
            $this->response([
                'status' => $token['status'],
                'message' => $token['e']
            ], 200);
        }
    
        $type = $token['token']['data']->type;
        $id = $token['token']['data']->id;
        $user = $token['token']['data']->user;
        $query = $this->get();
        $td = $this->token->generate('civil_status', $token['token']['data']);

        /**
         * SANITIZING INPUT OF POST DATA FOR XSS ATTACK
         */
        if($this->sanitizer->xss($query) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $td,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        $val = $this->validation->method_one($id, $user, $type);

        if($val['status'] == FALSE){
            $this->response([
                'status' => $val['status'],
                'token' => $td,
                'message' => $val['e']
            ], 200);      
        }

        $i = $this->mcivil_status->fetch(null , null, []);

        if(empty($i)){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'No Data Found'
            ], 200);
        }

        $this->response([
            'status' => TRUE,
            'token' => $td,
            'data' => $i
        ], 200);
    }
}