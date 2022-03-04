<?php

return [

    'js' => [

        [
            'handle_name' => 'mangocube-dashboard-settings-script',
            'src'         => MANGCUBE_ASSETS_BACKEND_URL.'js/admin-settings.js',
            'file'        => MANGCUBE_DIR_PATH.'assets/backend/js/admin-settings.js',
            'minimize'    => false,
            'public'      => false, // will load in_admin panel
            'admin'       => true, // will load in_admin panel
            'in_footer'   => true,
            'media'       => 'all',
            'deps'        => [
              'jquery','jquery-ui-core','wp-color-picker'
            ]
        ]
    ],

    'css' => [

        [
            'handle_name' => 'mangocube-dashboard-settings',
            'src'         => MANGCUBE_ASSETS_BACKEND_URL.'css/admin-settings.css',
            'file'        => MANGCUBE_DIR_PATH.'assets/backend/css/admin-settings.css',
            'minimize'    => false,
            'public'      => false,
            'admin'      => true,
            'media'=> 'all',
            'deps' => [
                
            ]
        ]
    ]
];