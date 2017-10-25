<?php

require get_template_directory() . '/inc/function-admin.php';
require get_template_directory() . '/inc/custom-post-type.php';

/*
	
@package sunsettheme
	
	========================
		ADMIN ENQUEUE FUNCTIONS
	========================
*/
function sunset_load_admin_scripts( $hook ){
	if( ('toplevel_page_sunset_general_slug' OR 'sunset_page_sunset_css_slug') != $hook ){ return; }
	
	wp_register_style( 'sunset_admin', get_template_directory_uri() . '/css/sunset.admin.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'sunset_admin' );

	wp_enqueue_media();
	wp_enqueue_script( 'ace', get_template_directory_uri() . '/js/ace/ace.js', array('jquery'), '1.2.1', true );
	wp_register_script( 'sunset_admin_js', get_template_directory_uri().'/js/sunset.admin.js', array('jquery'), '1.0.0', true );
	wp_enqueue_script('sunset_admin_js');

	
	
}
add_action( 'admin_enqueue_scripts', 'sunset_load_admin_scripts' );


/*
	
@package sunsettheme
	
	========================
		THEME SUPPORT OPTIONS
	========================
*/
$options = get_option('post_formats');
if (!empty($options)) {
  add_theme_support('post-formats', array_keys($options));
}

$header = get_option( 'custom_header' );
if( isset($header) && $header == 1 ){
	add_theme_support( 'custom-header' );
}
$background = get_option( 'custom_background' );
if( isset($background) && $background == 1 ){
	add_theme_support( 'custom-background' );
}