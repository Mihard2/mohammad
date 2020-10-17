<?php
/**
 * inForward Child Theme functions and definitions
 *
 */

if (!function_exists('mad_candidatepro_child_css')) {

	

	function mad_candidatepro_child_css() {

		if (!is_admin()) {

		$parent_style = 'candidatepro-style';
		
		wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
		
		wp_enqueue_style( 'child-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), wp_get_theme()->get('Version') );

		if ( is_rtl() ) {
			wp_enqueue_style( 'child-style-rtl', get_stylesheet_directory_uri() . '/rtl.css' );
		}
		
		}
		
	}
	
	add_action('wp_enqueue_scripts', 'mad_candidatepro_child_css');

}
