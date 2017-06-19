<?php
/*
Plugin Name: GreenDot
Plugin URI: http://fanaticdesign.co.uk/
Description: Add user friendly Green dots for easy edit
Version: 0.2
Date: 1 February 2015
Author: Fanatic.
Author URI: http://fanaticdesign.co.uk/
   

*/

defined( 'ABSPATH' ) or die( 'Silence is golden ...' );

include( plugin_dir_path( __FILE__ ) . 'includes/custom-field.php' );
if ( !class_exists('GreenDot') ) {

	/* @TODO: Find out if there's better solution */
	if(!function_exists('wp_get_current_user')) {
		include(ABSPATH . "wp-includes/pluggable.php"); 
	}
	
	
	class GreenDot {

		
		function __construct() {
			// Register style sheet.
				add_action( 'wp_enqueue_scripts', array( $this, 'greendot_styles_scripts' ) );
		}		
		
		
		function greendot_styles_scripts() {
				wp_register_style( 'css', plugins_url( 'green_dot/green_dot.css' ) );
				wp_enqueue_style( 'css' );	
			
				wp_register_script( 'js', plugins_url( 'green_dot/green.js' ), array('jquery'),'0.1',true );
				wp_enqueue_script( 'js' );				
		}

	}

	/* Only start if user can edit posts */
	if (  current_user_can('edit_posts') ) {
		$GreenDot = new GreenDot();
	}

	
}//endif