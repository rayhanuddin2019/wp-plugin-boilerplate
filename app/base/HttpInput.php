<?php
namespace Mangocube\base;

final class HttpInput{

    function __construct(){
        $this->unregistryGlobals(); // sample function you ahve to build.
        //Clean user input
       // $_GET        = $this->_processGET($_GET);
        // $_POST        = $this->_processPOST($_POST);
        // $_COOKIE    = $this->_processCOOKIE($_COOKIE);
        // $_FILES        = $this->_processCOOKIE($_FILES);
    }
 
    //Cleaning Functiions
    private function _processGET($request){
        //Here we will just be recursivly escaping the data for example usage
        $return_data = null;
        if(is_array($request)){
            $tmp = array();
            foreach($request as $key => $val){
                //Check the $key is valid here if you wish
                $tmp[$key] = $this->_processGET($val);
            }
            return $tmp;
        }
        //Here we can check the single values
        if(get_magic_quotes_gpc()){
            $return_data = stripslashes($request);
        }
    //Other checking here....
 
    //Return
    return $return_data;
    }
    private function _processPOST($_){
        //Check Post
    }
    private function _processCOOKIE($_){
        //Check Cookie    
    }
    private function _processFILES($_){
        //Check Files
    }    
    private function unregistryGlobals(){
        //Here you can do some work on unregistering globals for security etc
    }

    public function get_data(){
        return 'helo';
    }
 }