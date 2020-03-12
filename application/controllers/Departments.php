<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class Departments extends RestController {
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
        $td = $this->token->generate('departments', $token['token']['data']);

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

        $i = $this->mdepartments->fetch([], [], $this->get());

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
        //Admin can only use this function
        if($this->type != 'admin'){
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
        if($this->form_validation->run('department_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $datas = [
            'dept_name' => $this->post('dept_name'),
            'dept_abbv' => strtoupper($this->post('dept_abbv'))
        ];

        $i = $this->mdepartments->add($datas);

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
            'message' => 'Department Successfully Added'
        ], 200);    
    }

    public function index_delete(){
        //Admin can only use this function
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

        //Validates input data using specific rule
        $this->form_validation->reset_validation();
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
            'message' => 'Department Successfully Deleted'
        ], 200);    

    }

    private function index_put(){
        //Admin can only use this function
        if($this->type != 'admin'){
            $this->response([
                'status' => FALSE,
                'message' => 'Unauthorized User Type'
            ], 401); 
        }

        //Validates input data to avoid XSS Attack        
        if($this->sanitizer->xss($this->put()) !== TRUE){
            $this->response([
                'status' => false,
                'token' => $this->t,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        //Validates input data using specific rules
        $this->form_validation->reset_validation();
        $this->form_validation->set_data($this->put());
        if($this->form_validation->run('department_add') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' => $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);  
        }

        $i = $this->mdepartments->update($this->put());

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
            'message' => 'Department Successfully Updated'
        ], 200);    
    }

    public function photos_post(){
        //Admin can only use this function
        if($this->type != 'admin'){
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
        if($this->form_validation->run('department_img') == FALSE){
            $this->response([
                'status' => FALSE,
                'token' =>  $this->t,
                'message' => $this->form_validation->error_array()
            ], 200);    
        }

        $dept_id = $this->post('id');
        $upload = new \Delight\FileUpload\FileUpload();
        $directory = './uploads/departments/' . $dept_id . '/img';

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
        $upload->withAllowedExtensions([ 'jpeg', 'jpg', 'png' ]);
        $upload->from('photo');

        try {
            $uploadedFile = $upload->save();
            $filename =  '/uploads/departments/' . $dept_id . '/img/' . $uploadedFile->getFilenameWithExtension();

            $i =  $this->mdepartments->set_profile_img($dept_id, $filename);

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