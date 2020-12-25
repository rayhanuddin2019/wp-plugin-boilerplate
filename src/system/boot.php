<?php
use Illuminate\Config\Repository as Mangocube_Repository;
use Illuminate\Support\MessageBag as MangocubeMessageBag;
use Illuminate\Support\Collection as MangocubeCollection;
use Illuminate\Support\Fluent as MangocubeFluent;
use Illuminate\Support\Arr as MangocubeArr;
use Illuminate\Support\Str as MangocubeStr;
use Symfony\Component\Finder\Finder;
/*
**
*** In step one we created a constant called APPLICATION_PATH.
*** Now a smarty security check is to make sure that constant is set.
*** This will stope hackers from directly accessing the file from the browser.
*** So we just make sure that the APPLICATION_PATH is in the scope
**
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/*
**
*** Now at this point we can start including our files, and creating the objects etc.
*** The first object were going to be including is the regsitry object.
**
*/
require_once MANGCUBE_DIR_PATH .'/src/system/registry.php';


$mangocube = new \Mangocube\Registry;

/*
**
*** Loaded all plugin helper functions
*** 
**
*/
require_once MANGCUBE_DIR_PATH .'/src/helpers/generals.php';
//Add Httpnput to the global registry
$mangocube->httpinput = new \Mangocube\base\HttpInput();

/*
** docs - https://github.com/mattstauffer/Torch/blob/master/components/container/index.php
** laravel container package
*/
$mangocube_container = new Illuminate\Container\Container;
$mangocube_container->bind('mangocube_http', 'Mangocube\base\HttpInput');
$mangocube_http = $mangocube_container->make('mangocube_http');


/*
** All Config file access
**  Use this file anywhere of this plugin
*/

$mangocube_config = new Mangocube_Repository(require MANGCUBE_DIR_PATH . 'src/system/config/app.php');




echo  mangocube_resize('http://localhost/wp/production/wp-content/uploads/2020/11/logo-1.png',100,100);






