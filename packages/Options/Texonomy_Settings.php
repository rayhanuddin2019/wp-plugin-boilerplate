<?php  

namespace MangoCube_Packages\Options;

class Texonomy_Settings extends Base_Settings {

	// Hold all field classes
	var $fieldTypes = array();

	// Hold all setting fields object
	var $setting_fields = array();

	public function __construct( $parent ) {
		// Set parent to object
		$this->parent = $parent;
		$this->register_field();
		
		$this->add_hook();
	}

	/**
	 * Register actions
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function add_hook() {

		$taxonomy = isset( $this->parent->configs['taxonomy'] )? $this->parent->configs['taxonomy'] : 'category';
	  
		add_action( sprintf( '%s_edit_form_fields', $taxonomy ) , array( $this, 'render_meta_box_content' ),20 );
		add_action( sprintf( '%s_add_form_fields', $taxonomy ), [$this,'render_meta_box_content'],100 );

        add_action( sprintf( 'saved_%s', $taxonomy ), array( $this, 'save') );
        add_action( sprintf( 'edited_%s', $taxonomy ) , array( $this, 'save') );
	
	
	}

	public function save( $term_id  ) {
    
		$fields = $this->parent->configs['fields'];
	
		foreach($fields as $key => $field){
		
			if(isset($_POST[$key])){
				
				if( isset($field['sub_fields'])){
				     $repeater_data = mangocube_sanitize_cleaner( $_POST[ $key ] );
				     $data          = $this->get_transform_table_repeater_settings( $repeater_data );
				}else{

					$data = sanitize_text_field( $_POST[$key] );
    		
				}
				update_term_meta( $term_id , $key , $data );
			}
			
		}
	
       
    }

 	/**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $term ) {
  
		$fields = $this->parent->configs['fields'];
	
		if( !is_array( $fields ) ){
			return;
		}

		$term_id = null;

		if(isset($term->term_id)){
		  $term_id = $term->term_id;
		}

	
		foreach($fields as $key => $field){
			
			$field['option_name'] 	= $key;
			$field['option_id']   	= '';
			$field['id']			= $key;

			if( isset( $field[ 'type' ] ) ) {
				$field_class = $this->fieldTypes[strtolower($field['type'])];

				if( class_exists($field_class) ) {

					$value = is_null($term_id) ? '' : get_term_meta( $term_id, $key, true );

					if($field[ 'type' ] === 'repeat' && isset($value['field_count'])){
						unset($value['field_count']);	
					} 
					$render = new $field_class($field, $value, $this->parent);
					echo sprintf('<tr class="form-field">
					<th>
					<label for="cb_taxonomy_meta_data">%s</label>
				  </th>',$field['title']);
						echo '<td>';
						$render->render_field(true);
						echo '</td>';
					echo '</tr>';

				}
			}

		}
	
        // Display the form, using the current value.
        ?>
    
        <?php
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

	
}
?>