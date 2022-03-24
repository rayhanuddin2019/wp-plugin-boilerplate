<?php

namespace Mangocube\extensions\react\services;
use Mangocube\base\Runner;


final class Assets extends Runner
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public function register() 
	{
		
		add_action('admin_enqueue_scripts',[$this,'mangocube_admin_react']);
		add_action('enqueue_block_editor_assets',[$this,'mangocube_editor_react']);

		// Hook: Frontend assets.
		add_action( 'enqueue_block_assets', [$this,'mangocube_frontend_react'] );
	}


	public function mangocube_admin_react(){

       if(!file_exists(__DIR__ .'/../build/dashboard.asset.php')) {
		   return;
	   } 
		$deps = include_once __DIR__ .'/../build/dashboard.asset.php'; 
                    
		wp_enqueue_script( 'mangocube-blocks-admin-react', MANGCUBE_ADDONS_DIR_URL . 'react/build/dashboard.js', $deps['dependencies'], $deps['version'], true );
		wp_enqueue_style( 'mangocube-blocks-admin-react', MANGCUBE_ADDONS_DIR_URL . 'react/build/dashboard.css' );

	}

	public function mangocube_editor_react(){
		
		if(!file_exists(__DIR__ .'/../build/block.asset.php')) {
			return;
		}
		
		$deps = include_once __DIR__ .'/../build/block.asset.php'; 
		wp_enqueue_script( 'mangocube-blocks-editor-react', MANGCUBE_ADDONS_DIR_URL . 'react/build/block.js', $deps['dependencies'], $deps['version'], true );
	}
	

	public function mangocube_frontend_react(){
		
		if(!file_exists(__DIR__ .'/../build/frontend.asset.php')) {
			return;
		}
		
		$deps = include_once __DIR__ .'/../build/frontend.asset.php'; 
		wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' );
		wp_enqueue_style( 'mangocube-blocks-front-component', MANGCUBE_ADDONS_DIR_URL . 'react/build/frontend.css' );
		wp_enqueue_script( 'mangocube-blocks-front-component', MANGCUBE_ADDONS_DIR_URL . 'react/build/frontend.js', $deps['dependencies'], $deps['version'], true );
	}
}

?>




