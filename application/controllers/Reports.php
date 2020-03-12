<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Reports extends RestController {
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
        $td = $this->token->generate('reports', $token['token']['data']);

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

        $i = $this->mreports->fetch($this->id, $this->type, $this->get());

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
        //Only faculty can't use this function
        if($this->type == 'faculty'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        //Sanitizes input data to avoid XSS Attack
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validating input using specific rule with type authorization
        $this->form_validation->reset_validation();

        if($this->type == 'student'){
            $_POST['student_id'] = $this->id;

            $this->form_validation->set_data($_POST);
            if($this->form_validation->run('reports_student_add') == FALSE){
                $this->response([
                    'status' => FALSE,
                    'token' =>  $this->t,
                    'message' => $this->form_validation->error_array()
                ], 200);    
            }

            $i = $this->mreports->add_student($_POST);

        }else{ 
            $this->form_validation->set_data($this->post());
            if($this->form_validation->run('reports_add') == FALSE){
                $this->response([
                    'status' => FALSE,
                    'token' =>  $this->t,
                    'message' => $this->form_validation->error_array()
                ], 200);    
            }

            $i = $this->mreports->add_admin($this->post());
        }

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
            'message' => 'Report Successfully Added'
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

        $i = $this->mreports->delete($this->id , $this->type, $this->delete('id'));

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
            'message' => 'Report Successfully Deleted'
        ], 200);    

    }

    public function index_put(){
        //Only faculty can't use this function
        if($this->type == 'faculty'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }
        
        //Sanitizes input data to avoid XSS Attack
        if($this->sanitizer->xss($this->put()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }
        
        //Validates input data using specific admin rules

        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->put());

        if($this->type == 'admin'){
            if($this->form_validation->run('reports_update') == FALSE){
                $this->response([
                    'status' => FALSE,
                    'token' => $this->t,
                    'message' => $this->form_validation->error_array()
                ], 200);  
            }
        }

        //Validates input data using specific student rules
        if($this->type == 'student'){
            if($this->form_validation->run('reports_student_update') == FALSE){
                $this->response([
                    'status' => FALSE,
                    'token' => $this->t,
                    'message' => $this->form_validation->error_array()
                ], 200);  
            }            
        }

        $i = $this->mreports->update($this->type, $this->put()); 
        
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
            'message' => 'Report Updated Successfully'
        ], 200);    

    }

    /**
     * REPORTED STUDENTS
     */

    public function reported_get(){
        //Sanitizes input data to avoid XSS Attack
        if($this->sanitizer->xss($this->get()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        $i = $this->mreports->reported_get($this->id, $this->type, $this->get());

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
}