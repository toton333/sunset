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

    //adding section sidebar
	add_settings_section( 'sunset-section-sidebar-options-id', 'Sidebar Options', 'sunset_section_sidebar_options_callback', 'sunset_general_slug' );

	//adding first name field
	add_settings_field( 'sunset-first-name-field-id', 'First Name', 'sunset_first_name_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );



}


//callback field: first name
function sunset_first_name_callback(){
	$firstName = esc_attr( get_option( 'first_name' ) );
	echo '<input type="text" name="first_name" value="'.$firstName.'" placeholder="Enter first name" />';
}

//callback section: sidebar options
function  sunset_section_sidebar_options_callback(){

   echo "<h4>Customize sidebar options</h4>";
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

