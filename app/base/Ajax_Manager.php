<?php

namespace Mangocube\base;
use ReflectionClass;

Abstract Class Ajax_Manager
{
	
	protected $action;
	public $request;
	public $wp;
	public $user;
	
	abstract protected function render_response();
	public static function getActionName(){
	
	    return self::action(); 
    }

	public function requestType($requestType = NULL)
	{
		if(!is_null($requestType)){

			if(is_array($requestType)){
				return in_array($_SERVER['REQUEST_METHOD'], array_map('strtoupper', $requestType));
			}

			return ($_SERVER['REQUEST_METHOD'] === strtoupper($requestType));
		}

		return $_SERVER['REQUEST_METHOD'];
	}
	

	public static function boot()
	{ 

		$class = Self::getClassName();
		
		$action = new $class;
		
		$action->render_response();

		wp_die();
	}

	public static function listen($public = TRUE)
	{

		$action = Self::getActionName();
		$OBJName  = Self::getClassName();
         
		add_action("wp_ajax_{$action}", [$OBJName, 'boot']);
		
		if( $public ){
			add_action("wp_ajax_nopriv_{$action}", [$OBJName, 'boot']);
		}
	}

	public function __construct()
	{ 	
		global $wp;
		$this->wp = $wp;
		$this->request = $_REQUEST;
		

		if($this->isLoggedIn()){
			$this->user = wp_get_current_user();
		}
	}

	public static function getClassName()
	{
		return get_called_class();
	}
	
	public static function formURL(){
		return admin_url('/admin-ajax.php');
	}

	public static function action()
	{
		$class 		= Self::getClassName();
		$reflection = new ReflectionClass($class);
		$reflection_obj		= $reflection->newInstanceWithoutConstructor();
		if(!isset($reflection_obj->action)){
			throw new Exception("Public property \$reflection_obj not provided");
		}

		return $reflection_obj->action;
	}

	
	public function returnBack(){

		if(isset($_SERVER['HTTP_REFERER'])){
			wp_redirect( $_SERVER[ 'HTTP_REFERER' ] );
			die();
		}

		return false;
	}

	public function returnRedirect($url, $params = array()){

		$url .= '?'. http_build_query($params);

		wp_redirect( $url );

		wp_die();

	}

	public function returnJSON($data){
	
		wp_send_json($data);
	
	}

	public static function ajax_Url()
	{
		?>
			<script type="text/javascript">
				var mangocube_ajax_url = '<?php echo esc_url(admin_url('/admin-ajax.php')); ?>';
			</script>
		<?php
	}

	public static function load_ajax_url()
	{
		add_action('wp_head', ['\Mangocube\base\Ajax_Manager', 'ajax_Url']);
	}

	public static function url($params = array()){

		$params = http_build_query(array_merge(array(
			'action' => (new static())->action,
		), $params));

		return admin_url('/admin-ajax.php') .'?'. $params;
	}

	public function isLoggedIn()
	{
		return is_user_logged_in();
	}

	public function has($key)
	{
		if( isset( $this->request[ $key ]) ){
			return true;
		}

		return false;
	}

	public function get($key, $default = NULL, $stripslashes = TRUE){

		if($this->has($key)){
			if($stripslashes){
				return stripslashes($this->request[$key]);
			}
			return $this->request[$key];
		}
		return $default;
	}
	
	
}