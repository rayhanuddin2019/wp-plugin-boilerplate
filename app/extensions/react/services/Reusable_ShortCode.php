<?php

namespace Mangocube\extensions\react\services;
use Mangocube\base\Runner;


final class Reusable_ShortCode extends Runner
{
	/**
	 * Store all the classes inside an array
	 * @return array Full list of classes
	 */
	public function register() 
	{
		// Add to Datatable
        add_filter( 'manage_wp_block_posts_columns', [ $this , 'set_custom_shortcode_columns' ] );
        add_action( 'manage_wp_block_posts_custom_column' , [ $this,'custom_wp_block_column' ] , 10, 2 );
	    // create shortcode for reusable block
        add_shortcode( 'mangocube-reusable-block', [ $this, 'reusable_block_shortcode' ] );
    }
    
    function custom_wp_block_column( $column, $post_id ) {

        switch ( $column ) {
    
            case 'mangocube_shortcode' :
                echo  '<p contenteditable="true"> [mangocube-reusable-block id="' . $post_id . '"] </p>';
                break;
    
        }
    
    }

    
    function set_custom_shortcode_columns( $columns ) {
    
        $columns['mangocube_shortcode'] = __( 'Shortcode', 'mangocube' );
    
        return $columns;
    }

    function reusable_block_shortcode( $atts ){
        
        extract( shortcode_atts( array(
            'id' => '',
        ), $atts ) );
       
      
        if ( !is_numeric($id) ) {
            return;
        }
        
        $content = $this->get_reusable_block( $id );
        return $content;
    
    }

    function get_reusable_block( $block_id = '' ) {
        
        $block_id = intval( $block_id );
        $content = get_post_field( 'post_content', $block_id );
       
        return apply_filters( 'mangocube_guten_block_content', $content );
    }

   
}