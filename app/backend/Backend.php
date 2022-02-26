<?php 
namespace Mangocube\backend;
use Mangocube\backend\settings\Controller as Some_Service_Controller;

final Class Backend {
    protected $components = [];
    protected $services = [];
    protected $nav = null;
     
    public function __construct(){
        $this->register();
    }

    public function register(){
       
      $an_array = mangocube_app()->get('an-array');

      $provider = mangocube_app()->get(Some_Service_Controller::class);
  
        echo $provider->run();

    }

    
}

new Backend();

