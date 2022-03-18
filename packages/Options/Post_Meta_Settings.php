<?php  

namespace MangoCube_Packages\Options;

class Post_Meta_Settings extends Base_Settings {

	// Hold all field classes
	var $fieldTypes = array();

	// Hold all setting fields object
	var $setting_fields = array();

	public function __construct( $parent ) {
		
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

		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
        add_action( 'save_post',      array( $this, 'save') );
	
	}

	public function add_meta_box( $post_type ) {
        
		$meta_box_id 		= isset( $this->parent->configs['metabox_id'] )? $this->parent->configs['metabox_id'] : $post_type.'_bookta_settings';
		$title       		= isset( $this->parent->configs['title'] ) ? $this->parent->configs['title'] : 'Settings';
		$position    		= isset( $this->parent->configs['position'] ) ? $this->parent->configs['position'] : 'normal';
		$priority    		= isset( $this->parent->configs['priority'] ) ? $this->parent->configs['priority'] : 'high';
		$current_post_type  = isset( $this->parent->configs['post_type'] ) ? $this->parent->configs['post_type'] : null;
	  
	   if($current_post_type == $post_type){
	
			add_meta_box(
				$meta_box_id,
                $title,
                array( $this, 'render_meta_box_content' ),
                $post_type,
                $position,
                $priority
            );

	   }
		
        
    }

	public function save( $post_id ) {
        
        if ( ! isset( $_POST['mangocube_inner_custom_box_nonce'] ) ) {
            return $post_id;
        }
  
        $nonce = $_POST['mangocube_inner_custom_box_nonce'];
  
        if ( ! wp_verify_nonce( $nonce, 'mangocube_inner_custom_box' ) ) {
            return $post_id;
        }
  
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return $post_id;
        }
  
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}

		$fields = $this->parent->configs['fields'];

		foreach($fields as $key => $field){

			if(isset($_POST[$key])){

				if( isset($field['sub_fields'])){

					$sub_fields = mangocube_sanitize_cleaner( $_POST[ $key ] );
					$data       = $this->get_transform_table_repeater_settings( $sub_fields );
			
				}else{

					$data = sanitize_text_field( $_POST[$key] );
					
				}
				update_post_meta( $post_id , $key , $data );
			}
			
		}
  
       
    }

 	/**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $post ) {
		
        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'mangocube_inner_custom_box', 'mangocube_inner_custom_box_nonce' );
		
		$fields = $this->parent->configs['fields'];
	
		if( !is_array( $fields ) ){
			return;
		}

		foreach($fields as $key => $field){
			
			$field['option_name'] 	= $key;
			$field['option_id']   	= '';
			$field['id']			= $key;

			if( isset( $field[ 'type' ] ) ) {
				$field_class = $this->fieldTypes[strtolower($field['type'])];

				if( class_exists($field_class) ) {
					
					$value = get_post_meta( $post->ID, $key, true );
				    if($field[ 'type' ] === 'repeat' && isset($value['field_count'])){
					  unset($value['field_count']);	
					} 
					$new_bj = new $field_class($field, $value, $this->parent);
					$new_bj->render_field(true);
	

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