<?php

require get_template_directory() . '/inc/function-admin.php';
require get_template_directory() . '/inc/custom-post-type.php';
require get_template_directory() . '/inc/walker.php';

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
	
	========================
		FRONT-END ENQUEUE FUNCTIONS
	========================
*/
function sunset_load_scripts(){
	
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7', 'all' );
	wp_enqueue_style( 'sunset', get_template_directory_uri() . '/css/sunset.frontend.css', array(), '1.0.0', 'all' );
	wp_enqueue_style( 'raleway', 'https://fonts.googleapis.com/css?family=Raleway:200,300,500' );
	

    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', includes_url( '/js/jquery/jquery.js' ), false, NULL, true );
    wp_enqueue_script( 'jquery' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array('jquery'), '3.3.7', true );
	
}
add_action( 'wp_enqueue_scripts', 'sunset_load_scripts' );






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

/* Activate Nav Menu Option */
function sunset_register_nav_menu() {
	register_nav_menu( 'primary', 'Header Navigation Menu' );
}
add_action( 'after_setup_theme', 'sunset_register_nav_menu' );





/*
	
@package sunsettheme
	
	========================
		REMOVE GENERATOR VERSION NUMBER
	========================
*/
/* remove version string from js and css */
function sunset_remove_wp_version_strings( $src ) {
	
	global $wp_version;
	parse_str( parse_url($src, PHP_URL_QUERY), $query );
	if ( !empty( $query['ver'] ) && $query['ver'] === $wp_version ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
	
}
add_filter( 'script_loader_src', 'sunset_remove_wp_version_strings' );
add_filter( 'style_loader_src', 'sunset_remove_wp_version_strings' );
/* remove metatag generator from header */
function sunset_remove_meta_version() {
	return '';
}
add_filter( 'the_generator', 'sunset_remove_meta_version' );