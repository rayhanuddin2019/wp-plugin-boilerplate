<?php
/**
 * Plugin Name: MangoCube - Wordpress Startar plugin
 * Description: Startar plugin library for page builder plugin for WordPress.
 * Plugin URI: 	https://github.com/rayhanuddin2019
 * Version: 	1.0
 * Author: 		rayhanuddin2019
 * Author URI: 	https://github.com/rayhanuddin2019
 * License:  	apache-2.0+
 * License URI: http://www.apache.org/licenses/LICENSE-2.0
 * Text Domain: mangocube
 * Domain Path: /languages
 * 
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if (defined('MANGCUBE')) {
	/**
	 * The plugin was already loaded (maybe as another plugin with different directory name)
	 */
} else {

          
            require __DIR__.'/vendor/autoload.php';


            /*
            **
            *** 
            *** 1. Used for security
            *** 2. Used to help know where we am on the filesystem.
            *** 
            **
            */
            define( 'MANGCUBE', true );
            define( 'MANGCUBE_VERSION', '1.0' );
            define( 'MANGCUBE_LITE', true );
            define( 'MANGCUBE_ROOT', __FILE__ );
            define( 'MANGCUBE_URL', plugins_url( '/', MANGCUBE_ROOT ) );
            define( 'MANGCUBE_DIR_PATH', plugin_dir_path( MANGCUBE_ROOT ) );
            define( 'MANGCUBE_ADDONS_DIR_URL', plugin_dir_url( MANGCUBE_ROOT ) );
            define( 'MANGCUBE_PLUGIN_BASE', plugin_basename( MANGCUBE_ROOT ) );
            define( 'MANGCUBE_ITEM_NAME', 'MangoCube - Wordpress extension Addons + Builder' );

            /*
            **
            *** Now lets include the bootloader file
            **
            */

            do_action('mangocube_before_bootstrap');

            require MANGCUBE_DIR_PATH .'/src/system/boot.php';
            require MANGCUBE_DIR_PATH .'/src/extension/init.php';


            do_action('mangocube_after_bootstrap');

}