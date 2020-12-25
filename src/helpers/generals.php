<?php

/**
 * Resize any image from
 *
 * @param url  $url image 
 * @param mix $width image width size false for auto
 * @param mix $height image height size false for auto
 * @param boolen  $crop 
 * @return url string path
 * @version 1.0 very begining
 * inspired by unyson
 */ 

if ( ! function_exists( 'mangocube_resize' ) ) {
	function mangocube_resize( $url, $width = false, $height = false, $crop = false ) {

		$mangocube_resize = \Mangocube\helpers\resize::getInstance();
		$response  = $mangocube_resize->process( $url, $width, $height, $crop );

		return ( ! is_wp_error( $response ) && ! empty( $response['src'] ) ) ? $response['src'] : $url;
	}
}