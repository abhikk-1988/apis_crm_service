<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Demo extends CI_Controller{
    
    public function __construct(){
     
        parent::__construct();
        
        
    }
    
    // Public methods 
    
    public function index (){
     
        echo APPPATH; 
    }
}

