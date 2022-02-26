<?php

namespace Mangocube\system\config;

final class Loader
{
    
  
    /**
     * Retrieves php array file, json file, or ini file and builds array
     * @param $filepath Full path to where the file is located
     * @param $type is the type of file.  can be "ARRAY" "JSON"
     * @since 1.0
     */ 
    private function __construct($dir , $type = 'ARRAY')
    {
        switch($type) {

            case 'ARRAY':
              
                $this->store_array_config($dir);
                break; 

            case 'JSON':
              
                $this->store_json_config($dir);
                break;  
     
        }
    }

    public function store_array_config($dir){

        if( is_dir( $dir ) ){

            $files  =  mangocube_get_dir_file_list($dir);
        
            foreach($files as $key => $file_path){

                if(file_exists($file_path)){
                    $array_content = include $file_path;
                     
                    if( is_array( $array_content ) ) {
                          mangocube_app()->add($key, new \MangoCube_Packages\DI\Argument\Literal\ArrayArgument($array_content));
                    }
                }
    
            }

        }
 
    }

    public function store_json_config( $dir ){
        

        if( is_dir( $dir ) ){

            $files  =  mangocube_get_dir_file_list($dir,'json');
            foreach($files as $key => $file_path){

                  $array_content = json_decode(file_get_contents($file_path), true);
                
                  if( is_array( $array_content ) ) {
                       mangocube_app()->add($key, new \MangoCube_Packages\DI\Argument\Literal\ArrayArgument($array_content));
                  }

            }

        }

    }
    
    /**
     * Retrieves the instance of the class
     * @since 1.0
     * @param $filepath Full path to where the file is located
     * @param $type is array, json, or ini 
     */
    public static function getInstance($filepath, $type = 'ARRAY')
    {

        return new self($filepath, $type);
    }

}
