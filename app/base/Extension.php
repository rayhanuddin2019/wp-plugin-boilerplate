<?php

namespace Mangocube\base;

abstract class Extension {

    public static function get_services(){
	
      return [];
   	}
   /**
	 * Loop through the classes, initialize them, 
	 * and call the register() method if it exists
	 * @return
	 */
	public static function register_services() 
	{

		$service_list = static::get_services();
		
		if(is_array( $service_list )){

			foreach ( $service_list as $class ) {

				if( class_exists($class) ){
					
					$service = static::instantiate( $class );
			
					if ( method_exists( $service, 'register' ) ) {
						$service->register();
					}
				}    
			
			}
		}
	
		
	}

	/**
	 * Initialize the class
	 * @param  class $class    class from the services array
	 * @return class instance  new instance of the class
	 */
	private static function instantiate( $class )
	{
		$service = new $class();
         
		return $service;
	}

    
}