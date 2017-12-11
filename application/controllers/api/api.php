<?php

/**
 * REST API Controller 
 */

defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Jwt.php';

class Api extends REST_Controller {
    
    function __construct(){
        parent::__construct();   
        $this->load->model('Demo_model');
    }
   
    
    public function encodeString_get($str = ''){
        
        $encoded_string = Jwt::base64Encode($str);
        
        $this->response(['encoded_string' => $encoded_string],REST_Controller::HTTP_OK);
        
    }
    
    public function decodeString_get($str = ''){
        
        $decoded_string = Jwt::base64Decode($str);
        
        $this->response(['encoded_string'=> $str,'decoded_string' => $decoded_string],REST_Controller::HTTP_OK);
        
    }
    
    public function createToken_get(){
        
        $header     = array('alg' => 'HS256','typ' => 'JWT');
        $payload    = array('iss' => 'crm.bookmyhouse.com','admin' => FALSE,'iat' => time());
        
        // Base64 Encode Header and Payload
        
        $base64_encode_header   = Jwt::base64Encode(json_encode($header));
        $base64_encode_payload  = Jwt::base64Encode(json_encode($payload));
        
        $signature = Jwt::signToken($base64_encode_header.'.'.$base64_encode_payload);
        
        $token = $base64_encode_header.'.'.$base64_encode_payload.'.'.$signature;
        
        
        $this->response([
            'token' => $token,
            'header' => $base64_encode_header,
            'payload' => $base64_encode_payload,
            'signature' => $signature,
            'secret' => JWT_SECRET
        ],REST_Controller::HTTP_OK);
    }
 
    
    public function extractTime_get($ts = ''){
        
        $uri = $this->get();
        
        $date = date('Y-m-d H:i:s',$uri['ts']);
        
        echo $date;
    }
}


