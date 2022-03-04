<?php

namespace Mangocube\extensions\menu;
use Mangocube\base\Runner;
use Mangocube\serviceProviders\App\Checker as Checker;
use Mangocube\serviceProviders\App\Branch as Branch;


final class Help extends Runner
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public function register() 
	{

        // Do anything here
        //dump(__METHOD__);
		$availability_checker = mangocube_app()->get(Checker::class);
		$Branch = mangocube_app()->get(Branch::class);

		$availability_checker::listen();
		$Branch::listen();

		
      
	}
	
}

?>




