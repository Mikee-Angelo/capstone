<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use \Firebase\JWT\JWT;

date_default_timezone_set('Asia/Manila');

class Token extends JWT{
    #CHANGE KEY
    private $key = '@McQfThWmZq4t7w!z%C*F-JaNdRgUkXn';
    #FOR ISS
    private $url = 'http://localhost:8888/book-v1/';
    #FOR AUD
    private $aud = 'api/v1/';

    protected $CI;

    public function __construct(){
        #GET INSTANCE OF ALL FUNCTIONS OF CODEIGNITER
        $this->CI =& get_instance();
        #LOADING FORM VALIDATION LIBRARY
        $this->CI->load->library(['form_validation']);
    }
    
    #GENERATING JWT TOKEN
    public function generate($aud, $data){
        #PAYLOAD FOR JWT
        $payload = array(
            "iss" => $this->url,
            "aud" => $this->url.$this->aud.strtolower($aud),
            "iat" => time(),
            "data" => $data
        );

        try {
            #INITIALIZING JWT
            $jwt = JWT::encode($payload, $this->key);
            
            if(!$jwt){
                throw new Exception($jwt);    
            }

            return $jwt;
        }catch(Exception $e){
            return ['status' => FALSE, 'e' => $e->getMessage()];
        }
    }

    #VALIDATING JWT TOKEN
    public function validate(){
        #GET ALL HEADERS
        $header = apache_request_headers(); 
        #LEEWAY
        JWT::$leeway = 60;

        #CHECK IF HEADER IS FETCHED
        if(!is_array($header)){
            return ['status' => FALSE, 'e' => 'Something Went Wrong'];
        }

        #FIX AUTHORIZATION HEADER TEXT CASE
        $arr = array_change_key_case($header, CASE_UPPER);

        #CHECK IF AUTHORIZATION HEADER EXISTS
        if(!isset($arr['AUTHORIZATION'])){
            return ['status' => FALSE, 'e' => 'Authorization Failed'];
        }

        #STORE AUTHORIZATION HEADER 
        $token = $arr['AUTHORIZATION'];
        #SETTING TOKEN FOR VALIDATION
        $this->CI->form_validation->set_data(['t' => $token]);
        
        #VALIDATING TOKEN
        if($this->CI->form_validation->run('t') == FALSE){
            return ['status' => FALSE, 'e' => $this->CI->form_validation->error_array()];
        }

        try{
            #DECODING JWT TOKEN
            $decoded = JWT::decode($token, $this->key, array('HS256'));
 
            if(!$decoded){          
                throw new Exception($decoded);
            }

            return (array) $decoded;

        }catch(Exception $e){

            return ['status' => FALSE, 'e' => $e->getMessage()];
        }
    }
}