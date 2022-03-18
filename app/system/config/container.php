<?php

/**
 * All Service Configs are registered here.
 * @version 1.0.0
 * @since    2022-02-26
 * @param dir path
 * @param type can be "ARRAY" "JSON"
 */


Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'packages/Options/register','ARRAY');
Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'app/configs','ARRAY');

Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'app/configs/json','JSON');

Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'app/configs/options/posts','ARRAY');
Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'app/configs/options/taxonomy','ARRAY');
Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'app/configs/options/pages','ARRAY');
