<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use chriskacerguis\RestServer\RestController;

class Auth extends RestController {
    
    public function __construct(){
        parent::__construct();
    }

    public function index_post(){
        /**
         * SANITIZING INPUT OF POST DATA FOR XSS ATTACK
         */
        if($this->sanitizer->xss($this->post()) !== TRUE){
            $this->response([
                'status' => false,
                'message' => 'Error Handling Data'
            ], 404);            
        }

        if($this->form_validation->run('login') == FALSE){
            $this->response([
                'status' => false,
                'message' => $this->form_validation->error_array()
            ], 401);

        }else{
            /**
             * FORM INPUT NAME 
             * USERNAME - usr
             * PASSWORD - pwd
             */
            $user = $this->post('usr');
            $pwd = $this->post('pwd');

            //AUTHENTICATING PARAMETERS
            $i = $this->authlogin->init($user, $pwd);

            if($i === FALSE){

                $this->response([
                    'status' => false,
                    'message' => 'Invalid Account, Try Again'
                ], 401);


            }elseif(is_null($i)){

                $this->response([
                    'status' => false,
                    'message' => 'Incorrect Username or Password'
                ], 401);

            }else{
                /**
                 * RETURNING ID, USER AND TOKEN 
                 */
                $this->response([
                    'status' => true,
                    'token' => $this->token->generate('auth', $i),
                    'data' => $i
                ], 200);
                   
            }
        }
    }
}