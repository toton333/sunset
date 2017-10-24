<?php
/*
	
@package sunsettheme
	
	========================
		THEME CUSTOM POST TYPES
	========================
*/
$contact = get_option( 'activate_contact' );
if( isset($contact) && $contact == 1 ){

	//custom post
	add_action( 'init', 'sunset_contact_custom_post_type' );

    //filtering list columns and inserting data from post
	add_filter( 'manage_sunset-contact_posts_columns', 'sunset_set_contact_columns' );
	add_action( 'manage_sunset-contact_posts_custom_column', 'sunset_contact_custom_column', 10, 2 );

    //meta box creation and saving
	add_action( 'add_meta_boxes', 'sunset_contact_add_meta_box' );
	add_action( 'save_post', 'sunset_save_contact_email_data' );
}
/* CONTACT CPT */
function sunset_contact_custom_post_type() {
	$labels = array(
		'name' 				=> 'Messages',
		'singular_name' 	=> 'Message',
		'menu_name'			=> 'Messages',
		'name_admin_bar'	=> 'Message'
	);
	
	$args = array(
		'labels'			=> $labels,
		'show_ui'			=> true,
		'show_in_menu'		=> true,
		'capability_type'	=> 'post',
		'hierarchical'		=> false,
		'menu_position'		=> 26,
		'menu_icon'			=> 'dashicons-email-alt',
		'supports'			=> array( 'title', 'editor', 'author' )
	);
	
	register_post_type( 'sunset-contact', $args );
	
}

/* Setting columns */

function sunset_set_contact_columns($columns){

	$newColumns = array();
	$newColumns['title']   = 'Full Name';
	$newColumns['message'] = 'Message';
	$newColumns['email']   = 'Email';
	$newColumns['date']    = 'date'; 

	return $newColumns;

}

/* Adding content in the columns */

function sunset_contact_custom_column($column , $post_id){

	switch ($column) {
		case 'message':
			echo get_the_excerpt();
			break;

		case 'email':
			echo get_post_meta( $post_id, '_contact_email_meta_key', true );
			break;
		
		default:
			# code...
			break;
	}


}

/* Adding meta box */

function sunset_contact_add_meta_box(){

	add_meta_box( 'contact_email', 'User Email', 'sunset_contact_email_callback', 'sunset-contact', 'side' );
}


//html and input filed for meta box
function sunset_contact_email_callback($post){

	wp_nonce_field( 'sunset_save_contact_email_data', 'sunset_contact_email_meta_box_nonce');

	$value = get_post_meta( $post->ID, '_contact_email_meta_key', true );

	?>

      <label for=" sunset_contact_email_field" >User Email Address</label>
      <input type="email" id="sunset_contact_email_field" name="sunset_contact_email_field" value="<?php echo esc_attr($value ); ?>" size="25"  >

	<?php


}


//saving meta value with wpnonce check
function sunset_save_contact_email_data( $post_id ) {
	
	if( ! isset( $_POST['sunset_contact_email_meta_box_nonce'] ) ){
		return;
	}
	
	if( ! wp_verify_nonce( $_POST['sunset_contact_email_meta_box_nonce'], 'sunset_save_contact_email_data') ) {
		return;
	}
	
	if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ){
		return;
	}
	
	if( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}
	
	if( ! isset( $_POST['sunset_contact_email_field'] ) ) {
		return;
	}
	
	$my_data = sanitize_text_field( $_POST['sunset_contact_email_field'] );
	
	update_post_meta( $post_id, '_contact_email_meta_key', $my_data );
	
}