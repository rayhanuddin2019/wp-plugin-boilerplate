<?php

namespace Mangocube\extensions\menu;
use Mangocube\base\Extension;
  
final class Init extends Extension
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public static function get_services() 
	{
      
		return [
	       Help::class,		
	     	
		];
        
	}
	
}

?>




