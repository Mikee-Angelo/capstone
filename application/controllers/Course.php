<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Course extends RestController {

    public function __construct(){
        parent::__construct();
    }

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
        $td = $this->token->generate('courses', $token['token']['data']);

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

        $i = $this->mcourse->fetch(null, null, $query);

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

    public function index_post(){

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
        $td = $this->token->generate('students', $token['token']['data']);
        /**
         * SANITIZING INPUT OF POST DATA FOR XSS ATTACK
         */
        if($this->sanitizer->xss($this->post) !== TRUE){
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

        if($type != 'admin'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        if($this->form_validation->run('course_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $td,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mcourse->add($this->post());

        if($i == 0){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Something Went Wrong'
            ], 200);      
        }

        $this->response([
            'status' => TRUE,
            'token' => $td,
            'message' => 'Course Successfully Added'
        ], 200);    
    }

    public function index_delete(){
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
        $td = $this->token->generate('courses', $token['token']['data']);

        /**
         * SANITIZING INPUT OF POST DATA FOR XSS ATTACK
         */
        if($this->sanitizer->xss($this->delete()) !== TRUE){
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

        if($type != 'admin'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $data = $this->delete('id');

        $this->form_validation->set_data($this->delete());

        if($this->form_validation->run('id') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mcourse->delete($this->delete('id'));

        if($i == 0){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Something Went Wrong'
            ], 200);      
        }

        $this->response([
            'status' => TRUE,
            'token' => $td,
            'message' => 'Course Successfully Deleted'
        ], 200);    

    }

    private function index_update(){
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
        $td = $this->token->generate('courses', $token['token']['data']);

        /**
         * SANITIZING INPUT OF POST DATA FOR XSS ATTACK
         */
        if($this->sanitizer->xss($this->update()) !== TRUE){
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

        if($type != 'admin' || $type != 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $data = $this->update();
        $data_id = $this->get('id');

        $this->form_validation->set_data($data);
        $this->form_validation->set_data(['course_id' => $data_id]);

        if($this->form_validation->run('course_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mcourse->update($data_id, $data);

        if($i == 0){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Something Went Wrong'
            ], 200);      
        }

        $this->response([
            'status' => TRUE,
            'token' => $td,
            'message' => 'Course Updated Successfully'
        ], 200);    

    }

}