<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Faculty extends RestController {
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
        $td = $this->token->generate('faculty', $token['token']['data']);

        //Assign data to private variable
        $this->type = $token['token']['data']->type;
        $this->id = $token['token']['data']->id;
        $this->user = $token['token']['data']->user;
        $this->t = $td;
    }

    public function index_get(){
        //Student can't use this function
        if($this->type == 'student'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        //Sanitizes POST data to avoid XSS attack
        if($this->sanitizer->xss($this->get()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Sending data to model 
        $i = $this->mfaculty->fetch($this->id, $this->type, $this->get());

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
        //Sanitizes POST data to avoid XSS attack
        if($this->sanitizer->xss($this->post()) !== TRUE){
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
                'token' => $this->t,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        //Validates input data using specific rules
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->post());
        if($this->form_validation->run('faculty_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mfaculty->add($this->post());

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
            'message' => 'Faculty Successfully Added'
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

        //Sanitizes sent data to avoid XSS attack
        if($this->sanitizer->xss($this->delete()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validates data with specific rules
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->delete());
        if($this->form_validation->run('id') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->delete($this->delete('id'));

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

    public function index_put(){
        //Only admin can use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        //Sanitiizes data to avoid XSS attack
        if($this->sanitizer->xss($this->put()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validates data with specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->put());
        if($this->form_validation->run('faculty_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->update($this->put());

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
            'message' => 'Account Updated Successfully'
        ], 200);    

    }

    /**
     * DEGREE
     */

    public function degree_post(){
        //Only student can't use this function
        if($this->type == 'student'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        //Sanitizes data to avoid XSS attack
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validates data using specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->post());
        if($this->form_validation->run('degree_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mfaculty->degree_add($this->post());

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
            'message' => 'Degree Successfully Added'
        ], 200);    
    }

    public function degree_delete(){
        //Only student can't use this function
        if($this->type == 'student'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        //Sanitizes input data to avoid XSS attack
        if($this->sanitizer->xss($this->delete()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validates input data using specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->delete());
        if($this->form_validation->run('degree_delete') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->degree_delete($this->delete());

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
            'message' => 'Degree Successfully Deleted'
        ], 200);    

    }

    private function degree_put(){
        //Admin can only use this function 
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        //Sanitizes input data to avoid XSS atttack
        if($this->sanitizer->xss($this->put()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validates input data using specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->put());
        if($this->form_validation->run('degree_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->degree_update($this->put());

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
            'message' => 'Degree Updated Successfully'
        ], 200);    

    }

    /**
     * COURSE TAUGHT
     */

    public function taught_post(){

        //Admin can only use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        //Sanitizes input data to avoid XSS attack
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }
    
        //Validates input data using specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->post());
        if($this->form_validation->run('taught_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mfaculty->taught_add($this->post());

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
            'message' => 'Course Taught Successfully Added'
        ], 200);    
    }

    public function taught_delete(){
        //Sanitizes input data to avoid XSS Attack
        if($this->sanitizer->xss($this->delete()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Admin can only use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        //Validates user input using specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->delete());
        if($this->form_validation->run('taught_delete') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->taught_delete($this->delete());

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
            'message' => 'Course Taught Successfully Deleted'
        ], 200);    

    }

    private function taught_put(){

        //Admin can only use this function
        if($this->type != 'admin'){
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

        //Validates input data using specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->put());
        if($this->form_validation->run('taught_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->taught_update($this->put());

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
            'message' => 'Course Taught Updated Successfully'
        ], 200);    

    }
    
    /**
     * QUALIFICATIONS
     */

    public function qualifications_post(){
        //Only student can't use this function
        if($this->type == 'student'){
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

        //Validates input data using specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->post());
        if($this->form_validation->run('qualifications_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mfaculty->qualifications_add($this->post());

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
            'message' => 'Qualifications Successfully Added'
        ], 200);    
    }

    public function qualifications_delete(){
        //Only student can't use this function
        if($this->type == 'student'){
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
        if($this->form_validation->run('qualifications_delete') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->qualifications_delete($this->delete());

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
            'message' => 'Qualifications Successfully Deleted'
        ], 200);    

    }

    private function qualifications_update(){
        //Only student can't use this function
        if($this->type == 'student'){
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

        //Validates input data using specific rule
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->put());
        if($this->form_validation->run('qualifications_update') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mfaculty->qualifications_update($this->put());

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
            'message' => 'Qualifications Updated Successfully'
        ], 200);    

    }
    
    /**
     * FACULTY PROFILE PICTURE
     */

    public function photos_post(){
        //Only admin can use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }
        //Sanitizes POST data to avoid XSS attack
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
        if($this->form_validation->run('profile_img') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $faculty_id = $this->post('id');
        $upload = new \Delight\FileUpload\FileUpload();
        $directory = './uploads/faculty/' . $faculty_id . '/img';

        try {
            $this->filemanager->delete_files($directory);

        }catch(Exception $e){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'messsage' => $e->getMessage()
            ]);
        }

        $upload->withTargetDirectory($directory);
        $upload->withMaximumSizeInMegabytes(4);
        $upload->withAllowedExtensions([ 'jpeg', 'jpg' ]);
        $upload->from('photo');

        try {
            $uploadedFile = $upload->save();
            $filename =  '/uploads/faculty/' . $faculty_id . '/img/' . $uploadedFile->getFilenameWithExtension();

            $i =  $this->mfaculty->set_profile_img($faculty_id, $filename);

            if($i == FALSE){
                $this->response([
                    'status' => FALSE,
                    'token' => $this->t,
                    'message' => 'Something Went Wrong, Please try again later'
                ], 200);
            }
    
            $res = [
                'status' => TRUE,
                'token' => $this->t,
                'message' => 'Profile Successfully Updated'
            ];
            
            $this->response($res, 200);

        }
        catch (\Delight\FileUpload\Throwable\InputNotFoundException $e) {
            // input not found
            $this->response([ 'status' => FALSE , 'token' => $this->t, 'message' => $e . 'td' ], 200);

        }
        catch (\Delight\FileUpload\Throwable\InvalidFilenameException $e) {
            // invalid filename
            $this->response([ 'status' => FALSE , 'token' => $this->t, 'message' => $e . 'td' ], 200);

        }
        catch (\Delight\FileUpload\Throwable\InvalidExtensionException $e) {
            // invalid extension
            $this->response([ 'status' => FALSE , 'token' => $this->t, 'message' => $e . 'td' ], 200);

        }
        catch (\Delight\FileUpload\Throwable\FileTooLargeException $e) {
            // file too large
            $this->response([ 'status' => FALSE , 'token' => $this->t, 'message' => $e . 'td' ], 200);

        }
        catch (\Delight\FileUpload\Throwable\UploadCancelledException $e) {
            // upload cancelled
            $this->response([ 'status' => FALSE , 'token' => $this->t, 'message' => $e . 'td' ], 200);

        }
    }
}