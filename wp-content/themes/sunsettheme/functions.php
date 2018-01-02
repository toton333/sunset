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
	wp_enqueue_script( 'sunset', get_template_directory_uri() . '/js/sunset.js', array('jquery'), '1.0.0', true );


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

add_theme_support( 'post-thumbnails');

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



/*
	========================
		BLOG LOOP CUSTOM FUNCTIONS
	========================
*/
function sunset_posted_meta(){
	$posted_on = human_time_diff( get_the_time('U') , current_time('timestamp') );
	
	$categories = get_the_category();
	$separator = ', ';
	$output = '';
	$i = 1;
	
	if( !empty($categories) ):
		foreach( $categories as $category ):
			if( $i > 1 ): $output .= $separator; endif;
			$output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" alt="' . esc_attr( 'View all posts in%s', $category->name ) .'">' . esc_html( $category->name ) .'</a>';
			$i++; 
		endforeach;
	endif;
	
	return '<span class="posted-on">Posted <a href="'. esc_url( get_permalink() ) .'">' . $posted_on . '</a> ago</span> / <span class="posted-in">' . $output . '</span>';
}



function sunset_posted_footer(){
	
	$comments_num = get_comments_number();
	if( comments_open() ){
      
		if( $comments_num == 0 ){
			$comments = __('No Comments');
		} elseif ( $comments_num > 1 ){
			$comments= $comments_num . __(' Comments');
		} else {
			$comments = __('1 Comment');
		}
		$comments = '<a class="comments-link" href="' . get_comments_link() . '">'. $comments .' <span class="sunset-icon sunset-comment"></span></a>';

	} else {
		$comments = __('Comments are closed');
	}
	
	return '<div class="post-footer-container"><div class="row"><div class="col-xs-12 col-sm-6">'. get_the_tag_list('<div class="tags-list"><span class="sunset-icon sunset-tag"></span>', ' ', '</div>') .'</div><div class="col-xs-12 col-sm-6 text-right">'. $comments .'</div></div></div>';
}


function sunset_get_attachment($num = 1){
	
	 // need to detach image manualy from media library
	$output = '';
	if( has_post_thumbnail() && $num == 1 ): 
		$output =  get_the_post_thumbnail_url();
	else:
		$attachments = get_posts( array( 
			'post_type' => 'attachment',
			'posts_per_page' => $num,
			'post_parent' => get_the_ID()
		) );
		if( $attachments && $num == 1 ):
			foreach ( $attachments as $attachment ):
				$output = wp_get_attachment_url( $attachment->ID );
			endforeach;
		elseif( $attachments && $num > 1 ):
			$output = $attachments;
		endif;
		
		wp_reset_postdata();
		
	endif;
	
	return $output;
	
    
    /*
	global $post, $posts;
	  $output = ' ';
	  
	  if( has_post_thumbnail() ): 
	   $output = wp_get_attachment_url(get_post_thumbnail_id( get_the_ID() ) );
	   else:

	   $first_image = preg_match_all('/img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
	      $output = $matches [1] [0];

	    wp_reset_postdata();

	  endif;

	  return $output;
	  */
}



function sunset_get_embedded_media( $type = array() ){
	$content = do_shortcode( apply_filters( 'the_content', get_the_content() ) );
	$embed = get_media_embedded_in_content( $content, $type );
	
	if( in_array( 'audio' , $type) ):
		$output = str_replace( '?visual=true', '?visual=false', $embed[0] );
	else:
		$output = $embed[0];
	endif;
	
	return $output;
}

function sunset_get_bs_slides( $attachments ){
	
	$output = array();
	$count = count($attachments)-1;
	
	for( $i = 0; $i <= $count; $i++ ): 
	
		$active = ( $i == 0 ? ' active' : '' );
		
		$n = ( $i == $count ? 0 : $i+1 );
		$nextImg = wp_get_attachment_thumb_url( $attachments[$n]->ID );
		$p = ( $i == 0 ? $count : $i-1 );
		$prevImg = wp_get_attachment_thumb_url( $attachments[$p]->ID );
		
		$output[$i] = array( 
			'class'		=> $active, 
			'url'		=> wp_get_attachment_url( $attachments[$i]->ID ),
			'next_img'	=> $nextImg,
			'prev_img'	=> $prevImg,
			'caption'	=> $attachments[$i]->post_excerpt
		);
	
	endfor;
	
	return $output;
	
}

function sunset_grab_url() {
	if( ! preg_match( '/<a\s[^>]*?href=[\'"](.+?)[\'"]/i', get_the_content(), $links ) ){
		return false;
	}
	return esc_url_raw( $links[1] );
}
