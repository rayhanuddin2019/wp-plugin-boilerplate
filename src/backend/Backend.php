<?php 
namespace Mangocube\backend;
use Mangocube\backend\importer\Menu as Mangocube_Nav;

final Class Backend {
    protected $components = [];
    protected $services = [];
    protected $nav = null;
     
    public function __construct(){
        $this->register();
    }
    public function register(){
        $this->nav = new Mangocube_Nav();
        add_action( 'wp_ajax_mangocube_menu_importer', [$this->nav,'_import_ajax_handler'] );
        add_action('admin_init',[$this->nav,'register']);
       
    }

    
}

new Backend();

