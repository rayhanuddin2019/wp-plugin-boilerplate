<?php  

namespace MangoCube_Packages\Options\Fields;

class Settings {

	// Hold all field classes
	var $fieldTypes = array();

	// Hold all setting fields object
	var $setting_fields = array();

	/**
	 * Fire!
	 *
	 * @since 1.0.0
	 */
	public function __construct( $parent ) {
		// Set parent to object
		$this->parent = $parent;
		$this->register_field();
		$this->enqueue_field_dependency();
		$this->add_hook();
	}

	/**
	 * Register actions
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function add_hook() {
		add_action('admin_init', array($this, 'run') );
		add_action('admin_notices', array($this, 'admin_messages') );
	}

	/**
	 * Register action and settings
	 *
	 * @since  1.0.0
	 * @return void 
	 */
	public function run() {

		// This action must be added after admin_init action!
		if( isset($this->parent->configs['options_page_id']) ) {
			add_action( "load-" . $this->parent->configs['options_page_id'], array($this, 'reset_section_options') );
		}

		// Register settings
		$this->register_settings();
	}

	/**
	 * Regsiter all settings sections and fields
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function register_settings() {

		if( false == get_option( $this->parent->configs['opt_name'] ) ) {
			add_option( $this->parent->configs['opt_name'] );

			if($this->parent->configs['save_defaults']) {
				update_option( $this->parent->configs['opt_name'], $this->parent->default_options );
			}
			
		}

		foreach ( $this->parent->sections as $section ) {
			
			// Avoiding blank and link section tab.
			if( isset($section['type']) && ( 'blank' == $section['type'] || 'url' == $section['type'] ) ) {
				if( !empty($section['callback']) ) {
					add_action( 'mangocube_options_page_' . $this->parent->configs['opt_name'] . '_' . $section['id'], $section['callback'] );
				}
				continue;
			}

			add_settings_section( 
				$this->parent->configs['opt_name'] . '_' . $section['id'], 
				__return_null(), '__return_false', 
				$this->parent->configs['opt_name'] . '_' . $section['id'] );

			if( isset($section['fields']) && !empty($section['fields']) ) {
				foreach ( $section['fields'] as $key => $option ) {

					// Add some core configures to field
					$option['id'] = isset($key) ? $key : null;
					$option['section'] = $section['id'];
					$option['option_name'] = "{$this->parent->configs['opt_name']}[{$key}]";
					$option['option_id']   = '';

					add_settings_field( 
						$this->parent->configs['opt_name'] . '[' . $key . ']', 
						$option['title'], 
						array($this, 'field_callback'),
						$this->parent->configs['opt_name'] . '_' . $section['id'], 
						$this->parent->configs['opt_name'] . '_' . $section['id'], 
						$option
					);
					
				}
			}
		}

		register_setting( $this->parent->configs['opt_name'], $this->parent->configs['opt_name'], array($this, 'sanitize_callback') );
	}

	/**
	 * Field display
	 *
	 * Render the filed output according to field type
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function field_callback( $field ) {

		if( isset($field['type']) ) {

			$display = true;
		
			$field_class = $this->fieldTypes[$field['type']];
           
			if( class_exists($field_class) ) {
				$value  = isset($this->parent->options[ $field['id'] ]) ? $this->parent->options[ $field['id'] ] : '';
				$render = new $field_class($field, $value, $this->parent);
				$render->render_field();
			} else {
				_e('This field type does not exists, please check your code.', 'mangocube');
			}

		}
	}

	/**
	 * Settings Sanitization
	 *
 	 * Adds a settings error (for the updated message)
 	 * At some point this will validate options
	 *
	 * @param  array $options 			 - The array of options to be sanitized
	 * @since  1.0.0
	 * @return array $sanitizied_options - The array of sanitized options
	 */
	public function sanitize_callback( $options = array() ) {

		if ( empty( $_POST['_wp_http_referer'] ) ) {
			return $options;
		}

		if( empty($options) ) {
			return;
		}

		parse_str( $_POST['_wp_http_referer'], $referrer );

		$sanitizied_options = array();
		$tab = isset( $referrer['tab'] ) ? $referrer['tab'] : 'general';

		foreach ($options as $key => $value) {
			//Get the setting type (text, checkbox, etc)
			$type = isset($this->parent->sections[$tab]['fields'][$key]['type']) ? $this->parent->sections[$tab]['fields'][$key]['type'] : '';
			
			if( $type ) {
				//Field type specific filter
				$value = apply_filters( "mangocube_settings_sanitize_{$this->parent->configs['opt_name']}[{$key}]", $value );
			}

			//General filter
			$sanitizied_options[ $key ] = apply_filters('mangocube_settings_sanitize', $value );
		}
		
		// Merge our new settings with the existing
		$old_options = (array) $this->parent->options;

		$output = array_merge( $old_options, $sanitizied_options );
		add_settings_error( "mangocube-". $this->parent->configs['opt_name'] ."-notices", '', __( 'Settings updated!', 'mangocube' ), 'updated' );

		return $output;

	}

	/**
	 * Rest all settings belong to current section tab
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function reset_section_options() {

		if( isset($_GET['settings-updated'])) {
			return;
		}

		if( !isset($_GET['tab']) || !isset($_GET['action']) || !isset($_GET['reset_nonce']) ) {
			return;
		}

		if($_GET['action'] == 'reset' && wp_verify_nonce( $_GET['reset_nonce'], 'mangocube_reset')) {
			$section = $this->parent->sections[$_GET['tab']];
			$new_options = array();
			foreach ($section['fields'] as $key => $field) {
				$new_options[$key] = isset($field['default']) ? $field['default'] : '';
			}
			$new_options = wp_parse_args( $new_options, $this->parent->options );

			update_option( $this->parent->configs['opt_name'], $new_options );

			add_settings_error( "mangocube-". $this->parent->configs['opt_name'] ."-notices", '', __( 'Section Defaults Restored!', 'mangocube' ), 'updated' );

			$this->parent->refresh();
		}
	}

	/**
	 * Require field class files
	 * Can be use full namespace path
	 * @since  1.0.0
	 * @return void
	 */
	public function register_field() {

		$this->fieldTypes = mangocube_app()->get('register-options');
	
	}

	/**
	 * Enqueue setting fields
	 * in order to setup field dependency, it must
	 * be called once first to add it's own actions
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function enqueue_field_dependency() {

		foreach ( $this->parent->sections as $section ) {
			
			// Avoiding blank section tab.
			if( isset($section['type']) && ('blank' == $section['type'] || 'url' == $section['type']) ) {
				continue;
			}

			foreach ( $section['fields'] as $key => $field ) {

				$field['option_name'] 	= "{$this->parent->configs['opt_name']}[{$key}]";
				$field['option_id']   	= '';
				$field['id']			= $key;

				if( isset($field['type']) ) {
					$field_class = $this->fieldTypes[strtolower($field['type'])];
					if( class_exists($field_class) ) {
						$value  = '';
						// $value  = isset ( $this->parent->options[ $field['id'] ] ) ? $this->parent->options[ $field['id'] ] : '';
						$this->setting_fields[$field['id']] = new $field_class($field, $value, $this->parent);
					}
				}
				
			}
		}
	}

	/**
	 * Admin notices
	 * Display option messages after updated options
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function admin_messages() {
		settings_errors( "mangocube-". $this->parent->configs['opt_name'] ."-notices" );
	}
}
?>