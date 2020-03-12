<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Admin extends RestController {
    private $t, $id, $user, $type;

    public function __construct(){
        parent::__construct();

        //Validates token if valid JWT Token
        $token = $this->token->validate();

        if($token['status'] != TRUE){
            $this->response([
                'status' => $token['status'],
                'message' => $token['e']
            ], 404);
        }

        //Generates JWT Token
        $td = $this->token->generate('admin', $token['token']['data']);

        //Assign data to private variable
        $this->type = $token['token']['data']->type;
        $this->id = $token['token']['data']->id;
        $this->user = $token['token']['data']->user;
        $this->t = $td;
    }

    public function index_get(){

        //Sanitizes input data to avoid XSS Attack
        if($this->sanitizer->xss($this->get()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Only admin can use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        $i = $this->madmin->fetch($this->id, $this->type, $this->get());

        if(empty($i)){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => 'No Data Found'
            ], 200);
        }

        $this->response([
            'status' => TRUE,
            'token' => $this->t,
            'data' => $i
        ], 200);
    }

    public function index_post(){

        //Only admin can use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        //Sanitizes input data from XSS Attack
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validates input data using specific rules
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->post());
        if($this->form_validation->run('admin_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }
        
        $datas = [
            'username' => $this->post('username'),
            'password' => password_hash($this->post('password'), PASSWORD_BCRYPT)
        ];
        
        $i = $this->madmin->add($datas);

        if($i == 0){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => 'Something Went Wrong'
            ], 200);      
        }

        $this->response([
            'status' => TRUE,
            'token' => $this->t,
            'message' => 'Admin Successfully Added'
        ], 200);    
    }

    public function index_delete(){

        //Only admin can use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        //Sanitizes input data to avoid XSS Attack
        if($this->sanitizer->xss($this->delete()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validates input data using specific rules
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->delete());
        if($this->form_validation->run('id') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->madmin->delete($this->delete('id'));

        if($i == 0){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => 'Something Went Wrong'
            ], 200);      
        }

        $this->response([
            'status' => TRUE,
            'token' => $this->t,
            'message' => 'Account Successfully Deleted'
        ], 200);    

    }

    // private function index_put(){
    //     //Validates token if valid JWT Token
    //     $token = $this->token->validate();

    //     if($token['status'] != TRUE){
    //         $this->response([
    //             'status' => $token['status'],
    //             'message' => $token['e']
    //         ], 200);
    //     }  
        
    //     $type = $token['token']['data']->type;
    //     $id = $token['token']['data']->id;
    //     $user = $token['token']['data']->user;

    //     //Generates JWT Token
    //     $td = $this->token->generate($this->aud, $token['token']['data']);

    //     //Sanitizes input data to avoid XSS Attack
    //     if($this->sanitizer->xss($this->put()) !== TRUE){
    //         $this->response([
    //             'status' => false,
    //             'token' => $td,
    //             'message' => 'Error Handling Data'
    //         ], 404);            
    //     }

    //     //Only admin can use this function
    //     if($type != 'admin'){
    //         $this->response([
    //             'status' => FALSE,
    //             'message' => 'Unauthorized User Type'
    //         ], 401); 
    //     }

    //     //Validates input data using specific rules
    //     $this->form_validation->reset_validation();
    //     $this->form_validation->set_data($this->put());
    //     if($this->form_validation->run('course_update') == FALSE){
    //         $this->response([
    //             'status' => FALSE,
    //             'token' => $td,
    //             'message' => $this->form_validation->error_array()
    //         ], 200);  
    //     }

    //     $i = $this->madmin->update($data_id, $data);

    //     if($i == 0){
    //         $this->response([
    //             'status' => FALSE,
    //             'token' => $td,
    //             'message' => 'Something Went Wrong'
    //         ], 200);      
    //     }

    //     $this->response([
    //         'status' => TRUE,
    //         'token' => $td,
    //         'message' => 'Report Updated Successfully'
    //     ], 200);    

    // }

}