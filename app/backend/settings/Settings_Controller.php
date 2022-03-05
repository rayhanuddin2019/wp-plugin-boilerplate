<?php 
namespace Mangocube\backend\settings;

use MangoCube_Packages\Options\Settings_Api;

Class Settings_Controller {

    public function loader(){

        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts') );
        add_action( 'init', [$this,'sample_setings_setup'] );
   
    }

    function sample_setings_setup() {

        $sections = array();
        $configs  = array();
     
        $sections   = mangocube_app()->get('pages-settings-sections');
        $configs    = mangocube_app()->get('pages-settings');
    
        new Settings_Api(
            $configs, 
            apply_filters( 'mangocube_sample_option_sections', $sections )
        );
         
    }

    public function _blank_callback(){
        echo '<p>This is blank callback.</p>';
    }

    public function enqueue_scripts(){

        $asset_array = mangocube_app()->get('configs-settings-assets');

        $js_arr = $asset_array['js'];
        $css_arr = $asset_array['css'];

            foreach($css_arr as $css){
               
                if( file_exists( $css[ 'file' ] ) && $css['admin'] == true ) {
                   
                    $media = isset($css['media'])?$css['media']:'all';
                    wp_register_style(  $css[ 'handle_name' ]  , $css['src'] , $css['deps'] , filemtime( $css['file'] ), $media );
                    wp_enqueue_style(  $css[ 'handle_name' ] );
            
                }
            }

            foreach( $js_arr as $js ){

                if( file_exists( $js[ 'file' ] ) && $js['admin'] == true ) {
                    
                    wp_register_script( $js[ 'handle_name' ] , $js['src'] , $js['deps'] , filemtime( $js['file'] ) );
                    wp_enqueue_script( $js[ 'handle_name' ] );

                }   
            } 

        

    }
}