<?php  

namespace MangoCube_Packages\Options\Fields;;	

class Admin {

	var $options_page_id = '';

	public function __construct( $parent ) {
		$this->parent = $parent;
		add_action('admin_menu', array($this, 'add_admin_menu'));
	
	}

	/**
	 * Add admin menu page
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function add_admin_menu() {

		global $menu, $submenu;

		$menu_type = $this->parent->configs['menu_type'];
		$page_parent = $this->parent->configs['page_parent'];
		$optioins_page = '';
		// Themes should use add_theme_page() for adding admin pages
		if($menu_type == 'submenu' && isset($page_parent) && !empty($page_parent)) {

			$optioins_page = add_submenu_page( 
				$this->parent->configs['page_parent'], 
				$this->parent->configs['page_title'], 
				$this->parent->configs['menu_title'], 
				$this->parent->configs['page_permissions'], 
				$this->parent->configs['page_slug'],
				array($this, 'options_page_callback') 
			);
			
		} else {
				$optioins_page = add_menu_page( 
				$this->parent->configs['page_title'], 
				$this->parent->configs['menu_title'], 
				$this->parent->configs['page_permissions'], 
				$this->parent->configs['page_slug'], 
				array($this, 'options_page_callback') , 
				$this->parent->configs['menu_icon'], 
				$this->parent->configs['menu_priority'] 
			);
		}
		$this->parent->configs['options_page_id'] = $optioins_page;
		$this->options_page_id = $optioins_page;

	

	}

	/**
	 * Display options page
	 *
	 * @since  1.0.0
	 * @return void
	 */
	function options_page_callback() {
		$this->parent->mangocube_views->admin_options_page();
	}


}

?>
