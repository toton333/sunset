
<?php settings_errors(); ?>
<h1>Sunset general settings</h1>

<form action="options.php" method="post" >
	<?php settings_fields( 'sunset-settings-group' ); ?>
	<?php do_settings_sections('sunset_general_slug' ); ?>
	<?php submit_button(); ?>
</form>