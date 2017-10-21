
<h1>Sunset general settings</h1>
<?php settings_errors(); ?>


<?php 
    $profile_picture_url = esc_attr( get_option( 'profile_picture_url' ) );	
	$firstName = esc_attr( get_option( 'first_name' ) );
	$lastName = esc_attr( get_option( 'last_name' ) );
	$fullName = $firstName . ' ' . $lastName;
	$description = esc_attr( get_option( 'description' ) );

	
?>
<div class="sunset-sidebar-preview">
	<div class="sunset-sidebar">
		<div class="image-container">
			<div id="profile-picture-preview" class="profile-picture" style="background-image: url(<?php print $profile_picture_url; ?>);">
			</div>
		</div>
		<h1 class="sunset-username"><?php print $fullName; ?></h1>
		<h2 class="sunset-description"><?php print $description; ?></h2>
		<div class="icons-wrapper">
			
		</div>
	</div>
</div>

<form action="options.php" method="post" class="sunset-general-form">
	<?php settings_fields( 'sunset-settings-group' ); ?>
	<?php do_settings_sections('sunset_general_slug' ); ?>
	<?php submit_button(); ?>
</form>