<?php

namespace MangoCube_Packages\Options;

abstract class Base_Settings {
    
	/**
	 * Remove hidden clone row
	 * @since 1.0
	 * @param repeater settings array 
	 * @return array
	 */
	function get_transform_table_repeater_settings( $settings = [] ) {

		if(isset($settings['field_count'])){
			unset($settings['field_count']);	
		}
	 
		return $settings;
	}


}

