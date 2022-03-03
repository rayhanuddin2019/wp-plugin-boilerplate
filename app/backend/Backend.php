<?php 

namespace Mangocube\backend;
use Mangocube\backend\settings\Controller as Some_Service_Controller;
use Mangocube\serviceProviders\App\Notice as Mangocube_Notice;

final Class Backend {

    protected $components = [];
    protected $services = [];
    protected $nav = null;
     
    public function __construct(){
        $this->register();
    }

    public function register(){
       
      $an_array = mangocube_app()->get('configs-app');
      var_dump($an_array);
    //   $provider = mangocube_app()->get(Some_Service_Controller::class);
    //   $mangocube_Notice = mangocube_app()->get(Mangocube_Notice::class);
  
    //   $mangocube_Notice->run();

    }

    
}

new Backend();

