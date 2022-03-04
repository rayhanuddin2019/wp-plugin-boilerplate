<?php

namespace Mangocube\serviceProviders\App;
use Mangocube\base\Ajax_Manager;

Class Branch extends Ajax_Manager{

    protected $action = 'mangocube-branch-checker-action';
  
    protected function render_response(){

    	// Your Code Here!
        wp_send_json('json');
    }

   
}