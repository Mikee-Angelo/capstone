<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Students extends RestController {
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
        $td = $this->token->generate('students', $token['token']['data']);

        //Assign data to private variable
        $this->type = $token['token']['data']->type;
        $this->id = $token['token']['data']->id;
        $this->user = $token['token']['data']->user;
        $this->t = $td;
    }

    public function index_get(){

        //Sanitizing input of POST data to avoid XSS attack
        if($this->sanitizer->xss($this->get()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        $i = $this->mstudents->fetch($this->id, $this->type, $this->get());

        if(empty($i)){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => 'No Data Found'
            ], 200);
        }

        $res = [
            'status' => TRUE,
            'token' => $this->t,
        ];

        $this->response(array_merge($res, $i), 200);
    }

    public function index_post(){
        //The user type must be an admin to use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401);      
        }

        //Sanitizing input from cross-site scripting
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validating form input sent by the user
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->post());
        if($this->form_validation->run('students_add') == FALSE){
        $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        //Holds the count number of a single value in multidimensional array
        $c = '';

        //Checks all the count of multidimentional array if it is unique
        foreach($this->post() as $k => $v){
            if($c == ''){
                $c = count($v);
            }else{
                
                if(count($v) != $c){
                    $this->response([
                        'status' => FALSE,
                        'token' =>  $this->t,
                        'message' => 'Invalid Number of Data'
                    ], 200);    

                }
            }
        }

        //Holds the data of reconstructed array
        $d = [];

        //Reconstruct the multidimentional array
        for($x = 0; $x < $c; $x++){
            $a = [];
            
            foreach($this->post() as $k => $v){
                $a[$k] = $v[$x]; 
            }

            $d[] = $a;
        }

        $i = $this->mstudents->add($d);

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
            'message' => 'Students Successfully Added'
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

        //Sanitizing POST data to avoid XSS attack
        if($this->sanitizer->xss($this->delete()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validating data 
        $this->form_validatin->reset_validation();
        $this->form_validation->set_data($this->delete());
        if($this->form_validation->run('id') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mstudents->delete($this->delete('id'));

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
            'message' => 'Students Successfully Deleted'
        ], 200);    

    }

    public function index_put(){
        //Checks token if it is a valid JWT
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

        //Validates parsed data and check if match in database
        $val = $this->validation->method_one($id, $user, $type);

        if($val['status'] == FALSE){
            $this->response([
                'status' => $val['status'],
                'message' => $val['e']
            ], 200);      
        }

        //Sanitize POST data to avoid XSS attack
        if($this->sanitizer->xss($this->put()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $td,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Faculty can't use this function
        if($type == 'faculty'){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->put());
        if($this->form_validation->run('update_student') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $td,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mstudents->update($this->put());

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
            'message' => 'Student Successfully Updated'
        ], 200);    

    }

    /**
     * 
     * STUDENT'S SUBJECTS 
     */
    public function subject_get(){
        //Faculty can't use this function
        if($this->type == 'faculty'){
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

        $i = $this->mstudents->subjects_fetch($this->id, $this->type, $this->get());

        if(empty($i)){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => 'No Data Found'
            ], 200);
        }

        $res = [
            'status' => TRUE,
            'token' => $this->t,
            'data' => $i
        ];
        
        $this->response($res, 200);
    }

    public function subject_post(){
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
        if($this->form_validation->run('ss_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $i = $this->mstudents->subject_add($this->post());

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
            'message' => 'Students Successfully Added'
        ], 200);    
    }

    public function subject_delete(){

        //Only admin can use this account
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        //Sanitizes POST data to avoid XSS attack
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

        $i = $this->mstudents->subject_delete($this->delete('id')); 

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
            'message' => 'Students Successfully Added'
        ], 200);    

    }

    /**
     * STUDENTS PROFILE PICTURE
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
        $this->form_validation->set_data(['id' => $this->post('id')]);
        if($this->form_validation->run('profile_img') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $student_id = $this->post('id');
        $upload = new \Delight\FileUpload\FileUpload();
        $directory = './uploads/students/' . $student_id . '/img';

        try {
            $this->filemanager->delete_files($directory);

        }catch(Exception $e){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'messsage' => 'okay'
            ]);
        }

        $upload->withTargetDirectory($directory);
        $upload->withMaximumSizeInMegabytes(4);
        $upload->withAllowedExtensions([ 'jpeg', 'jpg' ]);
        $upload->from('photo');

        try {
            $uploadedFile = $upload->save();
            $filename =  '/uploads/students/' . $student_id . '/img/' . $uploadedFile->getFilenameWithExtension();

            $i =  $this->mstudents->set_profile_img($student_id, $filename);

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