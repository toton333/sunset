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

	add_submenu_page( 'sunset_general_slug', 'Sunset Theme options', 'Theme Optons', 'manage_options', 'sunset_theme_options_slug', 'sunset_theme_options_callback' );

	add_submenu_page( 'sunset_general_slug', 'Sunset Contact Form', 'Contact Form', 'manage_options', 'sunset_contact_form_slug', 'sunset_contact_form_callback' );

	add_submenu_page( 'sunset_general_slug', 'CSS options', 'CSS', 'manage_options', 'sunset_css_slug', 'sunset_css_callback' );

	

	//activate custom settings
	add_action( 'admin_init', 'sunset_custom_settings' );
	
}
add_action( 'admin_menu', 'sunset_add_admin_page' );

//custom settings function
function sunset_custom_settings(){

    /* 
       ========================
		Sidebar options
	   ========================

     */
    register_setting( 'sunset-settings-group', 'profile_picture_url' );
	register_setting( 'sunset-settings-group', 'first_name' );
	register_setting( 'sunset-settings-group', 'last_name' );
	register_setting( 'sunset-settings-group', 'twitter_handler' , 'sunset_sanitize_twitter_handler');
	register_setting( 'sunset-settings-group', 'facebook_handler' );
	register_setting( 'sunset-settings-group', 'gplus_handler' );
	register_setting( 'sunset-settings-group', 'description' );

    //adding section sidebar
	add_settings_section( 'sunset-section-sidebar-options-id', 'Sidebar Options', 'sunset_section_sidebar_options_callback', 'sunset_general_slug' );

	//adding profile picture field
	add_settings_field( 'sunset-profile-picture-field-id', 'Profile Picture', 'sunset_profile_picture_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

	//adding full name field
	add_settings_field( 'sunset-full-name-field-id', 'Full Name', 'sunset_full_name_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

    //adding description
	add_settings_field( 'sunset-description-field-id', 'Description', 'sunset_description_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

	//adding twitter field
	add_settings_field( 'sunset-twitter-field-id', 'Twitter', 'sunset_twitter_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

	//adding facebook field
	add_settings_field( 'sunset-facebook-field-id', 'Facebook', 'sunset_facebook_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );

	//adding Gplus field
	add_settings_field( 'sunset-gplus-field-id', 'Google+', 'sunset_gplus_callback', 'sunset_general_slug', 'sunset-section-sidebar-options-id' );


	/* 
       ========================
		Theme Options
	   ========================

     */

    register_setting( 'sunset-theme-support', 'post_formats' );
    register_setting( 'sunset-theme-support', 'custom_header' );
	register_setting( 'sunset-theme-support', 'custom_background' );

    //adding theme options section
    add_settings_section( 'sunset-theme-options-section-id', 'Theme options', 'sunset_section_theme_options_callback', 'sunset_theme_options_slug' );

    add_settings_field( 'sunset-post-format-field-id', 'Post Formats', 'sunset_post_format_callback', 'sunset_theme_options_slug', 'sunset-theme-options-section-id' );

    add_settings_field( 'sunset-custom-header-field-id', 'Custom Header', 'sunset_custom_header_callback', 'sunset_theme_options_slug', 'sunset-theme-options-section-id' );

    add_settings_field( 'sunset-custom-background-field-id', 'Custom background', 'sunset_custom_background_callback', 'sunset_theme_options_slug', 'sunset-theme-options-section-id' );

    /* 
       ========================
		Contact Form Options
	   ========================

     */
	register_setting( 'sunset-contact-options', 'activate_contact' );
	
	add_settings_section( 'sunset-contact-section-id', 'Contact Form', 'sunset_contact_section_callback', 'sunset_contact_form_slug');
	
	add_settings_field( 'sunset-contact-field-id', 'Activate Contact Form', 'sunset_contact_field_callback', 'sunset_contact_form_slug', 'sunset-contact-section-id' );
	

	
}

//callback section :contact

function sunset_contact_section_callback(){

	echo 'Activate and Deactivate the Built-in Contact Form';
}

//callback field :contact

function sunset_contact_field_callback(){

	$options = get_option( 'activate_contact' );
	$checked = ( isset($options ) && $options == 1 ? 'checked' : '' );
	echo '<label><input type="checkbox" id="custom_header" name="activate_contact" value="1" '.$checked.' /></label>';

}



//callback section :theme options

function sunset_section_theme_options_callback(){

	echo "<h4>Customize theme options</h4>";
}

//callback field : post formats

function sunset_post_format_callback(){

	$options = get_option( 'post_formats' );

	$formats = get_post_format_slugs();

	$output = '';
	foreach ( $formats as $format ){
		$checked = (isset($options[$format]) && $options[$format] == 1 ? "checked" : "");
		$output .= '<label><input type="checkbox" id="'.$format.'" name="post_formats['.$format.']" value="1" '.$checked.' /> '.$format.'</label><br>';
	}
	echo $output;


}

//callback field: custom header
function sunset_custom_header_callback(){

	$options = get_option( 'custom_header' );
	$checked = ( isset($options) && $options == 1 ? 'checked' : '' );
	echo '<label><input type="checkbox" id="custom_header" name="custom_header" value="1" '.$checked.' /> Activate the Custom Header</label>';

}

//callback field: custom background
function sunset_custom_background_callback(){

	$options = get_option( 'custom_background' );
	$checked = ( isset($options) && $options == 1 ? 'checked' : '' );
	echo '<label><input type="checkbox" id="custom_background" name="custom_background" value="1" '.$checked.' /> Activate the Custom Background</label>';
	
}


//callback field: profile picture
function sunset_profile_picture_callback(){
	$profile_picture_url = esc_attr( get_option( 'profile_picture_url' ) );

	if( empty($profile_picture_url) ){
		echo '<input type="button" class="button button-secondary" value="Upload Profile Picture" id="upload_button"><input type="hidden" id="profile_picture_url" name="profile_picture_url" value="" />';
	} else {
		echo '<input type="button" class="button button-secondary" value="Replace Profile Picture" id="upload_button"><input type="hidden" id="profile_picture_url" name="profile_picture_url" value="'.$profile_picture_url.'" /> <input type="button" class="button button-primary" value="Remove" id="remove-picture">';
	}


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

//callback field: description
function sunset_description_callback(){
	$description = esc_attr( get_option( 'description' ) );
	echo '<input type="text" name="description" value="'.$description.'" placeholder="Description " /> <p class="description">Write something smart.</p> ';
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

//theme options page 
function sunset_theme_options_callback(){

	require_once(get_template_directory().'/inc/admin-templates/sunset-theme-options.php');
}

//contact page

function sunset_contact_form_callback(){

	require_once(get_template_directory().'/inc/admin-templates/sunset-contact.php');
}

//css page
function sunset_css_callback() {
	//generation of css page
}

