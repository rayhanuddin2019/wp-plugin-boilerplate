<?php

/**
 * All Service Providers are registered here.
 * @version 1.0.0
 * @date    2022-02-26
 * @param dir path
 * @param type can be "ARRAY" "JSON"
 */


Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'packages/Options/register','ARRAY');
Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'app/configs','ARRAY');
Mangocube\system\config\Loader::getInstance(MANGCUBE_DIR_PATH . 'app/configs/json','JSON');
