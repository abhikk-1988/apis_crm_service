<?php if(! defined('BASEPATH')) exit('No direct script access allowed');

class Jwt {
    
    /*----------------------------------------
     | HASHING ALGO
     |----------------------------------------
     */
    static $_hash_algo = 'SHA256';
    
    
    /*--------------------------------------------------------------------------
     | BASE64 ENCODE STRING 
     |--------------------------------------------------------------------------
     */
    static function base64Encode($string = ''){
        
        if(!$string){
            return '';
        }
        
        return base64_encode($string);
    }
    
    
    /*--------------------------------------------------------------------------
     | BASE64 DECODE STRING 
     |--------------------------------------------------------------------------
     */
    static function base64Decode($string = ''){
        if(!$string){
            return '';
        }
        
        return base64_decode($string);
    }
    
    
    /*--------------------------------------------------------------------------
     | SIGN TOKEN WITH HASHING ALGORITHM 
     |--------------------------------------------------------------------------
     */
    static function signToken($data){
        return self::base64Encode(hash_hmac(self::$_hash_algo, $data, JWT_SECRET , TRUE));
    }
    
    
    /*--------------------------------------------------------------------------
     | REVERSE VERIFYING JWT TOKEN IF IT IS TEMPARED OR NOT  
     |--------------------------------------------------------------------------
     */
    static function verifyToken ($token = ''){
        
        if(!$token){
            return FALSE;
        }
        
        $token_arr          = explode('.', $token);
        $token_header       = self::base64Decode($token_arr[0]);
        $token_payload      = self::base64Decode($token_arr[1]);
        $token_signature    = $token_arr[2]; // It is already Base64 Encoded
        
        // create signature again with token header and token payload
        $base64_encoded_signature = self::signToken(self::base64Encode($token_header).'.'.self::base64Encode($token_payload));        
     
        // Compare token signature with new generated signature 
        
        return ($token_signature === $base64_encoded_signature ? TRUE : FALSE);
    }
 
    
    /*--------------------------------------------------------------------------
     | CREATE JWT TOKEN BY CONCATENATING HEADER PAYLOAD AND SIGNATURE
     |--------------------------------------------------------------------------
     */
    static function createToken ($header = '', $payload = ''){
        
        $_header    = self::base64Encode($header);
        $_payload   = self::base64Encode($payload);
        $_signature = self::signToken($_header.'.'.$_payload);
        
        return $_header.'.'.$_payload.'.'.$_signature;
    }
}