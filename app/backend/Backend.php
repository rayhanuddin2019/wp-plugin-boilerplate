<?php 

namespace Mangocube\backend;
use Mangocube\backend\settings\Controller as Some_Service_Controller;
use Mangocube\backend\settings\Settings_Controller as Settings_Controller;
use Mangocube\serviceProviders\App\Notice as Mangocube_Notice;


final Class Backend {
  
    public function __construct(){
        $this->register();
    }

    public function register(){
     
      $settings_loader = mangocube_app()->get(Settings_Controller::class);
      $settings_loader->loader();


    }

    
}

new Backend();

