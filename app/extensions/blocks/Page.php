<?php

namespace Mangocube\extensions\blocks;
use Mangocube\base\Runner;


final class Page extends Runner
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public function register() 
	{
		
        add_action('admin_menu', [$this,'_custom_submenu_page']);
 
	}
    
    function _custom_submenu_page() {
        add_submenu_page(
            'tools.php',
            'Submenu Page',
            'Submenu Page',
            'manage_options',
            'my-custom-submenu-page',
            [$this,'_submenu_page_callback'] );
    }

    function _submenu_page_callback() {
        echo '<div class="wrap mangowrapo"><div id="icon-tools" class="icon32"></div>';
            echo '<h2>My Custom Submenu Page</h2>';
            echo '<div id="root">My Custom Submenu Page</div>';
            echo '<div id="mango-counter">My Custom Submenu Page</div>';
            echo '<div id="entry-content">My Custom Submenu Page</div>';
        echo '</div>';
    }
}