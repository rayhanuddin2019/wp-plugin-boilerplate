<?php

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

require_once MANGCUBE_DIR_PATH .'/app/system/registry.php';

/*
**
*** Loaded all plugin helper functions
*** 
**
*/

foreach (array('generals') as $file) {
	require MANGCUBE_DIR_PATH .'/app/helpers/'.$file.'.php';
}

//Add Httpnput to the global registry


/*
** docs - https://github.com/mattstauffer/Torch/blob/master/components/container/index.php
** laravel container package
*/
//$mangocube_container = new Illuminate\Container\Container;



/*
** All Config file access
**  Use this file anywhere of this plugin
*/




/*
**  Backend loader
**  Use this file anywhere of this plugin
*/
require_once MANGCUBE_DIR_PATH .'/app/backend/Backend.php';







