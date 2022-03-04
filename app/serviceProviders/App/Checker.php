<?php

namespace Mangocube\serviceProviders\App;
use Mangocube\base\Ajax_Manager;

Class Checker extends Ajax_Manager{

    protected $action = 'mangocube-address-checker-action';
    
    protected function render_response(){

    	// Check Nonce
        // Your Code Here!
    	
      
        wp_send_json('json');
    }

   
}