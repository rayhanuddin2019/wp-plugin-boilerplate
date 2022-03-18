<?php

namespace MangoCube_Packages\Options;

use MangoCube_Packages\Options\Fields\Admin;
use MangoCube_Packages\Options\Fields\Views;
use MangoCube_Packages\Options\Fields\Settings;
use MangoCube_Packages\Options\Post_Meta_Settings;

class MetaBox_Api {

	// Hold setting configures
	var $configs = array();

	// Hold options
	var $options = array();

	// Hold default options
	var $default_options = array();

	// Hold null value options
	var $null_options = array();

	// Hold admin object
	var $mangocube_admin;

	// Hold settings object
	var $mangocube_settings;

	// Hold admin setting views object
	var $mangocube_views;

	public function __construct( $settings = array() ) {
        
		$this->configs = wp_parse_args( $settings, $this->get_default_configs() );
		$this->mangocube_settings = new Post_Meta_Settings($this);
	
	}

	/**
	 * Get default option configs
	 *
	 * @since  1.0.0
	 * @return array
	 */
	function get_default_configs() {

		$default = array(
			'title'      => 'General',
			'metabox_id' => 'general_post',   //unique
			'post_type'  => 'post',
			'priority'   => 1,
			'position'   => 'normal',
			'fields' => [] 
		);

		return $default;
	}


}

