<?php
/*
	
@package sunsettheme
	
	========================
		ADMIN PAGE
	========================
*/
function sunset_add_admin_page() {

	
	
	add_menu_page( 'Sunset Theme Options', 'Sunset', 'manage_options', 'sunset_general_slug', 'sunset_general_callback', get_template_directory_uri() . '/img/sunset-icon.png', 110 );

    //slug and callback need to match with parent menu to remove parent label from submenu list
	add_submenu_page( 'sunset_general_slug', 'General Options', 'General', 'manage_options', 'sunset_general_slug', 'sunset_general_callback'); 

	add_submenu_page( 'sunset_general_slug', 'CSS options', 'CSS', 'manage_options', 'sunset_css_slug', 'sunset_css_callback' );

	//activate custom settings
	add_action( 'admin_init', 'sunset_custom_settings' );
	
}
add_action( 'admin_menu', 'sunset_add_admin_page' );

//custom settings function
function sunset_custom_settings(){

	register_setting( 'sunset-settings-group', 'first_name' );
	register_setting( 'sunset-settings-group', 'last_name' );
	register_setting( 'sunset-settings-group', 'twitter_handler' , 'sunset_sanitize_twitter_handler');
	register_setting( 'sunset-settings-group', 'facebook_handler' );
	register_setting( 'sunset-settings-group', 'gplus_handler' );

    //adding section sidebar
	add_settings_section( 'sunset-section-sidebar-options-id', 'Sidebar Options', 'sunset_section_sidebar_options_callback', 'sunset_general_slug' );

	//adding full name field
	add_settings_field( 'sunset-full-name-field-id', 'Full Name', 'sunset_full_name_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

	//adding twitter field
	add_settings_field( 'sunset-twitter-field-id', 'Twitter', 'sunset_twitter_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

	//adding facebook field
	add_settings_field( 'sunset-facebook-field-id', 'Facebook', 'sunset_facebook_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

	//adding Gplus field
	add_settings_field( 'sunset-gplus-field-id', 'Google+', 'sunset_gplus_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

	



}


//callback field: full name
function sunset_full_name_callback(){
	$firstName = esc_attr( get_option( 'first_name' ) );
	$lasttName = esc_attr( get_option( 'last_name' ) );
	echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="Enter first name" />  <input type="text" name="last_name" value="'.$lasttName.'" placeholder="Enter last name" /> ';
}

//callback field: Twitter
function sunset_twitter_callback(){
	$twitter = esc_attr( get_option( 'twitter_handler' ) );
	echo '<input type="text" name="twitter_handler" value="'.$twitter.'" placeholder="Enter twitter handler " /><p class="description">Input your Twitter username without the @ character.</p>  ';
}

//callback field: facebook
function sunset_facebook_callback(){
	$facebook = esc_attr( get_option( 'facebook_handler' ) );
	echo '<input type="text" name="facebook_handler" value="'.$facebook.'" placeholder="Enter facebook handler " />  ';
}

//callback field: gplus
function sunset_gplus_callback(){
	$gplus = esc_attr( get_option( 'gplus_handler' ) );
	echo '<input type="text" name="gplus_handler" value="'.$gplus.'" placeholder="Enter gplus handler " />  ';
}




//callback section: sidebar options
function  sunset_section_sidebar_options_callback(){

   echo "<h4>Customize sidebar options</h4>";
}

//sanitization

function sunset_sanitize_twitter_handler($input){

  $output = sanitize_text_field( $input );
  $output = str_replace('@', ' ', $output);
  return $output;
}



//general page
function sunset_general_callback() {
	//generation of general page
	require_once(get_template_directory().'/inc/admin-templates/sunset-general.php');
}

//css page
function sunset_css_callback() {
	//generation of css page
}

