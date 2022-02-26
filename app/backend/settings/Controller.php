<?php 
namespace Mangocube\backend\settings;
use Mangocube\backend\settings\fields\Text;

Class Controller {
   
    public $html = '';
    public function __construct( Text $text ){
        
        $this->html = $text;
       
    }

    public function run(){
        echo $this->html->render();
    }
}