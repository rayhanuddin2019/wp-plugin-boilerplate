### How To Register Services Providers

Serviceprovider where we register plugin service like pdf , api those we run later into hooks . Most of the service call from extensions / Module folder. 

1.  Create a folder into serviceProvider 
2.  See into app folder / Backend folder
3. Register a class and class dependency into service provider class ( https://prnt.sc/NZVCW91Gg0G6 ) and https://prnt.sc/vDem2F8gpfUe
4.  Provide method use for alias
5. call this service from where in app into hook using container() function https://prnt.sc/LRooCFad2xKz


		$provider = mangocube_app()->get(Some_Service_Controller::class);

		$mangocube_Notice = mangocube_app()->get(Mangocube_Notice::class);
	
		$mangocube_Notice->run();
  

###  configuration file create and usage 
we can use two type of configuration files  (ARRAY , JSON) .

1.  Create a file into configs folder tools.php
2.  must  return array https://prnt.sc/2WuFWuh96mRS
###  usage
To get config data use mangocube_container('configs-dashboard'); function Here config is constant / Prefix See screenshoot https://prnt.sc/k1i5y8qCuxfb

`mangocube_container('configs-dashboard');`

###  Write Your Code

1.  Create a module folder in extensions https://prnt.sc/rP9HohcR0Aq8
2. Create a Init.php File and extend extension class


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
	
	
	
	

3.1 Create a class with register method  
3.2 put the class in to get_service into Above Init.php
3.3 Must Impplement runner class



    
    namespace Mangocube\extensions\menu;
    use Bookat\base\Runner;
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
		
		}
	
	}





