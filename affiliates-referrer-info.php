<?php
/*
 Plugin Name: Affiliates Referrer Info
Plugin URI: http://www.eggemplo.com
Description: Add a shortcode to show referrer info as lineal text (name and email)
Author: eggemplo
Version: 1.0
Author URI: http://www.eggemplo.com
*/

add_action ( 'init', 'add_aff_referrer_info_shortcodes' );

function add_aff_referrer_info_shortcodes($data) {
	add_shortcode ( 'aff-referrer-info', 'aff_referrer_info' );
	add_shortcode ( 'aff_referrer_info', 'aff_referrer_info' );
}

function aff_referrer_info ($attr = array()) {
	
	$output = "";
	$sep =  isset( $attr['separator'] ) ? $attr['separator'] : "<br>";
	$direct = isset( $attr['show_direct'] ) ? true : false;
	
	$name = isset( $attr['show_name'] ) ? true : false;
	$email = isset( $attr['show_email'] ) ? true : false;
	
	if ( !class_exists("Affiliates_Service" ) ) {
		require_once( AFFILIATES_CORE_LIB . '/class-affiliates-service.php' );
	}
	
	$affiliate_id = Affiliates_Service::get_referrer_id();
	if ( $affiliate_id ) {
		$affiliate = affiliates_get_affiliate( $affiliate_id );
		
		if ( $direct || ( $affiliate_id !== affiliates_get_direct_id() ) ) { 
			if ( $name ) {
				$output .= $affiliate['name'] . $sep;
			}
			if ( $email ) {
				$output .= $affiliate['email'] . $sep;
			}
			
			if ( strlen($output)>0 ) { // delete last separator
				$output = substr($output, 0, strlen($output)-strlen($sep));
			}
		}
		
	}	
	
	return $output;
					
}
