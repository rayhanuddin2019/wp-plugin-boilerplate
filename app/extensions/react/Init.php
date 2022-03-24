<?php

namespace Mangocube\extensions\react;
use Mangocube\base\Extension;
  
final class Init extends Extension
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 * @desc all class should implement runner class
	 */
	public static function get_services() 
	{
      
		return [
		   services\Page::class,		
		   services\Reusable_ShortCode::class,		
	       services\Assets::class,		
	 	];
        
	}
	
}

?>




