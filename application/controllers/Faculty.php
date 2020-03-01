<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Faculty extends RestController {
    private $aud = 'faculty';

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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        $val = $this->validation->method_one($id, $user, $type);

        if($val['status'] == FALSE){
            $this->response([
                'status' => $val['status'],
                'token' => $td,
                'message' => $val['e']
            ], 200);      
        }

        $i = $this->mfaculty->fetch($id, $type, $query);

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
        $td = $this->token->generate($this->aud, $token['token']['data']);

        if($type != 'admin'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        $val = $this->validation->method_one($id, $user, $type);

        if($val['status'] == FALSE){
            $this->response([
                'status' => $val['status'],
                'token' => $td,
                'message' => $val['e']
            ], 200);      
        }

        $datas = [
            'draft' => TRUE,
        ];

        $i = $this->madmin->add($datas);

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
            'message' => 'Faculty Successfully Initialized'
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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type != 'admin'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        $i = $this->mfaculty->delete($this->delete('id'));

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
            'message' => 'Account Successfully Deleted'
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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type != 'admin'){
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

        if($this->form_validation->run('faculty_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->update($data_id, $data);

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
            'message' => 'Account Updated Successfully'
        ], 200);    

    }

    /**
     * DEGREE
     */

    public function degree_post(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);
        /**
         * SANITIZING INPUT OF POST DATA FOR XSS ATTACK
         */
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $td,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        $val = $this->validation->method_one($id, $user, $type);

        if($val['status'] == FALSE){
            $this->response([
                'status' => $val['status'],
                'token' => $td,
                'message' => $val['e']
            ], 200);      
        }      
        
        if($this->form_validation->run('degree_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $td,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mfaculty->degree_add($id, $this->post());

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
            'message' => 'Degree Successfully Added'
        ], 200);    
    }

    public function degree_delete(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $data = $this->delete();
        $user =  $this->get('id');

        $this->form_validation->set_data($data);
        $this->form_validation->set_data($user);

        if($this->form_validation->run('degree_delete') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->degree_delete($data, $user);

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
            'message' => 'Degree Successfully Deleted'
        ], 200);    

    }

    private function degree_update(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type != 'admin'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $data = $this->update();
        $user = $this->get('id');

        $this->form_validation->set_data($data);
        $this->form_validation->set_data(['faculty_id' => $user]);

        if($this->form_validation->run('degree_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->degree_update($data, $user);

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
            'message' => 'Degree Updated Successfully'
        ], 200);    

    }

    /**
     * COURSE TAUGHT
     */

    public function taught_post(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);
        /**
         * SANITIZING INPUT OF POST DATA FOR XSS ATTACK
         */
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $td,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        $val = $this->validation->method_one($id, $user, $type);

        if($val['status'] == FALSE){
            $this->response([
                'status' => $val['status'],
                'token' => $td,
                'message' => $val['e']
            ], 200);      
        }      
        
        if($this->form_validation->run('taught_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $td,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mfaculty->taught_add($id, $this->post());

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
            'message' => 'Course Taught Successfully Added'
        ], 200);    
    }

    public function taught_delete(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $data = $this->delete();
        $user =  $this->get('id');

        $this->form_validation->set_data($data);
        $this->form_validation->set_data($user);

        if($this->form_validation->run('taught_delete') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->taught_delete($data, $user);

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
            'message' => 'Course Taught Successfully Deleted'
        ], 200);    

    }

    private function taught_update(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $data = $this->update();
        $user = $this->get('id');

        $this->form_validation->set_data($data);
        $this->form_validation->set_data(['faculty_id' => $user]);

        if($this->form_validation->run('taught_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->taught_update($data, $user);

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
            'message' => 'Course Taught Updated Successfully'
        ], 200);    

    }
    
    /**
     * QUALIFICATIONS
     */

    public function qualifications_post(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);
        /**
         * SANITIZING INPUT OF POST DATA FOR XSS ATTACK
         */
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $td,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        $val = $this->validation->method_one($id, $user, $type);

        if($val['status'] == FALSE){
            $this->response([
                'status' => $val['status'],
                'token' => $td,
                'message' => $val['e']
            ], 200);      
        }      
        
        if($this->form_validation->run('qualifications_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $td,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mfaculty->qualifications_add($id, $this->post());

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
            'message' => 'Qualifications Successfully Added'
        ], 200);    
    }

    public function qualifications_delete(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $data = $this->delete();
        $user =  $this->get('id');

        $this->form_validation->set_data($data);
        $this->form_validation->set_data($user);

        if($this->form_validation->run('qualifications_delete') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->qualifications_delete($data, $user);

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
            'message' => 'Qualifications Successfully Deleted'
        ], 200);    

    }

    private function qualifications_update(){
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
        $td = $this->token->generate($this->aud, $token['token']['data']);

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

        if($type == 'student'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $data = $this->update();
        $user = $this->get('id');

        $this->form_validation->set_data($data);
        $this->form_validation->set_data(['faculty_id' => $user]);

        if($this->form_validation->run('qualifications_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->qualifications_update($data, $user);

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
            'message' => 'Qualifications Updated Successfully'
        ], 200);    

    }
    
}