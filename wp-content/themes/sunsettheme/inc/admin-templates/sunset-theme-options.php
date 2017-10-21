<?php

   /* $profile_picture_url = esc_attr( get_option( 'profile_picture_url' ) );	*/
	
?>
<h1>Sunset theme options</h1>

<form action="options.php" method="post" class="sunset-general-form">
	<?php settings_fields( 'sunset-theme-group' ); ?>
	<?php  do_settings_sections('sunset_theme_options_slug' ); ?>
	<?php submit_button(); ?>
</form>